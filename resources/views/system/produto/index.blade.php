@extends('layouts.system')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Cd. Produto</th>
            <th scope="col">Nome Produto</th>
            <th scope="col">Unidade</th>
            <th scope="col">Preço</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($produtos as $produto)
            <tr>
                <td>{{ $produto->cdproduto }}</td>
                <td>{{ $produto->nmproduto }}</td>
                <td>{{ $produto->unidade }}</td>
                <td>{{ $produto->preco }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
