<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('revisores*') || $request->is('admin*') || $request->is('wsgetuserdata*')) {
                session()->flash('notification_mal', 'Debes iniciar sesión con una cuenta de Administrador/Revisor para acceder a esta sección.');
                return route('admin');
            }

            if ($request->is('asistentes*') || $request->is('credencial-asistente*') || $request->is('documentos-rechazados*')) {
                session()->flash('notification_mal', 'Debes iniciar sesión con tu cuenta de participante para acceder a esta sección.');
                return route('login');
            }

            return route('/');
        }
    }
}
