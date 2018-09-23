<table class="table">
    <thead>
    <tr>
        <th scope="col">Código</th>
        <th scope="col">Cliente</th>
        <th scope="col">Telefone</th>
        <th scope="col">Data</th>
        <th scope="col1">Total</th>
        <th scope="col1">Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($pedidos as $pedido)
        <tr>
            <td>{{ $pedido->id }}</td>
            <td>{{ $pedido->cliente()->get()[0]->nome }}</td>
            <td>{{ $pedido->cliente()->get()[0]->telefone }}</td>
            <td>{{ date('d/m/Y H:i:s', strtotime($pedido->dt_pedido)) }}</td>
            <td>{{ $pedido->total  }}</td>
            <td>{{ $pedido->status }}</td>
        </tr>
    @endforeach

    </tbody>
</table>
