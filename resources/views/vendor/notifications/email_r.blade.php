
<html lang="es">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Hola {{ $nombre . " " . $apellido_paterno . " " . $apellido_materno }}, haz olvidado tu contraseña?</h2>
        <p>En poco tiempo podemos solucionarlo!</p>
        <p>Para cambiar de contraseña simplemente debes hacer click en el siguiente enlace:</p>
    
        <a href="{{ redirect()->getUrlGenerator()->previous() . '/' . $token }}">
            Clic para cambiar tu contraseña
        </a>
    </body>
    </html>
    