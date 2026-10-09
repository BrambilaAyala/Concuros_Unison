@extends('layouts.app_admin')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1 class="m-0 text-dark font-weight-bold">
                        <i class="fas fa-user-plus text-success mr-2"></i> Inscripción Manual / Extemporánea
                    </h1>
                    <p class="text-muted mb-0">Registro y generación directa de folio para alumnos con casos especiales o fuera de fecha.</p>
                </div>
                <div class="col-sm-4 text-right">
                    <a href="{{ route('revisores.lista-inscritos') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver a Lista de Inscritos
                    </a>
                </div>
            </div>
            <hr class="mt-2 mb-3">
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5><i class="icon fas fa-ban"></i> Por favor corrige los siguientes errores:</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card card-success card-outline elevation-2">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">
                        <i class="fas fa-id-card mr-1 text-success"></i> Datos del Aspirante y Asignación de Concursos
                    </h3>
                </div>

                <form action="{{ route('revisores.guardar-asistente') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <!-- Sección 1: Datos Personales -->
                        <h5 class="text-primary font-weight-bold mb-3 border-bottom pb-2">
                            1. Información del Estudiante
                        </h5>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="nombre">Nombre(s) <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ej. Carlos Eduardo" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="apellido_paterno">Apellido Paterno <span class="text-danger">*</span></label>
                                <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" value="{{ old('apellido_paterno') }}" placeholder="Ej. Mendoza" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="apellido_materno">Apellido Materno</label>
                                <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" value="{{ old('apellido_materno') }}" placeholder="Ej. Peralta">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="curp">CURP <span class="text-danger">*</span></label>
                                <input type="text" name="curp" id="curp" class="form-control text-uppercase font-weight-bold" value="{{ old('curp') }}" placeholder="18 caracteres" maxlength="18" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="telefono">Teléfono de Contacto</label>
                                <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}" placeholder="10 dígitos">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="correo_electronico">Correo Electrónico <span class="text-danger">*</span></label>
                                <input type="email" name="correo_electronico" id="correo_electronico" class="form-control" value="{{ old('correo_electronico') }}" placeholder="ejemplo@correo.com" required>
                                <small class="text-muted">Se enviará la confirmación con el folio oficial.</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="contrasena">Contraseña de Acceso para el Alumno <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="contrasena" id="contrasena" class="form-control font-weight-bold" value="{{ old('contrasena') }}" placeholder="Mínimo 6 caracteres" minlength="6" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="copiarCurpComoPass()" title="Usar la CURP como contraseña">
                                            <i class="fas fa-magic mr-1"></i> Usar CURP
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">El alumno usará esta contraseña para acceder al portal.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="escuela_origen">Escuela / Preparatoria de Origen <span class="text-danger">*</span></label>
                                <input type="text" name="escuela_origen" id="escuela_origen" class="form-control" value="{{ old('escuela_origen') }}" placeholder="Ej. Cobach Plantel Reforma" required>
                            </div>
                        </div>

                        <!-- Sección 2: Concursos -->
                        <h5 class="text-primary font-weight-bold mt-4 mb-3 border-bottom pb-2">
                            2. Concursos a los que se Inscribe <span class="text-danger">*</span>
                        </h5>

                        <div class="form-group bg-light p-3 rounded border">
                            <p class="text-muted mb-2 font-weight-bold">Selecciona al menos un concurso:</p>
                            <div class="row">
                                @foreach($concursos as $c)
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox my-1">
                                            <input class="custom-control-input" type="checkbox" id="concurso_{{ $c->id }}" name="concursos[]" value="{{ $c->id }}" {{ ($c->nombre == 'Concurso Regional de Física') ? 'checked' : '' }}>
                                            <label for="concurso_{{ $c->id }}" class="custom-control-label font-weight-bold text-dark">
                                                {{ $c->nombre }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Sección 3: Maestro Asesor o Tutor -->
                        <h5 class="text-primary font-weight-bold mt-4 mb-3 border-bottom pb-2">
                            3. Maestro Asesor o Tutor Escolar <span class="text-muted font-weight-normal">(Opcional)</span>
                        </h5>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="asesor_nombre">Nombre(s) del Asesor</label>
                                <input type="text" name="asesor_nombre" id="asesor_nombre" class="form-control" value="{{ old('asesor_nombre') }}" placeholder="Nombre(s) del profesor">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="asesor_apellido_paterno">Apellido Paterno</label>
                                <input type="text" name="asesor_apellido_paterno" id="asesor_apellido_paterno" class="form-control" value="{{ old('asesor_apellido_paterno') }}" placeholder="Primer apellido">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="asesor_apellido_materno">Apellido Materno</label>
                                <input type="text" name="asesor_apellido_materno" id="asesor_apellido_materno" class="form-control" value="{{ old('asesor_apellido_materno') }}" placeholder="Segundo apellido">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="asesor_correo">Correo del Asesor</label>
                                <input type="email" name="asesor_correo" id="asesor_correo" class="form-control" value="{{ old('asesor_correo') }}" placeholder="asesor@ejemplo.com">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="asesor_telefono">Teléfono del Asesor</label>
                                <input type="text" name="asesor_telefono" id="asesor_telefono" class="form-control" value="{{ old('asesor_telefono') }}" placeholder="10 dígitos">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="asesor_escuela">Escuela del Asesor</label>
                                <input type="text" name="asesor_escuela" id="asesor_escuela" class="form-control" value="{{ old('asesor_escuela') }}" placeholder="Dejar vacío si es la misma del alumno">
                            </div>
                        </div>

                        <!-- Sección 4: Documentación Opcional -->
                        <h5 class="text-primary font-weight-bold mt-4 mb-3 border-bottom pb-2">
                            4. Documentación Escolar (Opcional en registro manual)
                        </h5>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="foto">Fotografía para credencial (JPG o PNG)</label>
                                <input type="file" name="foto" id="foto" class="form-control-file border p-2 rounded bg-white" accept="image/png, image/jpeg, image/jpg">
                                <small class="text-muted">Si no se carga, el sistema usará una imagen provisional que el alumno podrá actualizar.</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="constancia">Constancia o Credencial Escolar (JPG o PNG)</label>
                                <input type="file" name="constancia" id="constancia" class="form-control-file border p-2 rounded bg-white" accept="image/png, image/jpeg, image/jpg">
                                <small class="text-muted">Comprobante de estudios en nivel medio superior.</small>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 py-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Nota Operativa:</strong> Al guardar este formulario, el alumno quedará inmediatamente en estado <strong>Aprobado</strong>, se le asignará su <strong>Número de Folio Oficial</strong> correlativo y podrá descargar su Credencial con código QR.
                        </div>
                    </div>

                    <div class="card-footer bg-light text-right">
                        <a href="{{ route('revisores.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                        <button type="submit" class="btn btn-success btn-lg font-weight-bold px-4 shadow">
                            <i class="fas fa-check-circle mr-1"></i> Inscribir y Generar Folio Oficial
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function copiarCurpComoPass() {
            var curpVal = document.getElementById('curp').value.trim();
            if (curpVal.length > 0) {
                document.getElementById('contrasena').value = curpVal;
            } else {
                alert('Primero escribe la CURP del aspirante.');
                document.getElementById('curp').focus();
            }
        }
    </script>
@endsection
