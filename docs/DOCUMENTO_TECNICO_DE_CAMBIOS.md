# Documento Técnico de Cambios del Sistema SICREFyM
**Sistema de Inscripción al Concurso Regional de Física y Matemáticas**  
**Universidad de Sonora — División de Ciencias Exactas y Naturales**  
*Edición LV (2026)*

---

## 1. Resumen Ejecutivo de la Modernización

El proyecto **SICREFyM** presentaba diversas limitaciones acumuladas a lo largo de ediciones previas, entre ellas: inconsistencias en el flujo de registro de aspirantes, fallas en la carga de archivos de alta resolución, dependencias de documentos obligatorios ya no solicitados (como el acta de nacimiento), redirecciones cruzadas entre las sesiones de aspirantes y revisores, y una interfaz de administración sobrecargada, poco intuitiva y con problemas de visualización de evidencias fotográficas.

Se llevó a cabo una refactorización arquitectónica en tres ejes fundamentales:
1. **Diseño y Experiencia de Usuario (UI/UX):** Homogeneización con la identidad institucional de la UNISON, eliminación de ruidos visuales estridentes y optimización de flujos de trabajo ergonómicos.
2. **FrontEnd:** Modernización de vistas Blade, saneamiento del DOM para compatibilidad con scripts en tiempo real, previsualización adaptativa de documentos y diseño responsive.
3. **Backend:** Desacoplamiento de campos obsoletos, optimización de consultas SQL (resolviendo el problema N+1), robustecimiento del sistema de correos y generación garantizada de folios oficiales.

---

## 2. Cambios en Backend y Arquitectura

### 2.1. Base de Datos y Migraciones
* **Flexibilización de `acta_asistente`:**
  * Se generó la migración `2026_10_01_000001_make_acta_asistente_nullable_in_documentos.php`.
  * La columna `acta_asistente` en la tabla `documentos` ahora admite valores `NULL`. Esto permitió eliminar el requerimiento obligatorio de subir un acta de nacimiento, alineando la plataforma a las bases oficiales de la convocatoria actual.

### 2.2. Proveedores de Servicios y Estado Global (`app/Providers/AppServiceProvider.php`)
* **Inyección Global del Contador de Espera:**
  * Se implementó un `View::composer` sobre todas las vistas administrativas (`layouts.app_admin`, `includes.admin.navbar`, `revisor.*`).
  * Consulta optimizada:
    ```php
    $conteoEsperaGlobal = \App\Validaciones::where('estado', 'Espera')->count();
    $view->with('conteoEsperaGlobal', $conteoEsperaGlobal);
    ```
  * Esto permite que en todo momento el administrador visualice en el menú el número exacto de solicitudes pendientes en tiempo real sin recalcularlo en cada controlador.

### 2.3. Controladores de Revisión y Validación
* **`app/Http/Controllers/RevisoresController.php`:**
  * **Eager Loading Anti N+1:** Se optimizaron las consultas de `listaEspera()`, `listaInscritos()` y `listaAsistentes()`, precargando las relaciones `documentos.validaciones` y `concursos`.
  * **Módulo de Inscripción Manual:** Se agregó el método `createAsistente()`, `storeAsistente(Request $request)`,  permitiendo al administrador registrar directamente alumnos extemporáneos, asignarles sus concursos y generarles folio oficial sin depender del flujo del alumno.
* **`app/Http/Controllers/ValidacionesController.php`:**
  * **Resiliencia en el Envío de Correos:** Se protegieron las llamadas a `Mail::send` con bloques `try-catch (\Throwable $e)` registrando en log cualquier incidencia SMTP sin interrumpir la transacción ni arrojar errores 500 al revisor.
  * **Trazabilidad de Auditoría:** Ahora se guarda explícitamente el `id_revisor` del usuario autenticado que dictaminó la solicitud (`$validacion->id_revisor = auth('revisor')->id();`).
  * **Generación Robusta de Folio:** Inclusión del folio en la carga de datos del correo de confirmación y en la sesión flash de retroalimentación inmediata.
  * **Vinculación de Modelos:** Paso conjunto de `$validacion` y `$asistente` a la vista `revisor.validacion` para preservar la relación de concursos asignados intacta.

### 2.4. Controladores de Aspirantes y Registro
* **`app/Http/Controllers/DocumentosController.php`:**
  * Se eliminó la validación estricta de subida de acta de nacimiento.
  * Se ajustaron las reglas MIME para admitir `jpg, jpeg, png, pdf` con límites de hasta 10 MB por archivo.
  * Se implementó el almacenamiento seguro en `storage/app/public/` asegurando su disponibilidad pública vía el enlace simbólico.
