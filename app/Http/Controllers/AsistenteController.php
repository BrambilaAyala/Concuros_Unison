<?php

namespace App\Http\Controllers;

use App\Asistente;
use App\Concursos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\DocumentosController;

class AsistenteController extends Controller
{
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
        //
        
        
        $idConcursos= $request->input('concurso');
        $documentos = new DocumentosController();
        $concursos = Concursos::findOrFail($idConcursos);

        $asistente->curp = $request->input('curp');
        
        $asistente->fecha_nacimiento = $request->input('fecha_nacimiento');
        $asistente->escuela_origen = $request->input('escuela_origen');
        $asistente->telefono = $request->input('telefono');
        
        $asistente->concursos()->attach($concursos);        
       

        /**
         * DOCUMENTOS
         */
        
        $nombreArchivo = $request->file('foto_asistente')->getClientOriginalName();
        $extension = $request->file('foto_asistente')->getClientOriginalExtension();
        
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        
        $foto_asistente = $request->file('foto_asistente')->storeAs('fotos-de-asistentes',$asistente->curp.'_'.$datetime->format('d_M_Y_h').'.'.$extension);
        $acta_asistente = $request->file('acta_asistente')->storeAs('actas-asistentes',$asistente->curp.'_'.$datetime->format('d_M_Y_h').'.'.$extension);
        $constancia_escuela = $request->file('constancia_escuela')->storeAs('constancias-escuelas',$asistente->curp.'_'.$datetime->format('d_M_Y_h').'.'.$extension);
        
        
        $documentos->store($foto_asistente,$acta_asistente,$constancia_escuela,$asistente->id);
        
        
    
        $asistente->save();
        return redirect()->route('asistentes.show', compact('asistente'));
        
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
