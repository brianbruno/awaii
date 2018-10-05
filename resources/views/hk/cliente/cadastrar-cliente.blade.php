@extends('hk.cliente.app')

@section('content-app')
    <form id="logout-form" action="{{ route('cadastrar-cliente') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome</label>
            <input required value="{{ old('nome') }}" type="text" name="nome" class="form-control {{ $errors->has('nome') ? ' is-invalid' : '' }}"
                   id="nome" aria-describedby="nome-help">
            <small id="nome-help" class="form-text text-muted">Nome completo</small>
        </div>
        <div class="form-group">
            <label for="cpf">CPF</label>
            <input required value="{{ old('cpf') }}" type="text" name="cpf" class="form-control {{ $errors->has('cpf') ? ' is-invalid' : '' }}" id="cpf">
        </div>
        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input required value="{{ old('telefone') }}" type="text" name="telefone" class="form-control {{ $errors->has('telefone') ? ' is-invalid' : '' }}" id="telefone">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input required value="{{ old('email') }}" type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email">
        </div>

        <div class="form-group">
            <label for="endereco">Endereço</label>
            <input required value="{{ old('endereco') }}" type="text" name="endereco" class="form-control {{ $errors->has('endereco') ? ' is-invalid' : '' }}" id="endereco">
        </div>

        <button type="submit" class="btn btn-secondary">
            Cadastrar
        </button>
    </form>
@endsection
