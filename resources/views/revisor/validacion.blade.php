@extends('layouts.app_admin')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0 text-dark font-weight-bold">
                        <i class="fas fa-tasks text-primary mr-2"></i> Mesa de Validación de Documentos
                    </h1>
                    <p class="text-muted mb-0">Revisa la documentación adjunta para autorizar la inscripción o solicitar subsanación</p>
                </div>
                <div class="col-sm-5 text-right mt-2 mt-sm-0">
                    <a href="{{ route('revisores.lista-espera') }}" class="btn btn-outline-secondary font-weight-bold shadow-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Volver a Lista de Espera
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @if (session('jsAlert'))
                <div class="alert alert-danger alert-dismissible fade show elevation-1 mb-3" role="alert">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Atención</h5>
                    <p class="mb-0">{{ session()->get('jsAlert') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show elevation-1 mb-3" role="alert">
                    <h5><i class="icon fas fa-ban"></i> Se encontraron errores al validar</h5>
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form role="form" method="POST" action="{{ route('validaciones.update', $validacion->id) }}" id="formValidacion">
                @csrf
                @method("PUT")

                <div class="row">
                    <!-- Columna Izquierda: Ficha del Aspirante & Dictamen -->
                    <div class="col-lg-4 mb-4">
                        <!-- Tarjeta Expediente Aspirante -->
                        <div class="card card-primary card-outline elevation-2 mb-3">
                            <div class="card-header bg-white border-bottom-0 pb-0">
                                <h3 class="card-title font-weight-bold text-dark">
                                    <i class="fas fa-user-graduate text-primary mr-2"></i> Expediente del Aspirante
                                </h3>
                            </div>
                            <div class="card-body text-center pt-3 pb-2">
                                <div class="avatar-circle mx-auto mb-3 elevation-1" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #004990, #0b1f3a); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: bold;">
                                    {{ mb_substr($validacion->nombre ?? 'A', 0, 1) }}{{ mb_substr($validacion->apellido_paterno ?? '', 0, 1) }}
                                </div>
                                <h5 class="font-weight-bold text-dark mb-1">
                                    {{ $validacion->nombre }} {{ $validacion->apellido_paterno }} {{ $validacion->apellido_materno }}
                                </h5>
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-envelope mr-1"></i>{{ $validacion->correo_electronico }}
                                </p>

                                <ul class="list-group list-group-unbordered text-left mb-3">
                                    <li class="list-group-item py-2 px-1">
                                        <b class="text-muted"><i class="fas fa-fingerprint mr-1 text-secondary"></i> CURP</b>
                                        <span class="float-right font-weight-bold text-dark font-monospace">{{ $validacion->curp ?? 'No registrada' }}</span>
                                    </li>
                                    <li class="list-group-item py-2 px-1">
                                        <b class="text-muted"><i class="fas fa-calendar-alt mr-1 text-secondary"></i> Nacimiento</b>
                                        <span class="float-right text-dark">{{ $validacion->fecha_nacimiento ?? 'No registrada' }}</span>
                                    </li>
                                    <li class="list-group-item py-2 px-1">
                                        <b class="text-muted"><i class="fas fa-school mr-1 text-secondary"></i> Escuela</b>
                                        <span class="float-right text-dark font-weight-500 text-right" style="max-width: 60%;">{{ $validacion->escuela_origen ?? 'No registrada' }}</span>
                                    </li>
                                    <li class="list-group-item py-2 px-1">
                                        <b class="text-muted"><i class="fas fa-phone mr-1 text-secondary"></i> Teléfono</b>
                                        <span class="float-right text-dark">{{ $validacion->telefono ?? 'No registrado' }}</span>
                                    </li>
                                </ul>

                                <!-- Concursos solicitados -->
                                <div class="text-left mt-2">
                                    <label class="text-muted small font-weight-bold text-uppercase mb-1">Concursos Solicitados:</label>
                                    <div>
                                        @php
                                            $concursos = isset($asistente) && $asistente->concursos ? $asistente->concursos : ($validacion->concursos ?? []);
                                        @endphp
                                        @forelse ($concursos as $c)
                                            <span class="badge badge-info px-2 py-1 mr-1 mb-1" style="font-size: 0.8rem;">
                                                <i class="fas fa-award mr-1"></i>{{ $c->nombre }}
                                            </span>
                                        @empty
                                            <span class="badge badge-light text-muted border">Sin concursos asignados</span>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Maestro Asesor o Tutor -->
                                @php
                                    $asesor = isset($asistente) && $asistente->asesor ? $asistente->asesor : null;
                                @endphp
                                @if($asesor)
                                    <div class="text-left mt-3 pt-3 border-top">
                                        <label class="text-muted small font-weight-bold text-uppercase mb-2">
                                            <i class="fas fa-chalkboard-teacher text-info mr-1"></i> Maestro Asesor / Tutor:
                                        </label>
                                        <div class="p-2 bg-light rounded border small">
                                            <div class="font-weight-bold text-dark mb-1">
                                                {{ $asesor->nombre }} {{ $asesor->apellido_paterno }} {{ $asesor->apellido_materno }}
                                            </div>
                                            <div class="text-muted mb-1">
                                                <i class="fas fa-envelope mr-1"></i> {{ $asesor->correo_electronico }}
                                            </div>
                                            <div class="text-muted mb-1">
                                                <i class="fas fa-phone mr-1"></i> {{ $asesor->telefono }}
                                            </div>
                                            @if($asesor->escuela_origen)
                                                <div class="text-muted">
                                                    <i class="fas fa-school mr-1"></i> {{ $asesor->escuela_origen }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Tarjeta Resumen de Dictamen -->
                        <div class="card elevation-2" id="cardDictamen" style="border-top: 4px solid #28a745;">
                            <div class="card-header bg-white">
                                <h3 class="card-title font-weight-bold" style="font-size: 1rem;">
                                    <i class="fas fa-clipboard-check text-success mr-2" id="iconDictamen"></i> Dictamen de Revisión
                                </h3>
                            </div>
                            <div class="card-body">
                                <div id="alertaDictamenAprobado" class="alert alert-success border-0 mb-3" style="background-color: #d4edda; color: #155724;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle fa-2x mr-3 text-success"></i>
                                        <div>
                                            <strong class="d-block">Se Aprobará la Solicitud</strong>
                                            <small>El sistema asignará automáticamente el <b>Folio Oficial</b> y enviará el correo de confirmación al alumno.</small>
                                        </div>
                                    </div>
                                </div>

                                <div id="alertaDictamenRechazo" class="alert alert-danger border-0 mb-3 d-none" style="background-color: #f8d7da; color: #721c24;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle fa-2x mr-3 text-danger"></i>
                                        <div>
                                            <strong class="d-block">Se Solicitará Reenvío</strong>
                                            <small>Se notificará por correo al alumno con las observaciones detalladas para que reenvíe sus documentos.</small>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success btn-block btn-lg font-weight-bold shadow" id="btnSubmitDictamen">
                                    <i class="fas fa-check-circle mr-1"></i> Aprobar y Asignar Folio
                                </button>
                                <a href="{{ route('revisores.lista-espera') }}" class="btn btn-outline-secondary btn-block mt-2 font-weight-bold">
                                    Cancelar y Volver
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Inspección de Documentos -->
                    <div class="col-lg-8">
                        <!-- Documento 1: Fotografía para credencial -->
                        <div class="card card-outline card-primary elevation-2 mb-4" id="cardDocFoto">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h3 class="card-title font-weight-bold text-dark m-0">
                                    <i class="fas fa-portrait text-info mr-2"></i> 1. Fotografía para Credencial
                                </h3>
                                <a href="/storage/{{ $validacion->foto_asistente }}" target="_blank" class="btn btn-xs btn-outline-primary font-weight-bold">
                                    <i class="fas fa-external-link-alt mr-1"></i> Ver tamaño original
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-5 text-center mb-3 mb-md-0">
                                        <div class="preview-box p-2 bg-light border rounded position-relative">
                                            <img src="/storage/{{ $validacion->foto_asistente }}" 
                                                 alt="Fotografía del aspirante" 
                                                 class="img-fluid rounded document-img"
                                                 style="max-height: 280px; object-fit: contain; width: 100%;">
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            <i class="fas fa-info-circle mr-1"></i> Deberá ser tipo credencial, fondo claro y nítida
                                        </small>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="font-weight-bold text-dark mb-2">Evaluación del Documento:</label>
                                        <div class="decision-group d-flex mb-3">
                                            <label class="decision-option decision-accept mr-3">
                                                <input type="radio" name="fotoRechazo" value="" onchange="actualizarEstadoDoc('foto', false)" {{ old('fotoRechazo') ? '' : 'checked' }}>
                                                <span class="decision-label">
                                                    <i class="fas fa-check-circle mr-1"></i> Aceptar Fotografía
                                                </span>
                                            </label>
                                            <label class="decision-option decision-reject">
                                                <input type="radio" name="fotoRechazo" value="Foto identificatoria" onchange="actualizarEstadoDoc('foto', true)" {{ old('fotoRechazo') ? 'checked' : '' }}>
                                                <span class="decision-label">
                                                    <i class="fas fa-times-circle mr-1"></i> Rechazar
                                                </span>
                                            </label>
                                        </div>

                                        <div id="textFoto" class="{{ old('fotoRechazo') ? '' : 'd-none' }} animated fadeIn">
                                            <div class="form-group mb-0">
                                                <label for="txt1" class="text-danger small font-weight-bold">
                                                    <i class="fas fa-pen mr-1"></i> Motivo del rechazo (será enviado al alumno):
                                                </label>
                                                <textarea class="form-control @error('textoFotoRechazo') is-invalid @enderror" 
                                                          name="textoFotoRechazo" 
                                                          id="txt1" 
                                                          rows="3" 
                                                          minlength="10" 
                                                          placeholder="Ejemplo: La imagen es borrosa o no corresponde a una fotografía tamaño credencial de frente.">{{ old('textoFotoRechazo') }}</textarea>
                                                @error('textoFotoRechazo')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documento 2: Constancia o credencial escolar -->
                        <div class="card card-outline card-warning elevation-2 mb-4" id="cardDocConstancia">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h3 class="card-title font-weight-bold text-dark m-0">
                                    <i class="fas fa-file-invoice text-warning mr-2"></i> 2. Constancia o Credencial Escolar
                                </h3>
                                <a href="/storage/{{ $validacion->constancia_escuela }}" target="_blank" class="btn btn-xs btn-outline-primary font-weight-bold">
                                    <i class="fas fa-external-link-alt mr-1"></i> Ver tamaño original
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-5 text-center mb-3 mb-md-0">
                                        <div class="preview-box p-2 bg-light border rounded position-relative">
                                            <img src="/storage/{{ $validacion->constancia_escuela }}" 
                                                 alt="Constancia escolar del aspirante" 
                                                 class="img-fluid rounded document-img"
                                                 style="max-height: 280px; object-fit: contain; width: 100%;">
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            <i class="fas fa-info-circle mr-1"></i> Vigente, con sello y nombre legible
                                        </small>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="font-weight-bold text-dark mb-2">Evaluación del Documento:</label>
                                        <div class="decision-group d-flex mb-3">
                                            <label class="decision-option decision-accept mr-3">
                                                <input type="radio" name="constanciaRechazo" value="" onchange="actualizarEstadoDoc('constancia', false)" {{ old('constanciaRechazo') ? '' : 'checked' }}>
                                                <span class="decision-label">
                                                    <i class="fas fa-check-circle mr-1"></i> Aceptar Constancia
                                                </span>
                                            </label>
                                            <label class="decision-option decision-reject">
                                                <input type="radio" name="constanciaRechazo" value="Constancia escolar" onchange="actualizarEstadoDoc('constancia', true)" {{ old('constanciaRechazo') ? 'checked' : '' }}>
                                                <span class="decision-label">
                                                    <i class="fas fa-times-circle mr-1"></i> Rechazar
                                                </span>
                                            </label>
                                        </div>

                                        <div id="textConstancia" class="{{ old('constanciaRechazo') ? '' : 'd-none' }} animated fadeIn">
                                            <div class="form-group mb-0">
                                                <label for="txt3" class="text-danger small font-weight-bold">
                                                    <i class="fas fa-pen mr-1"></i> Motivo del rechazo (será enviado al alumno):
                                                </label>
                                                <textarea class="form-control @error('textoConstanciaRechazo') is-invalid @enderror" 
                                                          name="textoConstanciaRechazo" 
                                                          id="txt3" 
                                                          rows="3" 
                                                          minlength="10" 
                                                          placeholder="Ejemplo: La constancia no cuenta con sello oficial o no es del ciclo escolar actual.">{{ old('textoConstanciaRechazo') }}</textarea>
                                                @error('textoConstanciaRechazo')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .decision-group {
        user-select: none;
    }
    .decision-option {
        margin-bottom: 0;
        cursor: pointer;
    }
    .decision-option input[type="radio"] {
        display: none;
    }
    .decision-label {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
        border: 2px solid transparent;
        transition: all 0.2s ease;
    }
    /* Estilos para Aceptar */
    .decision-accept .decision-label {
        background-color: #f1f8e9;
        color: #2e7d32;
        border-color: #c8e6c9;
    }
    .decision-accept input[type="radio"]:checked + .decision-label {
        background-color: #28a745;
        color: #ffffff;
        border-color: #28a745;
        box-shadow: 0 3px 8px rgba(40, 167, 69, 0.35);
    }
    /* Estilos para Rechazar */
    .decision-reject .decision-label {
        background-color: #fbe9e7;
        color: #c62828;
        border-color: #ffcdd2;
    }
    .decision-reject input[type="radio"]:checked + .decision-label {
        background-color: #dc3545;
        color: #ffffff;
        border-color: #dc3545;
        box-shadow: 0 3px 8px rgba(220, 53, 69, 0.35);
    }
    .preview-box {
        background-color: #f8f9fa;
        min-height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<script>
    function actualizarEstadoDoc(tipo, esRechazo) {
        if (tipo === 'foto') {
            if (esRechazo) {
                $('#textFoto').removeClass('d-none');
                $('#txt1').focus();
            } else {
                $('#textFoto').addClass('d-none');
            }
        } else if (tipo === 'constancia') {
            if (esRechazo) {
                $('#textConstancia').removeClass('d-none');
                $('#txt3').focus();
            } else {
                $('#textConstancia').addClass('d-none');
            }
        }
        revisarDictamenGlobal();
    }

    function revisarDictamenGlobal() {
        const fotoRechazo = $('input[name="fotoRechazo"]:checked').val();
        const constanciaRechazo = $('input[name="constanciaRechazo"]:checked').val();
        const algunRechazo = (fotoRechazo !== "") || (constanciaRechazo !== "");

        const cardDictamen = $('#cardDictamen');
        const iconDictamen = $('#iconDictamen');
        const alertaAprobado = $('#alertaDictamenAprobado');
        const alertaRechazo = $('#alertaDictamenRechazo');
        const btnSubmit = $('#btnSubmitDictamen');

        if (algunRechazo) {
            cardDictamen.css('border-top', '4px solid #dc3545');
            iconDictamen.removeClass('text-success fa-clipboard-check').addClass('text-danger fa-exclamation-circle');
            alertaAprobado.addClass('d-none');
            alertaRechazo.removeClass('d-none');
            btnSubmit.removeClass('btn-success').addClass('btn-danger')
                     .html('<i class="fas fa-paper-plane mr-1"></i> Notificar Rechazo para Reenvío');
        } else {
            cardDictamen.css('border-top', '4px solid #28a745');
            iconDictamen.removeClass('text-danger fa-exclamation-circle').addClass('text-success fa-clipboard-check');
            alertaAprobado.removeClass('d-none');
            alertaRechazo.addClass('d-none');
            btnSubmit.removeClass('btn-danger').addClass('btn-success')
                     .html('<i class="fas fa-check-circle mr-1"></i> Aprobar y Asignar Folio');
        }
    }

    $(document).ready(function() {
        revisarDictamenGlobal();
    });
</script>
@endpush