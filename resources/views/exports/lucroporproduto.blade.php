<table class="table">
    <thead>
    <tr>
        <th scope="col">Cd. Produto</th>
        <th scope="col">Nome Produto</th>
        <th scope="col">Preço de Custo</th>
        <th scope="col">Preço de Venda</th>
        <th scope="col">Diferença</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($produtos as $produto)
        <tr>
            <td>{{ $produto->cdproduto }}</td>
            <td>{{ $produto->nmproduto }}</td>
            <td>{{ $produto->precocustof }}</td>
            <td>{{ $produto->precof }}</td>
            <td>{{ $produto->taxalucrof }}</td>
        </tr>
    @endforeach

    </tbody>
</table>
