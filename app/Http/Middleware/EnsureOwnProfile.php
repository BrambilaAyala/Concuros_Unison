<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureOwnProfile
{
    /**
     * Intercepta la petición y valida que un aspirante solo pueda acceder a su propio expediente.
     * Previene ataques de tipo IDOR (Insecure Direct Object Reference) manipulando IDs en la URL.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Si el usuario autenticado es un revisor, tiene facultades de administración
        if (Auth::guard('revisor')->check()) {
            return $next($request);
        }

        $asistenteParam = $request->route('asistente');

        if ($asistenteParam) {
            $targetId = is_object($asistenteParam) ? $asistenteParam->id : $asistenteParam;
            $currentUserId = Auth::guard('web')->id();

            if (!$currentUserId || (int)$targetId !== (int)$currentUserId) {
                abort(403, 'Acceso Denegado: No tienes autorización para consultar o modificar el expediente de otro participante.');
            }
        }

        return $next($request);
    }
}