* **`app/Http/Controllers/Auth/RegisterController.php` y `AsistenteController.php`:**
  * Corrección del flujo de confirmación por correo: se garantiza que el aspirante reciba su token de verificación y pueda restablecer contraseña si lo requiere.

### 2.5. Autenticación y Protección de Sesiones
* **`app/Http/Middleware/RedirectIfAuthenticated.php`:**
  * Se corrigió la redirección cruzada entre el guard por defecto (`web` para aspirantes) y el guard `revisor` para administradores.
  * Si un usuario tiene abierta una sesión de revisor en `/revisores`, el middleware ya no lo redirige erróneamente a `/asistentes`, respetando la separación de dominios de acceso.

### 2.6. Blindaje de Seguridad y Control de Acceso Directo por URL
* **Protección Estricta del Módulo Administrativo:**
  * Se asignó el middleware `auth:revisor` a todo el grupo de rutas `/revisores/*` y al endpoint `/wsgetuserdata/{userID}`.
  * Se agregó el constructor con `$this->middleware('auth:revisor')` en `ValidacionesController.php` (Defensa en Profundidad), impidiendo que cualquier tercero o aspirante consulte o dictamine expedientes escribiendo URLs en el navegador.
* **Protección Anti-IDOR (Insecure Direct Object Reference):**
  * Se implementó el middleware `app/Http/Middleware/EnsureOwnProfile.php` registrado como `'own.profile'`.
  * Valida que si un participante autenticado intenta modificar o consultar `/asistentes/{id}/edit` o `/documentos-rechazados/{id}`, el `{id}` pertenezca forzosamente a su propia cuenta.
  * Verificaciones redundantes a nivel de controlador en `AsistenteController@show`, `edit`, `update` y `DocumentosController@actualizarDocumentosRechazados`. Si se detecta manipulación de ID, el sistema aborta inmediatamente con un error HTTP 403 Forbidden.
* **Redirección Contextual en `Authenticate.php`:**
  * Si un usuario no autenticado escribe rutas de administración en la URL, se le redirige automáticamente a `/admin` con una notificación de advertencia.
  * Si escribe rutas privadas de aspirantes, se le redirige a `/login`.
* **Vistas de Excepción Personalizadas:**
  * Creación de `resources/views/errors/403.blade.php` y `404.blade.php` con identidad visual UNISON y opciones seguras de retorno.

### 2.7. Módulo del Maestro Asesor o Tutor Escolar
* **Ampliación del Esquema (`asesores`):**
  * Migración `database/migrations/2026_10_09_000001_update_asesores_table_schema.php`.
  * Corrección de desbordamiento de enteros: el campo `telefono` fue elevado a `BIGINT UNSIGNED` para soportar números móviles mexicanos de 10 dígitos (anteriormente limitados a 4,294,967,295 por `INT UNSIGNED`).
  * Los campos `apellido_materno` y `escuela_origen` se configuraron como `NULLABLE` para soportar registros flexibles.
* **Modelos y Relaciones Eloquent:**
  * [`app/Asistente.php`](/sicrefym/app/Asistente.php): Relación `asesor() { return $this->hasOne(Asesor::class, 'id_asistente'); }`.
  * [`app/Asesor.php`](/sicrefym/app/Asesor.php): `$fillable` configurado y relación inversa `asistente() { return $this->belongsTo(Asistente::class, 'id_asistente'); }`.
* **Persistencia y Flujo Operativo:**
  * En [`AsistenteController@update`](/sicrefym/app/Http/Controllers/AsistenteController.php), se validan los campos (`asesor_nombre`, `asesor_apellido_paterno`, `asesor_correo`, `asesor_telefono` con 10 dígitos) y se persiste mediante `updateOrCreate`.
  * En [`RevisoresController@storeAsistente`](/sicrefym/app/Http/Controllers/RevisoresController.php), se admiten campos opcionales del asesor al realizar inscripciones manuales/extemporáneas.
* **Visualización Multicanal:**
  * Perfil del alumno ([`perfil.blade.php`](/sicrefym/resources/views/asistente/perfil.blade.php)): Tarjeta informativa con los datos del tutor escolar.
  * Mesa de revisión ([`validacion.blade.php`](/sicrefym/resources/views/revisor/validacion.blade.php)): Bloque de datos del asesor en el expediente lateral izquierdo del dictaminador.
  * Modales de consulta rápida ([`admin.js`](/sicrefym/public/js/admin.js), [`listaAsistentes.blade.php`](/sicrefym/resources/views/revisor/listaAsistentes.blade.php) y [`listaInscritos.blade.php`](/sicrefym/resources/views/revisor/listaInscritos.blade.php)): Eager loading en `wsGetUserData` y pintado dinámico en la ficha modal.

