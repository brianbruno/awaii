<template>
    <div>
        <loading :show="carregando"
                 :label="label">
        </loading>

        <div>

            <div class="card-group" v-for="conf in tela">
                <div class="card" v-for="produto in conf.produtos" v-on:click="cliqueBotao(produto)"
                     v-bind:style="produto.style">
                    <div class="card-body">
                        <p class="card-text">{{ produto.nome }}</p>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="container">
            <div class="row">
                <div class="card col-sm-12 col-md-9">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" >
                                <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th class="text-center">Quantidade</th>
                                    <th class="text-center">Preço</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Remover</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="produto in novaVenda.produtos">
                                    <td>{{ produto.labelproduto }}</td>
                                    <td class="text-center">{{ produto.quantidade }}</td>
                                    <td class="text-center">{{ produto.precounitariof }}</td>
                                    <td class="text-center">{{ produto.totalf }}</td>
                                    <td class="text-center">
                                        <a href="#">
                                            <i class="material-icons text-danger">close</i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card col-sm-12 col-md-3">
                    <div class="card-body">
                        <div class="text-left">
                            <small>Total da Venda:</small> <h4>{{ novaVenda.totalf}}</h4>
                        </div>

                        <div class="text-center">
                            <button :disabled="!novaVenda.produtos.length > 0" type="button" class="btn btn-success" v-on:click="finalizarPedido">Finalizar Pedido</button>
                            <router-link to="/housekeeping/vendas">
                                <button type="button" class="btn btn-danger" v-on:click="cancelarPedido">Cancelar Pedido</button>
                            </router-link>
                        </div>

                    </div>
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
                tela: [
                    {
                      produtos: []
                    }
                ],
                novaVenda: {
                    totalf: 'R$ 0,00',
                    total: 0,
                    produtos: []
                }
            }
        },
        mounted() {
            this.buscarProdutos();
        },
        methods: {
            buscarProdutos: function () {
                let self = this;
                this.carregando = true;
                let result = [];

                axios.get('/api/produtosjson/produtoscaixa').then((response)=> {
                    self.tela = [];
                    result = response;
                    response.data.forEach(function(item) {
                        self.tela.push(item);
                    });
                }).finally(() => {
                    this.carregando = false;
                });

                return result;
            },
            cliqueBotao: function (botao) {
                let self = this;

                self.addProdutoLancamento(botao);
            },
            addProdutoLancamento: function (info) {

                let self = this;
                let totalVenda = 0;
                const item = this.novaVenda.produtos.filter(item => {
                    return item.cdproduto === info.cdproduto
                });

                if (item.length > 0) {
                    const prod = item[0];

                    prod.quantidade++;
                    prod.total = prod.quantidade * prod.precounitario;
                    prod.totalf = self.numberToReal(prod.total);

                } else {
                    this.novaVenda.produtos.push(
                        {
                            cdproduto: info.cdproduto,
                            labelproduto: info.cdproduto + ' - ' + info.nome,
                            precounitario: info.precounitario,
                            precounitariof: self.numberToReal(info.precounitario),
                            quantidade: 1,
                            total: info.precounitario,
                            totalf: self.numberToReal(info.precounitario)
                        }
                    );
                }

                this.novaVenda.produtos.forEach(item => {
                    totalVenda += item.total;
                });
                this.novaVenda.totalf = this.numberToReal(totalVenda);
                this.novaVenda.total = totalVenda;
            },
            numberToReal: function (numero) {
                numero = numero.toFixed(2).split('.');
                numero[0] = "R$ " + numero[0].split(/(?=(?:...)*$)/).join('.');
                return numero.join(',');
            },
            limpar: function() {
                this.novaVenda = {
                    totalf: 'R$ 0,00',
                    total: 0,
                    produtos: []
                };
            },
            finalizarPedido: function () {
                const self = this;
                this.carregando = true;

                axios.post('/api/pedido/novopedido', this.novaVenda).then((response) => {
                    if (response.data.resultado) {
                        self.showNotification(response.data.mensagem, 'sucesso');
                        self.buscarProdutos();
                        self.limpar();
                        self.novoLancamento.tipo = '';
                        self.novoLancamento.produtos = [];
                    } else {
                        self.showNotification('Ocorreu um erro ao inserir o pedido. ' + response.data.mensagem , 'erro');
                    }
                    this.carregando = false;
                });
            },
            cancelarPedido: function () {
                this.novaVenda = {
                    totalf: 'R$ 0,00',
                    total: 0,
                    produtos: []
                }
            },
            showNotification: function (mensagem, tipo) {
                toastr.options.closeButton = true;
                toastr.options.preventDuplicates = true;
                toastr.options.timeOut = 5000; // How long the toast will display without user interaction
                toastr.options.extendedTimeOut = 10000; // How long the toast will display after a user hovers over it
                toastr.options.progressBar = true;
                if (tipo === 'info') {
                    toastr.info(mensagem)
                } else if (tipo === 'alerta') {
                    toastr.warning(mensagem)
                } else if (tipo === 'erro') {
                    toastr.error(mensagem, 'Erro!');
                } else if (tipo === 'sucesso') {
                    toastr.success(mensagem, 'Sucesso!');
                }
            }
        }
    }
</script>