<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SICREFyM</title>

    <!-- Scripts -->
    {{-- <script src="js/app.js" defer></script> --}}


    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="css/app.css" rel="stylesheet"> --}}
    <link href="/css/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="/css/redes-icon.css" rel="stylesheet">
    <link href="/css/header.css" rel="stylesheet">
    <link href="/css/registro_login.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header>
            @include('includes.header')
        </header>
        <main class="py-4" style="padding-top: 0; padding-bottom: 89px;">
            @yield('content')
        </main>
    </div>
    <footer style="height: 89px; position: fixed; bottom: 0; width: 100%; background-color:#004990">
        @include('includes.footer')
    </footer>
    <script src="/js/jquery-3.5.1.js"></script>
    <script src="/js/bootstrap/bootstrap.js"></script>
    <script>
        /// Url actual
        let pathname = new String(window.location.pathname);
        let url = pathname.replace("/", "");

        /// Elementos de li
        const tabs = ["register", "login", "asistentes"];

        tabs.forEach(e => {
            /// Compara el url actual con el arreglo
            if ( url === e) {
                /// Agregar tab- para hacer que coincida la Id
                setActive("tab-" + e);
            }
            if(url == ""){
                setActive("tab-inicio");
            }
        });

        /// Funcion que asigna la clase active
        function setActive(id) {
            document.getElementById(id).setAttribute("class", "txt-brand active");
        }
    </script>
    <script>
        $('#form_edit_asistente').submit(function(e) {
          if ($('input[type=checkbox]:checked').length === 0) {
            e.preventDefault();
            alert('Debe seleccionar al menos un valor dentro de la tabla que contiene los concursos para continuar.');
          }
        });    
    </script>
    
</body>

</html>
