<template>
    <div id="aplicacao">
        <loading
            :show="carregando"
            :label="label">
        </loading>
        <div class="card">
            <div class="bg-dark">
                <produto-nav></produto-nav>
            </div>
            <div class="card-header">
                Produtos
            </div>
            <div class="input-group">
                <input type="text" v-model="busca" class="form-control form-control-lg" id="preco" placeholder="Buscar...">
                <select id="tipo" v-model="tipo" class="form-control form-control-lg" v-on:change="filtrarProdutos">
                    <option value="T" selected>Todos</option>
                    <option value="V">Venda</option>
                    <option value="C">Compra</option>
                </select>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Cd. Produto</th>
                        <th scope="col">Nome Produto</th>
                        <th scope="col" class="text-center">Tipo</th>
                        <th scope="col">Unidade</th>
                        <th scope="col">Preço</th>
                        <th scope="col" class="text-center">Preço de Custo</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="produto in produtos" v-on:click="clickProduto(produto.cdproduto)">
                            <td>{{ produto.cdproduto }}</td>
                            <td>{{ produto.nmproduto }}</td>
                            <td v-if="produto.tipo === 'C'" class="text-center text-success"><i class="fas fa-arrow-circle-down"></i></td>
                            <td v-if="produto.tipo === 'V'" class="text-center text-danger"><i class="fas fa-arrow-circle-up"></i></td>
                            <td>{{ produto.unidadeLabel }}</td>
                            <td>{{ produto.precof }}</td>
                            <td class="text-center">{{ produto.precocustof }}</td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                produtos: {},
                carregando: false,
                label: 'Carregando...',
                busca: '',
                tipo: 'T',
                backupProdutos: {}
            };
        },
        mounted() {
            this.buscarProdutos();
        },
        watch: {
            busca: function () {
                this.filtrarProdutos();
                this.debouncedGetAnswer()
            }
        },
        created: function () {
            this.debouncedGetAnswer = _.debounce(this.filtrarProdutos, 500)
        },
        methods: {
            buscarProdutos: function () {
                let self = this;
                this.carregando = true;
                let result = [];

                axios.get('/api/produtos/produtos').then((response)=> {
                    self.produtos = [];
                    result = response;
                    let i = 0;
                    response.data.forEach(function(item) {
                        Vue.set(self.produtos, i, item);
                        i++;
                    });
                    self.backupProdutos = self.produtos;
                }).finally(() => {
                    this.carregando = false;
                });

                return result;
            },
            clickProduto: function (cdproduto) {
                router.push({ name: "produto", params: { cdproduto: cdproduto }});
            },
            filtrarProdutos: function() {
                const self = this;
                self.produtos = [];
                let i = 0;
                self.backupProdutos.forEach(function(item) {
                    if ((item.cdproduto.toUpperCase().includes(self.busca.toUpperCase()) || item.nmproduto.toUpperCase().includes(self.busca.toUpperCase()))
                        && (item.tipo === self.tipo || self.tipo === 'T')) {
                        Vue.set(self.produtos, i, item);
                        i++;
                    }
                });
            }
        }
    };
</script>
