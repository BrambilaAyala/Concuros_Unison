@extends('layouts.app_admin')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0 text-dark font-weight-bold">
                        <i class="fas fa-clock text-warning mr-2"></i> Bandeja de Revisión de Documentos
                    </h1>
                    <p class="text-muted mb-0">Solicitudes enviadas por aspirantes que requieren validación de documentos y asignación de folio</p>
                </div>
                <div class="col-sm-5 text-right mt-2 mt-sm-0">
                    <a href="{{ route('revisores.crear-asistente') }}" class="btn btn-success font-weight-bold shadow-sm">
                        <i class="fas fa-user-plus mr-1"></i> + Inscripción Manual
                    </a>
                    <a href="{{ route('revisores.index') }}" class="btn btn-outline-secondary ml-1">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al Panel
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
                    <h5><i class="icon fas fa-check-circle"></i> ¡Acción Realizada!</h5>
                    <p class="mb-0" style="font-size: 1rem;">{{ session('notification') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @php
                $pendientes = $asistentes->filter(function($a) {
                    return $a->documentos && $a->documentos->validaciones->isNotEmpty() && $a->documentos->validaciones->last()->estado === 'Espera';
                });
            @endphp

            <div class="card card-warning card-outline elevation-1">
                <div class="card-header border-0 bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <h3 class="card-title font-weight-bold text-dark" style="font-size: 1.1rem;">
                                Solicitudes Pendientes 
                                <span class="badge badge-warning ml-2 font-weight-bold px-2 py-1" style="font-size: 0.9rem;">
                                    {{ $pendientes->count() }} pendientes
                                </span>
                            </h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="input-group input-group-sm ml-auto" style="max-width: 350px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
                                </div>
                                <input type="text" id="buscadorEspera" class="form-control border-left-0" placeholder="Buscar por nombre, CURP, escuela..." onkeyup="filtrarTablaEspera()">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped text-nowrap" id="tablaEspera">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Aspirante</th>
                                <th>Escuela de Origen</th>
                                <th>Concursos Solicitados</th>
                                <th>Fecha de Envío</th>
                                <th class="text-center" style="width: 160px;">Acción Requerida</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendientes as $index => $asistenteEspera)
                                <tr>
                                    <td class="align-middle font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-warning text-dark font-weight-bold mr-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 0.9rem;">
                                                {{ strtoupper(substr($asistenteEspera->nombre, 0, 1) . substr($asistenteEspera->apellido_paterno, 0, 1)) }}
                                            </div>
                                            <div>
                                                <strong class="d-block text-dark">{{ $asistenteEspera->nombre }} {{ $asistenteEspera->apellido_paterno }} {{ $asistenteEspera->apellido_materno }}</strong>
                                                <small class="text-muted"><i class="fas fa-id-badge mr-1"></i>{{ $asistenteEspera->curp ?? 'Sin CURP' }} • <i class="fas fa-envelope mr-1"></i>{{ $asistenteEspera->correo_electronico }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-dark font-weight-500">{{ $asistenteEspera->escuela_origen ?? 'No especificada' }}</span>
                                    </td>
                                    <td class="align-middle">
                                        @forelse ($asistenteEspera->concursos as $c)
                                            <span class="badge badge-info px-2 py-1 mr-1" style="font-size: 0.78rem;">
                                                {{ $c->nombre }}
                                            </span>
                                        @empty
                                            <span class="text-muted small">Sin concursos</span>
                                        @endforelse
                                    </td>
                                    <td class="align-middle text-muted" style="font-size: 0.9rem;">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $asistenteEspera->created_at ? $asistenteEspera->created_at->format('d/M/Y, g:ia') : 'Reciente' }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <a class="btn btn-warning btn-sm font-weight-bold shadow-sm px-3" href="{{ route('validaciones.edit', $asistenteEspera->id) }}">
                                            <i class="fas fa-search-plus mr-1"></i> Revisar y Validar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="my-4">
                                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                                            <h4 class="font-weight-bold text-dark mt-3">¡Bandeja al día!</h4>
                                            <p class="text-muted mb-3" style="max-width: 450px; margin: 0 auto;">
                                                No hay solicitudes pendientes de revisión en este momento. Las nuevas inscripciones que realicen los aspirantes aparecerán automáticamente aquí.
                                            </p>
                                            <a href="{{ route('revisores.lista-inscritos') }}" class="btn btn-outline-primary btn-sm font-weight-bold">
                                                <i class="fas fa-list mr-1"></i> Ver Alumnos Inscritos
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

    <script>
        function filtrarTablaEspera() {
            var input = document.getElementById("buscadorEspera");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("tablaEspera");
            var trs = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

            for (var i = 0; i < trs.length; i++) {
                var text = trs[i].textContent || trs[i].innerText;
                if (text.toLowerCase().indexOf(filter) > -1) {
                    trs[i].style.display = "";
                } else {
                    trs[i].style.display = "none";
                }
            }
        }
    </script>
@endsection