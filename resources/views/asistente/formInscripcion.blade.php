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
                                <input id="curp" type="text" class="form-control @error('curp') is-invalid @enderror"name="curp" value="{{ old('curp') }}" required autocomplete="curp" pattern="^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$" autofocus>

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
                                <input id="foto_asistente" type="file" class="form-control" name="foto_asistente" id="foto_asistente" accept="image/png, image/jpeg" required>
                                <input type="hidden" name="image_croped" id="image_croped" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="acta_asistente" class="col-md-4 col-form-label text-md-right">{{ __('Acta de nacimiento') }}</label>

                            <div class="col-md-6">
                                <input id="acta_asistente" type="file" class="form-control" name="acta_asistente" accept="image/png, image/jpeg" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="constancia_escuela" class="col-md-4 col-form-label text-md-right">{{ __('Constancia escolar') }}</label>

                            <div class="col-md-6">
                                <input id="constancia_escuela" type="file" class="form-control" name="constancia_escuela" accept="image/png, image/jpeg" required>
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


{{-- Modal --}}
<div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                <h4 class="modal-title">Recorta tu imagen</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 text-center">
                        <div id="image_demo" style="width:350px; margin-top:30px"></div>
                    </div>
                    <div class="col-md-4" style="padding-top:30px;">
                        <br />
                        <br />
                        <br/>
                        <button class="btn btn-success crop_image">Recortar imagen</button>
                    </div>
                </div>
            </div>
{{--             <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> --}}
        </div>
    </div>
</div>

   
   

@endsection