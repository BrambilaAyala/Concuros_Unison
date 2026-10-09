<?php

namespace App\Http\Controllers;

use App\Asistente;
use App\Revisores;
use App\Concursos;
use App\Validaciones;
use App\Documentos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;

class RevisoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:revisor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalAsistentes = Asistente::count();
        $enEspera = DB::table('validaciones')
            ->where('estado', 'Espera')
            ->count();
        $aprobados = DB::table('validaciones')
            ->where('estado', 'Aprobado')
            ->count();
        $rechazados = DB::table('validaciones')
            ->where('estado', 'Rechazado')
            ->count();

        $sinDocumentos = $totalAsistentes - ($enEspera + $aprobados + $rechazados);
        if ($sinDocumentos < 0) {
            $sinDocumentos = 0;
        }

        $concursos = Concursos::withCount('asistentes')->get();

        $ultimasValidaciones = Validaciones::with(['documento.asistente'])
            ->latest()
            ->take(5)
            ->get();

        return view('revisor.index', compact(
            'totalAsistentes',
            'enEspera',
            'aprobados',
            'rechazados',
            'sinDocumentos',
            'concursos',
            'ultimasValidaciones'
        ));
    }

    public function listaEspera()
    {
        $asistentes = Asistente::with(['documentos.validaciones', 'concursos'])
            ->orderBy('id', 'desc')
            ->get();

        return view('revisor.listaEspera', compact('asistentes'));
    }

    public function listaAsistentes()
    {
        $asistentes = Asistente::with(['documentos.validaciones', 'concursos'])
            ->orderBy('id', 'desc')
            ->get();
        
        return view('revisor.listaAsistentes', compact('asistentes'));
    }

    public function listaInscritos()
    {
        $asistentesInscritos = Asistente::with(['documentos.validaciones', 'concursos'])
            ->whereNotNull('folio')
            ->orderBy('folio', 'asc')
            ->get();

        // Si por alguna razón un alumno aprobado no tiene folio aún, incluirlo también
        if ($asistentesInscritos->isEmpty()) {
            $asistentesInscritos = Asistente::with(['documentos.validaciones', 'concursos'])
                ->whereHas('documentos.validaciones', function($q) {
                    $q->where('estado', 'Aprobado');
                })
                ->get();
        }

        return view('revisor.listaInscritos', compact('asistentesInscritos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Revisores  $revisores
     * @return \Illuminate\Http\Response
     */
    public function show(Revisores $revisores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Revisores  $revisores
     * @return \Illuminate\Http\Response
     */
    public function edit(Revisores $revisores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Revisores  $revisores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Revisores $revisores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Revisores  $revisores
     * @return \Illuminate\Http\Response
     */
    public function createAsistente()
    {
        $concursos = Concursos::all();
        return view('revisor.crearAsistente', compact('concursos'));
    }

    public function storeAsistente(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:80',
            'apellido_paterno' => 'required|string|max:80',
            'apellido_materno' => 'nullable|string|max:80',
            'correo_electronico' => 'required|email|max:80|unique:asistentes,correo_electronico',
            'contrasena' => 'nullable|string|min:6',
            'curp' => 'required|string|max:18',
            'telefono' => 'nullable|numeric',
            'escuela_origen' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'concursos' => 'required|array|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'constancia' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'asesor_nombre' => 'nullable|string|max:191',
            'asesor_apellido_paterno' => 'nullable|string|max:191',
            'asesor_apellido_materno' => 'nullable|string|max:191',
            'asesor_correo' => 'nullable|email|max:191',
            'asesor_telefono' => 'nullable|digits:10',
            'asesor_escuela' => 'nullable|string|max:191',
        ]);

        $fecha_actual = Carbon::now();
        $fecha_actual->setTimezone('GMT-7');

        // Determinar contraseña: la que escribió el admin, o por defecto la CURP
        $rawContrasena = !empty($request->contrasena) ? trim($request->contrasena) : strtoupper(trim($request->curp));

        // 1. Crear el Asistente
        $asistente = new Asistente();
        $asistente->nombre = trim($request->nombre);
        $asistente->apellido_paterno = trim($request->apellido_paterno);
        $asistente->apellido_materno = trim($request->apellido_materno);
        $asistente->correo_electronico = trim($request->correo_electronico);
        $asistente->contrasena = Hash::make($rawContrasena);
        $asistente->curp = strtoupper(trim($request->curp));
        $asistente->fecha_nacimiento = $request->fecha_nacimiento;
        $asistente->telefono = $request->telefono;
        $asistente->escuela_origen = trim($request->escuela_origen);
        $asistente->email_verified_at = $fecha_actual;
        $asistente->fecha_registro_aceptado = $fecha_actual->format('d_M_Y , g:ia');
        $asistente->save();

        // Guardar Asesor si se proporcionó información en el registro manual
        if (!empty($request->asesor_nombre) && !empty($request->asesor_apellido_paterno)) {
            $escuelaAsesor = !empty($request->asesor_escuela) ? trim($request->asesor_escuela) : trim($request->escuela_origen);
            $asistente->asesor()->create([
                'nombre' => trim($request->asesor_nombre),
                'apellido_paterno' => trim($request->asesor_apellido_paterno),
                'apellido_materno' => trim($request->asesor_apellido_materno),
                'correo_electronico' => trim($request->asesor_correo ?? ''),
                'telefono' => $request->asesor_telefono,
                'escuela_origen' => $escuelaAsesor,
            ]);
        }

        // 2. Asociar los concursos seleccionados
        $asistente->concursos()->attach($request->concursos);

        // 3. Manejar documentos (si subieron archivos o usar placeholders)
        $fotoPath = 'fotos-de-asistentes/default_aspirante.png';
        if ($request->hasFile('foto')) {
            $fotoExt = $request->file('foto')->getClientOriginalExtension();
            $fotoName = $asistente->curp . '_' . $fecha_actual->format('d_M_Y_h') . '.' . $fotoExt;
            $request->file('foto')->storeAs('fotos-de-asistentes', $fotoName, 'public');
            $fotoPath = "fotos-de-asistentes/$fotoName";
        }

        $constanciaPath = 'constancias-escuelas/default_constancia.png';
        if ($request->hasFile('constancia')) {
            $constExt = $request->file('constancia')->getClientOriginalExtension();
            $constName = $asistente->curp . '_' . $fecha_actual->format('d_M_Y_h') . '.' . $constExt;
            $request->file('constancia')->storeAs('constancias-escuelas', $constName, 'public');
            $constanciaPath = "constancias-escuelas/$constName";
        }

        $documento = new Documentos();
        $documento->id_asistente = $asistente->id;
        $documento->foto_asistente = $fotoPath;
        $documento->constancia_escuela = $constanciaPath;
        $documento->acta_asistente = '';
        $documento->fecha_creacion = $fecha_actual->format('d_M_Y , g:ia');
        $documento->save();

        // 4. Generar Folio Oficial conforme al algoritmo de SICREFyM
        $año_edicion = $fecha_actual->year;
        $cursos_folio = [0, 0, 0];
        $concursosTexto = [];
        foreach ($asistente->concursos()->get() as $c) {
            if ($c->id >= 1 && $c->id <= 3) {
                $cursos_folio[$c->id - 1] = 1;
            }
            $concursosTexto[] = $c->nombre;
        }
        $cantidad_aprobados = Validaciones::where('estado', 'Aprobado')->count() + 1;
        $alumnos_folio_str = str_pad($cantidad_aprobados, 3, '0', STR_PAD_LEFT);
        $folio = $año_edicion . '-' . implode('', $cursos_folio) . '-' . $alumnos_folio_str;

        $asistente->folio = $folio;
        $asistente->save();

        // 5. Crear la Validación en estado Aprobado
        $validacion = new Validaciones();
        $validacion->id_documento = $documento->id;
        $validacion->id_revisor = auth('revisor')->id();
        $validacion->estado = 'Aprobado';
        $validacion->comentario = 'Inscripción manual extemporánea realizada directamente por el Comité Revisor.';
        $validacion->fecha_validacion = $fecha_actual->format('d_M_Y , g:ia');
        $validacion->save();

        // 6. Enviar correo de confirmación con Folio y Contraseña
        $emailEnviado = false;
        try {
            $data = [
                "nombre" => $asistente->nombre,
                "apellido_paterno" => $asistente->apellido_paterno,
                "apellido_materno" => $asistente->apellido_materno,
                "correo_electronico" => $asistente->correo_electronico,
                "estado" => $validacion->estado,
                "concursos" => implode(", ", $concursosTexto),
                "folio" => $folio,
                "contrasena" => $rawContrasena,
            ];
            \Illuminate\Support\Facades\Mail::send('vendor.notifications.email_aprobado', $data, function($message) use ($data) {
                $message->to($data['correo_electronico'], $data['nombre'])
                        ->subject('CRFyM - Confirmación de inscripción y Folio Oficial');
            });
            $emailEnviado = true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("No se pudo enviar correo SMTP: " . $e->getMessage());
        }

        $msg = "¡Aspirante {$asistente->nombre} {$asistente->apellido_paterno} inscrito exitosamente! • Folio Oficial: {$folio} • Contraseña de acceso: {$rawContrasena}";
        if ($emailEnviado) {
            $msg .= " • Se ha enviado el correo con su confirmación a {$asistente->correo_electronico}.";
        } else {
            $msg .= " • (Nota: El correo no se pudo despachar automáticamente por la configuración SMTP; entrega el folio y contraseña manualmente al alumno).";
        }

        return redirect()->route('revisores.lista-inscritos')->with('notification', $msg);
    }

    public function wsGetUserData($id){
        $userData = Asistente::with('asesor')->findOrFail($id);
        if ($userData->documentos()->exists()) {
            $userStatus = $userData->documentos->validaciones->last();
            $userCourses = $userData->concursos;
            $data = array($userData, $userStatus, $userCourses);
        } else {
            $inscrito = false;
            $data = array($userData, $inscrito);
        }
        return json_encode($data);
    }

    public function toggleConvocatoria(Request $request)
    {
        $evento = \App\Evento::first();
        if (!$evento) {
            $evento = \App\Evento::create([
                'nombre' => 'LV Concurso Regional de Física y Matemáticas',
                'edicion' => 'LV (2026)',
                'activo' => true,
                'mensaje_cierre' => 'El periodo de inscripciones para el LV Concurso Regional de Física y Matemáticas ha concluido. Agradecemos su participación e interés.',
            ]);
        }

        $evento->activo = !$evento->activo;
        $evento->save();

        $estado = $evento->activo ? 'ABIERTA (Inscripciones Activas)' : 'CERRADA (Inscripciones Desactivadas)';
        return redirect()->back()->with('notification', "El estado de la convocatoria ha cambiado: ahora se encuentra {$estado}.");
    }

    public function actualizarMensajeCierre(Request $request)
    {
        $request->validate([
            'mensaje_cierre' => 'required|string|max:1000',
        ]);

        $evento = \App\Evento::first();
        if (!$evento) {
            $evento = \App\Evento::create([
                'nombre' => 'LV Concurso Regional de Física y Matemáticas',
                'edicion' => 'LV (2026)',
                'activo' => true,
                'mensaje_cierre' => $request->mensaje_cierre,
            ]);
        } else {
            $evento->mensaje_cierre = $request->mensaje_cierre;
            $evento->save();
        }

        return redirect()->back()->with('notification', 'El mensaje oficial de cierre de convocatoria ha sido actualizado exitosamente.');
    }


}
