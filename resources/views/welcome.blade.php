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

<div class="container">
    <div class="row justify-content-center" style="font-size: 20px">
        
        {{-- Contenido --}}

        <p>El proceso de inscripción será habilitado del <b>1 de abril al 27 de abril de 2019</b> en el siguiente enlace (Inscripciones) 
        y los pasos a seguir por cada uno de los interesados en participar en los concursos, son los siguientes:</p>
        
        <ol>
            <li>Registrar sus datos en la página de registro de participantes (<b>del 1 al 27 de abril!</b>). Con esto, se le envía un correo con los datos registrados (usualmente llega a la carpeta de correos "no deseados").</li>
            <li>Ingresar al sistema de registro de participantes (con los datos de acceso enviados por correo) para enviar la documentación que solicitan los concursos.</li>
            <li>El comité organizador del concurso valida que la documentación sea correcta. Una vez revisados los documentos, se les envía un nuevo correo electrónico con la revisión realizada.</li>
            <li>En caso de que la documentación enviada sea correcta, <b>la inscripción está completada</b>. En caso de que algún documento sea incorrecto, el interesado deberá enviarlo de nuevo.</li>
            <li>Presentarse el día del concurso (<b>6 de mayo de 2019</b>) con una identificación para recoger su credencial de concursante.</li>
        </ol>

    </div>
</div>

@endsection