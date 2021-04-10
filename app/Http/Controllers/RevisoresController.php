<?php

namespace App\Http\Controllers;

use App\Revisores;
use App\Asistente;
use Illuminate\Http\Request;


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
        return view('revisor.index');
    }

    public function listaEspera()
    {
        $asistentes = Asistente::join('documentos', 'asistentes.id', '=', 'documentos.id_asistente')
        ->join('validaciones', 'documentos.id', '=', 'validaciones.id_documento')->where('estado', 'Espera')
        ->select('asistentes.id', 'asistentes.nombre', 'documentos.created_at')
        ->orderBy('created_at', 'asc')->get();
        //$asistentes_espera = $asistentes->where()
        //dd($asistentes);
        return view('revisor.listaEspera', compact('asistentes'));
    }

    public function listaAsistentes()
    {
        return view('revisor.listaAsistentes');
    }

    public function listaInscritos()
    {
        return view('revisor.listaInscritos');
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
    public function destroy(Revisores $revisores)
    {
        //
    }



}
