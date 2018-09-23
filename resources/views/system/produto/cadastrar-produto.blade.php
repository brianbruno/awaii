@extends('layouts.system')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Cadastro de produto</div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (!empty($resultado)  && $resultado)
                                <div class="alert alert-success" role="alert">
                                    Produto cadastrado com sucesso!
                                </div>
                        @endif

                        <form id="logout-form" action="{{ route('cadastrar-produto') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="cdproduto">Código do Produto</label>
                                <input type="text" name="cdproduto" class="form-control" id="cdproduto" aria-describedby="cdprod-help" placeholder="0000000000">
                                <small id="cdprod-help" class="form-text text-muted">Código com 10 dígitos</small>
                            </div>
                            <div class="form-group">
                                <label for="nmproduto">Nome do Produto</label>
                                <input type="text" name="nmproduto" class="form-control" id="nmproduto">
                            </div>
                            <div class="form-group">
                                <label for="unidade">Unidade</label>
                                <input type="text" name="unidade" class="form-control" id="unidade">
                            </div>
                            <div class="form-group">
                                <label for="preco">Preço</label>
                                <input type="text" name="preco" class="form-control" id="preco">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Cadastrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
