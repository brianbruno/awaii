@extends('hk.usuario.app')

@section('content-app')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Nome</th>
            <th scope="col">Email</th>
            <th class="text-center" scope="col">Level</th>
            <th class="text-center">Unidade</th>
            <th class="text-center">Editar</th>
        </tr>
        </thead>
        <tbody>
        @foreach (App\User::all() as $usuario)
            <tr>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td class="text-center">{{ $usuario->level }}</td>
                <td class="text-center">{{ $usuario->unidade }}</td>
                <td class="text-center"><a href="{{ route('usuario-id', ['id' => $usuario->id]) }}"><i class="material-icons text-secondary">edit</i></a></td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
