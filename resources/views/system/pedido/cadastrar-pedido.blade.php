@extends('layouts.system')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Novo pedido</div>

                    <div class="card-body">
                        <form id="logout-form" action="{{ route('cadastrar-pedido') }}" method="POST">
                            @csrf	
                            <div class="form-group">	
                                <label for="id_cliente">Cliente</label>	
                                <select id="id_cliente" name="id_cliente" class="custom-select">	
                                    <option selected>Escolha um cliente</option>	
                                    @foreach ($clientes as $cliente)	
                                        <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>	
                                    @endforeach	
                                </select>	
                            </div>	
                             <div class="form-group">	
                                <label for="cdproduto">Item</label>	
                                <select id="cdproduto" name="cdproduto" class="custom-select">	
                                    <option selected>Escolha um produto</option>	
                                    @foreach ($produtos as $produto)	
                                        <option value="{{ $produto->cdproduto }}">{{ $produto->nmproduto }}</option>	
                                    @endforeach	
                                </select>	
                            </div>	
                             <div class="form-group">	
                                <label for="quantidade">Quantidade</label>	
                                <input required type="number" name="quantidade" class="form-control" id="quantidade">	
                            </div>	
                             <button type="submit" class="btn btn-primary">	
                                Cadastrar	
                            </button>	
                        </form>
                      
                        <pedido></pedido>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