### 2.8. Módulo de Control de Convocatoria (Apertura y Cierre Automatizado)
* **Persistencia de Estado del Concurso (`eventos`):**
  * Migración `database/migrations/2026_10_09_000002_add_activo_to_eventos_table.php` agregando `activo` (boolean, default true) y `mensaje_cierre` (text, nullable).
  * Inyección global mediante `AppServiceProvider.php` compartiendo `$eventoGlobal` a todas las vistas Blade del sistema.
* **Control en el Panel de Administración:**
  * En [`revisor/index.blade.php`](/sicrefym/resources/views/revisor/index.blade.php), se integró una tarjeta ejecutiva que muestra el estatus en tiempo real (`ABIERTA` o `CERRADA`), con un botón de conmutación directa (`toggle-convocatoria`) y un formulario para personalizar el mensaje oficial de clausura.
  * Elimina completamente la necesidad de comentar o modificar código PHP/Blade en el servidor al concluir el concurso.
* **Comportamiento Dinámico del Portal Público:**
  * En [`header.blade.php`](/sicrefym/resources/views/includes/header.blade.php): Al estar inactiva la convocatoria, se oculta el botón de **"Registro"** y se mantiene visible **"Acceso"**.
  * En [`welcome.blade.php`](/sicrefym/resources/views/welcome.blade.php): Se reemplazan las instrucciones de inscripción por un aviso formal y estilizado con el mensaje de cierre oficial configurado por los organizadores, permitiendo el ingreso directo a los alumnos ya registrados para consultar sus expedientes y descargar credenciales.
  * En [`RegisterController.php`](/sicrefym/app/Http/Controllers/Auth/RegisterController.php): Bloqueo estricto a nivel controlador tanto en `showRegistrationForm()` como en `register()` redirigiendo con alerta en caso de intentos directos por URL.

---

## 3. Cambios en FrontEnd

### 3.1. Navegación y Estructura Base (`resources/views/`)
* **`includes/admin/navbar.blade.php`:**
  * **Barra Horizontal Despejada:** Se eliminaron botones secundarios redundantes (*"En Espera"*, *"+ Inscripción Manual"*, *"Ver Portal"*) que sobrecargaban la barra superior. Queda una barra limpia, ligera y con el perfil de usuario y salida rápida.
  * **Menú Lateral Tipográfico:** Se eliminó toda la iconografía / simbología que generaba ruido y fatiga visual. Ahora cuenta con enlaces textuales limpios con tipografía clara y un contador de espera sutil en pastilla semitransparente.
* **`layouts/app_admin.blade.php`:**
  * Se integraron las directivas `@stack('styles')` y `@stack('scripts')`.
  * Se restauró el fondo gris oscuro clásico `#343a40` en el menú lateral, combinando con una cabecera de marca en `#2c3136`.
  * Fondo de contenido suave en `#f8fafc` que reduce la fatiga visual.

### 3.2. Mesa de Validación Ergonómica (`revisor/validacion.blade.php`)
* **Problema Previo:** Imágenes sin contención CSS (`<img>` crudos) que al provenir de cámaras de teléfonos móviles (4000x3000px) desbordaban la pantalla, empujando los controles fuera del campo visual.
* **Solución Implementada:**
  * **Diseño en 2 Columnas:**
    * **Columna Izquierda:** Expediente con datos del alumno (CURP, fecha de nacimiento, escuela, teléfono, concursos solicitados) y tarjeta de Dictamen Global interactiva.
    * **Columna Derecha:** Cajas de previsualización confinadas (`max-height: 280px; object-fit: contain;`) con enlace *"Ver tamaño original"* para inspección en alta resolución en pestaña separada.
  * **Controles Interactivos de Decisión:** Toggles visuales de Aceptar/Rechazar. Al seleccionar rechazo, se expande suavemente el área de texto con validación de motivo y el botón de envío cambia en tiempo real a color rojo indicando *"Notificar Rechazo para Reenvío"*.

### 3.3. Padrón Oficial de Inscritos (`revisor/listaInscritos.blade.php`)
* Visualización destacada del Folio Oficial (ej. `2026-110-001`).
* Buscador predictivo en tiempo real con filtro instantáneo en cliente.
* Botón de impresión rápida para listas físicas o exportación directa a PDF (`window.print()`).
* Modal de expediente completo de 2 columnas con previsualización cuidada de documentos.

