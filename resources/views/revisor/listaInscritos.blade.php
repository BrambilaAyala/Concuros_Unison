@extends('layouts.app_admin')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1 class="m-0 text-dark">Lista de los alumnos que se le acepto la documentacion</h1>
                    <hr style="background-color: black;">
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    {{-- @php
        // dd($asistentesInscritos[0]->documentos->validaciones->last()->estado =='Aprobado');
        dd(isset($asistentesInscritos[0]->documentos->validaciones));
    @endphp --}}
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            {{-- buscador --}}
            <label for="inputBuscadorNombre">Buscador por: Nombre, Folio, Concursos, Estado</label>
            <br>
            <input type="text" id="inputBuscadorNombre" onkeyup="buscadorPorNombre()" placeholder="Busca por nombre..." title="Escribe un nombre"> <br>
            <input type="hidden" id="vistaInscritos" name="vistaInscritos" value = 1>
            {{-- fin buscador --}}
            <div class="card">
                <div class="card-body table-responsive p-0" style="max-height: 700px;">
                  <table class="table table-head-fixed text-nowrap">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>No. Folio</th>
                        {{-- <th>Fecha de envio de documento</th> --}}
                        <th>Concursos</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($asistentesInscritos as $asistenteInscrito)
                        @if (isset($asistenteInscrito->documentos->validaciones))
                          @if ($asistenteInscrito->documentos->validaciones->last()->estado == 'Aprobado')
                            @php
                                  
                              $arrayConcursos = Array();
                              for($i = 0 ; $i <  count($asistenteInscrito->concursos) ; $i++){
                                $arrayConcursos[] = $asistenteInscrito->concursos[$i]->nombre ;
                                
                              }
                              $concursos = implode(", ",$arrayConcursos);
                            @endphp
                            <tr id='tablaTR'>
                              <td><p>{{$asistenteInscrito->nombre}} {{$asistenteInscrito->apellido_paterno}} {{$asistenteInscrito->apellido_materno}}</p></td>
                              {{-- <td>{{$asistenteInscrito->fecha_creacion}}</td> --}}
                              <td><p>{{$asistenteInscrito->folio}}</p></td>
                              <td><p>{{$concursos}}</p></td>
                              
                            </tr>
                          @endif
                          
                        @endif
                        
                      @endforeach
                      
                    </tbody>
                  </table>
                </div>
              </div>
        </div>
    </div>

@endsection
<script src="{{asset('js/admin.js')}}"></script>