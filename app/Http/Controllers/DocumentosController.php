<?php

namespace App\Http\Controllers;

use App\Asistente as Asistente;
use App\Concursos;
use App\Documentos;
use App\Validaciones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentosController extends Controller
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
        //
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
    // public function store($foto,$acta,$constancia,$idAsistente)
    // {
    //     $asistente = Asistente::findOrFail($idAsistente);
    //     $fecha_creacion = Carbon::now()->setTimezone('GMT-7')->format('d_M_Y , g:ia');
        
    //     $documentos = new Documentos();
    //     $documentos->foto_asistente = $foto;
    //     $documentos->acta_asistente = $acta;
    //     $documentos->constancia_escuela = $constancia;
    //     $documentos->fecha_creacion = $fecha_creacion;
    //     $asistente->documentos()->save($documentos);
    //     $documentos->save();
    // }
    public function store(Request $request, Asistente $asistente)
    {
        //dd($request);
        // dd($asistente->curp);
        /**
         * fechas utilizadas con el formato dia_mes_anio, hora:minutos am-pm
         */
        $fecha_actual = Carbon::now();
        $fecha_actual->setTimezone('GMT-7');
        $fecha_creacion = Carbon::now()->setTimezone('GMT-7')->format('d_M_Y , g:ia');
        $asistente = Asistente::findOrFail($asistente->id);
        $documentos = new Documentos();

        $fotoPath = $this->saveCroppedPhoto($request->image_croped, $asistente->curp, $fecha_actual, $request->file('foto_asistente'));
        if ($fotoPath) {
            $documentos->foto_asistente = $fotoPath;
        }

        $extensiones = [
            'constancia_escuela' => $request->file('constancia_escuela')->getClientOriginalExtension()
        ];
        
        $request->hasFile('constancia_escuela') ? $documentos->constancia_escuela = $request->file('constancia_escuela')->storeAs('constancias-escuelas',$asistente->curp.'_'.$fecha_actual->format('d_M_Y_h').'.'.$extensiones['constancia_escuela'], 'public') : '';
        $documentos->fecha_creacion = $fecha_creacion;

        //dd($documentos);

        $asistente->documentos()->save($documentos);
        $documentos->validaciones()->create([
            'estado' => 'Espera',
        ]);
        $documentos->save();
        
        
        // dd($validacion->documento());
        // $nombreArchivo = $request->file('foto_asistente')->getClientOriginalName();
        
    }
    
    public function actualizarDocumentosRechazados(Request $request, Asistente $asistente){
        if (auth()->id() !== $asistente->id) {
            abort(403, 'Acceso Denegado: No tienes autorización para modificar la documentación de otro participante.');
        }

        $val = Validator::make($request->all(),[
            'image_croped' => ['sometimes', 'nullable', 'min:500'],
            'foto_asistente' => ['sometimes', 'nullable'],
            //'acta_asistente' => ['sometimes', 'file', 'image', 'mimes:jpeg,png,jpg'],
            'constancia_escuela' => ['sometimes', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:30720'],
        ]);

        //dd($val);

        if ($val->fails())
        {
            return redirect()->back()->withInput()->withErrors($val->errors());
        }  
        
        /**
         * DOCUMENTOS
         * se llama a la funcion store del controlador DocumentosController.
         */
        // dd($request->input('doc'));
        
        $fecha_actual = Carbon::now();
        $fecha_actual->setTimezone('GMT-7');
        $fecha_creacion = Carbon::now()->setTimezone('GMT-7')->format('d_M_Y , g:ia');
        $asistente = Asistente::findOrFail($asistente->id);
        $documentos = Documentos::findOrFail($asistente->documentos->id);
        // dd($documentos);
        $validacion = new Validaciones();

        if ($request->hasFile('foto_asistente') || !empty($request->image_croped)) {
            $fotoPath = $this->saveCroppedPhoto($request->image_croped, $asistente->curp, $fecha_actual, $request->file('foto_asistente'));
            if ($fotoPath) {
                $documentos->foto_asistente = $fotoPath;
            }
        }

        $extensiones = [
            'constancia_escuela' => $request->hasFile('constancia_escuela') ? $request->file('constancia_escuela')->getClientOriginalExtension() : ''
        ];
        
        $request->hasFile('constancia_escuela') ? $documentos->constancia_escuela = $request->file('constancia_escuela')->storeAs('constancias-escuelas',$asistente->curp.'_'.$fecha_actual->format('d_M_Y_h').'.'.$extensiones['constancia_escuela'],'public') : '';
        $documentos->fecha_creacion = $fecha_creacion;
        // dd($request->all());
        if ($request->input('concurso') !=null) {
            $idConcursos= $request->input('concurso');
            $concursos = Concursos::findOrFail($idConcursos);
            // dd('entro a cursos');
            $asistente->concursos()->sync($concursos);
        }
        // dd('hola');
        $asistente->documentos()->save($documentos);
        $documentos->validaciones()->create([
            'estado' => 'Espera',
        ]);
        $documentos->save();
        return redirect()->route('asistentes.show', compact('asistente'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Documentos  $documentos
     * @return \Illuminate\Http\Response
     */
    public function show(Documentos $documentos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Documentos  $documentos
     * @return \Illuminate\Http\Response
     */
    public function edit(Documentos $documentos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Documentos  $documentos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documentos $documentos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documentos  $documentos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documentos $documentos)
    {
        //
    }

    /**
     * Guarda la fotografía recortada (o archivo directo) en las ubicaciones de storage
     */
    private function saveCroppedPhoto($imageCroped, $curp, $fechaActual, $fileFallback = null)
    {
        $data = null;
        if (!empty($imageCroped) && strpos($imageCroped, ',') !== false) {
            $image_array_1 = explode(";", $imageCroped);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
        } elseif ($fileFallback && file_exists($fileFallback->getRealPath())) {
            $data = file_get_contents($fileFallback->getRealPath());
        }

        if (!$data) {
            return null;
        }

        $imageName = $curp . '_' . $fechaActual->format('d_M_Y_h') . '.png';

        $paths = [
            public_path("storage/fotos-de-asistentes"),
            storage_path("app/public/fotos-de-asistentes"),
            base_path("storage/fotos-de-asistentes")
        ];

        foreach ($paths as $path) {
            if (!file_exists($path)) {
                @mkdir($path, 0755, true);
            }
            @file_put_contents("$path/$imageName", $data);
        }

        return "fotos-de-asistentes/$imageName";
    }
}
