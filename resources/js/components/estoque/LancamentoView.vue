<template>
    <div>
        <loading
            :show="carregando"
            :label="label">
        </loading>
        <estoque-nav></estoque-nav>
        <div class="card">
            <div class="card-body">
                <h2>Lançamento {{ lancamento.id }}</h2>
                <h4>Lançamento de {{ lancamento.tipoLabel }}</h4>
                <h5>Total de itens do lançamento: {{ lancamento.itensLancamento }}</h5>
            </div>
            <div class="card-footer text-muted text-right">
                <button type="button" class="btn btn-danger" v-on:click="excluirLancamento(lancamento.id)">Excluir Lançamento</button>
            </div>
        </div>
        <hr>
        <div class="list-group">
            <div class="list-group-item list-group-item-action flex-column align-items-start bg-charleston text-white">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-1">Itens do Lançamento</h5>
                </div>
            </div>
            <div v-for="item in lancamento.itens" href="#" class="list-group-item list-group-item-action flex-column align-items-start rounded">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ item.nmproduto }}</h5>
                </div>
                <p class="mb-1">Quantidade: {{ item.quantidade }} {{ item.unidadeLabel }}</p>
                <p class="mb-1">Preço: {{ item.precof }}</p>
                <p>Total: R$ {{ item.quantidade * item.precounitario }}</p>
            </div>

        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                id: '',
                carregando: true,
                label: 'Carregando...',
                lancamento: {}
            };
        },
        mounted() {
            this.id = this.$route.params.id;
            this.buscarLancamento();
        },
        methods: {
            buscarLancamento: function () {
                let self = this;
                this.carregando = true;

                axios.get('/api/estoque/lancamento/'+this.id).then((response)=> {
                    self.lancamento = response.data;
                }).finally(() => {
                    this.carregando = false;
                });
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
                    router.push({ name: "estoque" });
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
    }
</script>
