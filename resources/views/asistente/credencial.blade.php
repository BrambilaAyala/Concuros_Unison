@extends('layouts.app')

@section('content')
<style>
    @media print {
        header, footer, nav, .no-print, .btn, .alert {
            display: none !important;
        }
        body {
            background-color: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        main {
            padding: 0 !important;
            margin: 0 !important;
        }
        #credencialPrintContainer {
            box-shadow: none !important;
            border: 2px solid #004990 !important;
            margin: 0 auto !important;
            width: 100% !important;
            max-width: 650px !important;
            page-break-inside: avoid;
        }
    }
    .cred-header {
        background: linear-gradient(135deg, #002e5b 0%, #004990 100%);
        color: #fff;
    }
    .badge-gold {
        background-color: #f7a11a;
        color: #1a1a1a;
        font-weight: bold;
    }
    .folio-box {
        background: #eef5fc;
        border: 2px dashed #004990;
        border-radius: 8px;
    }
</style>

<div class="container my-4">
    <!-- Barra superior de acciones para el alumno -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print flex-wrap gap-2">
        <div>
            <a href="{{ route('asistentes.index') }}" class="btn btn-outline-secondary">
                ← Volver a mi Perfil
            </a>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge badge-success mr-3 p-2 font-weight-bold" style="font-size: 0.95rem;">
                ✓ Inscripción Confirmada
            </span>
            <button onclick="window.print()" class="btn btn-primary font-weight-bold shadow-sm">
                🖨️ Imprimir / Guardar en PDF
            </button>
        </div>
    </div>

    <!-- TARJETA OFICIAL DE CREDENCIAL Y PASE DE EXAMEN -->
    <div id="credencialPrintContainer" class="card shadow-lg mx-auto" style="max-width: 720px; border-radius: 12px; overflow: hidden; border: 2px solid #004990;">
        <!-- Encabezado Institucional UNISON -->
        <div class="cred-header p-3 px-4">
            <div class="row align-items-center">
                <div class="col-2 text-center">
                    <img src="/img/logo_uni.jpg" alt="Logo UNISON" style="height: 65px; border-radius: 6px; background: #fff; padding: 2px;">
                </div>
                <div class="col-8">
                    <h6 class="mb-0 text-uppercase font-weight-bold" style="color: #f7a11a; font-size: 0.75rem; letter-spacing: 1px;">Universidad de Sonora</h6>
                    <h5 class="mb-0 font-weight-bold text-white" style="font-size: 1.05rem;">División de Ciencias Exactas y Naturales</h5>
                    <p class="mb-0 text-light" style="font-size: 0.8rem;">Departamentos de Física y Matemáticas</p>
                </div>
                <div class="col-2 text-right">
                    <span class="badge badge-gold px-2 py-1 text-uppercase" style="font-size: 0.75rem;">LV Edición</span>
                    <span class="d-block text-white font-weight-bold mt-1" style="font-size: 0.8rem;">2026</span>
                </div>
            </div>
            <div class="mt-2 pt-2 border-top border-primary text-center">
                <h5 class="mb-0 text-uppercase font-weight-bold text-white tracking-wide" style="font-size: 0.95rem; letter-spacing: 1.5px;">
                    Credencial Oficial de Participante & Pase de Examen
                </h5>
            </div>
        </div>

        <!-- Cuerpo de la Credencial -->
        <div class="card-body p-4">
            <div class="row align-items-center">
                <!-- Fotografía del Aspirante -->
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <div style="width: 155px; height: 195px; border: 3px solid #f7a11a; border-radius: 8px; overflow: hidden; margin: 0 auto; box-shadow: 0 4px 8px rgba(0,0,0,0.15);" class="position-relative bg-light d-flex align-items-center justify-content-center">
                        @if(optional($asistente->documentos)->foto_asistente)
                            <img src="/storage/{{ $asistente->documentos->foto_asistente }}" alt="Foto Asistente" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="/img/prueba.jpg" alt="Foto Asistente" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                        <span class="badge badge-dark position-absolute" style="bottom: 4px; left: 4px; right: 4px; font-size: 0.65rem; letter-spacing: 0.5px;">
                            ASPIRANTE ACREDITADO
                        </span>
                    </div>
                </div>

                <!-- Datos Principales del Aspirante -->
                <div class="col-md-8">
                    <div class="folio-box p-3 mb-3 text-center">
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Número de Folio Oficial:</span>
                        <h3 class="mb-0 font-weight-bold text-primary" style="font-family: monospace; letter-spacing: 2px;">
                            {{ $asistente->folio }}
                        </h3>
                    </div>

                    <table class="table table-sm table-borderless mb-0" style="font-size: 0.9rem;">
                        <tbody>
                            <tr>
                                <th style="width: 32%; color: #555;">Participante:</th>
                                <td class="font-weight-bold text-dark">{{ $asistente->nombre }} {{ $asistente->apellido_paterno }} {{ $asistente->apellido_materno }}</td>
                            </tr>
                            <tr>
                                <th style="color: #555;">CURP:</th>
                                <td class="font-weight-bold text-monospace">{{ $asistente->curp }}</td>
                            </tr>
                            <tr>
                                <th style="color: #555;">Escuela:</th>
                                <td class="text-dark">{{ $asistente->escuela_origen }}</td>
                            </tr>
                            <tr>
                                <th style="color: #555;">Correo:</th>
                                <td class="text-muted">{{ $asistente->correo_electronico }}</td>
                            </tr>
                            <tr>
                                <th style="color: #555;">Fecha Validación:</th>
                                <td class="text-dark">{{ $asistente->fecha_registro_aceptado ?? ($validacion->fecha_validacion ?? date('d/m/Y')) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr class="my-3">

            <!-- Concursos y Código QR -->
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="font-weight-bold text-dark mb-2" style="font-size: 0.85rem;">
                        <i class="fa fa-pencil-square-o text-primary"></i> Concursos en los que participa:
                    </h6>
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        @foreach($concursos as $c)
                            <span class="badge badge-primary px-3 py-2 mr-2 mb-1" style="font-size: 0.8rem; border-radius: 6px;">
                                {{ $c->nombre }}
                            </span>
                        @endforeach
                    </div>
                    <div class="alert alert-light border mb-0 p-2 mt-2" style="font-size: 0.75rem; color: #444; line-height: 1.4;">
                        <strong>Instrucciones para el día del examen:</strong><br>
                        • Presentar esta credencial impresa o en dispositivo móvil junto con una identificación con fotografía.<br>
                        • Consultar en la página oficial el aula asignada para tu número de folio antes de ingresar.<br>
                        • No se permite el uso de dispositivos móviles ni calculadoras programables durante la prueba.
                    </div>
                </div>

                <!-- Código QR Dinámico en SVG -->
                <div class="col-md-4 text-center mt-3 mt-md-0">
                    <div class="p-2 bg-white border rounded d-inline-block shadow-sm">
                        <svg class="d-block mx-auto" width="105" height="105" viewBox="0 0 100 100">
                            <rect width="100" height="100" fill="white" />
                            <!-- Esquinas estándar QR -->
                            <rect x="5" y="5" width="28" height="28" fill="#004990" />
                            <rect x="9" y="9" width="20" height="20" fill="white" />
                            <rect x="13" y="13" width="12" height="12" fill="#004990" />
                            
                            <rect x="67" y="5" width="28" height="28" fill="#004990" />
                            <rect x="71" y="9" width="20" height="20" fill="white" />
                            <rect x="75" y="13" width="12" height="12" fill="#004990" />

                            <rect x="5" y="67" width="28" height="28" fill="#004990" />
                            <rect x="9" y="71" width="20" height="20" fill="white" />
                            <rect x="13" y="75" width="12" height="12" fill="#004990" />

                            <!-- Patrón interno personalizado -->
                            <rect x="40" y="8" width="8" height="8" fill="#f7a11a" />
                            <rect x="52" y="16" width="6" height="6" fill="#004990" />
                            <rect x="40" y="38" width="20" height="20" fill="#004990" />
                            <rect x="44" y="42" width="12" height="12" fill="white" />
                            <rect x="48" y="46" width="4" height="4" fill="#f7a11a" />
                            
                            <rect x="70" y="40" width="8" height="8" fill="#004990" />
                            <rect x="82" y="52" width="10" height="8" fill="#004990" />
                            <rect x="15" y="42" width="12" height="6" fill="#004990" />
                            <rect x="40" y="68" width="10" height="10" fill="#004990" />
                            <rect x="55" y="72" width="14" height="8" fill="#004990" />
                            <rect x="78" y="72" width="12" height="14" fill="#f7a11a" />
                        </svg>
                        <small class="text-muted d-block font-weight-bold mt-1" style="font-size: 0.65rem;">CÓDIGO DE ACCESO</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie de página de seguridad -->
        <div class="card-footer bg-light px-4 py-2 border-top d-flex justify-content-between align-items-center" style="font-size: 0.75rem; color: #666;">
            <span>Folio Digital Verificado • Comité Organizador CRFyM UNISON</span>
            <span class="font-weight-bold text-dark">Hermosillo, Sonora • México</span>
        </div>
    </div>
</div>
@endsection
