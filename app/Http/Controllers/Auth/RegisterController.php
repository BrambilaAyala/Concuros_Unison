<?php

namespace App\Http\Controllers\Auth;

use App\Asistente;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
//use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Rule\Parameters;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'asistentes';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showRegistrationForm()
    {
        $evento = \App\Evento::first();
        if ($evento && !$evento->activo) {
            return redirect('/')->with('notification_mal', 'El periodo de registro oficial ha concluido. Consulta el aviso oficial en la página principal.');
        }
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $evento = \App\Evento::first();
        if ($evento && !$evento->activo) {
            return redirect('/')->with('notification_mal', 'El periodo de registro oficial ha concluido. No se aceptan nuevas solicitudes.');
        }

        $this->validator($request->all())->validate();

        event(new \Illuminate\Auth\Events\Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new \Illuminate\Http\JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'correo_electronico' => ['required', 'string', 'max:255', 'unique:asistentes'],
            'contrasena' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
/* 
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]); */
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Asistente
     */
    protected function create(array $data)
    {
        $confirmation_code = Str::random(25);
        $data['confirmation_code'] = $confirmation_code;

        $asistente = Asistente::create([
            'nombre' => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'],
            'correo_electronico' => $data['correo_electronico'],
            'contrasena' => Hash::make($data['contrasena']),
            'confirmation_code' => $confirmation_code,
        ]);

        try {
            Mail::send('vendor.notifications.email_validacion', $data, function($message) use ($data) {
                $message->to($data['correo_electronico'], $data['nombre'])->subject('CRFyM - Verifica tu dirección de correo electrónico');
            });
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning("No se pudo enviar correo de validación a " . $data['correo_electronico'] . ": " . $e->getMessage());
        }

        return $asistente;
    }

}
