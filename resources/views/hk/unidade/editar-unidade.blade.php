@extends('hk.unidade.app')

@section('content-app')
    <h2>Editar unidade</h2>
    <form id="logout-form" action="{{ route('editar-unidade', ['id' => $unidade->id]) }}" method="POST">
        @csrf
        <input type="text" hidden id="id" name="id" value="{{ $unidade->id }}">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input required value="{{ $unidade->nome }}" type="text" name="nome" class="form-control" id="nome" aria-describedby="nome-help">
            <small id="nome-help" class="form-text text-muted">Nome da unidade</small>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input required value="{{ $unidade->telefone }}" type="text" name="telefone" class="form-control" id="telefone">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">
                Cadastrar
            </button>
        </div>
    </form>
@endsection
