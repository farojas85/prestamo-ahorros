<template>
    <div>
        <!-- Navigation -->
        <nav class="navbar navbar-light bg-light static-top">
            <div class="container">
                <a class="navbar-brand" href="/">Presti-Ahorros</a>
                <!-- <router-link tag="a" to="login" class="btn btn-primary">Iniciar Sesi&oacute;n</router-link> -->
                <a class="btn btn-primary" href="" @click.prevent="getLogin">Iniciar Sesi&oacute;n</a>
            </div>
        </nav>
        <router-view></router-view>
    </div>
</template>
<script>
export default {
    methods:{
        getLogin()
        {
            this.$router.push('/login')
        }
    }
}
</script>
