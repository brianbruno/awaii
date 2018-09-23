@extends('layouts.system')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a class="btn btn-primary btn-lg" href="{{ route('produtos') }}">Cadastrar produto</a>
                        <button type="button" class="btn btn-primary btn-lg">Novo pedido</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
