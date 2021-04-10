@extends('layouts.app_admin')

@section('content')
    <!-- Content Header -->
    <input type="text" id="myInput" onkeyup="buscadorPorNombre()" placeholder="Busca por nombre..." title="Escribe un nombre">
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
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive p-0" style="max-height: 700px;">
                  <table class="table table-head-fixed text-nowrap">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Fecha de envio de documento</th>
                        <th>No. Folio</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($asistentes as $asistente)
                        <tr id='test'>
                          <td><p id='nombre'>{{$asistente->nombre}} {{$asistente->apellido_paterno}} {{$asistente->apellido_materno}}</p></td>
                          @if (isset($asistente->documentos->fecha_creacion))
                            <td><p id='fechaEnvioDoc'>{{$asistente->documentos->fecha_creacion}}</p></td>
                          @else 
                            <td><p>Alumno no inscrito</p> </td>
                          @endif
                          
                          {{-- <td><a class="btn btn-primary" href="{{ route('revisores.edit', Auth::user()->id) }}"  type="submit">Validar</a></td> --}}
                        </tr>
                      @endforeach
                      
                    </tbody>
                  </table>
                </div>
              </div>
        </div>
    </div>
<script>
  function buscadorPorNombre() {

    let input, filter, tr, td, a, i, valorTxt;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    tr = document.querySelectorAll("#test");
    for (let i = 0; i < tr.length; i++) {
      td = tr[i].firstElementChild;
      p = td.getElementsByTagName("p")[0]
      valorTxt = p.textContent || p.innerText;
      if (valorTxt.toUpperCase().indexOf(filter) > -1) {
          
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
    
  }
</script>
@endsection