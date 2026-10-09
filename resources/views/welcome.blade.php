@extends('layouts.app')

@section('content')

@if (session('notification'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('notification') }}
    </div>
@endif

@if (session('notification_mal'))
    <div class="alert alert-danger" role="alert">
        {{ session()->get('notification_mal') }}
    </div>
@endif

<div class="container py-3">
    @if(isset($eventoGlobal) && !$eventoGlobal->activo)
        <!-- Convocatoria Cerrada / Concluida -->
        <div class="card border-warning shadow-sm mb-4">
            <div class="card-header bg-warning text-dark font-weight-bold py-3" style="font-size: 1.25rem;">
                <i class="fas fa-lock mr-2"></i> Convocatoria de Inscripciones Concluida
            </div>
            <div class="card-body p-4 text-center">
                <div class="my-3">
                    <i class="fas fa-calendar-times text-warning" style="font-size: 3.5rem;"></i>
                </div>
                <h3 class="text-dark font-weight-bold mb-3">El periodo de registro oficial ha finalizado</h3>
                <div class="alert alert-light border py-3 px-4 mx-auto text-dark" style="max-width: 800px; font-size: 1.15rem; line-height: 1.6; background-color: #fdfaf2;">
                    {{ $eventoGlobal->mensaje_cierre ?? 'El periodo de inscripciones para el LV Concurso Regional de Física y Matemáticas ha concluido. Agradecemos su participación e interés.' }}
                </div>
                <hr class="my-4">
                <p class="mb-3 text-secondary" style="font-size: 1.05rem;">
                    <strong>¿Ya te habías registrado previamente?</strong> Puedes iniciar sesión con tu cuenta para consultar el estatus de tu solicitud o descargar tu Credencial Oficial con Código QR:
                </p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 py-2 shadow font-weight-bold" style="background-color: #004990; border-color: #004990; font-size: 1.15rem;">
                    <i class="fas fa-sign-in-alt mr-2"></i> Acceso para Alumnos Registrados
                </a>
            </div>
        </div>

        <div class="text-center text-muted mt-3" style="font-size: 1rem;">
            Para dudas o aclaraciones comunicarse al correo <b><a href="mailto:concurso.fismat@unison.mx">concurso.fismat@unison.mx</a></b> o a los teléfonos 6622592108 y 6622592109.
        </div>
    @else
        <!-- Convocatoria Abierta (Flujo Habitual) -->
        <div style="font-size: 20px">
            {{-- Contenido --}}
            <br>En esta plataforma podrás inscribirte al <strong>LV Concurso Regional de Física y Matemáticas</strong>, para esto, deberás seguir las siguientes instrucciones:<br><br>

            <ol>
                <li>Crea una cuenta en la pestaña <b><a href="{{ route('register') }}">REGISTRO</a></b> proporcionando tu nombre, tu dirección de correo electrónico y una contraseña.</li><br>
                <li>Ingresa a la bandeja de entrada de tu correo electrónico, busca el correo de verificación que te hemos enviado, y <b>confirma</b> que la dirección de correo que nos proporcionaste te pertenece. Revisa la carpeta de correo no deseado o SPAM si no recibiste el correo en tu bandeja de entrada.</li><br>
                <li>Una vez confirmado tu correo, serás redirigido a esta plataforma. En la pestaña <b><a href="{{ route('login') }}">ACCESO</a></b> podrás ingresar a tu perfil y completar la información y envío de documentos requeridos para la inscripción. Deberás tener a la mano tu CURP, una constancia de estudios (o credencial escolar) expedida por la escuela donde estudias, y una fotografía para credencial, todos estos en formato JPG, JPEG o PNG.<br></li><br>
                <li>Al enviar tu solicitud, el comité organizador verificará que tu documentación esté completa y <b>te confirmará por correo electrónico si tu inscripción se completó satisfactoriamente asignándote tu número de folio oficial.</b> En caso de que el comité te solicite que reenvíes nuevamente algún documento, deberás ingresar a tu cuenta en esta plataforma y realizar el reenvío correspondiente.</li><br>
            </ol>
            
            <p><b>IMPORTANTE</b>: Tienes hasta el <strong>1 de mayo de 2026</strong> para inscribirte al concurso, y recuerda que la inscripción estará finalizada hasta que el Comité así te lo confirme por correo, de modo que te pedimos estar atento al mismo. 
            <br /><b style="color:red;">¡No habrá inscripciones presenciales durante los días del concurso!</b></p>
            <p>Para dudas o aclaraciones comunicarse al correo <b><a href="mailto:concurso.fismat@unison.mx">concurso.fismat@unison.mx</a></b> o a los teléfonos 6622592108 y 6622592109.</p>
        </div>
    @endif
</div>

@endsection