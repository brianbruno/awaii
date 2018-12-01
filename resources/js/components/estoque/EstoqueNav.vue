<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div>
                    <router-link v-if="current.name !== 'estoque'" to="/housekeeping/estoque">
                        <button type="button" class="btn btn-deeporange-darken4 float-left">Movimentações</button>
                    </router-link>
                </div>
                <div>
                    <router-link v-if="current.name !== 'estoque-lancamento'" to="/housekeeping/estoque/lancamento">
                        <button type="button" class="btn btn-deeporange-darken4 float-left">Novo Lançamento</button>
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
            novoLancamento: function () {
                router.push({ name: "estoque-lancamento" });
            },
            voltar: function () {
                router.go(-1);
            },
        }
    };
</script>
