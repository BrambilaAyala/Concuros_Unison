@extends('layouts.app_admin')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1 class="m-0 text-dark font-weight-bold">
                        <i class="fas fa-tachometer-alt text-primary mr-2"></i> Panel de Control - SICREFyM 2026
                    </h1>
                    <p class="text-muted mb-0">Resumen ejecutivo y monitoreo del Concurso Regional de Física y Matemáticas (UNISON)</p>
                </div>
                <div class="col-sm-4 text-right">
                    <span class="badge badge-success px-3 py-2" style="font-size: 0.9rem;">
                        <i class="fas fa-calendar-check mr-1"></i> Edición LV • 2026
                    </span>
                </div>
            </div>
            <hr class="mt-2 mb-3">
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @if (session('notification'))
                <div class="alert alert-success alert-dismissible fade show elevation-1 mb-3" role="alert">
                    <h5><i class="icon fas fa-check-circle"></i> Notificación del Sistema</h5>
                    <p class="mb-0">{{ session()->get('notification') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Tarjeta de Control Operativo de Convocatoria (Apertura / Cierre) -->
            <div class="card elevation-2 mb-4 {{ (isset($eventoGlobal) && $eventoGlobal->activo) ? 'card-outline card-success' : 'card-outline card-danger' }}">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <i class="fas fa-power-off mr-2 fa-lg {{ (isset($eventoGlobal) && $eventoGlobal->activo) ? 'text-success' : 'text-danger' }}"></i>
                            <div>
                                <h3 class="card-title font-weight-bold text-dark mb-0" style="font-size: 1.15rem;">
                                    Control de Convocatoria / Estado del Concurso
                                </h3>
                                <small class="text-muted d-block">Gestiona la disponibilidad del registro público sin necesidad de modificar código en el servidor.</small>
                            </div>
                        </div>
                        <div>
                            @if(isset($eventoGlobal) && $eventoGlobal->activo)
                                <span class="badge badge-success px-3 py-2 font-weight-bold shadow-sm" style="font-size: 0.95rem;">
                                    <i class="fas fa-check-circle mr-1"></i> ABIERTA • Recibiendo Solicitudes
                                </span>
                            @else
                                <span class="badge badge-danger px-3 py-2 font-weight-bold shadow-sm" style="font-size: 0.95rem;">
                                    <i class="fas fa-lock mr-1"></i> CERRADA • Nuevos Registros Desactivados
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-6 border-right">
                            <h6 class="font-weight-bold text-dark mb-2">
                                <i class="fas fa-toggle-on mr-1 text-primary"></i> Interruptor de Apertura / Cierre
                            </h6>
                            <p class="text-muted small mb-3">
                                @if(isset($eventoGlobal) && $eventoGlobal->activo)
                                    Al <strong>cerrar la convocatoria</strong>, la página principal ocultará los enlaces de registro y mostrará el aviso oficial de clausura. Los aspirantes inscritos podrán seguir ingresando a consultar y descargar su credencial oficial.
                                @else
                                    La convocatoria se encuentra actualmente <strong>cerrada</strong>. Puedes reabrirla en cualquier momento para volver a recibir inscripciones en el portal público.
                                @endif
                            </p>

                            <form action="{{ route('revisores.toggle-convocatoria') }}" method="POST" class="d-inline">
                                @csrf
                                @if(isset($eventoGlobal) && $eventoGlobal->activo)
                                    <button type="submit" class="btn btn-outline-danger font-weight-bold shadow-sm px-4" onclick="return confirm('¿Confirmas que deseas CERRAR la convocatoria? Los aspirantes ya no podrán registrarse en la plataforma.');">
                                        <i class="fas fa-ban mr-1"></i> Cerrar Convocatoria Ahora
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-success font-weight-bold shadow-sm px-4" onclick="return confirm('¿Confirmas que deseas REABRIR la convocatoria de inscripciones?');">
                                        <i class="fas fa-door-open mr-1"></i> Reabrir Convocatoria
                                    </button>
                                @endif
                            </form>

                            <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary font-weight-bold ml-2 shadow-sm">
                                <i class="fas fa-external-link-alt mr-1"></i> Previsualizar Portal Público
                            </a>
                        </div>

                        <div class="col-lg-6 mt-3 mt-lg-0">
                            <h6 class="font-weight-bold text-dark mb-2">
                                <i class="fas fa-bullhorn mr-1 text-info"></i> Mensaje Oficial de Cierre (Visible al Público al Concluir)
                            </h6>
                            <form action="{{ route('revisores.actualizar-mensaje-cierre') }}" method="POST">
                                @csrf
                                <div class="form-group mb-2">
                                    <textarea name="mensaje_cierre" class="form-control" rows="3" placeholder="Mensaje que verán los visitantes cuando la convocatoria esté cerrada...">{{ optional($eventoGlobal)->mensaje_cierre ?? 'El periodo de inscripciones para el LV Concurso Regional de Física y Matemáticas ha concluido. Agradecemos su participación e interés.' }}</textarea>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold shadow-sm px-3">
                                        <i class="fas fa-save mr-1"></i> Guardar Mensaje de Cierre
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4 Tarjetas de Métricas Principales (Small Boxes) -->
            <div class="row">
                <!-- Total Registrados -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info elevation-2">
                        <div class="inner">
                            <h3>{{ $totalAsistentes ?? 0 }}</h3>
                            <p>Total de Registrados</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('revisores.lista-asistentes') }}" class="small-box-footer">
                            Ver todos <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- En Espera -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning elevation-2">
                        <div class="inner">
                            <h3>{{ $enEspera ?? 0 }}</h3>
                            <p>En Espera de Revisión</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <a href="{{ route('revisores.lista-espera') }}" class="small-box-footer font-weight-bold">
                            Atender solicitudes <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Aprobados / Con Folio -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success elevation-2">
                        <div class="inner">
                            <h3>{{ $aprobados ?? 0 }}</h3>
                            <p>Inscritos con Folio</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="{{ route('revisores.lista-inscritos') }}" class="small-box-footer">
                            Ver inscritos <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Rechazados / Subsanando -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger elevation-2">
                        <div class="inner">
                            <h3>{{ $rechazados ?? 0 }}</h3>
                            <p>Documentos Rechazados</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <a href="{{ route('revisores.lista-asistentes') }}" class="small-box-footer">
                            Consultar detalles <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Fila de Secciones Detalladas -->
            <div class="row">
                <!-- Columna Izquierda: Avance por Concurso -->
                <div class="col-lg-7">
                    <div class="card card-primary card-outline elevation-1">
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-award mr-1 text-primary"></i> Inscripciones por Concurso
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-light">Año 2026</span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(isset($concursos) && count($concursos) > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>Concurso</th>
                                                <th class="text-center">Aspirantes</th>
                                                <th>Proporción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($concursos as $c)
                                                @php
                                                    $porcentaje = ($totalAsistentes > 0) ? round(($c->asistentes_count / $totalAsistentes) * 100, 1) : 0;
                                                @endphp
                                                <tr>
                                                    <td class="font-weight-bold text-dark">{{ $c->nombre }}</td>
                                                    <td class="text-center">
                                                        <span class="badge badge-primary px-2 py-1" style="font-size: 0.9rem;">
                                                            {{ $c->asistentes_count }}
                                                        </span>
                                                    </td>
                                                    <td style="width: 40%;">
                                                        <div class="progress progress-sm rounded">
                                                            <div class="progress-bar bg-primary" style="width: {{ $porcentaje }}%"></div>
                                                        </div>
                                                        <small class="text-muted">{{ $porcentaje }}% del total</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No hay información de concursos registrada.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Tarjeta de Normas de Revisión 2026 -->
                    <div class="card card-info card-outline elevation-1">
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-info-circle mr-1 text-info"></i> Directrices de Validación para el Revisor (2026)
                            </h3>
                        </div>
                        <div class="card-body py-2">
                            <ul class="list-unstyled mb-0 text-sm">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success mr-2"></i>
                                    <strong>Fotografía tipo credencial:</strong> Fondo claro, rostro descubierto, buena iluminación y recorte adecuado.
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success mr-2"></i>
                                    <strong>Constancia / Credencial Escolar:</strong> Debe mostrar el nombre completo del aspirante y la institución educativa de nivel medio superior.
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-bell text-warning mr-2"></i>
                                    <strong>Acta de Nacimiento:</strong> Exenta para la edición 2026 para acelerar el proceso de inscripción.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Últimas Validaciones y Accesos Rápidos -->
                <div class="col-lg-5">
                    <!-- Accesos Rápidos -->
                    <div class="card card-secondary card-outline elevation-1">
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-bolt mr-1 text-warning"></i> Acciones Inmediatas
                            </h3>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('revisores.crear-asistente') }}" class="btn btn-primary btn-block font-weight-bold mb-2 shadow-sm text-left py-2">
                                <i class="fas fa-user-plus mr-2"></i> Inscripción Manual / Extemporánea
                            </a>
                            <a href="{{ route('revisores.lista-espera') }}" class="btn btn-warning btn-block text-dark font-weight-bold mb-2 shadow-sm text-left py-2">
                                <i class="fas fa-user-clock mr-2"></i> Revisar Lista de Espera ({{ $enEspera ?? 0 }} pendientes)
                            </a>
                            <a href="{{ route('revisores.lista-inscritos') }}" class="btn btn-success btn-block font-weight-bold mb-2 shadow-sm text-left py-2">
                                <i class="fas fa-address-book mr-2"></i> Consultar Lista de Inscritos Oficiales
                            </a>
                            <a href="{{ route('revisores.lista-asistentes') }}" class="btn btn-info btn-block font-weight-bold shadow-sm text-left py-2">
                                <i class="fas fa-search mr-2"></i> Búsqueda General de Asistentes
                            </a>
                        </div>
                    </div>

                    <!-- Últimas Validaciones Realizadas -->
                    <div class="card card-dark card-outline elevation-1">
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-history mr-1 text-secondary"></i> Actividad Reciente
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                @if(isset($ultimasValidaciones) && count($ultimasValidaciones) > 0)
                                    @foreach($ultimasValidaciones as $v)
                                        @php
                                            $asist = optional(optional($v->documento)->asistente);
                                            $badgeColor = 'secondary';
                                            if ($v->estado == 'Aprobado') $badgeColor = 'success';
                                            elseif ($v->estado == 'Espera') $badgeColor = 'warning';
                                            elseif ($v->estado == 'Rechazado') $badgeColor = 'danger';
                                        @endphp
                                        <li class="item">
                                            <div class="product-info ml-2">
                                                <span class="product-title font-weight-bold text-dark">
                                                    {{ $asist->nombre ?? 'Aspirante' }} {{ $asist->apellido_paterno ?? '' }}
                                                    <span class="badge badge-{{ $badgeColor }} float-right">{{ $v->estado }}</span>
                                                </span>
                                                <span class="product-description text-xs text-muted">
                                                    {{ $v->fecha_validacion ?? $v->updated_at->format('d/m/Y H:i') }}
                                                    @if($asist && $asist->folio)
                                                        • Folio: <strong>{{ $asist->folio }}</strong>
                                                    @endif
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="item p-3 text-muted text-center text-sm">
                                        No hay validaciones recientes registradas.
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection