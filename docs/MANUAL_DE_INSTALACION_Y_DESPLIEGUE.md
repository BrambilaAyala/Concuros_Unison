# Manual de Instalación, Configuración y Despliegue
**Sistema de Inscripción al Concurso Regional de Física y Matemáticas (SICREFyM)**  
**Universidad de Sonora — División de Ciencias Exactas y Naturales**  
*Versión 2026*

---

## Índice
1. [Especificaciones y Requisitos del Entorno](#1-especificaciones-y-requisitos-del-entorno)
   - 1.1 [Lenguaje y Runtime](#11-lenguaje-y-runtime)
   - 1.2 [Extensiones de PHP Obligatorias](#12-extensiones-de-php-obligatorias)
   - 1.3 [Ajustes en `php.ini`](#13-ajustes-en-phpini)
   - 1.4 [Base de Datos](#14-base-de-datos)
   - 1.5 [Node.js y Gestores de Paquetes](#15-nodejs-y-gestores-de-paquetes)
2. [Matriz de Librerías y Dependencias](#2-matriz-de-librerías-y-dependencias)
   - 2.1 [Dependencias Backend (Composer)](#21-dependencias-backend-composer)
   - 2.2 [Dependencias FrontEnd (NPM)](#22-dependencias-frontend-npm)
3. [Guía de Instalación Paso a Paso](#3-guía-de-instalación-paso-a-paso)
   - 3.1 [Descarga o Clonación del Proyecto](#31-descarga-o-clonación-del-proyecto)
   - 3.2 [Instalación de Paquetes PHP (Composer)](#32-instalación-de-paquetes-php-composer)
   - 3.3 [Instalación y Compilación de Assets (NPM)](#33-instalación-y-compilación-de-assets-npm)
   - 3.4 [Configuración de Variables de Entorno (`.env`)](#34-configuración-de-variables-de-entorno-env)
   - 3.5 [Generación de Llave de Aplicación](#35-generación-de-llave-de-aplicación)
   - 3.6 [Creación y Migración de la Base de Datos](#36-creación-y-migración-de-la-base-de-datos)
   - 3.7 [Carga de Semillas Iniciales (Seeders)](#37-carga-de-semillas-iniciales-seeders)
   - 3.8 [Enlace Simbólico de Almacenamiento](#38-enlace-simbólico-de-almacenamiento)
   - 3.9 [Permisos de Carpetas](#39-permisos-de-carpetas)
4. [Configuración del Servicio de Correos](#4-configuración-del-servicio-de-correos)
5. [Despliegue y Ejecución](#5-despliegue-y-ejecución)
   - 5.1 [En Entorno de Desarrollo Local](#51-en-entorno-de-desarrollo-local)
   - 5.2 [En Servidor de Producción (Apache / Nginx)](#52-en-servidor-de-producción-apache--nginx)
6. [Diagnóstico y Resolución de Problemas (Troubleshooting)](#6-diagnóstico-y-resolución-de-problemas-troubleshooting)

---

## 1. Especificaciones y Requisitos del Entorno

### 1.1. Lenguaje y Runtime
* **Lenguaje:** PHP `>= 7.2.5` hasta `8.0.x` (Recomendado oficialmente: **PHP 8.0.30 x64**).
* **Framework:** Laravel `7.30.7` (LTS).

### 1.2. Extensiones de PHP Obligatorias
Verifique que las siguientes extensiones se encuentren descomentadas y activas en su archivo `php.ini`:
* `extension=fileinfo` *(Imprescindible para la detección segura del tipo MIME de fotografías y constancias)*.
* `extension=pdo_mysql` *(Conexión a la base de datos)*.
* `extension=mbstring` *(Manejo de cadenas UTF-8 y acentuación)*.
* `extension=openssl` *(Cifrado de contraseñas y tokens)*.
* `extension=tokenizer` *(Compilación de plantillas Blade)*.
* `extension=xml` / `extension=dom` *(Generación de documentos y exportaciones)*.
* `extension=ctype`
* `extension=json`
* `extension=gd` o `extension=imagick` *(Procesamiento de fotos para credenciales)*.
* `extension=curl` *(Comunicaciones externas y servicios web)*.

### 1.3. Ajustes en `php.ini`
Debido a que los estudiantes suelen subir fotografías de alta resolución tomadas directamente con sus celulares, configure los siguientes valores mínimos en su `php.ini`:

```ini
upload_max_filesize = 32M
post_max_size = 32M
memory_limit = 256M
max_execution_time = 120
date.timezone = America/Hermosillo
```

### 1.4. Base de Datos
* **Motor compatible:** MySQL `5.7+` o `8.0+` / MariaDB `10.3+`.
* **Cotejamiento recomendado:** `utf8mb4` con collation `utf8mb4_unicode_ci`.

### 1.5. Node.js y Gestores de Paquetes
* **Composer:** Versión `2.2.x` o superior.
* **Node.js:** Versión `14.x` a `18.x` LTS.
* **NPM:** Versión `6.x` a `9.x`.

---

## 2. Matriz de Librerías y Dependencias

### 2.1. Dependencias Backend (Composer - `composer.json`)
| Paquete | Versión | Propósito |
| :--- | :--- | :--- |
| `php` | `^7.2.5 \| ^8.0` | Entorno de ejecución |
| `laravel/framework` | `^7.29` | Núcleo del framework MVC |
| `laravel/ui` | `^2.4` | Andamiaje de autenticación y vistas |
| `twbs/bootstrap` | `4.6.0` | Framework de diseño CSS y componentes interactivos |
| `fideloper/proxy` | `^4.4` | Manejo seguro de headers detrás de proxies inversos |
| `fruitcake/laravel-cors` | `^2.0` | Políticas de CORS para servicios REST |
| `guzzlehttp/guzzle` | `^7.0.1` | Cliente HTTP para consumo de APIs |
| `laravel/tinker` | `^2.5` | Consola interactiva REPL de depuración |
| `laravel-lang/lang` | `~7.0` | Diccionario de localización en español |

### 2.2. Dependencias FrontEnd (NPM - `package.json`)
| Paquete | Versión | Propósito |
| :--- | :--- | :--- |
| `bootstrap` | `^4.0.0` | Estilos base de componentes e interfaz |
| `jquery` | `^3.5.1` | Manipulación del DOM y peticiones asíncronas |
| `popper.js` | `^1.12` | Posicionamiento de tooltips, dropdowns y modales |
| `laravel-mix` | `^5.0.1` | Wrapper de Webpack para compilación de estilos y scripts |
| `sass` / `sass-loader` | `^1.15.2` / `^8.0.0` | Preprocesador de hojas de estilo SCSS |
| `axios` | `^0.21.1` | Cliente de peticiones HTTP en cliente |

---

## 3. Guía de Instalación Paso a Paso

### 3.1. Descarga o Clonación del Proyecto
Sitúese en la raíz donde alojará la aplicación:
```bash
git clone <URL_DEL_REPOSITORIO> sicrefym
cd sicrefym
```

### 3.2. Instalación de Paquetes PHP (Composer)
Ejecute la instalación de dependencias optimizadas:
```bash
composer install --optimize-autoloader
```
*(En servidores de producción use: `composer install --optimize-autoloader --no-dev`)*.

### 3.3. Instalación y Compilación de Assets (NPM)
Instale las dependencias de Node.js y compile los estilos y scripts:
```bash
npm install
npm run prod
```

### 3.4. Configuración de Variables de Entorno (`.env`)
Copie la plantilla base si no existe el archivo `.env`:
```bash
cp .env.example .env
```
Abra el archivo `.env` y configure los parámetros clave:

```env
APP_NAME=SICREFyM
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sicrefym
DB_USERNAME=root
DB_PASSWORD=tu_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

FILESYSTEM_DRIVER=public
```

### 3.5. Generación de Llave de Aplicación
Genere la clave de cifrado única para la sesión y cookies:
```bash
php artisan key:generate
```

### 3.6. Creación y Migración de la Base de Datos
1. Inicie su servidor MySQL y cree la base de datos con cotejamiento UTF-8:
   ```sql
   CREATE DATABASE sicrefym CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Ejecute las migraciones de Laravel para crear las tablas:
   ```bash
   php artisan migrate
   ```

### 3.7. Carga de Semillas Iniciales (Seeders)
Pueble la base de datos con los concursos oficiales (Física y Matemáticas) y las cuentas de revisores predeterminadas:
```bash
php artisan db:seed
```

> [!NOTE]  
> Esto cargará automáticamente los registros base en las tablas `concursos`, `revisores` y `validacion_definiciones`.

### 3.8. Enlace Simbólico de Almacenamiento
Para que las fotografías y credenciales escolares almacenadas en `storage/app/public/` sean accesibles desde el navegador mediante `/storage/...`, es **estrictamente obligatorio** crear el enlace simbólico:
```bash
php artisan storage:link
```

### 3.9. Permisos de Carpetas (Entornos Linux / Producción)
Asegúrese de que el servidor web (`www-data`, `apache` o `nginx`) tenga permisos de escritura en los directorios de caché y almacenamiento:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```
> [!Advertencia]  
> El entorno variara, puede que los permisos cambien o se necesiten nuevos. Por eso se necesita tener cuidado al momento de la ejecucion.
---

## 4. Configuración del Servicio de Correos

### Opción A: Modo Pruebas / Desarrollo Local (Recomendado sin servidor SMTP)
En el archivo `.env`:
```env
MAIL_MAILER=log
```
Todos los correos emitidos por el sistema (aprobación, rechazo, folios, restablecimiento de contraseña) se escribirán en texto plano dentro del archivo:  
📁 `storage/logs/laravel.log`.

### Opción B: Modo Producción (Servidor SMTP Institucional UNISON)
Configure en el `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.unison.mx
MAIL_PORT=587
MAIL_USERNAME=concurso.fismat@unison.mx
MAIL_PASSWORD=tu_password_seguro
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=concurso.fismat@unison.mx
MAIL_FROM_NAME="Comité Organizador CRFyM - UNISON"
```
> [!NOTE]  
> El 'Modo de Prueba' es cuando no estas conectado a la red de Unison. Cuando se conecte a la red de Unison, cambiar el '.env', para el 'Modo de Produccion'.
---

## 5. Despliegue y Ejecución

### 5.1. En Entorno de Desarrollo Local
Inicie el servidor embebido de PHP / Artisan:
```bash
php artisan serve --port=8000
```
* Portal de Aspirantes: [http://127.0.0.1:8000](http://127.0.0.1:8000)
* Panel de Revisores: [http://127.0.0.1:8000/revisores](http://127.0.0.1:8000/revisores)

### 5.2. En Servidor de Producción (Apache)
Cree un archivo de configuración de VirtualHost (ej. `/etc/apache2/sites-available/sicrefym.conf`):

```apache
<VirtualHost *:80>
    ServerName sicrefym.unison.mx
    DocumentRoot /var/www/html/sicrefym/public

    <Directory /var/www/html/sicrefym/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/sicrefym_error.log
    CustomLog ${APACHE_LOG_DIR}/sicrefym_access.log combined
</VirtualHost>
```
Habilite el módulo de reescritura y el sitio:
```bash
sudo a2enmod rewrite
sudo a2ensite sicrefym.conf
sudo systemctl restart apache2
```

---

## 6. Diagnóstico y Resolución de Problemas (Troubleshooting)

### Error 1: *"Subir foto asistente ha fallado"*
* **Causa:** La extensión `fileinfo` no está activada en `php.ini`, o el peso de la imagen excede el parámetro `upload_max_filesize`.
* **Solución:**
  1. Abra su `php.ini` y verifique que `extension=fileinfo` no tenga `;` al inicio.
  2. Incremente `upload_max_filesize = 32M` y `post_max_size = 32M`.
  3. Reinicie su servidor web o servicio PHP.

### Error 2: *"Las imágenes de los alumnos se ven rotas en el panel de revisores"*
* **Causa:** No se ha generado el enlace simbólico entre `public/storage` y `storage/app/public`.
* **Solución:**
  Ejecute en la raíz del proyecto:
  ```bash
  php artisan storage:link
  ```

### Error 3: *"Error 419 - Page Expired"*
* **Causa:** La sesión expiró por inactividad o la directiva `@csrf` no fue enviada en un formulario.
* **Solución:**
  Limpie las cookies del navegador y verifique los permisos en `storage/framework/sessions`. Ejecute:
  ```bash
  php artisan view:clear
  php artisan cache:clear
  ```

### Error 4: *"Redirección infinita o colisión al abrir /admin teniendo abierta la sesión de alumno"*
* **Causa:** Las sesiones de los guards `web` y `revisor` se encontraban entrelazadas en middleware previo.
* **Solución:**
  Se solucionó con el middleware actualizado `RedirectIfAuthenticated.php`. Si ocurre en desarrollo, abra una ventana de incógnito o borre la cookie `sicrefym_session`.

> [!NOTE]  
> Los errores pueden ver variados, estos son los errores mas comunes para este proyecto. Y las soluciones tambien pueden ser variadas, asi que los errores y soluciones pueden no ser iguales a las documentadas.