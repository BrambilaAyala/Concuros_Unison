<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Hola {{ $nombre . " " . $apellido_paterno . " " . $apellido_materno }}, gracias por registrarte en el <strong>Concurso Regional de Física y Matemáticas</strong> !</h2>
    <p>Hemos tenido algún problema con tus documentos enviados.</p>
    <p>Estos son los documentos con algún problema: <b>{{ $doc_rechazado }}</b>.</p>
    <p><pre>{{ $comentario }}</pre></p>
    <p>Por el momento tu estado dentro de nuestro registro se encuentra como <b>{{ $estado }}</b>.</p>
    <p>Si deseas subir tus archivos nuevamente con las correcciones hechas por favor igrersa a tu perfil dentro de la pagina de registro.</p>

{{--     <a href="{{ redirect()->getUrlGenerator()->previous() . '/verify/' . $confirmation_code }}">
        Clic para confirmar tu email
    </a> --}}
</body>
</html>