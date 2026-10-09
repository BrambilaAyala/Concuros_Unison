<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SICREFyM - Panel de Administración</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/css/admin/all.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/admin/adminlte.min.css">

    <style>
        /* Paleta visual limpia, moderna y equilibrada */
        body {
            background-color: #f8fafc;
            color: #334155;
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        .content-wrapper {
            background-color: #f8fafc;
        }
        .main-header {
            box-shadow: 0 1px 2px rgba(0,0,0,0.03) !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }
        
        /* Menú lateral gris clásico (#343a40) mejorado, sin iconografía y sin colores estridentes */
        .main-sidebar {
            background-color: #343a40 !important;
            box-shadow: 0 0 15px rgba(0,0,0,0.08) !important;
        }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link {
            color: #c2c7d0;
            font-weight: 500;
            padding: 9px 16px;
            border-radius: 6px;
            font-size: 0.93rem;
            transition: all 0.15s ease;
        }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
            background-color: #004990 !important;
            color: #ffffff !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link .badge {
            background-color: rgba(255, 255, 255, 0.18) !important;
            color: #ffffff !important;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 10px;
        }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active .badge {
            background-color: #ffffff !important;
            color: #004990 !important;
        }

        /* Tarjetas con sombras suaves y bordes limpios */
        .card {
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
            border-radius: 6px;
        }
    </style>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
    
		@include('includes.admin.navbar')
    
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			@yield('content')
		</div>
	    <!-- /.content-wrapper -->
    
        <!-- Main Footer -->
		<footer class="main-footer text-sm py-2 bg-white border-top">
			<div class="float-right d-none d-sm-inline text-muted font-weight-bold">
				SICREFyM v2026.1
			</div>
			<span class="text-muted">Concurso Regional de Física y Matemáticas &copy; 2026 <a href="https://www.unison.mx" target="_blank" class="text-primary font-weight-bold">Universidad de Sonora</a>.</span>
		</footer>
    </div>
    <!-- ./wrapper -->
    
    <script src="/js/jquery-3.5.1.js"></script>
    <script src="/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="/js/admin/adminlte.min.js"></script>
    <script src="/js/admin.js"></script>
    @stack('scripts')
</body>
</html>