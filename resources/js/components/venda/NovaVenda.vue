<template>
    <div>
        <loading :show="carregando"
                 :label="label">
        </loading>
        <div class="card">
            <div class="card-header bg-green-lighten3">
                <div class="row">
                    <div class="col-sm-11">
                        <h2><span class="align-bottom">Novo Pedido</span></h2>
                    </div>
                    <div class="col-sm-1 text-right">
                        <button v-on:click="widget.mode = 'view'" type="button" class="btn btn-danger btn-sm text-white">Cancelar</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="logout-form">
                    <div class="form-group">
                        <label for="id_cliente">Cliente</label>
                        <v-select id="id_cliente" v-model="clienteSelecionado" :options="clientes"></v-select>
                    </div>
                    <div class="form-group">
                        <label for="selectProduto">Produto</label>
                        <v-select id="selectProduto" v-model="produtoSelecionado" :options="produtos"></v-select>
                    </div>
                    <div class="form-group">
                        <label for="quantidade">Quantidade</label>
                        <input required type="number" name="quantidade" class="form-control" id="quantidade">
                    </div>

                </form>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button v-on:click="adicionarVenda()" type="button" class="btn btn-primary">Cadastrar</button>
                </div>
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
                produtos: [],
                clientes: [],
                produtoSelecionado: {},
                clienteSelecionado: {},
                overlay: true
            }
        },
        mounted() {
            this.buscarPedidos();
            this.buscarClientes();
            this.buscarProdutos();
            let self = this;
            Echo.channel('pedidos')
                .listen('PedidoEntregue', (e) => {
                    console.log(e);
                    self.overlay = false;
                    self.buscarPedidos();
                });
        },
        methods: {
            buscarClientes: function () {
                let self = this;
                this.carregando = true;
                let result = [];

                axios.get('/api/cliente/clientes').then((response)=> {
                    self.clientes = [];
                    result = response;
                    response.data.forEach(function(item) {
                        self.clientes.push({label: item.id + ' - ' + item.nome, value: item.id});
                    });
                }).finally(() => {
                    this.carregando = false;
                });

                return result;
            },
            buscarProdutos: function () {
                let self = this;
                this.carregando = true;
                let result = [];

                axios.get('/api/produtos/produtos?tipo=V').then((response)=> {
                    self.produtos = [];
                    result = response;
                    response.data.forEach(function(item) {
                        self.produtos.push({label: item.cdproduto + ' - ' + item.nmproduto, value: item.cdproduto});
                    });
                }).finally(() => {
                    this.carregando = false;
                });

                return result;
            },
            buscarPedidos: function () {
                let self = this;
                this.carregando = true;
                let result = [];

                axios.get('/api/pedido/json').then((response)=> {
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

                axios.post('/api/finalizar/json/'+idPedido+'/'+idUnidade).then((response)=> {
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