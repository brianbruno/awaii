@extends('layouts.novo-usuario')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <h1>Oi {{ Auth::user()->name }}!</h1>
                        <p>Ficamos felizes que você deseja usar o Awaii, mas você ainda não possui uma loja associada.</p>
                        <p>Envie um email para contato@brian.place para que você seja associado a uma unidade, ok?</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
