<template>
    <div id="aplicacao">
        <loading
            :show="carregando"
            :label="label">
        </loading>
        <estoque-nav></estoque-nav>
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label for="tipo">Tipo de lançamento</label>
                                <select id="tipo" v-model="novoLancamento.tipo" class="form-control">
                                    <option value="E">Entrada</option>
                                    <option value="S">Saída</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="selectProduto">Produto</label>
                                <v-select id="selectProduto" v-model="novoProduto.selectProduto" :options="produtos"></v-select>
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label for="qtde">Quantidade</label>
                                <input type="number" v-model="novoProduto.quantidade" class="form-control form-control-lg" id="qtde">
                            </div>
                            <div class="form-group col-sm-12 col-md-3">
                                <label for="precounitario">Preço</label>
                                <input type="number" class="form-control form-control-lg" id="precounitario" v-model="novoProduto.precounitario">
                            </div>
                        </div>
                        <div class="text-center">
                            <button id="button" type="button" class="btn btn-lg btn-warning" v-on:click="addProdutoLancamento">Confirmar</button>
                        </div>
                    </form>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover" v-if="novoLancamento.produtos.length > 0">
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
                        <tr v-for="produto in novoLancamento.produtos">
                            <td>{{ produto.labelproduto }}</td>
                            <td class="text-center">{{ produto.quantidade }}</td>
                            <td class="text-center">{{ produto.precounitario }}</td>
                            <td class="text-center">{{ produto.total }}</td>
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
            <div class="card-footer text-muted text-right">
                <button type="button" class="btn btn-success" v-on:click="salvarLancamento">Salvar</button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                carregando: false,
                label: 'Carregando...',
                novoLancamento: {
                    tipo: '',
                    produtos: []
                },
                produtos: [],
                novoProduto: {}

            };
        },
        mounted() {
            this.buscarProdutos();
        },
        methods: {
            buscarProdutos: function () {
                let self = this;
                this.carregando = true;
                let result = [];

                axios.get('/api/produtos/produtos').then((response)=> {
                    self.produtos = [];
                    result = response;
                    response.data.forEach(function(item) {
                        self.produtos.push({label: item.cdproduto + ' - ' + item.nmproduto, value: item.cdproduto});
                    });
                }).finally(() => {
                    this.carregando = false;
                });
            },
            addProdutoLancamento: function () {
                if (this.novoProduto.selectProduto && this.novoProduto.quantidade && this.novoProduto.quantidade) {
                    this.novoLancamento.produtos.push(
                        {
                            cdproduto: this.novoProduto.selectProduto.value,
                            labelproduto: this.novoProduto.selectProduto.label,
                            precounitario: this.novoProduto.precounitario,
                            quantidade: this.novoProduto.quantidade,
                            total: this.novoProduto.precounitario * this.novoProduto.quantidade
                        }
                    );

                    this.limpar();

                } else {
                    this.showNotification('Preencha todos os campos', 'alerta');
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
            },
            salvarLancamento: function () {
                const self = this;
                this.carregando = true;

                if (this.novoLancamento.tipo) {
                    axios.post('/api/estoque/novolancamento', this.novoLancamento).then((response) => {
                        if (response.data.resultado) {
                            self.showNotification('Lançamento inserido com sucesso!', 'sucesso');
                            self.buscarProdutos();
                            self.limpar();
                            self.novoLancamento.tipo = '';
                            self.novoLancamento.produtos = [];
                        } else {
                            self.showNotification('Ocorreu um erro ao inserir o lançamento. ' + response.data.mensagem , 'erro');
                        }
                        this.carregando = false;
                    });

                } else {
                    this.carregando = false;
                    this.showNotification('Preencha todos os campos', 'alerta');
                }
            },
            limpar: function () {
                this.novoProduto.selectProduto.value =
                    this.novoProduto.selectProduto.label =
                        this.novoProduto.precounitario =
                            this.novoProduto.quantidade =
                                this.novoProduto.precounitario  = '';
            }
        }
    }
</script>
