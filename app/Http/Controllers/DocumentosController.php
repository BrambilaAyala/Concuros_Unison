<?php

namespace App\Http\Controllers;

use App\Asistente as Asistente;
use App\Documentos;
use App\Validaciones;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DocumentosController extends Controller
{
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

        // dd($asistente->curp);
        /**
         * fechas utilizadas con el formato dia_mes_anio, hora:minutos am-pm
         */
        $fecha_actual = Carbon::now();
        $fecha_actual->setTimezone('GMT-7');
        $fecha_creacion = Carbon::now()->setTimezone('GMT-7')->format('d_M_Y , g:ia');
        $asistente = Asistente::findOrFail($asistente->id);
        $documentos = new Documentos();
        $validacion = new Validaciones();

        $extensiones = [
            'foto_asistente'     => $request->file('foto_asistente')->getClientOriginalExtension(),
            'acta_asistente'     => $request->file('acta_asistente')->getClientOriginalExtension(),
            'constancia_escuela' => $request->file('constancia_escuela')->getClientOriginalExtension()
        ];
        
        $documentos->foto_asistente = $request->file('foto_asistente')->storeAs('fotos-de-asistentes',$asistente->curp.'_'.$fecha_actual->format('d_M_Y_h').'.'.$extensiones['foto_asistente']);
        $documentos->acta_asistente = $request->file('acta_asistente')->storeAs('actas-asistentes',$asistente->curp.'_'.$fecha_actual->format('d_M_Y_h').'.'.$extensiones['acta_asistente']);
        $documentos->constancia_escuela = $request->file('constancia_escuela')->storeAs('constancias-escuelas',$asistente->curp.'_'.$fecha_actual->format('d_M_Y_h').'.'.$extensiones['constancia_escuela']);
        $documentos->fecha_creacion = $fecha_creacion;
        $asistente->documentos()->save($documentos);
        $documentos->validaciones()->create([$documentos->id]);
        $documentos->save();
        
        // dd($validacion->documento());
        // $nombreArchivo = $request->file('foto_asistente')->getClientOriginalName();
        
        
        

        
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
}
