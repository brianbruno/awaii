<template>
    <div class="card">
        <div class="card-header">Fila</div>

        <div class="card-body text-center">
            <h2>Pedido pronto:</h2>
            <h1 class="pedidoPronto">{{ ultimosPedidos[0]}}</h1>
            <h6>{{ ultimosPedidos[1]}}</h6>
            <h6>{{ ultimosPedidos[2]}}</h6>
            <h6>{{ ultimosPedidos[3]}}</h6>
        </div>
    </div>
</template>

<style scoped>
    .pedidoPronto {
        font-size: 120px;
        color: red;
    }
</style>

<script>
    export default {
        data () {
            return {
                ultimosPedidos : ['Nenhum pedido :(', 'Nenhum pedido :(', 'Nenhum pedido :(', 'Nenhum pedido :('],
            }
        },
        mounted() {
            let self = this;
            Echo.channel('pedidos')
                .listen('PedidoEntregue', (e) => {
                    self.addPedido(e.pedido);
                });
        },
        methods: {
            addPedido: function (pedido) {
                let self = this;

                self.ultimosPedidos.unshift(pedido.id);
                self.ultimosPedidos.pop();

            },
        }
    }
</script>
