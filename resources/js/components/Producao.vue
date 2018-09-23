<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-11">
                    <h2><span class="align-bottom">Produção</span></h2>
                </div>
                <div class="col-sm-1 text-right">
                    <img v-if="carregando" class="loader" src="http://awaii.brian.place/public/images/loader.gif">
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="card-deck">
                <div class="col-md-4" v-for="producao in producaoPendente">
                    <div class="card text-white bg-dark">
                        <div class="card-header">Produto {{ producao.produto.cdproduto }}</div>
                        <div class="card-body">
                            <h4 class="card-title">{{ producao.produto.nmproduto }}</h4>
                            <h6>Quantidade: {{ producao.quantidade }}</h6>
                        </div>
                        <div class="card-footer text-muted">
                            <h6>{{ producao.data }}</h6>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="text-right">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a v-bind:href="'pedido/'+producao.pedido.id"
                                            class="btn btn-sm btn-secondary text-white"><i class="material-icons">description</i>
                                    </a>
                                    <button v-on:click="finalizarItem(producao.pedido.id, producao.sequencial)"
                                             class="btn btn-sm btn-success text-white"><i class="material-icons">check</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data () {
            return {
                mensagem: '',
                titulo: '',
                producaoPendente: [],
                carregando: false
            }
        },
        mounted() {
            let self = this;
            self.buscarProdutos();
            Echo.channel('novo-pedido')
                .listen('PedidoRealizado', (e) => {
                    self.buscarProdutos();
                });
        },
        methods: {
            buscarProdutos: function () {
                let self = this;
                this.carregando = true;

                axios.get('api/producao/json').then((response)=> {
                    self.producaoPendente = [];
                    let i = 0;
                    response.data.forEach(function(item) {
                        Vue.set(self.producaoPendente, i, item);
                        i++;
                    });
                }).finally(() => {
                    this.carregando = false;
                });
            },
            finalizarItem: function(id, sequencial) {
                this.carregando = true;
                self = this;

                axios.post('producao/finalizar/'+id+'/'+sequencial).then((response)=> {
                    // console.log(response.data)
                }).finally(() => {
                    this.carregando = false;
                });
            }
        }
    }
</script>
