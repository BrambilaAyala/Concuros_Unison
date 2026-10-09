@extends('layouts.app_admin')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0 text-dark font-weight-bold">
                        <i class="fas fa-users text-primary mr-2"></i> Directorio General de Participantes
                    </h1>
                    <p class="text-muted mb-0">Listado integral de aspirantes registrados, estatus de su documentación y folios asignados</p>
                </div>
                <div class="col-sm-5 text-right mt-2 mt-sm-0">
                    <a href="{{ route('revisores.crear-asistente') }}" class="btn btn-success font-weight-bold shadow-sm mr-1">
                        <i class="fas fa-user-plus mr-1"></i> + Inscripción Manual
                    </a>
                    <a href="{{ route('revisores.lista-espera') }}" class="btn btn-warning font-weight-bold shadow-sm">
                        <i class="fas fa-inbox mr-1"></i> Ver Espera
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

            <!-- Resumen Rápido -->
            @php
                $totalAsistentes = $asistentes->count();
                $totalInscritos = $asistentes->filter(function($a) {
                    return !empty($a->folio) || ($a->documentos && $a->documentos->validaciones->isNotEmpty() && $a->documentos->validaciones->last()->estado === 'Aprobado');
                })->count();
                $totalEspera = $asistentes->filter(function($a) {
                    return $a->documentos && $a->documentos->validaciones->isNotEmpty() && $a->documentos->validaciones->last()->estado === 'Espera';
                })->count();
                $totalReenvio = $asistentes->filter(function($a) {
                    return $a->documentos && $a->documentos->validaciones->isNotEmpty() && $a->documentos->validaciones->last()->estado === 'Rechazado';
                })->count();
            @endphp

            <div class="row mb-3">
                <div class="col-6 col-md-3">
                    <div class="info-box bg-light shadow-sm border mb-2">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-muted font-weight-bold">Total Registrados</span>
                            <span class="info-box-number text-dark" style="font-size: 1.3rem;">{{ $totalAsistentes }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-box bg-light shadow-sm border mb-2">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock text-white"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-muted font-weight-bold">En Revisión</span>
                            <span class="info-box-number text-dark" style="font-size: 1.3rem;">{{ $totalEspera }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-box bg-light shadow-sm border mb-2">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-muted font-weight-bold">Acreditados / Folio</span>
                            <span class="info-box-number text-dark" style="font-size: 1.3rem;">{{ $totalInscritos }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="info-box bg-light shadow-sm border mb-2">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-undo-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-muted font-weight-bold">Reenvío Solicitado</span>
                            <span class="info-box-number text-dark" style="font-size: 1.3rem;">{{ $totalReenvio }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla Directorio -->
            <div class="card card-primary card-outline elevation-1">
                <div class="card-header border-0 bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-5 mb-2 mb-md-0">
                            <h3 class="card-title font-weight-bold text-dark" style="font-size: 1.1rem;">
                                Listado de Aspirantes
                                <span class="badge badge-secondary ml-2 font-weight-bold px-2 py-1">{{ $totalAsistentes }} registros</span>
                            </h3>
                        </div>
                        <div class="col-md-7 text-right">
                            <div class="input-group input-group-sm ml-auto" style="max-width: 420px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
                                </div>
                                <input type="text" id="inputBuscadorNombre" class="form-control border-left-0" onkeyup="buscadorPorNombre()" placeholder="Buscar por Nombre, Folio, Concurso o Estado...">
                                <input type="hidden" id="vistaInscritos" name="vistaInscritos" value="0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped text-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th>Aspirante</th>
                                <th style="width: 140px;">No. Folio</th>
                                <th>Concursos Registrados</th>
                                <th style="width: 130px;">Estatus</th>
                                <th class="text-center" style="width: 160px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="listaTabla">
                            @forelse ($asistentes as $key => $asistente)
                                @php
                                    $arrayConcursos = [];
                                    if ($asistente->concursos) {
                                        foreach ($asistente->concursos as $c) {
                                            $arrayConcursos[] = $c->nombre;
                                        }
                                    }
                                    $concursosStr = count($arrayConcursos) > 0 ? implode(", ", $arrayConcursos) : 'Sin concursos';

                                    $estadoStr = 'Enviando';
                                    $estadoBadge = '<span class="badge badge-secondary px-2 py-1"><i class="fas fa-edit mr-1"></i>Enviando</span>';
                                    $esEspera = false;

                                    if ($asistente->documentos && $asistente->documentos->validaciones->isNotEmpty()) {
                                        $lastVal = $asistente->documentos->validaciones->last()->estado;
                                        if ($lastVal == 'Espera') {
                                            $estadoStr = 'Espera';
                                            $estadoBadge = '<span class="badge badge-warning text-dark px-2 py-1 font-weight-bold"><i class="fas fa-clock mr-1"></i>En Espera</span>';
                                            $esEspera = true;
                                        } elseif ($lastVal == 'Rechazado') {
                                            $estadoStr = 'Renvío';
                                            $estadoBadge = '<span class="badge badge-danger px-2 py-1 font-weight-bold"><i class="fas fa-undo-alt mr-1"></i>Reenvío</span>';
                                        } elseif ($lastVal == 'Aprobado') {
                                            $estadoStr = 'Inscrito';
                                            $estadoBadge = '<span class="badge badge-success px-2 py-1 font-weight-bold"><i class="fas fa-check-circle mr-1"></i>Inscrito</span>';
                                        }
                                    } elseif (!empty($asistente->folio)) {
                                        $estadoStr = 'Inscrito';
                                        $estadoBadge = '<span class="badge badge-success px-2 py-1 font-weight-bold"><i class="fas fa-check-circle mr-1"></i>Inscrito</span>';
                                    }

                                    $initials = mb_substr($asistente->nombre ?? 'A', 0, 1) . mb_substr($asistente->apellido_paterno ?? '', 0, 1);
                                @endphp
                                <tr id="tablaTR">
                                    <td class="align-middle">
                                        <!-- Estructura DOM requerida por admin.js buscadorPorNombre() -->
                                        <p id="nombre" class="m-0 font-weight-bold text-dark" style="font-size: 0.95rem;">
                                            {{ $asistente->nombre }} {{ $asistente->apellido_paterno }} {{ $asistente->apellido_materno }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="fas fa-school mr-1"></i>{{ $asistente->escuela_origen ?? 'Escuela no especificada' }} • 
                                            <i class="fas fa-envelope mr-1"></i>{{ $asistente->correo_electronico }}
                                        </small>
                                    </td>
                                    <td class="align-middle">
                                        <p id="folio" class="m-0">
                                            @if (!empty($asistente->folio))
                                                <span class="badge badge-primary px-2 py-1 font-weight-bold" style="font-size: 0.88rem;">
                                                    <i class="fas fa-certificate mr-1 text-warning"></i>{{ $asistente->folio }}
                                                </span>
                                            @else
                                                <span class="text-muted font-italic" style="font-size: 0.85rem;">Sin folio</span>
                                            @endif
                                        </p>
                                    </td>
                                    <td class="align-middle">
                                        <p class="d-none">{{ $concursosStr }}</p>
                                        @if(count($arrayConcursos) > 0)
                                            @foreach($asistente->concursos as $c)
                                                <span class="badge badge-info px-2 py-1 mr-1" style="font-size: 0.78rem;">
                                                    {{ $c->nombre }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="badge badge-light text-muted border">Sin concursos</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <p class="d-none">{{ $estadoStr }}</p>
                                        {!! $estadoBadge !!}
                                    </td>
                                    <td class="align-middle text-center">
                                        <button value="{{ $asistente->id }}" type="button" class="btn btn-info btn-sm font-weight-bold shadow-sm botonInfo mr-1" data-toggle="modal" data-target="#staticBackdrop" title="Ver ficha y documentos">
                                            <i class="fas fa-eye mr-1"></i> Ficha
                                        </button>
                                        @if($esEspera)
                                            <a href="{{ route('validaciones.edit', $asistente->id) }}" class="btn btn-warning btn-sm font-weight-bold shadow-sm text-dark" title="Revisar documentación">
                                                <i class="fas fa-check-double mr-1"></i> Validar
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="my-4">
                                            <i class="fas fa-users-slash text-muted" style="font-size: 3.5rem;"></i>
                                            <h4 class="font-weight-bold text-dark mt-3">No hay alumnos registrados</h4>
                                            <p class="text-muted">Aún no se han recibido registros en la plataforma.</p>
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
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #004990 0%, #0b1f3a 100%);">
                    <h5 class="modal-title font-weight-bold" id="staticBackdropLabel">
                        <i class="fas fa-id-card-alt text-warning mr-2"></i> Expediente del Aspirante
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4" id="modalBody">
                    <!-- Ficha General con Grid Bootstrap -->
                    <div class="card card-outline card-primary mb-3">
                        <div class="card-header py-2 bg-light font-weight-bold text-dark">
                            <i class="fas fa-user-circle mr-1 text-primary"></i> Datos Generales y de Contacto
                        </div>
                        <div class="card-body py-3">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="text-muted text-uppercase mb-0" style="font-size: 0.75rem;">Nombre Completo</label>
                                    <div id="divNombre" class="font-weight-bold text-dark" style="font-size: 1.05rem;"></div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="text-muted text-uppercase mb-0" style="font-size: 0.75rem;">Número de Folio</label>
                                    <div id="divFolio" class="font-weight-bold text-primary" style="font-size: 1.05rem;"></div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label id="curp" class="text-muted text-uppercase mb-0" style="font-size: 0.75rem;">CURP</label>
                                    <div id="divCurp" class="font-weight-bold text-dark"></div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label id="fNacimiento" class="text-muted text-uppercase mb-0" style="font-size: 0.75rem;">Fecha de Nacimiento</label>
                                    <div id="divNacimiento" class="text-dark"></div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label id="escuela" class="text-muted text-uppercase mb-0" style="font-size: 0.75rem;">Escuela de Procedencia</label>
                                    <div id="divEscuela" class="text-dark font-weight-500"></div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label id="correo" class="text-muted text-uppercase mb-0" style="font-size: 0.75rem;">Correo Electrónico</label>
                                    <div id="divCorreo" class="text-dark"></div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label id="telefono" class="text-muted text-uppercase mb-0" style="font-size: 0.75rem;">Teléfono de Contacto</label>
                                    <div id="divTelefono" class="text-dark"></div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="text-muted text-uppercase mb-0" style="font-size: 0.75rem;">Estatus Actual</label>
                                    <div id="divEstatus" class="font-weight-bold"></div>
                                </div>
                            </div>

                            <hr class="my-2">

                            <div class="row mt-2">
                                <div class="col-12">
                                    <label id="concursos" class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Concursos Registrados</label>
                                    <div id="divConcursos" class="badge-container"></div>
                                </div>
                            </div>

                            <div id="seccionAsesor" class="row mt-2 pt-2 border-top" style="display:none;">
                                <div class="col-12">
                                    <label class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">
                                        <i class="fas fa-chalkboard-teacher text-primary mr-1"></i> Maestro Asesor / Tutor
                                    </label>
                                    <div class="small p-2 bg-light rounded border">
                                        <span id="divAsesorNombre" class="font-weight-bold text-dark d-block"></span>
                                        <span id="divAsesorContacto" class="text-muted d-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documentos Adjuntos -->
                    <div class="card card-outline card-secondary mb-0">
                        <div class="card-header py-2 bg-light font-weight-bold text-dark">
                            <i class="fas fa-file-image mr-1 text-primary"></i> Documentación Adjunta
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-center mb-3">
                                    <label id="identificacion" class="font-weight-bold d-block text-muted mb-2">
                                        <i class="fas fa-portrait mr-1 text-info"></i> Fotografía del Aspirante
                                    </label>
                                    <div id="divImgAsistente" class="p-2 border rounded bg-light d-flex align-items-center justify-content-center" style="min-height: 220px; max-height: 320px; overflow: hidden;"></div>
                                </div>
                                <div class="col-md-6 text-center mb-3">
                                    <label id="constancia" class="font-weight-bold d-block text-muted mb-2">
                                        <i class="fas fa-file-invoice mr-1 text-warning"></i> Constancia / Credencial Escolar
                                    </label>
                                    <div id="divImgAsistenteConstancia" class="p-2 border rounded bg-light d-flex align-items-center justify-content-center" style="min-height: 220px; max-height: 320px; overflow: hidden;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cerrar Expediente
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    #divImgAsistente img,
    #divImgAsistenteConstancia img {
        max-width: 100%;
        max-height: 280px;
        object-fit: contain;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    #divImgAsistente img:hover,
    #divImgAsistenteConstancia img:hover {
        transform: scale(1.02);
    }
    #divConcursos ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    #divConcursos li {
        background-color: #e3f2fd;
        color: #0d47a1;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 600;
        border: 1px solid #bbdefb;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/admin.js') }}"></script>
@endpush
