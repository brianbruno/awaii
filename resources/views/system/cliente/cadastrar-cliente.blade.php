@extends('layouts.system')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Cadastro de cliente</div>

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
                                Cliente cadastrado com sucesso!
                            </div>
                        @endif

                        <form id="logout-form" action="{{ route('cadastrar-cliente') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input required type="text" name="nome" class="form-control" id="nome" aria-describedby="nome-help">
                                <small id="nome-help" class="form-text text-muted">Nome completo</small>
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input required type="text" name="cpf" class="form-control" id="cpf">
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone</label>
                                <input required type="text" name="telefone" class="form-control" id="telefone">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input required type="email" name="email" class="form-control" id="email">
                            </div>

                            <div class="form-group">
                                <label for="endereco">Endereço</label>
                                <input required type="text" name="endereco" class="form-control" id="endereco">
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
