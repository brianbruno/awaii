@extends('hk.produto.app')

@section('content-app')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Cd. Produto</th>
            <th scope="col">Nome Produto</th>
            <th scope="col">Unidade</th>
            <th scope="col">Preço</th>
            <th scope="col">Preço de Custo</th>
            <th class="text-center">Editar</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($produtos as $produto)
            <tr>
                <td>{{ $produto->cdproduto }}</td>
                <td>{{ $produto->nmproduto }}</td>
                <td>{{ $produto->unidade }}</td>
                <td>{{ $produto->precof }}</td>
                <td>R$0,00</td>
                <td class="text-center"><a href="{{ route('produto-id', ['id' => $produto->cdproduto]) }}"><i class="material-icons text-secondary">edit</i></a></td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
