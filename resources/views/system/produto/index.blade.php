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
                                    <td>{{ $produto->precof }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
