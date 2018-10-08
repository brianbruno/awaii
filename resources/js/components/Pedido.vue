<template>
    <div id="view">
        <loading
            :show="carregando"
            :label="label">
        </loading>
        <div class="card-header">
            <div class="row">
                <div class="col-sm-11">
                    <h2><span class="align-bottom">Pedidos pendentes</span></h2>
                </div>
                <div class="col-sm-1 text-right">
                    <button v-on:click="buscarPedidos" type="button" class="btn btn-info btn-sm text-white">Atualizar</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Data</th>
                    <th scope="col1">Total</th>
                    <th scope="col">Editar</th>
                </tr>
                </thead>
                <tbody>

                <!--@foreach (\App\Pedido::getPedidosPendentes() as $pedido)-->
                <tr v-for="pedido in pedidos">
                    <td>{{ pedido.pedido_id }}</td>
                    <td>{{ pedido.cliente_nome }}</td>
                    <td>{{ pedido.cliente_telefone }}</td>
                    <td>{{ pedido.dt_br }}</td>
                    <td>{{ pedido.total  }}</td>
                    <td><a v-bind:href="'pedido/'+pedido.pedido_id+'/'+pedido.unidade_id"><i class="material-icons text-secondary">edit</i></a>
                        <a href="#" v-on:click="finalizarPedido(pedido.pedido_id, pedido.unidade_id)"><i class="material-icons text-danger">close</i></a></td>
                </tr>
                <!--@endforeach-->

                </tbody>
            </table>
            <div class="text-right">
                <a class="btn btn-secondary" href="exportar">Exportar pedidos</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                carregando: false,
                label: 'Aguarde...',
                pedidos: [],
                overlay: true,
            }
        },
        mounted() {
            this.buscarPedidos();
            let self = this;
            Echo.channel('pedidos')
                .listen('PedidoEntregue', (e) => {
                    console.log(e);
                    self.overlay = false;
                    self.buscarPedidos();
                });
        },
        methods: {
            buscarPedidos: function () {
                let self = this;
                this.carregando = true;
                let result = [];

                axios.get('api/pedido/json').then((response)=> {
                    self.pedidos = [];
                    result = response;
                    let i = 0;
                    response.data.forEach(function(item) {
                        Vue.set(self.pedidos, i, item);
                        i++;
                    });
                }).finally(() => {
                    this.carregando = false;
                    this.overlay = true;
                });

                return result;
            },
            finalizarPedido: function (idPedido, idUnidade) {
                let self = this;
                this.carregando = true;
                let result = [];

                axios.post('api/finalizar/json/'+idPedido+'/'+idUnidade).then((response)=> {
                    toastr.options.closeButton = true;
                    toastr.options.preventDuplicates = true;
                    toastr.options.timeOut = 5000; // How long the toast will display without user interaction
                    toastr.options.extendedTimeOut = 10000; // How long the toast will display after a user hovers over it
                    toastr.options.progressBar = true;

                    if (response.data.codigo !== 200) {
                        toastr.warning(response.data.mensagem, 'Atenção!');
                    } else {
                        toastr.success(response.data.mensagem, 'Sucesso!');
                    }
                }).finally(() => {
                    this.carregando = false;
                });

                return result;
            }
        }
    }
</script>
