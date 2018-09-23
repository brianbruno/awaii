@extends('layouts.system')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Produção</div>

                    <div class="card-body">
                        <div class="row">
                            @if (!empty($message))
                                <notification mensagem="{{ $message }}" tipo="sucesso" titulo="Sucesso!"></notification>
                            @endif
                            @foreach (App\ItemPedido::getProducaoPendente() as $producao_pendente)
                                <div class="col-md-4">
                                    <div class="card text-white bg-dark mb-3">
                                        <div class="card-header">Produto {{ $producao_pendente->produto()->get()[0]->cdproduto }}</div>
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $producao_pendente->produto()->get()[0]->nmproduto }}</h4>
                                            <h6>Quantidade: {{ $producao_pendente->quantidade }}</h6>
                                        </div>
                                        <div class="card-footer text-muted">
                                            <h6>{{ $producao_pendente->data }}</h6>
                                        </div>
                                        <div class="card-footer text-muted">
                                            <div class="text-right">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{ route('pedido-id', ['id' => $producao_pendente->pedido()->get()[0]->id]) }}" class="btn btn-sm btn-secondary text-white"><i class="material-icons">description</i></a>
                                                    <a href="{{ route('finalizar-item', ['id_pedido' => $producao_pendente->pedido()->get()[0]->id, 'id_item' => $producao_pendente->sequencial]) }}" class="btn btn-sm btn-success text-white"><i class="material-icons">check</i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
