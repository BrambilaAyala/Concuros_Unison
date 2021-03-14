@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="container container-h-secundario">
                    <div class="card-header h-secundario">{{ __('Informacion para iniciar la inscripcion a algún concurso.') }}</div>
                </div>
                
                <div class="card-body">
                    <form method="POST" id="form_edit_asistente" action="{{route('asistentes.update', Auth::user()->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="form-group row">
                            <label for="curp" class="col-md-4 col-form-label text-md-right">{{ __('CURP') }}</label>

                            <div class="col-md-6">
                                <input id="curp" type="text" class="form-control @error('curp') is-invalid @enderror"name="curp" value="{{ old('curp') }}" required autocomplete="curp" autofocus>

                                @error('curp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de nacimiento') }}</label>

                            <div class="col-md-6">
                                <input id="fecha_nacimiento" type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror"name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required autocomplete="fecha_nacimiento" autofocus>

                                @error('fecha_nacimiento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="escuela_origen" class="col-md-4 col-form-label text-md-right">{{ __('Escuela de origen') }}</label>

                            <div class="col-md-6">
                                <input id="escuela_origen" type="text" class="form-control @error('escuela_origen') is-invalid @enderror"name="escuela_origen" value="{{ old('escuela_origen') }}" required autocomplete="escuela_origen" autofocus>

                                @error('escuela_origen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>

                            <div class="col-md-6">
                                <input id="correo_electronico" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required autocomplete="telefono">

                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <table class="table table-hover tabla-cursos">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" colspan="3">Selecciona el o los concursos a los cuales te quieras inscribir</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr>
                                        <td>Concurso Regional de Física</td>
                                        <td><input type="checkbox" aria-label="" name="concurso[0]" value="1" ></td>
                                    </tr>
                                    <tr>
                                        <td>Concurso Regional de Matemáticas</td>
                                        <td><input type="checkbox" aria-label="" name="concurso[1]" value="2" ></td>
                                    </tr>
                                    <tr>
                                        <td>Preselectivo para la Olimpiada Nacional de Fisíca</td>
                                        <td><input type="checkbox" aria-label="" name="concurso[2]" value="3" ></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group row">
                            <label for="foto_asistente" class="col-md-4 col-form-label text-md-right">{{ __('Foto del Asistente') }}</label>

                            <div class="col-md-6">
                                <input id="foto_asistente" type="file" class="form-control @error('foto_asistente') is-invalid @enderror" name="foto_asistente" required autocomplete="foto_asistente">

                                @error('foto_asistente')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="acta_asistente" class="col-md-4 col-form-label text-md-right">{{ __('Acta de nacimiento') }}</label>

                            <div class="col-md-6">
                                <input id="acta_asistente" type="file" class="form-control" name="acta_asistente" required autocomplete="acta_asistente">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="constancia_escuela" class="col-md-4 col-form-label text-md-right">{{ __('Constancia escolar') }}</label>

                            <div class="col-md-6">
                                <input id="constancia_escuela" type="file" class="form-control" name="constancia_escuela" required autocomplete="constancia_escuela">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Empesar inscripcion') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection