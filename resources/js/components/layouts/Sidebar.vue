<template>
    <aside class="main-sidebar sidebar-light-navy elevation-4">
        <a href="index3.html" class="brand-link">
            <img src="images/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block" v-if="$auth.user">{{ $auth.user.name }}</a>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <template v-for="menu in $auth.menus()" >
                        <router-link  tag='li' :key="menu.id"
                            class="nav-item" :to="menu.enlace">
                            <a href="#" class="nav-link">
                                <i class="nav-icon" :class="menu.icono"></i>
                                <p>{{ menu.nombre }}</p>
                            </a>
                        </router-link>
                    </template>
                </ul>
            </nav>
        </div>
    </aside>
</template>
<script>
    export default {
        props:['ruta'],
        created() {
            //console.log(this.$auth.menus())
        },
        methods:{

        }
    }
</script>
