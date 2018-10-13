<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('public/css/housekeeping.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a href="{{ url('housekeeping') }}">{{ config('app.name', 'Awaii') }}</a>
                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <div class="sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/bootstrap4/assets/img/user.jpg" alt="User picture">
                    </div>
                    <div class="user-info">
                        <span class="user-name"><strong>{{ \Auth::user()->name }}</strong></span>
                        <span class="user-role">Administrator</span>
                        <span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>Online</span>
                        </span>
                    </div>
                </div>
                <!-- sidebar-header  -->
                <div class="sidebar-search">
                    <div>
                        <div class="input-group">
                            <input type="text" class="form-control search-menu" placeholder="Buscar...">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sidebar-search  -->
                <div class="sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>Geral</span>
                        </li>
                        <li>
                            <a href="{{ url('housekeeping/') }}">
                                <i class="fa fa-tachometer-alt"></i>
                                <span>Dashbooard</span>
                                <span class="badge badge-pill badge-danger">New</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-chart-line"></i>
                                <span>Relatórios</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="#">Pedidos</a>
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        <a href="{{ url('housekeeping/relatorios/lucroporproduto') }}">Lucro por produto</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fas fa-boxes"></i>
                                <span>Cadastros</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="{{ url('housekeeping/unidades') }}">Unidade</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('housekeeping/clientes') }}">Cliente</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('housekeeping/produtos') }}">Produto</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="{{ url('housekeeping/estoque') }}">
                                <i class="fas fa-dolly"></i>
                                <span>Estoque</span>
                            </a>
                        </li>
                        <li class="header-menu">
                            <span>Usuários</span>
                        </li>
                        <li>
                            <a href="{{ url('housekeeping/usuarios') }}">
                                <i class="fas fa-user-check"></i>
                                <span>Usuários</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('housekeeping/user-management') }}">
                                <i class="fas fa-user-check"></i>
                                <span>Controle de acesso</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->
            <div class="sidebar-footer">
                <a href="#">
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-pill badge-warning notification">3</span>
                </a>
                <a href="#">
                    <i class="fa fa-envelope"></i>
                    <span class="badge badge-pill badge-success notification">7</span>
                </a>
                <a href="#">
                    <i class="fa fa-cog"></i>
                    <span class="badge-sonar"></span>
                </a>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>
        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <main class="py-4">

                @if (!empty($resultado)  && $resultado)
                    <notification mensagem="Operação realizada com sucesso!" tipo="sucesso" titulo="Sucesso!"></notification>
                @endif

                @if (!empty($resultado)  && !$resultado)
                    <notification mensagem="Ocorreu um erro ao realizar a operação." tipo="erro" titulo="Erro!"></notification>
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <notification mensagem="{{ $error }}" tipo="erro" titulo="Erro!"></notification>
                    @endforeach
                @endif

                @if (!empty($exception))
                    <div class="alert alert-danger">
                        <h1><strong>Erro crítico!</strong></h1>
                        <p>{{ $exception }}</p>
                    </div>
                @endif
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
        </main>
        <!-- page-content" -->
    </div>
</div>
<!-- page-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script>
    jQuery(function ($) {

        $(".sidebar-dropdown > a").click(function() {
            $(".sidebar-submenu").slideUp(200);
            if (
                $(this)
                    .parent()
                    .hasClass("active")
            ) {
                $(".sidebar-dropdown").removeClass("active");
                $(this)
                    .parent()
                    .removeClass("active");
            } else {
                $(".sidebar-dropdown").removeClass("active");
                $(this)
                    .next(".sidebar-submenu")
                    .slideDown(200);
                $(this)
                    .parent()
                    .addClass("active");
            }
        });

        $("#close-sidebar").click(function() {
            $(".page-wrapper").removeClass("toggled");
        });
        $("#show-sidebar").click(function() {
            $(".page-wrapper").addClass("toggled");
        });




    });
</script>
@yield('scripts')
</body>
</html>
