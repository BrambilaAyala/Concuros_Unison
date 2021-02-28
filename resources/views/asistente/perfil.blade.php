@extends('layouts.app')

@section('content')
    <div class="container" style="background-color: white;">
        <div class="justify-content-center">
            <div class="container">
                <div class="card-header" style="background-color: #e0e0e0; font-size: 20px; text-align: center;">{{ __('Información de asistente') }}</div>
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
                    <label for="">Me llamo luis</label>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-3 col-form-label text-md-left" for="">Correo utilizado: </label>
                    <label for="">e@m.com</label>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-3 col-form-label text-md-left" for="">Congreso/s registrados:</label>
                    <label for="">Aún no proporcionado</label>
                </div>
                <div style="font-size: 20px">
                    <button class="btn btn-primary" style="float: right;" type="submit">Editar información de acceso</button>
                </div>
            </div>
        </div>

        <div class="container justify-content-center">
            <div class="container" style="margin-top: 20px">
                <div class="card-header" style="background-color: #e0e0e0; font-size: 20px; text-align: center;">
                    {{ __('Información necesaria para la inscripción') }}
                </div>
            </div>
            <div class="card-body" style="overflow: hidden;">
                <div style="font-size: 20px">
                    <label class="col-md-6 col-form-label text-md-right" for="">CURP:</label>
                    <label for="">Una curp aquí</label>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-6 col-form-label text-md-right" for="">Fecha de nacimiento: </label>
                    <label for="">Alguna fecha aquí</label>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-6 col-form-label text-md-right" for="">Ciudad de origen:</label>
                    <label for="">Euruapan</label>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-6 col-form-label text-md-right" for="">Telefono:</label>
                    <label for="">numeros</label>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-6 col-form-label text-md-right" for="">Foto identificatoria:</label>
                    <span class="badge badge-success">Inscrito</span>
                    <span class="badge badge-secondary">En proceso</span>
                    <span class="badge badge-danger">Rechazado</span>
                    <span class="badge badge-dark">Sin subir</span>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-6 col-form-label text-md-right" for="">Aconcta de nacimiento:</label>
                    <span class="badge badge-success">Inscrito</span>
                    <span class="badge badge-secondary">En proceso</span>
                    <span class="badge badge-danger">Rechazado</span>
                    <span class="badge badge-dark">Sin subir</span>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-6 col-form-label text-md-right" for="">Constancia escolar:</label>
                    <span class="badge badge-success">Inscrito</span>
                    <span class="badge badge-secondary">En proceso</span>
                    <span class="badge badge-danger">Rechazado</span>
                    <span class="badge badge-dark">Sin subir</span>
                </div>
                <br>
                <table class="table .table-hover" style="width: 500px; margin: 0 auto;">
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
                <br>
                <div style="font-size: 20px">
                    <a class="btn btn-primary" href="{{ route('asistentes.edit', 1) }}" style="float: right;" type="submit">Editar información para la inscripción</a>
                </div>
            </div>
        </div>
    </div>
@endsection