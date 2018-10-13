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
                    <th>Cd. Produto</th>
                    <th>Nome Produto</th>
                    <th class="text-center">Nº Lançamento</th>
                    <th>Data da movimentação</th>
                    <th class="text-right">Quantidade</th>
                    <th class="text-right">Preço</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($produtos as $produto)
                    <tr>
                        <td>{{ $produto->cdproduto }}</td>
                        <td>{{ $produto->nmproduto }}</td>
                        <td class="text-center">{{ $produto->id }}</td>
                        <td>{{ $produto->dt_br }}</td>
                        <td class="text-right">{{ $produto->quantidade }}</td>
                        <td class="text-right">{{ $produto->precounitario }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted text-right">
            <a href="{{ url('housekeeping/relatorios/movimentacaoestoque/export') }}"><button type="button" class="btn btn-secondary">Exportar</button></a>
        </div>
    </div>
@endsection
