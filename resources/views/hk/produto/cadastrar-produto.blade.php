@extends('hk.produto.app')

@section('content-app')
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
@endsection
