@extends('hk.unidade.app')

@section('content-app')
    <form id="logout-form" action="{{ route('associar-unidade') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="id">Usuário</label>
            <select id="id" name="id" class="custom-select">
                <option selected>Escolha um usuário</option>
                @foreach (App\User::all() as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="unidade">Unidade</label>
            <select id="unidade" name="unidade" class="custom-select">
                <option selected>Escolha uma unidade</option>
                @foreach (App\Unidade::all() as $unidade)
                    <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Associar
        </button>
    </form>
@endsection
