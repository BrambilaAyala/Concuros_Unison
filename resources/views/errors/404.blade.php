@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fas fa-compass text-warning" style="font-size: 4rem;"></i>
                    </div>
                    <h1 class="display-4 font-weight-bold text-dark">404</h1>
                    <h3 class="font-weight-bold text-dark mb-3">Página No Encontrada</h3>
                    
                    <p class="lead text-muted mb-4">
                        La dirección URL que escribiste no existe en el sistema o fue reubicada por motivos de seguridad.
                    </p>

                    <div>
                        <a href="{{ url('/') }}" class="btn btn-primary font-weight-bold px-4">
                            <i class="fas fa-home mr-1"></i> Ir al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
