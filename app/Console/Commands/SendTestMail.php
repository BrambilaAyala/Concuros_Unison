<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email? : Correo electronico de destino}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba el envio de correos y la configuracion SMTP del sistema SICREFyM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $destinatario = $this->argument('email') ?? 'brambila4a@outlook.com';
        $mailer = config('mail.default');

        $this->info("==================================================");
        $this->info("     SICREFyM - Diagnóstico de Envío de Correo    ");
        $this->info("==================================================");
        $this->line("• Driver activo:       <comment>{$mailer}</comment>");
        
        if ($mailer === 'smtp') {
            $this->line("• Servidor SMTP:       <comment>" . config('mail.mailers.smtp.host') . "</comment>");
            $this->line("• Puerto:              <comment>" . config('mail.mailers.smtp.port') . "</comment>");
            $this->line("• Cifrado:             <comment>" . (config('mail.mailers.smtp.encryption') ?? 'Ninguno') . "</comment>");
            $this->line("• Usuario SMTP:        <comment>" . config('mail.mailers.smtp.username') . "</comment>");
        }
        
        $this->line("• Remitente (From):    <comment>" . config('mail.from.address') . " (" . config('mail.from.name') . ")</comment>");
        $this->line("• Destinatario prueba: <comment>{$destinatario}</comment>");
        $this->line('');

        $this->info("Intentando enviar correo de prueba con la plantilla oficial...");

        try {
            $data = [
                'nombre' => 'Aspirante',
                'apellido_paterno' => 'Prueba',
                'apellido_materno' => 'Técnica',
                'correo_electronico' => $destinatario,
                'confirmation_code' => 'TEST_TOKEN_' . strtoupper(substr(md5(time()), 0, 10))
            ];

            Mail::send('vendor.notifications.email_validacion', $data, function ($message) use ($destinatario) {
                $message->to($destinatario, 'Usuario de Prueba')
                        ->subject('CRFyM 2026 - Verificación de Sistema de Correo');
            });

            if ($mailer === 'log') {
                $this->info("✔ [MODO LOG ACTIVO] El correo se generó con éxito y se guardó en: storage/logs/laravel.log");
                $this->line("  (Abre storage/logs/laravel.log para ver el mensaje HTML completo)");
            } else {
                $this->info("✔ ¡ÉXITO! El servidor SMTP aceptó el mensaje y fue despachado a {$destinatario}.");
            }

            return 0;
        } catch (\Throwable $e) {
            $this->error("✘ ERROR AL ENVIAR CORREO:");
            $this->error($e->getMessage());
            $this->line('');
            $this->warn("Posibles causas:");
            if (strpos($e->getMessage(), 'timed out') !== false || strpos($e->getMessage(), 'Connection refused') !== false) {
                $this->line(" - El servidor SMTP no es accesible desde tu red actual (bloqueo de puerto o firewall).");
                $this->line(" - Si estás en una red doméstica, el servidor 'mail.mat.uson.mx' suele requerir estar dentro de la red UNISON o VPN.");
                $this->line(" - Para pruebas locales sin conexión a UNISON, cambia MAIL_MAILER=log en tu archivo .env.");
            } elseif (strpos($e->getMessage(), 'authentication') !== false || strpos($e->getMessage(), '535') !== false) {
                $this->line(" - Usuario o contraseña SMTP incorrectos en tu archivo .env.");
            }
            return 1;
        }
    }
}
