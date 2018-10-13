<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item" v-bind:class="{ active: current.name === 'produtos' }">
                        <router-link to="/housekeeping/produtos"><a class="nav-link">Produtos <span class="sr-only">(current)</span></a></router-link>
                    </li>
                    <li class="nav-item" v-bind:class="{ active: current.name === 'cadastrar-produto' }">
                        <router-link to="/housekeeping/produtos/cadastrar"><a class="nav-link">Cadastrar Produto</a></router-link>
                    </li>
                </ul>
                <div class="text-right" v-if="current.name === 'produto'">
                    <button type="button" class="btn btn-info text-white" v-on:click="voltar()">Voltar</button>
                </div>
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
            voltar: function () {
                router.go(-1);
            },
        }
    };
</script>
