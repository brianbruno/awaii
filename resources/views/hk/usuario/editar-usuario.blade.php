@extends('hk.usuario.app')

@section('content-app')
    <form id="logout-form" action="{{ route('editar-usuario', ['id' => $usuario->id]) }}" method="POST">
        @csrf
        <input type="text" hidden id="id" name="id" value="{{ $usuario->id }}">
        <div class="form-group">
            <label for="name">Nome</label>
            <input required value="{{ $usuario->name }}" type="text" name="name" class="form-control" id="name" aria-describedby="nome-help">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input required value="{{ $usuario->email }}" type="email" name="email" class="form-control" id="email">
        </div>
        <div class="form-group">
            <label for="unidade">Unidade</label>
            <select id="unidade" name="unidade" class="custom-select">
                @if(!empty($usuario->unidade()->get()[0]))
                    <option selected value="{{ empty($usuario->unidade()->get()[0]->id) ? '' : $usuario->unidade()->get()[0]->id  }}">Atual: {{ empty($usuario->unidade()->get()[0]->nome) ? '' : $usuario->unidade()->get()[0]->nome }}</option>
                @else
                    <option selected value="null">Nenhuma</option>
                @endif
                @foreach (\App\Unidade::all() as $unidade)
                    <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="level">Level</label>
            <select id="level" name="level" class="custom-select">
                <option selected value="{{ $usuario->level }}">Atual: {{ $usuario->level }}</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-secondary ">
                Alterar
            </button>
        </div>
    </form>
@endsection
