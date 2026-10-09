@extends('layouts.app')

@section('content')
@php
    //dd(Auth::user()->documentos->validaciones()->latest()->first());
    //dd(Auth::user()->concursos()->get()->all());
@endphp
    <div class="container">
        <div class="justify-content-center">
            <!--
            <div class="container">
                <div class="card-header h-secundario">{{ __('Información de asistente') }}</div>
            </div>
        -->
            <div class="card-body" style="overflow: hidden;">
                <!--<img style="height: 256px; float: left; " src="/img/prueba.jpg" alt="">-->
                <div style="font-size: 20px">
                    <label for=""><b>Estatus de la solicitud de inscripción</b></label>
                    @if (Auth::user()->documentos)
                        @if (Auth::user()->documentos->validaciones()->latest()->first()->estado == "Rechazado")
                            <span class="badge badge-danger">Rechazado</span>
                        @endif
                        @if (Auth::user()->documentos->validaciones()->latest()->first()->estado == "Espera")
                            <span class="badge badge-secondary">En revisión</span>
                        @endif
                        @if (Auth::user()->documentos->validaciones()->latest()->first()->estado == "Aprobado")
                            <span class="badge badge-success">Inscrito</span>
                        @endif
                    @else
                        <span class="badge badge-dark">En proceso</span>
                    @endif
                </div>
                <div style="font-size: 20px;">
                    <label class="col-md-3 col-form-label text-md-left" for="">Folio: </label>
                    @if (!Auth::user()->folio)
                        <label for="">Se proporcionará al completar la inscripción satisfactoriamente</label>
                    @else
                        <label for="" class="font-weight-bold text-primary">{{ Auth::user()->folio }}</label>
                    @endif
                </div>

                @if (Auth::user()->folio && optional(optional(Auth::user()->documentos)->validaciones()->latest()->first())->estado == "Aprobado")
                    <div class="my-3 p-3 bg-light border border-success rounded text-center shadow-sm">
                        <h5 class="text-success font-weight-bold mb-2">¡Inscripción Acreditada Exitosamente!</h5>
                        <p class="mb-2 text-dark" style="font-size: 16px;">Ya puedes consultar y descargar tu Credencial Oficial y Pase de Acceso con Código QR para el día del examen.</p>
                        <a href="{{ route('asistentes.credencial') }}" class="btn btn-success btn-lg font-weight-bold shadow-sm">
                            📇 Ver y Descargar mi Credencial Oficial
                        </a>
                    </div>
                @endif
                <div style="font-size: 20px">
                    <label class="col-md-3 col-form-label text-md-left" for="">Nombre:</label>
                    <label for="">{{Auth::user()->nombre." ".Auth::user()->apellido_paterno." ".Auth::user()->apellido_materno}}</label>
                </div>
                <div style="font-size: 20px">
                    <label class="col-md-3 col-form-label text-md-left" for="">Correo: </label>
                    <label for="">{{Auth::user()->correo_electronico}}</label>
                </div>

                @if (Auth::user()->documentos)
                    <div style="font-size: 20px">
                        <label class="col-md-3 col-form-label text-md-left" for="">CURP:</label>
                        <label for=""> {{Auth::user()->curp}}</label>
                    </div>
                    <div style="font-size: 20px">
                        <label class="col-md-3 col-form-label text-md-left" for="">Fecha de nacimiento:</label>
                        <label for=""> {{Auth::user()->fecha_nacimiento}}</label>
                    </div>
                    <div style="font-size: 20px">
                        <label class="col-md-3 col-form-label text-md-left" for="">Escuela de origen:</label>
                        <label for=""> {{Auth::user()->escuela_origen}}</label>
                    </div>
                    <div style="font-size: 20px">
                        <label class="col-md-3 col-form-label text-md-left" for="">Teléfono:</label>
                        <label for=""> {{Auth::user()->telefono}}</label>
                    </div>
                    <div style="font-size: 20px">
                        <label class="col-md-3 col-form-label text-md-left" for="">Concurso(s):</label>
                        <label for="">
                            @foreach (Auth::user()->concursos()->get()->all() as $concurso)
                                {{ $concurso->nombre }},
                            @endforeach
                        </label>
                    </div>

                    @if (Auth::user()->asesor)
                        <div class="my-3 p-3 bg-light border border-info rounded">
                            <h5 class="text-primary font-weight-bold mb-2" style="font-size: 19px;">
                                <i class="fas fa-chalkboard-teacher mr-1"></i> Maestro Asesor o Tutor Escolar
                            </h5>
                            <div class="row" style="font-size: 17px;">
                                <div class="col-md-6 mb-1">
                                    <strong>Nombre:</strong> {{ Auth::user()->asesor->nombre }} {{ Auth::user()->asesor->apellido_paterno }} {{ Auth::user()->asesor->apellido_materno }}
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Correo:</strong> {{ Auth::user()->asesor->correo_electronico }}
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Teléfono:</strong> {{ Auth::user()->asesor->telefono }}
                                </div>
                                <div class="col-md-6 mb-1">
                                    <strong>Escuela:</strong> {{ Auth::user()->asesor->escuela_origen ?? Auth::user()->escuela_origen }}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div style="font-size: 20px">
                        <label class="col-md-3 col-form-label text-md-left" for="">Foto para credencial:</label>
                        <img src="/storage/{{ Auth::user()->documentos->foto_asistente }}" alt="">
                    </div>
                    <br>

                    <br>
                    <div style="font-size: 20px">
                        <label class="col-md-3 col-form-label text-md-left" for="">Constancia escolar:</label>
                        <img src="/storage/{{ Auth::user()->documentos->constancia_escuela }}" alt="">
                    </div>

                @endif
            </div>
        </div>

        @if (!Auth::user()->documentos)
        <div class="container justify-content-center">
            <div class="col-md-12 col-form-label" style="font-size: 20px">
                <p>Para continuar con el envío de tu solicitud deberás tener a la mano tu CURP, una constancia de estudios (o tu credencial de la escuela) expedida por la escuela donde estudias, y una fotografía para credencial, todos estos en formato JPG, JPEG o PNG.</p>
            </div>

            <div class="card-body" style="overflow: hidden;">
                <div style="font-size: 20px">
                    <a class="btn btn-primary" href="{{ route('asistentes.edit', Auth::user()->id) }}" style="float: right;" type="submit">Continuar</a>
                </div>
                <div style="font-size: 20px;">
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="float: left;" type="submit">Salir</a>
                </div>
            </div>
        </div>
        @else
            @if (Auth::user()->documentos->validaciones()->latest()->first()->estado == "Rechazado")
                <div class="container justify-content-center">
                    <div class="container container-h-secundario">
                        <div class="card-header h-secundario">
                            {{ __('Documentos rechazados') }}
                        </div>
                    </div>
                    <div class="card-body" style="overflow: hidden; font-size: 20px;">
                        <!--<p>A continuacion se te mostraran los archivos que se te rechazaron y su razon de rechazo.</p>-->
                        <p><b>{{ Auth::user()->documentos->validaciones()->latest()->first()->doc_rechazado }}</b></p>
                        <pre>{{ Auth::user()->documentos->validaciones()->latest()->first()->comentario }}</pre>

                        <div>Te invitamos a atender las observaciones anteriores y actualizar tus documentos para continuar con el proceso de inscripción.</div>
                        
{{--
                         <div style="font-size: 20px">
                            <label class="col-md-6 col-form-label text-md-center" for="">Foto para la credencial</label>
                            <span class="badge badge-success">Aceptado</span>
                            <span class="badge badge-danger">Rechazado</span>
                        </div>
                        <div style="font-size: 20px">
                            <label class="col-md-6 col-form-label text-md-center" for="">Acta de nacimiento</label>
                            <span class="badge badge-success">Aceptado</span>
                            <span class="badge badge-danger">Rechazado</span>
                        </div>
                        <div style="font-size: 20px">
                            <label class="col-md-6 col-form-label text-md-center" for="">Constancia de estudios</label>
                            <span class="badge badge-success">Aceptado</span>
                            <span class="badge badge-danger">Rechazado</span>
                        </div> 
    --}}
                        <div style="font-size: 20px">
                            @csrf
                            <a class="btn btn-primary" href="{{route('asistentes.rechazado')}}" style="float: right;" type="submit">Editar</a>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        
    </div>
@endsection