<template>
    <div>
        <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="/principal" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> -->
            </ul>
            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Buscar"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li v-if="this.$auth.user">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true" >
                        <img :src="this.$auth.user.foto" height="32"> {{ this.$auth.user.name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Mi Perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="" class="dropdown-item">
                            <i class="fas fa-cogs mr-2"></i> Configuraciones
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="" class="dropdown-item"
                            @click.prevent="logout">
                            <i class="fas fa-power-off mr-2"></i> Cerrar Sesi&oacute;n
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>
<script>
    export default {
        data() {
            return {

            }
        },
        methods:{
            logout() {
                let config = {
                    headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token-api')
                    }
                }
                axios.get('api/logout-user',config).then(respuesta=> {
                    if(respuesta.data.ok==1)
                    {
                        localStorage.removeItem('token-api')
                        localStorage.removeItem('user-logged')
                        this.$router.push('/')
                    }
                })
            }
        }
    }
</script>
