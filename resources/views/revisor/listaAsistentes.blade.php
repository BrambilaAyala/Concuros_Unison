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
    
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid" >
          {{-- buscador --}}
          <label for="inputBuscadorNombre">Buscador por nombre</label>
          <br>
          <input type="text" id="inputBuscadorNombre" onkeyup="buscadorPorNombre()" placeholder="Busca por nombre..." title="Escribe un nombre"> <br>
          {{-- fin buscador --}}
            <div class="card" style="top: 1rem;">
                <div class="card-body table-responsive p-0" style="max-height: 700px;">
                  <table class="table table-head-fixed text-nowrap">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Fecha de envio de documento</th>
                        <th>No. Folio</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($asistentes as $asistente)
                        <tr id='tablaTR'>
                          <td><p id='nombre'>{{$asistente->nombre}} {{$asistente->apellido_paterno}} {{$asistente->apellido_materno}}</p></td>
                          @if (isset($asistente->documentos->fecha_creacion))
                            <td><p >{{$asistente->documentos->fecha_creacion}}</p></td>
                            @if (isset($asistente->folio))
                              <td><p >{{$asistente->folio}}</p></td>
                            @else 
                              <td><p >Alumno sin número de folio</p></td>
                            @endif
                            
                          @else 
                            <td><p>Alumno no inscrito</p> </td>
                            <td><p >Alumno sin número de folio</p></td>
                          @endif
                          
                          <td><a class="btn btn-primary" href="{{ route('revisores.edit', Auth::user()->id) }}"  type="submit">Validar</a></td>
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