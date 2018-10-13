<template>
    <div id="aplicacao">
        <loading
            :show="carregando"
            :label="label">
        </loading>
        <produto-nav></produto-nav>
        <div class="card">
            <div class="card-body">
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
                    let i = 0;
                    response.data.forEach(function(item) {
                        Vue.set(self.produtos, i, item);
                        i++;
                    });
                }).finally(() => {
                    this.carregando = false;
                });

                return result;
            },
            clickProduto: function (cdproduto) {
                router.push({ name: "produto", params: { cdproduto: cdproduto }});
            }
        }
    };
</script>
