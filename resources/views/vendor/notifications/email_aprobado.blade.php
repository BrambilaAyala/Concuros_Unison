<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Hola {{ $nombre . " " . $apellido_paterno . " " . $apellido_materno }}, gracias por registrarte en el <strong>Concurso Regional de Física y Matemáticas</strong> !</h2>
    <p>Te damos la bienvenida, haz sido  <b>{{ $estado }}</b>.</p>
    <p>Estos son tus concursos: <b>{{ $concursos }}</b></p>
    <p>Nos vemos pronto!</p>

{{--     <a href="{{ redirect()->getUrlGenerator()->previous() . '/verify/' . $confirmation_code }}">
        Clic para confirmar tu email
    </a> --}}
</body>
</html>