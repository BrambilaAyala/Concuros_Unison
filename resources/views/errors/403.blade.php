@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-danger">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fas fa-shield-alt text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h1 class="display-4 font-weight-bold text-dark">403</h1>
                    <h3 class="font-weight-bold text-danger mb-3">Acceso Denegado / Prohibido</h3>
                    
                    <p class="lead text-muted mb-4">
                        {{ $exception->getMessage() ?: 'No cuentas con los privilegios requeridos para ingresar a esta sección o estás intentando consultar o modificar un expediente que no te pertenece.' }}
                    </p>

                    <div class="alert alert-light border text-left p-3 mb-4 mx-auto" style="max-width: 520px;">
                        <small class="text-muted d-block font-weight-bold mb-1"><i class="fas fa-info-circle mr-1 text-primary"></i> Medidas de Seguridad Activas:</small>
                        <ul class="mb-0 pl-3 text-muted small">
                            <li>El Panel Administrativo requiere credenciales de Revisor autorizadas.</li>
                            <li>Los participantes solo pueden consultar y actualizar su propio expediente.</li>
                            <li>Los intentos de manipulación de URL son registrados por el sistema.</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-center flex-wrap" style="gap: 10px;">
                        @if(auth('revisor')->check())
                            <a href="{{ route('revisores.index') }}" class="btn btn-primary font-weight-bold px-4">
                                <i class="fas fa-tachometer-alt mr-1"></i> Ir al Panel de Revisores
                            </a>
                        @elseif(auth('web')->check())
                            <a href="{{ route('asistentes.index') }}" class="btn btn-primary font-weight-bold px-4">
                                <i class="fas fa-user mr-1"></i> Volver a Mi Expediente
                            </a>
                        @else
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary font-weight-bold px-4">
                                <i class="fas fa-home mr-1"></i> Ir a la Página Principal
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-primary font-weight-bold px-4">
                                <i class="fas fa-sign-in-alt mr-1"></i> Iniciar Sesión
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
