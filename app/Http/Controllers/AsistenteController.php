<?php

namespace App\Http\Controllers;

use App\Asistente;
use App\Concursos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\DocumentosController;
use DB;
use Illuminate\Support\Facades\Validator;

class AsistenteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:web', 'verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('asistente.perfil');
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
     * @param  \App\Asistente  $asistente
     * @return \Illuminate\Http\Response
     */
    public function show(Asistente $asistente)
    {
        if (!auth('revisor')->check() && auth()->id() !== $asistente->id) {
            abort(403, 'Acceso Denegado: No tienes autorización para consultar el expediente de otro participante.');
        }
        return view('asistente.perfil');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asistente  $asistente
     * @return \Illuminate\Http\Response
     */
    public function edit(Asistente $asistente)
    {
        if (!auth('revisor')->check() && auth()->id() !== $asistente->id) {
            abort(403, 'Acceso Denegado: No tienes autorización para ver o modificar los datos de otro participante.');
        }
        return view('asistente.formInscripcion', compact('asistente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asistente  $asistente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asistente $asistente)
    {
        if (!auth('revisor')->check() && auth()->id() !== $asistente->id) {
            abort(403, 'Acceso Denegado: No tienes autorización para modificar los datos de otro participante.');
        }
        //
        //dd($request);

        $val = Validator::make($request->all(),[
            'curp' => ['required', 'regex:/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/'],
            'fecha_nacimiento' => ['required', 'date_format:Y-m-d'],
            'escuela_origen' => ['required', ],
            'telefono' => ['required', 'digits:10',],
            'concurso.*' => ['required', 'digits_between:1,3'],
            'image_croped' => ['required', 'min:500'],
            'foto_asistente' => ['sometimes', 'nullable'],
            'constancia_escuela' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:30720'],
            'asesor_nombre' => ['required', 'string', 'max:191'],
            'asesor_apellido_paterno' => ['required', 'string', 'max:191'],
            'asesor_apellido_materno' => ['nullable', 'string', 'max:191'],
            'asesor_correo' => ['required', 'email', 'max:191'],
            'asesor_telefono' => ['required', 'digits:10'],
            'asesor_escuela' => ['nullable', 'string', 'max:191'],
        ]);

        //dd($val);

        if ($val->fails())
        {
            return redirect()->back()->withInput()->withErrors($val->errors());
        }  
        
        $idConcursos= $request->input('concurso');
        $documentos = new DocumentosController();
        
        $concursos = Concursos::findOrFail($idConcursos);

        $asistente->curp = $request->input('curp');
        
        $asistente->fecha_nacimiento = $request->input('fecha_nacimiento');
        $asistente->escuela_origen = $request->input('escuela_origen');
        $asistente->telefono = $request->input('telefono');
        
        $asistente->concursos()->attach($concursos);        
       
        $asistente->save();

        // Guardar o actualizar información del Maestro Asesor / Tutor
        $escuelaAsesor = $request->input('asesor_escuela');
        if (empty($escuelaAsesor)) {
            $escuelaAsesor = $request->input('escuela_origen');
        }

        $asistente->asesor()->updateOrCreate(
            ['id_asistente' => $asistente->id],
            [
                'nombre' => trim($request->input('asesor_nombre')),
                'apellido_paterno' => trim($request->input('asesor_apellido_paterno')),
                'apellido_materno' => trim($request->input('asesor_apellido_materno')),
                'correo_electronico' => trim($request->input('asesor_correo')),
                'telefono' => $request->input('asesor_telefono'),
                'escuela_origen' => trim($escuelaAsesor),
            ]
        );

        /**
         * DOCUMENTOS
         * se llama a la funcion store del controlador DocumentosController.
         */

        $documentos->store($request,$asistente);
        //============

    
        // $asistente->save();
        return redirect()->route('asistentes.show', compact('asistente'));
        
    }
    

    public function indexRechazados(){
        
        $cabecera = array();
        $estadosDocumentos = DB::table('documentos')
            ->where('documentos.id_asistente', '=' ,auth()->user()->id)
            ->join('validaciones', 'validaciones.id_documento', '=' , 'documentos.id')
            ->latest('validaciones.updated_at')->first();
        // dd(gettype($estadosDocumentos));
        $cabecera['documentos_rechazados'] = explode(',',$estadosDocumentos->doc_rechazado);
        $cabecera['documentos_rechazados'] = array_map('trim',$cabecera['documentos_rechazados']);
        // dd($cabecera['estados_documentos']);
        return view('asistente.editarDocumentos', compact('cabecera'));

        
        // return view('asistente.editarDocumentos');
    }
    public function credencial()
    {
        $asistente = auth()->user();
        if (!$asistente || !$asistente->folio) {
            return redirect()->route('asistentes.index')->with('notification_mal', 'Tu inscripción aún no ha sido aprobada o no cuentas con folio oficial asignado.');
        }

        $validacion = optional(optional($asistente->documentos)->validaciones())->latest()->first();
        if (!$validacion || $validacion->estado !== 'Aprobado') {
            return redirect()->route('asistentes.index')->with('notification_mal', 'Tu solicitud de inscripción debe estar en estado Aprobado para acceder a la credencial.');
        }

        $concursos = $asistente->concursos;
        return view('asistente.credencial', compact('asistente', 'concursos', 'validacion'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asistente  $asistente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asistente $asistente)
    {
        //
    }
}
