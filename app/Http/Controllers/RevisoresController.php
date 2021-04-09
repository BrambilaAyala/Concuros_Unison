<?php

namespace App\Http\Controllers;

use App\Asistente;
use App\Revisores;
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
        return view('revisor.index');
    }

    public function listaEspera()
    {
        return view('revisor.listaEspera');
    }

    public function listaAsistentes()
    {
        $asistentes = Asistente::orderBy('nombre')->get();
        
        return view('revisor.listaAsistentes',compact('asistentes'));
    }

    public function listaInscritos()
    {
        /**
         * 
         */
        $asistentesInscritos = DB::table('asistentes')
            ->join('documentos', 'asistentes.id', '=', 'documentos.id_asistente')
            ->join('validaciones', function($join){
                $join->on('documentos.id', '=', 'validaciones.id_documento' )
                        ->where('validaciones.estado', '=', 'Aprobado');
            })
            ->join('concursos','asistentes.id', '=','concursos.id')
            ->select('asistentes.*', 'validaciones.estado','documentos.fecha_creacion','concursos.nombre as nombre_concurso')
            ->orderBy('nombre_concurso')->orderBy('asistentes.folio')
            ->get();

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
        return view('revisor.validacion', compact('revisores'));
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
