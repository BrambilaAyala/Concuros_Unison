<div class="top-header">
    <div class="container">
        @auth

                <a class="btn btn-outline-light btn-sm lo-btn" style="float: right; position: relative; top: 0.5px; margin-left: 2em; font-size: 1em;"  href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

        @endauth

        <a href="#"><span class="icon-tt"></span></a>
        <a href="#"><span class="icon-fb"></span></a>
    </div>
</div>

<div class="container center-header">

</div>

<nav class="navbar navbar-expand-md navbar-light shadow-sm">
    <div class="container">
        <a class="txt-brand" href="{{ url('/') }}">
            {{-- {{ config('app.name', 'SICRFyM') }} --}}<b>SICRFyM</b>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            {{--<ul class="navbar-nav mr-auto">

            </ul> --}}

            <!-- Right Side Of Navbar -->
            {{-- ml-auto --}}
            <ul class="navbar-nav mr-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="txt-brand"  href="{{ route('login') }}">{{ __('Accede') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="txt-brand" href="{{ route('register') }}">{{ __('Registrate') }}</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="txt-brand"  href="{{ route('asistentes.index') }}">{{ __('Perfil') }}</a>
                    </li>
                @endguest  
            </ul>
        </div>
    </div>
</nav>
