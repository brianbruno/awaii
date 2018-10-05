@extends('hk.cliente.app')

@section('content-app')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Nome</th>
            <th scope="col">Telefone</th>
            <th scope="col">Email</th>
            <th class="text-center">Editar</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($clientes as $cliente)
            <tr>
                <td>{{ $cliente->nome }}</td>
                <td>{{ $cliente->telefone }}</td>
                <td>{{ $cliente->email }}</td>
                <td class="text-center"><a href="{{ route('cliente-id', ['id' => $cliente->id]) }}"><i class="material-icons text-secondary">edit</i></a></td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
