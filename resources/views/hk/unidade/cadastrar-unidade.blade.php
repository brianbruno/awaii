@extends('hk.unidade.app')

@section('content-app')
    <form id="logout-form" action="{{ route('cadastrar-unidade') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome</label>
            <input required type="text" name="nome" class="form-control" id="nome" aria-describedby="nome-help">
            <small id="nome-help" class="form-text text-muted">Nome da unidade</small>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input required type="text" name="telefone" class="form-control" id="telefone">
        </div>
        <button type="submit" class="btn btn-primary">
            Cadastrar
        </button>
    </form>
@endsection
