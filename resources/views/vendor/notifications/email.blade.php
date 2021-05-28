<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Hola {{ $nombre . " " . $apellido_paterno . " " . $apellido_materno }}, gracias por registrarte en el <strong>Concurso Regional de Física y Matemáticas</strong> !</h2>
    <p>Por favor confirma tu correo electrónico.</p>
    <p>Para ello simplemente debes hacer click en el siguiente enlace:</p>

    <a href="{{ redirect()->getUrlGenerator()->previous() . '/verify/' . $confirmation_code }}">
        Clic para confirmar tu email
    </a>
</body>
</html>