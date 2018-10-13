<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <ul class="navbar-nav">
                    <li class="nav-item" v-bind:class="{ active: current.name === 'estoque' }">
                        <router-link to="/housekeeping/estoque"><a class="nav-link">Movimentação <span class="sr-only">(current)</span></a></router-link>
                    </li>
                </ul>
                <div class="text-right">
                    <button v-if="current.name === 'lancamento'" type="button" class="btn btn-info text-white" v-on:click="voltar()">Voltar</button>
                    <button type="button" class="btn btn-info text-white" v-on:click="novoLancamento()">Novo Lançamento</button>
                </div>
        </nav>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                current: '',
                label: 'Carregando...',
                carregando: true,
            };
        },
        mounted() {
            this.current = this.$router.currentRoute;
        },
        methods: {
            novoLancamento: function () {
                router.push({ name: "estoque-lancamento" });
            },
            voltar: function () {
                router.go(-1);
            },
        }
    };
</script>
