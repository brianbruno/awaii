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
                @if(Auth::user()->podeAcessarPagina('pedido'))
                    <li class="nav-item dropdown {{ Request::segment(1) == 'pedido' ? 'active' : ''}}">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-utensils"><span class="badge badge-danger">{{ \App\Pedido::pedidosPendentes(Auth::user()->unidade) }}</span></i>
                            Pedido
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->podeAcessarPagina('pedidos'))
                                <a class="dropdown-item" href="{{ route('pedidos') }}">Pedidos</a>
                            @endif
                            @if(Auth::user()->podeAcessarPagina('cadastrar-pedido'))
                                <a class="dropdown-item" href="{{ route('cadastrar-pedido') }}">Novo Pedido</a>
                            @endif
                        </div>
                </li>
                @endif

                @if(Auth::user()->podeAcessarPagina('producao'))
                    <li class="nav-item dropdown {{ Request::segment(1) == 'pedido' ? 'active' : ''}}">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-clipboard-list"></i>
                            Produção
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->podeAcessarPagina('producao'))
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
                                Gerencial
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
    <nav class="navbar sub-nav">
        <span class="navbar-text ml-auto text-light">
            Unidade: {{ Auth::user()->unidade()->get()[0]->nome }}
        </span>
    </nav>
    <main class="py-4">
        @if (!empty($message))
            <notification mensagem="{{ $message }}" tipo="alerta" titulo="Alerta!"></notification>
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

        @if (!empty($stacktrace) && env('APP_ENV', 'production') == 'local')
            <div class="alert alert-danger">
                <h1><strong>Stacktrace:</strong></h1>
                <p>{{ $stacktrace }}</p>
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
