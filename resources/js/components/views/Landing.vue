<template>
    <div>
         <header class="masthead text-white text-center"
            style="background:url('images/vendor/startbootstrap-landing-page/bg-masthead1.jpg');background-size: cover;background-repeat: no-repeat;">
            <div class="overlay"></div>
            <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto text-navy">
                <h1 class="mb-5">Sistema de Pr&eacute;stamos, Cr&eacute;ditos, Cobranzas y Ahorros</h1>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                </div>
            </div>
            </div>
        </header>
    </div>
</template>
<script>
    export default {
        created()
        {
            this.$store.commit('SET_LAYOUT','landing-layout')
        }
    }
</script>
