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
                        <th>Validar asistente</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($asistentesInscritos as $asistenteInscrito)
                        <tr>
                          <td>{{$asistenteInscrito->nombre}} {{$asistenteInscrito->apellido_paterno}} {{$asistenteInscrito->apellido_materno}}</td>
                          <td>{{$asistenteInscrito->fecha_creacion}}</td>
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