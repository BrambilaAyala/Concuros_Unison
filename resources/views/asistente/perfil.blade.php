@extends('layouts.app')

@section('content')
@php
    //dd(Auth::user()->documentos);
@endphp
    <div class="container">
        <div class="justify-content-center">
            <div class="container">
                <div class="card-header h-secundario">{{ __('Información de asistente') }}</div>
            </div>
            <div class="card-body" style="overflow: hidden;">
                <img style="height: 256px; float: left; " src="img/prueba.jpg" alt="">
                <div style="font-size: 20px">
                    <label for=""><b>Estatus de la inscripción</b></label>
                    <span class="badge badge-success">Inscrito</span>
                    <span class="badge badge-secondary">En proceso</span>
                    <span class="badge badge-danger">Rechazado</span>
                    <span class="badge badge-dark">Sin subir datos requeridos</span>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-3 col-form-label text-md-left" for="">Folio: </label>
                    <label for="">Aún no proporcionado</label>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-3 col-form-label text-md-left" for="">Nombre:</label>
                    <label for="">{{Auth::user()->nombre." ".Auth::user()->apellido_paterno." ".Auth::user()->apellido_materno}}</label>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-3 col-form-label text-md-left" for="">Correo utilizado: </label>
                    <label for="">{{Auth::user()->correo_electronico}}</label>
                </div>
{{--                 <div style="font-size: 20px">
                    <label class="col-md-3 col-form-label text-md-left" for="">Congreso/s registrados:</label>
                    <label for=""> {{Auth::user()->}}</label>
                </div> --}}
                {{-- <div style="font-size: 20px">
                    <button class="btn btn-primary" style="float: right;" type="submit">Editar información de acceso</button>
                </div> --}}
            </div>
        </div>

        @if (!Auth::user()->documentos)
        <div class="container justify-content-center">
            <div class="container container-h-secundario">
                <div class="card-header h-secundario">
                    {{ __('Información necesaria para la inscripción') }}
                </div>
            </div>
            <div class="col-md-12 col-form-label" style="font-size: 20px">
                <p>A continuacion se mostrara una pequeña lista con la informacion necesaria para empezar la inscripcion. 
                Asegurate de tener toda la informacion para empezar el registro.</p>
            </div>
            <div class="card-body" style="overflow: hidden;">
                <div style="font-size: 20px">
                    <label class="col-md-12 col-form-label text-md-center" for="">CURP</label>
                    {{-- <label for="">Una curp aquí</label> --}}
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-12 col-form-label text-md-center" for="">Fecha de nacimiento</label>
                    {{-- <label for="">Alguna fecha aquí</label> --}}
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-12 col-form-label text-md-center" for="">Ciudad de origen</label>
                    {{-- <label for="">Euruapan</label> --}}
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-12 col-form-label text-md-center" for="">Telefono</label>
                    {{-- <label for="">numeros</label> --}}
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-12 col-form-label text-md-center" for="">Foto identificatoria</label>
{{--                     <span class="badge badge-success">Aceptado</span>
                    <span class="badge badge-secondary">En proceso</span>
                    <span class="badge badge-danger">Rechazado</span>
                    <span class="badge badge-dark">Sin subir</span> --}}
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-12 col-form-label text-md-center" for="">Acta de nacimiento</label>
{{--                     <span class="badge badge-success">Aceptado</span>
                    <span class="badge badge-secondary">En proceso</span>
                    <span class="badge badge-danger">Rechazado</span>
                    <span class="badge badge-dark">Sin subir</span> --}}
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-12 col-form-label text-md-center" for="">Constancia escolar</label>
{{--                     <span class="badge badge-success">Aceptado</span>
                    <span class="badge badge-secondary">En proceso</span>
                    <span class="badge badge-danger">Rechazado</span>
                    <span class="badge badge-dark">Sin subir</span> --}}
                </div>
                <br>
                <table class="table tabla-cursos">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" colspan="3">Selecciona el o los concursos a los cuales te quieras inscribir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Concurso Regional de Física</td>
                            <td><input type="checkbox" aria-label="" disabled></td>
                        </tr>
                        <tr>
                            <td>Concurso Regional de Matemáticas</td>
                            <td><input type="checkbox" aria-label="" disabled></td>
                        </tr>
                        <tr>
                            <td>Preselectivo para la Olimpiada Nacional de Fisíca</td>
                            <td><input type="checkbox" aria-label="" disabled></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-12 col-form-label" style="font-size: 20px">
                    <p>Recuerda que antes de ser inscrito al evento se tienen que validar tus archivos subidos. 
                    Solo hasta que estos sean validados sera que se te registrara al evento.</p>
                </div>
                <br>
                <div style="font-size: 20px">
                    <a class="btn btn-primary" href="{{ route('asistentes.edit', Auth::user()->id) }}" style="float: right;" type="submit">Editar información para la inscripción</a>
                </div>
            </div>
        </div>
        @else
        <div class="container justify-content-center">
            <div class="container container-h-secundario">
                <div class="card-header h-secundario">
                    {{ __('Estado de los documentos proporcionados') }}
                </div>
            </div>
            <div class="card-body" style="overflow: hidden;">
                <div style="font-size: 20px">
                    <label class="col-md-6 col-form-label text-md-center" for="">Foto identificatoria</label>
                    <span class="badge badge-success">Aceptado</span>
                    <span class="badge badge-secondary">En proceso</span>
                    <span class="badge badge-danger">Rechazado</span>
                    <span class="badge badge-dark">Sin subir</span>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-6 col-form-label text-md-center" for="">Acta de nacimiento</label>
                    <span class="badge badge-success">Aceptado</span>
                    <span class="badge badge-secondary">En proceso</span>
                    <span class="badge badge-danger">Rechazado</span>
                    <span class="badge badge-dark">Sin subir</span>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-6 col-form-label text-md-center" for="">Constancia escolar</label>
                    <span class="badge badge-success">Aceptado</span>
                    <span class="badge badge-secondary">En proceso</span>
                    <span class="badge badge-danger">Rechazado</span>
                    <span class="badge badge-dark">Sin subir</span>
                </div>
                <div style="font-size: 20px">
                    <a class="btn btn-primary" href="#" style="float: right;" type="submit">Editar documento/s rechazado/s</a>
                </div>
            </div>
        </div>
        @endif
        
    </div>
@endsection