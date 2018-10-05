@extends('layouts.system')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pedidos pendentes</div>

                    <div class="card-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">Data</th>
                                <th scope="col1">Total</th>
                                <th scope="col">Editar</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->id }}</td>
                                    <td>{{ $pedido->cliente->nome }}</td>
                                    <td>{{ $pedido->cliente->telefone }}</td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($pedido->dt_pedido)) }}</td>
                                    <td>{{ $pedido->total  }}</td>
                                    <td><a href="{{ route('pedido-id', ['id' => $pedido->id]) }}"><i class="material-icons text-secondary">edit</i></a>
                                        <a href="{{ route('finalizar-pedido', ['id' => $pedido->id]) }}"><i class="material-icons text-danger">close</i></a></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="text-right">
                            <a class="btn btn-secondary" href="{{ route('exportar-pedidos') }}">Exportar pedidos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
