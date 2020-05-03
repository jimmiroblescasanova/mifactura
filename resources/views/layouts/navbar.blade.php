<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'MiFactura') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ setActive('home') }}">Inicio</a>
                    </li>
                    @if (!Auth::user()->is_admin)
                        <li class="nav-item dropdown {{ setActive('documents.*') }}">
                            <a id="documentsDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Mis Documentos <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="documentsDropdown">
                                <a class="dropdown-item" href="{{ route('documents.index', 'I') }}">
                                    Facturas
                                </a>
                                <a class="dropdown-item" href="{{ route('documents.index', 'P') }}">
                                    Complementos de Pago
                                </a>
                                <a class="dropdown-item" href="{{ route('documents.index', 'E') }}">
                                    Notas de Crédito
                                </a>
                            </div>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ setActive('user.*') }}" href="{{ route('user.edit') }}">Mis datos</a>
                    </li>
                    @if (Auth::user()->is_admin)
                        {{--<li class="nav-item">
                            <a class="nav-link {{ setActive('admin.empresa') }}" href="{{ route('admin.empresa') }}">Empresa</a>
                        </li>--}}
                        <li class="nav-item">
                            <a class="nav-link {{ setActive('admin.users') }}" href="{{ route('admin.users') }}">Usuarios registrados</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Ingresar</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->rfc }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Salir
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
