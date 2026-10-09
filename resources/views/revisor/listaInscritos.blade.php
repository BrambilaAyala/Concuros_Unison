@extends('layouts.app_admin')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0 text-dark font-weight-bold">
                        <i class="fas fa-id-card text-success mr-2"></i> Padrón Oficial de Alumnos Inscritos
                    </h1>
                    <p class="text-muted mb-0">Listado de aspirantes con documentación aprobada y número de folio oficial asignado para el concurso</p>
                </div>
                <div class="col-sm-5 text-right mt-2 mt-sm-0">
                    <button class="btn btn-outline-dark font-weight-bold mr-1" onclick="window.print()">
                        <i class="fas fa-print mr-1"></i> Imprimir Lista
                    </button>
                    <a href="{{ route('revisores.crear-asistente') }}" class="btn btn-success font-weight-bold shadow-sm">
                        <i class="fas fa-user-plus mr-1"></i> + Inscripción Manual
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @if (session('notification'))
                <div class="alert alert-success alert-dismissible fade show elevation-1 mb-3" role="alert">
                    <h5><i class="icon fas fa-check-circle"></i> ¡Operación Exitosa!</h5>
                    <p class="mb-0" style="font-size: 1rem;">{{ session('notification') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @php
                $inscritosFiltrados = $asistentesInscritos->filter(function($a) {
                    if (!empty($a->folio)) return true;
                    return $a->documentos && $a->documentos->validaciones->isNotEmpty() && $a->documentos->validaciones->last()->estado === 'Aprobado';
                });
            @endphp

            <div class="card card-success card-outline elevation-1">
                <div class="card-header border-0 bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <h3 class="card-title font-weight-bold text-dark" style="font-size: 1.1rem;">
                                Directorio de Participantes Acreditados
                                <span class="badge badge-success ml-2 font-weight-bold px-2 py-1" style="font-size: 0.9rem;">
                                    {{ $inscritosFiltrados->count() }} inscritos
                                </span>
                            </h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="input-group input-group-sm ml-auto" style="max-width: 380px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
                                </div>
                                <input type="text" id="inputBuscadorNombre" class="form-control border-left-0" onkeyup="buscadorPorNombre()" placeholder="Buscar por Nombre, Folio o Concurso...">
                                <input type="hidden" id="vistaInscritos" name="vistaInscritos" value="1">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped text-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 130px;">Folio Oficial</th>
                                <th>Nombre del Alumno</th>
                                <th>Escuela de Procedencia</th>
                                <th>Concursos Acreditados</th>
                                <th class="text-center" style="width: 160px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inscritosFiltrados as $asistenteInscrito)
                                @php
                                    $arrayConcursos = [];
                                    foreach ($asistenteInscrito->concursos as $c) {
                                        $arrayConcursos[] = $c->nombre;
                                    }
                                    $concursosStr = implode(", ", $arrayConcursos);
                                @endphp
                                <tr id="tablaTR">
                                    <td class="align-middle">
                                        <span class="badge badge-primary px-3 py-2 font-weight-bold" style="font-size: 0.95rem; letter-spacing: 0.5px;">
                                            <i class="fas fa-certificate mr-1 text-warning"></i>
                                            {{ $asistenteInscrito->folio ?? 'Pendiente' }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <p id="nombreP" class="m-0 font-weight-bold text-dark" style="font-size: 0.95rem;">
                                            {{ $asistenteInscrito->nombre }} {{ $asistenteInscrito->apellido_paterno }} {{ $asistenteInscrito->apellido_materno }}
                                        </p>
                                        <p id="folioP" class="d-none">{{ $asistenteInscrito->folio ?? '' }}</p>
                                        <small class="text-muted"><i class="fas fa-envelope mr-1"></i>{{ $asistenteInscrito->correo_electronico }} • CURP: {{ $asistenteInscrito->curp ?? 'N/D' }}</small>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-dark font-weight-500">{{ $asistenteInscrito->escuela_origen ?? 'No especificada' }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <p id="concursosP" class="d-none">{{ $concursosStr }}</p>
                                        <p id="estadoP" class="d-none">Inscrito</p>
                                        @forelse ($asistenteInscrito->concursos as $c)
                                            <span class="badge badge-info px-2 py-1 mr-1" style="font-size: 0.78rem;">
                                                {{ $c->nombre }}
                                            </span>
                                        @empty
                                            <span class="badge badge-secondary">Sin concursos</span>
                                        @endforelse
                                    </td>
                                    <td class="align-middle text-center">
                                        <button value="{{ $asistenteInscrito->id }}" type="button" class="btn btn-info btn-sm font-weight-bold shadow-sm botonInfo mr-1" data-toggle="modal" data-target="#staticBackdrop">
                                            <i class="fas fa-eye mr-1"></i> Ficha
                                        </button>
                                        <a href="{{ route('asistentes.credencial') }}" target="_blank" class="btn btn-outline-success btn-sm font-weight-bold" title="Vista previa de credencial">
                                            <i class="fas fa-id-badge"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="my-4">
                                            <i class="fas fa-id-card text-muted" style="font-size: 3.5rem;"></i>
                                            <h4 class="font-weight-bold text-dark mt-3">Aún no hay participantes inscritos</h4>
                                            <p class="text-muted mb-3">Revisa las solicitudes en la bandeja de espera para aprobar y asignar folios oficiales.</p>
                                            <a href="{{ route('revisores.lista-espera') }}" class="btn btn-warning btn-sm font-weight-bold">
                                                <i class="fas fa-clock mr-1"></i> Ir a Bandeja de Espera
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalle del Alumno -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="staticBackdropLabel">
                        <i class="fas fa-user-graduate mr-2"></i> Expediente del Participante
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4" id="modalBody">
                    <div class="row">
                        <div class="col-md-7 border-right">
                            <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3">Datos Personales y Escolares</h6>
                            
                            <div class="form-group mb-2">
                                <label class="text-muted small mb-0">Nombre Completo:</label>
                                <div id="divNombre" class="font-weight-bold text-dark" style="font-size: 1.05rem;"></div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="text-muted small mb-0" id="curp">CURP:</label>
                                    <div id="divCurp" class="font-weight-bold text-dark"></div>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small mb-0" id="fNacimiento">Nacimiento:</label>
                                    <div id="divNacimiento" class="font-weight-bold text-dark"></div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="text-muted small mb-0" id="correo">Correo Electrónico:</label>
                                    <div id="divCorreo" class="text-dark"></div>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small mb-0" id="telefono">Teléfono:</label>
                                    <div id="divTelefono" class="text-dark"></div>
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label class="text-muted small mb-0" id="escuela">Escuela de Origen:</label>
                                <div id="divEscuela" class="font-weight-bold text-dark"></div>
                            </div>

                            <div class="form-group mb-2">
                                <label class="text-muted small mb-0" id="concursos">Concursos Inscrito:</label>
                                <div id="divConcursos" class="mt-1"></div>
                            </div>

                            <div id="seccionAsesor" class="mt-2 pt-2 border-top" style="display:none;">
                                <label class="text-muted small text-uppercase font-weight-bold mb-1">
                                    <i class="fas fa-chalkboard-teacher mr-1 text-primary"></i> Maestro Asesor / Tutor:
                                </label>
                                <div class="small p-2 bg-light rounded border">
                                    <span id="divAsesorNombre" class="font-weight-bold text-dark d-block"></span>
                                    <span id="divAsesorContacto" class="text-muted d-block"></span>
                                </div>
                            </div>

                            <div class="row mt-3 pt-2 border-top">
                                <div class="col-6">
                                    <label class="text-muted small mb-0">Folio Oficial Asignado:</label>
                                    <div id="divFolio" class="h5 font-weight-bold text-primary mb-0"></div>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small mb-0">Estatus del Registro:</label>
                                    <div id="divEstatus" class="mt-1"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3">Documentos Adjuntos</h6>
                            
                            <div class="mb-3 text-center">
                                <label class="text-muted small d-block mb-1" id="identificacion">Fotografía para Credencial:</label>
                                <div id="divImgAsistente" class="border rounded p-1 bg-light d-inline-block" style="max-width: 140px;"></div>
                            </div>

                            <div class="text-center">
                                <label class="text-muted small d-block mb-1" id="constancia">Constancia o Credencial Escolar:</label>
                                <div id="divImgAsistenteConstancia" class="border rounded p-1 bg-light d-inline-block" style="max-width: 220px; max-height: 180px; overflow: hidden;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm font-weight-bold" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cerrar Ficha
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection