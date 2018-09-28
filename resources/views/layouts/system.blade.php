<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Request::segment(1) == '' ? 'active' : ''}}">
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="fa fa-home"></i>
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </li>
                <li class="nav-item dropdown {{ Request::segment(1) == 'produto' ? 'active' : ''}}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-warehouse"></i>
                        Produto
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('produtos') }}">Produtos</a>
                        <a class="dropdown-item" href="{{ route('cadastrar-produto') }}">Cadastrar Produto</a>
                    </div>
                </li>

                <li class="nav-item dropdown {{ Request::segment(1) == 'cliente' ? 'active' : ''}}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-address-card"></i>
                        Cliente
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('clientes') }}">Clientes</a>
                        <a class="dropdown-item" href="{{ route('cadastrar-cliente') }}">Cadastrar Cliente</a>
                    </div>
                </li>
                @if(Auth::user()->podeAcessarPagina('pedido'))
                    <li class="nav-item dropdown {{ Request::segment(1) == 'pedido' ? 'active' : ''}}">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-utensils"><span class="badge badge-danger">{{ \App\Pedido::pedidosPendentes() }}</span></i>
                            Pedido
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->podeAcessarPagina('pedidos'))
                                <a class="dropdown-item" href="{{ route('pedidos') }}">Pedidos</a>
                            @endif
                            @if(Auth::user()->podeAcessarPagina('cadastrar-pedido'))
                                <a class="dropdown-item" href="{{ route('cadastrar-pedido') }}">Novo Pedido</a>
                            @endif
                            @if(Auth::user()->podeAcessarPagina('producao'))
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('producao') }}">Produção</a>
                            @endif
                        </div>
                </li>
                @endif
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fa fa-user-circle"></i>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if(Auth::user()->podeAcessarPagina('housekeeping'))
                            <a class="dropdown-item" href="{{ route('housekeeping') }}" >
                                Painel de Controle
                            </a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <main class="py-4">
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

        @if (!empty($resultado)  && $resultado)
            <notification mensagem="Operação realizada com sucesso!" tipo="sucesso" titulo="Sucesso!"></notification>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>
