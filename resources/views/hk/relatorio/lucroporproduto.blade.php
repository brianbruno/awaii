@extends('layouts.hk')

@section('content')
    <div class="card border-dark">
        <div class="card-header text-white bg-dark">
            Relatório de Lucro por Produto
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Cd. Produto</th>
                    <th scope="col">Nome Produto</th>
                    <th scope="col">Preço de Custo</th>
                    <th scope="col">Preço de Venda</th>
                    <th scope="col">Diferença</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($produtos as $produto)
                    <tr>
                        <td>{{ $produto->cdproduto }}</td>
                        <td>{{ $produto->nmproduto }}</td>
                        <td>{{ $produto->precocustof }}</td>
                        <td>{{ $produto->precof }}</td>
                        <td>{{ $produto->taxalucrof }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
