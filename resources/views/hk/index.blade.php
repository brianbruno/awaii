@extends('layouts.hk')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Housekeeping</div>

                    <div class="card-body">
                        <h1><strong>Oi {{ Auth::user()->name }}!</strong></h1>
                        <p>Temos {{ App\Unidade::all()->count() }} unidades cadastradas!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
