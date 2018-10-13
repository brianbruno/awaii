<template>
    <div id="aplicacao">
        <loading
            :show="carregando"
            :label="label">
        </loading>
        <estoque-nav></estoque-nav>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">ID Lançamento</th>
                        <th scope="col" class="text-center">Tipo de Lançamento</th>
                        <th scope="col">Data</th>
                        <th class="text-center">Excluir</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="lancamento in lancamentos">
                        <td v-on:click="clickLancamento(lancamento.id)">{{ lancamento.id }}</td>
                        <td v-on:click="clickLancamento(lancamento.id)" v-if="lancamento.tipo === 'S'" class="text-danger text-center">Saída</td>
                        <td v-on:click="clickLancamento(lancamento.id)" v-if="lancamento.tipo === 'E'" class="text-secondary text-center">Entrada</td>
                        <td v-on:click="clickLancamento(lancamento.id)">{{ lancamento.dt_br }}</td>
                        <td class="text-center">
                            <a href="#" v-on:click="excluirLancamento(lancamento.id)">
                                <i class="material-icons text-danger">close</i>
                            </a>
                        </td>
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
                carregando: false,
                label: 'Carregando...',
                lancamentos: []
            };
        },
        mounted() {
            this.buscarLancamentos();
        },
        methods: {
            buscarLancamentos: function () {
                let self = this;
                this.carregando = true;
                let result = [];

                axios.get('/api/estoque/movimentacoes').then((response)=> {
                    self.lancamentos = [];
                    result = response;
                    let i = 0;
                    response.data.forEach(function(item) {
                        Vue.set(self.lancamentos, i, item);
                        i++;
                    });
                }).finally(() => {
                    this.carregando = false;
                });

                return result;
            },
            clickLancamento: function (id) {
                router.push({ name: "lancamento", params: { id: id }});
            },
            excluirLancamento: function (id) {
                const self = this;
                this.carregando = true;

                axios.post('/api/estoque/lancamento/excluirlancamento', { id: id }).then((response)=> {
                    if (response.data.resultado) {
                        self.showNotification('Lançamento excluido com sucesso!', 'sucesso')
                    } else {
                        self.showNotification('Ocorreu um erro ao excluir o lançamento. ' + response.data.mensagem, 'erro');
                    }
                }).finally(() => {
                    this.carregando = false;
                    this.buscarLancamentos();
                });
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
        }
    };
</script>
