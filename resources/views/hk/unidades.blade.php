@extends('layouts.hk')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Unidades</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Telefone</th>
                                <th class="text-center" scope="col">Usuários</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach (App\Unidade::all() as $unidade)
                                <tr>
                                    <td>{{ $unidade->nome }}</td>
                                    <td>{{ $unidade->telefone }}</td>
                                    <td class="text-center">{{ $unidade->usuarios()->get()->count() }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
