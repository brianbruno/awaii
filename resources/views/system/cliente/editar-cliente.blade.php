@extends('layouts.system')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Cadastro de cliente</div>
                    <div class="card-body">
                        <form id="logout-form" action="{{ route('editar-cliente') }}" method="POST">
                            @csrf
                            <input type="text" hidden id="id" name="id" value="{{ $cliente->id }}">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input required type="text" value="{{ $cliente->nome }}" name="nome" class="form-control" id="nome" aria-describedby="nome-help" disabled>
                                <small id="nome-help" class="form-text text-muted">Nome completo</small>
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input required type="text" value="{{ $cliente->cpf }}" name="cpf" class="form-control" id="cpf" disabled>
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone</label>
                                <input required type="text" value="{{ $cliente->telefone }}" name="telefone" class="form-control" id="telefone">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input required type="email" value="{{ $cliente->email }}" name="email" class="form-control" id="email">
                            </div>

                            <div class="form-group">
                                <label for="endereco">Endereço</label>
                                <input required type="text" value="{{ $cliente->endereco }}" name="endereco" class="form-control" id="endereco">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Salvar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
