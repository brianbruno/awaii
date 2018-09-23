@extends('layouts.system')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Cliente</th>
            <th scope="col">Telefone</th>
            <th scope="col">Data</th>
            <th scope="col">Editar</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->cliente()->get()[0]->nome }}</td>
                <td>{{ $pedido->cliente()->get()[0]->telefone }}</td>
                <td>{{ date('d/m/Y H:i:s', strtotime($pedido->dt_pedido)) }}</td>
                <td><a href="{{ route('pedido-id', ['id' => $pedido->id]) }}"><i class="material-icons text-secondary">edit</i></a>
                    <a href="{{ route('finalizar-pedido', ['id' => $pedido->id]) }}"><i class="material-icons text-danger">close</i></a></td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
