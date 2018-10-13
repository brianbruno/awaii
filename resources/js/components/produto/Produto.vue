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
                        <th scope="col">Unidade</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Preço de Custo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="produto in produtos" v-on:click="clickProduto(produto.cdproduto)">
                        <td>{{ produto.cdproduto }}</td>
                        <td>{{ produto.nmproduto }}</td>
                        <td>{{ produto.unidadeLabel }}</td>
                        <td>{{ produto.precof }}</td>
                        <td class="text-center">R$0,00</td>
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
