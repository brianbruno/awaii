<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div v-if="current.name === 'cadastrar-produto' || current.name === 'produto'">
                    <router-link to="/housekeeping/produtos">
                        <button type="button" class="btn btn-deeporange-darken4 float-left">Produtos</button>
                    </router-link>
                </div>
                <div v-if="current.name === 'produtos'">
                    <router-link to="/housekeeping/produtos/cadastrar">
                        <button type="button" class="btn btn-deeporange-darken4 float-left">Cadastrar Produto</button>
                    </router-link>
                </div>
            </div>
        </div>
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
