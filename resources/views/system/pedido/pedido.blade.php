@extends('layouts.system')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pedido {{ $pedido->id }} | Cliente: {{ $pedido->cliente()->get()[0]->nome }}</div>

                    <div class="card-body">
                        <a class="btn btn-warning btn-lg btn-block" href="{{ route('finalizar-pedido', ['id' => $pedido->id]) }}">Finalizar Pedido</a>
                        <hr>
                        @if (!empty($exception))
                            <div class="alert alert-danger">
                                <strong>Erro crítico!</strong>
                                <p>{{ $exception }}</p>
                                <p>{{ $stacktrace }}</p>
                            </div>
                        @endif
                        @if (!empty($resultado)  && $resultado)
                            <div class="alert alert-success" role="alert">
                                Item registrado com sucesso!
                            </div>
                        @endif
                        @if (!empty($message))
                            <notification mensagem="{{ $message }}" tipo="erro" titulo="Erro!"></notification>
                        @endif
                        <form id="form" method="POST" action="{{ route('cadastrar-item') }}" class="form-inline">
                            @csrf
                            <input type="text" hidden id="id_pedido" name="id_pedido" value="{{ $pedido->id }}">
                            <label class="sr-only" for="cdproduto">Item</label>
                            <select id="cdproduto" name="cdproduto" class="custom-select form-control mb-2 col-sm-5">
                                <option selected>Escolha um produto</option>
                                @foreach ($produtos as $produto)
                                    <option value="{{ $produto->cdproduto }}">{{ $produto->nmproduto }}</option>
                                @endforeach
                            </select>

                            <label class="sr-only" for="quantidade">Quantidade</label>
                            <input required type="number" name="quantidade" class="form-control mb-2 col-sm-5" id="quantidade">

                            <button type="submit" class="btn btn-primary mb-2 col-sm-2">Inserir</button>

                        </form>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Preço</th>
                                <th scope="col">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pedido->itens()->get() as $item)
                                <tr class="{{ $item->status != 'PRODUZIDO' ? 'bg-red-lighten3' : 'bg-green-lighten3'}}">
                                    <td>{{ $item->produto()->get()[0]->nmproduto }}</td>
                                    <td>{{ $item->quantidade.' ('.$item->produto()->get()[0]->unidade.')' }}</td>
                                    <td>{{ $item->preco }}</td>
                                    <td>{{ $item->total }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-right"><strong>Total: </strong></td>
                                <td>{{ $pedido->total }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
