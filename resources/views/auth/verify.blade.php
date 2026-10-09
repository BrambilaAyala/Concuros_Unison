@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><strong>{{ __('Verificación de correo electrónico requerida') }}</strong></span>
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> {{ __('Cerrar sesión') }}
                    </a>
                </div>

                <div class="card-body">
                    <p>{{ __('Favor de confirmar el correo de verificación que hemos enviado a tu cuenta:') }} <strong>{{ Auth::user()->correo_electronico ?? '' }}</strong></p>
                    <p class="text-muted"><small><i>Revisa la carpeta de correo no deseado (SPAM) si no recibiste el correo en tu bandeja de entrada principal.</i></small></p>

                    @if(config('app.debug') && Auth::user() && Auth::user()->confirmation_code)
                        <div class="alert alert-info mt-3" style="border-left: 4px solid #17a2b8;">
                            <h5><i class="fa fa-flask"></i> Modo Local / Desarrollo detectado:</h5>
                            <p class="mb-2">Para facilitar tus pruebas sin depender de un servidor SMTP externo, puedes verificar tu correo con este botón directo:</p>
                            <a href="{{ url('/register/verify/' . Auth::user()->confirmation_code) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-check-circle"></i> Confirmar mi correo automáticamente
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
