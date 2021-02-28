<?php

namespace App\Http\Controllers;

use App\Asistente as Asistente;
use App\Documentos;
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
    public function store($foto,$acta,$constancia,$idAsistente)
    {
        $asistente = Asistente::findOrFail($idAsistente);
        $fecha_creacion = Carbon::now()->setTimezone('GMT-7')->format('d_M_Y , g:ia');
        
        $documentos = new Documentos();
        $documentos->foto_asistente = $foto;
        $documentos->acta_asistente = $acta;
        $documentos->constancia_escuela = $constancia;
        $documentos->fecha_creacion = $fecha_creacion;
        $asistente->documentos()->save($documentos);
        $documentos->save();
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
