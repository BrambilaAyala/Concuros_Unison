<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #002e5b; padding: 15px; text-align: center; border-radius: 6px 6px 0 0;">
        <h2 style="color: #ffffff; margin: 0; font-size: 18px; text-transform: uppercase; letter-spacing: 1px;">Universidad de Sonora</h2>
        <h3 style="color: #f7a11a; margin: 5px 0 0 0; font-size: 14px;">LV Concurso Regional de Física y Matemáticas</h3>
    </div>

    <div style="border: 1px solid #ddd; border-top: none; padding: 25px; border-radius: 0 0 6px 6px;">
        <h2 style="color: #004990; margin-top: 0;">Hola {{ $nombre . " " . $apellido_paterno . " " . $apellido_materno }}</h2>

        <p>Te confirmamos que tu inscripción al <strong>LV Concurso Regional de Física y Matemáticas</strong> ha finalizado exitosamente.</p>

        @if(isset($folio) && !empty($folio))
        <div style="background-color: #eef5fc; border: 2px dashed #004990; padding: 15px; margin: 20px 0; text-align: center; border-radius: 8px;">
            <span style="color: #666; font-size: 13px; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; display: block;">Número de Folio Oficial Asignado:</span>
            <span style="font-size: 26px; color: #004990; font-weight: bold; font-family: monospace; display: block; margin-top: 5px;">{{ $folio }}</span>
            @if(isset($concursos) && !empty($concursos))
                <p style="margin: 8px 0 0 0; font-size: 14px; color: #444;"><strong>Concurso(s):</strong> {{ $concursos }}</p>
            @endif
        </div>
        @endif

        @if(isset($contrasena) && !empty($contrasena))
        <div style="background-color: #fff9e6; border-left: 4px solid #f7a11a; padding: 12px 15px; margin: 15px 0; border-radius: 4px;">
            <p style="margin: 0; font-weight: bold; color: #8a6d3b;">Tus credenciales para ingresar a la plataforma:</p>
            <p style="margin: 5px 0 0 0; font-size: 14px;">
                • <strong>Correo:</strong> {{ $correo_electronico }}<br>
                • <strong>Contraseña:</strong> <span style="font-family: monospace; font-size: 15px; background: #eee; padding: 1px 6px; border-radius: 3px;">{{ $contrasena }}</span>
            </p>
        </div>
        @endif

        <p><strong>IMPORTANTE:</strong> Es indispensable que conserves este número de folio, pues te servirá para identificar el aula donde se aplicarán los exámenes y para ingresar a la plataforma a consultar y descargar tu <strong>Credencial Oficial con Código QR</strong>.</p>
        
        <p>Te solicitamos estar atento a la página del evento donde se publicarán los horarios y distribución de aulas correspondientes.</p>
        
        <p><br><strong>¡Te esperamos el día del evento y te deseamos mucho éxito!</strong></p>
        
        <hr style="border: none; border-top: 1px solid #eee; margin: 25px 0;">
        
        <p style="font-size: 13px; color: #666;">
            Para cualquier duda o aclaración sobre tu inscripción, puedes comunicarte al correo <a href="mailto:concurso.fismat@unison.mx" style="color: #004990;">concurso.fismat@unison.mx</a>.
        </p>
        
        <p style="margin-top: 20px; font-size: 14px;">
            Atentamente,<br>
            <strong>Comité Organizador del CRFyM</strong><br>
            Departamento de Física y Departamento de Matemáticas<br>
            Universidad de Sonora
        </p>
    </div>
</body>
</html>