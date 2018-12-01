<template>
    <div>
        <loading
            :show="carregando"
            :label="label">
        </loading>
        <div class="card">
            <div class="bg-dark">
                <produto-nav></produto-nav>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h2>{{ produto.nmproduto }}</h2>
                    <div class="btn-group" role="group" aria-label="Alterações">
                        <button v-on:click="editarProduto()" v-if="!modoEdicao" type="button" class="btn btn-indigo btn-sm">Editar Produto</button>
                        <button v-on:click="cancelarEditarProduto()" v-if="modoEdicao" type="button" class="btn btn-danger btn-sm">Cancelar</button>
                        <button v-on:click="salvarEditarProduto()" v-if="modoEdicao" type="button" class="btn btn-success btn-sm">Salvar</button>                    </div>
                </div>
                <div v-if="!modoEdicao">
                    <div class="d-flex justify-content-between">
                        <h5>Preço de venda: {{ produto.precof }}</h5>
                        <small>Código do produto: {{ produto.cdproduto}}</small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h5>Custo do produto: {{ produto.precocustof }}</h5>
                        <small class="text-muted" v-if="produto.tipo === 'V'">Produto de Venda</small>
                        <small class="text-muted" v-if="produto.tipo === 'C'">Produto de Compra</small>
                    </div>
                    <h5>Quantidade em estoque: ?</h5>
                    <h6>Unidade: {{ produto.unidadeLabel}}</h6>
                </div>
                <div v-if="modoEdicao">
                    <form>
                        <div class="form-group">
                            <label for="nmproduto">Nome do produto</label>
                            <input type="text" v-model="editProduto.nmproduto" class="form-control form-control-lg" id="nmproduto" placeholder="Quantidade">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4">
                                    <label for="preco">Preço de Venda</label>
                                    <input type="text" v-model="editProduto.preco" class="form-control form-control-lg" id="preco" placeholder="Quantidade">
                                </div>
                                <div class="col-4">
                                    <label for="unidade">Unidade de produção</label>
                                    <v-select id="unidade" v-model="editProduto.unidade" :options="unidadesProducao"></v-select>
                                </div>
                                <div class="col-4">
                                    <label for="tipo">Tipo de produto</label>
                                    <select id="tipo" v-model="editProduto.tipo" class="form-control form-control-lg">
                                        <option value="V">Venda</option>
                                        <option value="C">Compra</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <div class="list-group">
            <div class="list-group-item list-group-item-action flex-column align-items-start bg-charleston text-white">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-1">Receita</h5>
                    <div class="text-right">
                        <div v-if="!addProduto">
                            <button v-on:click="adicionarProduto()" type="button" class="btn btn-outline-warning">Adicionar Produto</button>
                        </div>
                        <div v-if="addProduto">
                            <button v-on:click="cancelarAdicionarProduto()" type="button" class="btn btn-outline-danger">Cancelar</button>
                            <button v-on:click="salvarAdicionarProduto()" type="button" class="btn btn-outline-success">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="addProduto" class="list-group-item list-group-item-action flex-column align-items-start">
                <form>
                    <div class="form-group">
                        <label for="selectProduto">Produto</label>
                        <v-select id="selectProduto" v-model="selectedValue" :options="produtos"></v-select>
                    </div>
                    <div class="form-group">
                        <label for="qtde">Quantidade</label>
                        <input type="number" v-model="novaReceita.quantidade" class="form-control" id="qtde" placeholder="Quantidade">
                    </div>
                </form>
            </div>
            <div v-for="receita in produto.receita" class="list-group-item list-group-item-action flex-column align-items-start rounded">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ receita.nomefilho }}</h5>
                    <button type="button" class="btn btn-outline-danger btn-sm" v-on:click="excluirComposicao(receita.id)">Excluir composição</button>
                </div>
                <div class="d-flex w-100 justify-content-between">
                    <p class="mb-1">Quantidade: {{ receita.quantidade }} {{ receita.unidadeLabel }}</p>
                    <small class="text-muted">{{ receita.cdproduto_filho }}</small>
                </div>
                <div class="d-flex w-100 justify-content-between">
                    <small class="text-muted">Custo da composicao: {{ receita.precocustocomposicaof }}</small>
                    <small class="text-muted">Quantidade em estoque: ?</small>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    export default {
        watch: {
            '$route' (to, from) {
                console.log(to);
                console.log(from);
            }
        },
        data () {
            return {
                carregando: true,
                label: 'Carregando...',
                cdproduto: '',
                selectedValue: '',
                produto: {
                    receita: []
                },
                produtos: [],
                addProduto: false,
                modoEdicao: false,
                novaReceita: {
                    cdproduto: '',
                    quantidade: 0
                },
                editProduto: {
                    nmproduto: '',
                    unidade: '',
                    preco: ''
                },
                selected: null,
                unidadesProducao: [
                    {
                        'value': 'KG',
                        'label': 'Quilos'
                    },
                    {
                        'value': 'G',
                        'label': 'Gramas'
                    },
                    {
                        'value': 'UN',
                        'label': 'Unidade'
                    },
                    {
                        'value': 'ML',
                        'label': 'Mililitros'
                    }
                ]
            };
        },
        mounted() {
            this.cdproduto = this.$route.params.cdproduto;
            this.buscarProduto();
        },
        methods: {
            buscarProduto: function () {
                let self = this;
                this.carregando = true;
                let result = [];

                axios.get('/api/produtos/'+this.cdproduto).then((response)=> {
                    self.produto = response.data;
                }).finally(() => {
                    this.carregando = false;
                });

                return result;
            },
            clickProduto: function (cdproduto) {
                router.push({ name: "produto", params: { cdproduto: cdproduto }});
            },
            adicionarProduto: function () {
                const self = this;

                self.buscarProdutos();
                this.addProduto = true;
            },
            cancelarAdicionarProduto: function () {
                this.addProduto = false;
                this.novaReceita.cdproduto = '';
                this.novaReceita.quantidade = 0;
            },
            salvarAdicionarProduto: function () {
                const self = this;
                this.carregando = true;
                this.novaReceita.cdproduto = this.produto.cdproduto;
                this.novaReceita.cdproduto_filho = this.selectedValue.value;

                if (this.novaReceita.cdproduto && this.novaReceita.cdproduto_filho && this.novaReceita.quantidade) {
                    axios.post('/api/produtos/adicionarreceita', this.novaReceita).then((response)=> {
                        if (response.data.resultado) {
                            self.showNotification('Produto cadastrado com sucesso!', 'sucesso')
                        } else {
                            self.showNotification('Ocorreu um erro ao cadastrar o produto.', 'erro');
                        }
                    }).finally(() => {
                        this.carregando = false;
                        this.cancelarAdicionarProduto();
                        this.buscarProduto();
                    });

                } else {
                    this.carregando = false;
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
            buscarProdutos: function () {
                let self = this;
                this.carregando = true;
                let result = [];

                axios.get('/api/produtos/produtos').then((response)=> {
                    self.produtos = [];
                    result = response;
                    response.data.forEach(function(item) {
                        if (item.cdproduto !== self.produto.cdproduto) {
                            self.produtos.push({label: item.cdproduto + ' - ' + item.nmproduto, value: item.cdproduto});
                        }
                    });
                }).finally(() => {
                    this.carregando = false;
                });

                return result;
            },
            excluirComposicao: function (id) {
                const self = this;
                this.carregando = true;

                axios.post('/api/produtos/excluircomposicao', { id: id }).then((response)=> {
                    if (response.data.resultado) {
                        self.showNotification('Produto excluido com sucesso!', 'sucesso')
                    } else {
                        self.showNotification('Ocorreu um erro ao excluir o produto. ' + response.data.mensagem, 'erro');
                    }
                }).finally(() => {
                    this.carregando = false;
                    this.buscarProduto();
                });
            },
            editarProduto: function () {
                const self = this;
                this.modoEdicao = true;
                this.editProduto.cdproduto = this.produto.cdproduto;
                this.editProduto.nmproduto = this.produto.nmproduto;

                let unidade = this.unidadesProducao.filter((produto) => {
                    return produto.value === self.produto.unidade

                })[0];
                this.editProduto.unidade = { 'label': unidade.label, 'value': unidade.value };
                this.editProduto.preco = this.produto.preco;
                this.editProduto.tipo = this.produto.tipo;
            },
            cancelarEditarProduto: function () {
                this.modoEdicao = false;
                this.editProduto.cdproduto = '';
                this.editProduto.nmproduto = '';
                this.editProduto.unidade = '';
                this.editProduto.preco = '';
                this.editProduto.tipo = '';
            },
            salvarEditarProduto: function () {
                const self = this;
                this.carregando = true;

                if (this.editProduto.cdproduto && this.editProduto.nmproduto && this.editProduto.unidade) {
                    this.editProduto.unidade = this.editProduto.unidade.value;
                    axios.post('/api/produtos/editarproduto', this.editProduto).then((response) => {
                        if (response.data.resultado) {
                            self.showNotification('Produto alterado com sucesso!', 'sucesso');
                            self.cancelarEditarProduto();
                            self.buscarProduto();
                        } else {
                            self.showNotification('Ocorreu um erro ao cadastrar o produto. ' + response.data.mensagem , 'erro');
                        }
                        this.carregando = false;
                    });

                } else {
                    this.carregando = false;
                    this.showNotification('Preencha todos os campos', 'alerta');
                }
            }
        }
    };
</script>
