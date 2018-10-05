@extends('layouts.hk')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Adicionar Licença</div>

                    <div class="card-body">
                        <form id="logout-form" action="{{ route('adicionar-licenca') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="id">Unidade</label>
                                <select id="id" name="id" class="custom-select">
                                    <option selected>Escolha uma unidade</option>
                                    @foreach (\App\Unidade::all() as $unidade)
                                        <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="validade_licenca">Validade</label>
                                <input required type="text" placeholder="01/01/2000" name="validade_licenca" class="form-control" id="validade_licenca">
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-secondary ">
                                    Adicionar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
