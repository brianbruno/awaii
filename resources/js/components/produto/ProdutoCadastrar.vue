<template>
    <div>
        <loading
            :show="carregando"
            :label="label">
        </loading>
        <produto-nav></produto-nav>
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="qtde">Código do Produto</label>
                        <input type="text" @change="autoFill()" v-model="novoProduto.cdproduto" class="form-control" id="qtde">
                    </div>
                    <div class="form-group">
                        <label for="nmproduto">Nome do Produto</label>
                        <input type="text" v-model="novoProduto.nmproduto" class="form-control" id="nmproduto">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="tipo">Tipo de produto</label>
                                <select id="tipo" v-model="novoProduto.tipo" class="form-control">
                                    <option value="V">Venda</option>
                                    <option value="C">Compra</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="unidade">Unidade de produção</label>
                                <select v-model="novoProduto.unidade" id="unidade" class="custom-select">
                                    <option value="KG">Quilos (KG)</option>
                                    <option value="G">Gramas (G)</option>
                                    <option value="UN">Unidade (UN)</option>
                                    <option value="ML">Mililitros (ML)</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="preco">Preço</label>
                                    <input type="number" :disabled="novoProduto.tipo !== 'V'" v-model="novoProduto.preco" class="form-control" id="preco">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="text-right">
                    <button v-on:click="salvarAdicionarProduto()" type="button" class="btn btn-success">Salvar</button>
                </div>
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
                novoProduto: {
                    nmproduto: '',
                    cdproduto: Math.floor(Date.now() / 1000),
                    unidade: '',
                    preco: '',
                }
            };
        },
        mounted() {
            this.autoFill();
        },
        methods: {
            salvarAdicionarProduto: function () {
                const self = this;
                this.carregando = true;

                if (this.novoProduto.cdproduto && this.novoProduto.nmproduto && this.novoProduto.unidade) {
                    axios.post('/api/produtos/adicionarproduto', this.novoProduto).then((response) => {
                        if (response.data.resultado) {
                            self.showNotification('Produto cadastrado com sucesso!', 'sucesso');
                        } else {
                            self.showNotification('Ocorreu um erro ao cadastrar o produto.', 'erro');
                        }
                    }).finally(() => {
                        this.carregando = false;
                        this.novoProduto.nmproduto = '';
                        this.novoProduto.cdproduto = Math.floor(Date.now() / 1000);
                        this.novoProduto.unidade = '';
                        this.novoProduto.preco = '';
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
            autoFill: function () {
                let pad_char = '0';
                let pad = new Array(1 + 10).join(pad_char);
                this.novoProduto.cdproduto = (pad + this.novoProduto.cdproduto).slice(-pad.length);
            }
        }
    };
</script>
