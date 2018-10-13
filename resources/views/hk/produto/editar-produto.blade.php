@extends('hk.produto.app')

@section('content-app')
    <h2>{{ $produto->nmproduto }}</h2>

    <h4>Custo total do produto: R$ 2,50</h4>

    <h5>Receita:</h5>
    <table class="table table-hover table-striped">
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
        @foreach($produto->receita as $item_receita)
            <tr>
                <td>{{ $item_receita->cdproduto_filho }}</td>
                <td>{{ $item_receita->produto()->get()[0]->nmproduto  }}</td>
                <td>{{ $item_receita->produto()->get()[0]->unidade }}</td>
                <td>{{ $item_receita->produto()->get()[0]->precof }}</td>
                <td>R$0,00</td>
                <td class="text-center"><a href="{{ route('produto-id', ['id' => $produto->cdproduto]) }}"><i class="material-icons text-secondary">edit</i></a></td>
            </tr>
        @endforeach

        </tbody>
    </table>

@endsection
