@extends('layouts.app_admin')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1 class="m-0 text-dark">Lista de todos los alumnos que enviaron documentacion</h1>
                    <hr style="background-color: black;">
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
   {{-- @php
       dd($asistentes[1]->concursos);
   @endphp --}}
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid" >
          {{-- buscador --}}
          <label for="inputBuscadorNombre">Buscador por: Nombre, Folio, Concursos, Estado</label>
          <br>
          <input type="text" id="inputBuscadorNombre" onkeyup="buscadorPorNombre()" placeholder="Busca por nombre..." title="Escribe un nombre"> <br>
          {{-- fin buscador --}}
            <div class="card" style="top: 1rem;">
                <div class="card-body table-responsive p-0" style="max-height: 700px;">
                  <table class="table table-head-fixed text-nowrap">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        {{-- <th>Fecha de envio de documento</th> --}}
                        <th>No. Folio</th>
                        <th>Concursos inscrito</th>
                        <th>Estado de inscripción</th>
                        {{-- <th>Acción</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      {{-- @php
                          dd($asistentes[1]->documentos->last()->validaciones);
                      @endphp --}}
                      @foreach ($asistentes as $key => $asistente)
                      
                        <tr id='tablaTR'>
                          <td><p id='nombre'>{{$asistente->nombre}} {{$asistente->apellido_paterno}} {{$asistente->apellido_materno}}</p></td>
                          {{-- @if (isset($asistente->documentos->last()->fecha_creacion)) --}}
                            {{-- <td><p >{{$asistente->documentos->fecha_creacion}}</p></td> --}}

                            @if (isset($asistente->folio))
                              <td><p id="folio">{{$asistente->folio}}</p></td>
                            @else 
                            
                              <td><p >Alumno sin número de folio</p></td>
                            @endif
                            {{-- 
                              Codigo para concatenar los concursos inscrito del alumno  
                            --}}
                            @php
                              
                              $concursos = Array();
                              for($i = 0 ; $i <  count($asistente->concursos) ; $i++){
                                $concursos[] = $asistente->concursos[$i]->nombre ;
                                
                              }
                              $resultado = implode(", ",$concursos);
                            @endphp
                            {{-- 
                              FIN CODIGO
                            --}}
                            <td><p>{{$resultado}}</p></td>
                            <td><p>{{$asistente->documentos->validaciones->last()->estado}}</p></td>
                            {{-- @if ($asistente->documentos->last()->validaciones[$key]->estado == 'Espera' )
                              <td><a class="btn btn-primary" href="{{ route('validaciones.edit', $asistente->id) }}"  type="submit">Validar</a></td>
                            @endif --}}
                            
                          {{-- @else 
                            <td><p>Alumno no inscrito</p> </td>
                            <td><p >Alumno sin número de folio</p></td>
                          @endif --}}
                          
                          
                        </tr>
                      @endforeach
                      
                    </tbody>
                  </table>
                </div>
              </div>
        </div>
    </div>
@endsection
<script src="{{asset('js/admin.js')}}"></script>