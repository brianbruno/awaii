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
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="card text-white bg-deeporange-darken4" >
                                    <div class="card-header">Pedidos pendentes</div>
                                    <div class="card-body text-center">
                                        <h1 class="card-title"><strong>{{ App\Pedido::pedidosPendentes() }}</strong></h1>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