### 3.4. Directorio General de Asistentes (`revisor/listaAsistentes.blade.php`)
* **Tarjetas de Estadísticas (KPIs Rápidos):** 4 métricas superiores (Total Registrados, En Revisión, Acreditados con Folio, Reenvío Solicitado).
* **Compatibilidad DOM con `admin.js`:** Se mantuvieron los cuatro elementos `<p>` requeridos por el algoritmo de búsqueda nativo (`nombre`, `folio`, `concursos`, `estado`) garantizando búsqueda sin excepciones de JavaScript.
* **Badges Semánticos:** Indicadores visuales claros para los 4 estados posibles (*Inscrito*, *En Espera*, *Reenvío*, *Enviando*).

### 3.5. Bandeja de Espera (`revisor/listaEspera.blade.php`)
* Buscador integrado en cabecera de tarjeta.
* Botón directo de acción: `[Revisar y Validar]`.
* Estado vacío amigable cuando el contador de pendientes llega a cero.

---

## 4. Cambios en Diseño y Experiencia de Usuario (UI/UX)

| Aspecto | Antes | Ahora |
| :--- | :--- | :--- |
| **Paleta de Colores** | Mezcla de amarillos intensos, rojos y verdes en el menú lateral | Fondo gris carbón sobrio (`#343a40`), acentos institucionales UNISON (`#004990`) y tonos neutros |
| **Menú Lateral** | Íconos de colores discordantes y títulos pesados | Tipografía limpia, sin iconografía distractora, enlaces con espaciado ergonómico |
| **Barra Superior** | Saturada con 5 botones de colores que competían por atención | Minimalista, solo muestra título contextual, usuario activo y salida |
| **Inspección de Fotos** | Fotos gigantes desbordadas vertical y horizontalmente | Contenedor centrado y adaptativo con apertura a pantalla completa |
| **Retroalimentación** | Alertas JavaScript intrusivas (`alert()`) | Notificaciones estilizadas de Bootstrap 4 y badges interactivos |
| **Impresión** | Páginas no optimizadas con menús visibles en el papel | Hoja limpia con estilos `@media print` para emitir listas de asistencia |



---

## 5. Matriz de Archivos Modificados

```
app/
├── Asesor.php                                    (Fillable y relación con asistente)
├── Asistente.php                                 (Relaciones con concursos, documentos y asesor)
├── Documentos.php                                (Flexibilización de acta_asistente)
├── Evento.php                                    (Casts y fillable para estado activo y mensaje)
├── Http/
│   ├── Controllers/
│   │   ├── AsistenteController.php               (Flujos de registro, credencial y guardado de asesor)
│   │   ├── Auth/
│   │   │   └── RegisterController.php            (Bloqueo de registro con convocatoria cerrada)
│   │   ├── DocumentosController.php              (Manejo de archivos y validación)
│   │   ├── RevisoresController.php               (Eager loading, asesor manual, toggle de convocatoria)
│   │   └── ValidacionesController.php            (Dictamen, auditoría y correos resilientes)
│   └── Middleware/
│       ├── EnsureOwnProfile.php                  (Prevención anti-IDOR en perfil y documentos)
│       └── RedirectIfAuthenticated.php          (Prevención de colisión de sesiones)
└── Providers/
    └── AppServiceProvider.php                    (View composer de conteo global y $eventoGlobal)

database/
└── migrations/
    ├── 2026_10_01_000001_make_acta_asistente_nullable_in_documentos.php
    ├── 2026_10_09_000001_update_asesores_table_schema.php
    └── 2026_10_09_000002_add_activo_to_eventos_table.php

public/js/
└── admin.js                                      (Renderizado dinámico de asesor en ficha modal)

resources/views/
├── asistente/
│   ├── formInscripcion.blade.php                 (Campos del asesor escolar)
│   └── perfil.blade.php                          (Visualización del asesor escolar)
├── includes/
│   ├── admin/navbar.blade.php                    (Barra horizontal y menú lateral gris sobrio)
│   └── header.blade.php                          (Visibilidad condicional de enlace Registro)
├── layouts/app_admin.blade.php                   (Layout administrativo limpio y stacks)
├── revisor/
│   ├── index.blade.php                           (Dashboard ejecutivo + Control de Convocatoria)
│   ├── listaAsistentes.blade.php                 (Directorio general con modal ampliado de asesor)
│   ├── listaEspera.blade.php                     (Bandeja de revisión con estado vacío)
│   ├── listaInscritos.blade.php                  (Padrón oficial e impresión con modal de asesor)
│   ├── crearAsistente.blade.php                  (Formulario con campos de asesor opcional)
│   └── validacion.blade.php                      (Mesa de inspección con expediente de asesor)
├── welcome.blade.php                             (Aviso oficial dinámico de cierre de convocatoria)
└── vendor/notifications/
    ├── email_aprobado.blade.php                  (Notificación con folio oficial)
    └── email_rechazado.blade.php                 (Notificación con retroalimentación)
```
