<template>
    <div></div>
</template>

<script>
    export default {
        mounted() {
            this.showNotification();
        },
        props: {
            mensagem: String,
            titulo: String,
            tipo: String
        },
        methods: {
            showNotification: function () {
                toastr.options.closeButton = true;
                toastr.options.preventDuplicates = true;
                toastr.options.timeOut = 5000; // How long the toast will display without user interaction
                toastr.options.extendedTimeOut = 10000; // How long the toast will display after a user hovers over it
                toastr.options.progressBar = true;
                if (this.tipo === 'info') {
                    toastr.info(this.mensagem, this.titulo)
                } else if (this.tipo === 'alerta') {
                    toastr.warning(this.mensagem, this.titulo)
                } else if (this.tipo === 'erro') {
                    toastr.error(this.mensagem, this.titulo);
                } else if (this.tipo === 'sucesso') {
                    toastr.success(this.mensagem, this.titulo);
                }
            },
        }
    }
</script>
