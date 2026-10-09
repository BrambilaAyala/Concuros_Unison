@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!--
                <div class="container container-h-secundario">
                    <div class="card-header h-secundario">{{ __('Información para iniciar la inscripción a concursos.') }}</div>
                </div>
                -->
                <div class="card-body">
                    <form method="POST" id="form_edit_asistente" action="{{route('asistentes.update', Auth::user()->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="form-group row">
                            <label for="curp" class="col-md-4 col-form-label text-md-right">{{ __('CURP [MAYUSCULAS]:') }}</label>

                            <div class="col-md-6">
                                <input id="curp" type="text" class="form-control @error('curp') is-invalid @enderror"name="curp" value="{{ old('curp') }}" required autocomplete="curp" pattern="^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$" autofocus placeholder="CURP en mayúsculas">

                                @error('curp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de nacimiento:') }}</label>

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
                            <label for="escuela_origen" class="col-md-4 col-form-label text-md-right">{{ __('Escuela:') }}</label>

                            <div class="col-md-6">
                                <input id="escuela_origen" type="text" class="form-control @error('escuela_origen') is-invalid @enderror"name="escuela_origen" value="{{ old('escuela_origen') }}" required autocomplete="escuela_origen" autofocus placeholder="Escuela en la cual te encuentras estudiando">

                                @error('escuela_origen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Sección: Datos del Maestro Asesor o Tutor -->
                        <div class="col-12 my-3">
                            <div class="card border-info shadow-sm">
                                <div class="card-header bg-light font-weight-bold text-dark py-2">
                                    <i class="fas fa-chalkboard-teacher mr-1 text-primary"></i> Información del Maestro Asesor o Tutor Escolar
                                </div>
                                <div class="card-body py-3">
                                    <p class="text-muted small mb-3">Registra los datos del profesor o asesor escolar que te orienta en tu preparación para el concurso.</p>

                                    <div class="form-group row">
                                        <label for="asesor_nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre(s) del Asesor:') }} <span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <input id="asesor_nombre" type="text" class="form-control @error('asesor_nombre') is-invalid @enderror" name="asesor_nombre" value="{{ old('asesor_nombre', optional(Auth::user()->asesor)->nombre) }}" required placeholder="Nombre(s) del profesor asesor">
                                            @error('asesor_nombre')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="asesor_apellido_paterno" class="col-md-4 col-form-label text-md-right">{{ __('Apellido Paterno:') }} <span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <input id="asesor_apellido_paterno" type="text" class="form-control @error('asesor_apellido_paterno') is-invalid @enderror" name="asesor_apellido_paterno" value="{{ old('asesor_apellido_paterno', optional(Auth::user()->asesor)->apellido_paterno) }}" required placeholder="Primer apellido del asesor">
                                            @error('asesor_apellido_paterno')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="asesor_apellido_materno" class="col-md-4 col-form-label text-md-right">{{ __('Apellido Materno:') }}</label>
                                        <div class="col-md-6">
                                            <input id="asesor_apellido_materno" type="text" class="form-control @error('asesor_apellido_materno') is-invalid @enderror" name="asesor_apellido_materno" value="{{ old('asesor_apellido_materno', optional(Auth::user()->asesor)->apellido_materno) }}" placeholder="Segundo apellido (opcional)">
                                            @error('asesor_apellido_materno')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="asesor_correo" class="col-md-4 col-form-label text-md-right">{{ __('Correo Electrónico:') }} <span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <input id="asesor_correo" type="email" class="form-control @error('asesor_correo') is-invalid @enderror" name="asesor_correo" value="{{ old('asesor_correo', optional(Auth::user()->asesor)->correo_electronico) }}" required placeholder="correo.asesor@ejemplo.com">
                                            @error('asesor_correo')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="asesor_telefono" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono del Asesor:') }} <span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <input id="asesor_telefono" type="text" pattern="[0-9]{10}" class="form-control @error('asesor_telefono') is-invalid @enderror" name="asesor_telefono" value="{{ old('asesor_telefono', optional(Auth::user()->asesor)->telefono) }}" required placeholder="Teléfono de 10 dígitos">
                                            @error('asesor_telefono')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <label for="asesor_escuela" class="col-md-4 col-form-label text-md-right">{{ __('Escuela del Asesor:') }}</label>
                                        <div class="col-md-6">
                                            <input id="asesor_escuela" type="text" class="form-control @error('asesor_escuela') is-invalid @enderror" name="asesor_escuela" value="{{ old('asesor_escuela', optional(Auth::user()->asesor)->escuela_origen) }}" placeholder="Institución donde labora (opcional si es tu misma escuela)">
                                            <small class="form-text text-muted">Si trabaja en tu misma escuela, puedes dejarlo vacío y se asignará automáticamente.</small>
                                            @error('asesor_escuela')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono:') }}</label>

                            <div class="col-md-6">
                                <input id="correo_electronico" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required autocomplete="telefono" placeholder="Número telefónico" pattern="[0-9]{10}">

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
                                        <th scope="col" colspan="3">Selecciona los concursos a los cuales te quieres inscribir:</th>
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
                            <label for="foto_asistente" class="col-md-4 col-form-label text-md-right">{{ __('Foto para credencial:') }}</label>

                            <div class="col-md-6">
                                <input id="foto_asistente" type="file" class="form-control @error('foto_asistente') is-invalid @enderror @error('image_croped') is-invalid @enderror" name="foto_asistente" id="foto_asistente" accept="image/png, image/jpeg" required>
                                <input type="hidden" name="image_croped" id="image_croped" value="">
                                <small class="text-muted d-block">Imagen JPG, JPEG o PNG. Al seleccionarla, se abrirá una ventana para recortarla al tamaño oficial.</small>
                                <div id="crop_status" class="mt-1" style="display:none; color: #28a745; font-weight: bold;">
                                    <i class="fa fa-check-circle"></i> Fotografía recortada correctamente
                                </div>
                                @error('foto_asistente')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('image_croped')
                                    <span class="text-danger d-block mt-1 font-weight-bold" role="alert">
                                        <strong>Debes recortar la fotografía en la ventana emergente antes de enviar.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="constancia_escuela" class="col-md-4 col-form-label text-md-right">{{ __('Constancia de estudios:') }}</label>

                            <div class="col-md-6">
                                <input id="constancia_escuela" type="file" class="form-control @error('constancia_escuela') is-invalid @enderror" name="constancia_escuela" accept="image/png, image/jpeg" required>
                                <small class="text-muted d-block">Imagen JPG, JPEG o PNG de tu credencial o constancia escolar vigente.</small>
                                @error('constancia_escuela')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <center>
                        <div class="col-md-9 my-3 alert alert-warning text-center" style="font-size: 0.95rem;">
                            <b>IMPORTANTE:</b> Recuerda que tu inscripción estará finalizada hasta que el comité así te lo confirme por correo electrónico, de modo que te pedimos estar atento al mismo.
                        </div>
                        </center>

                        <div class="form-group row mb-4 text-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg px-5 shadow font-weight-bold" style="background-color: #004990; border-color: #004990; font-size: 1.15rem; padding: 12px 30px;">
                                    {{ __('Enviar solicitud de inscripción') }}
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
<div id="uploadimageModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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