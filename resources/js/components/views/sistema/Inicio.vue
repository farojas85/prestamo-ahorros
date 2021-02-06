<template>
    <div>
        <content-header :ruta="this.ruta" :title="this.titleCard"></content-header>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-pills ">
                                    <li class="nav-item" v-if="$auth.can('roles.inicio')">
                                        <a class="nav-link active" href="" data-toggle="tab" @click="cambiarVista('Roles')">Roles</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('usuarios.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Usuarios')">Usuarios</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('permisos.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Permisos')">Permisos</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('permiso-role.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Permisos/Roles')">Permisos/Roles</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('menus.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Menús')">Men&uacute;s</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('menu-role.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Menús/Roles')">Men&uacute;s/Roles</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body" id="contenido-modelos">
                                <roles-view v-if="modeloActual=='Roles'"></roles-view>
                                <usuarios-view v-else-if="modeloActual=='Usuarios'"></usuarios-view>
                                <permisos-view v-else-if="modeloActual=='Permisos'"></permisos-view>
                                <permiso-role-view v-else-if="modeloActual=='Permisos/Roles'"></permiso-role-view>
                                <menu-view v-else-if="modeloActual=='Menús'"></menu-view>
                                <menu-role-view v-else-if="modeloActual=='Menús/Roles'"></menu-role-view>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    import ContentHeader from '../../layouts/ContentHeader'
    import RolesView from './role/Inicio'
    import UsuariosView from './usuario/Inicio'
    import PermisosView from './permiso/Inicio'
    import PermisoRoleView from './permiso-role/Inicio'
    import MenuView from './menu/Inicio'
    import MenuRoleView from './menu-role/Inicio'

    export default {
        created()
        {   
            //this.ruta.meta.descripcion = this.titleCard
            this.$store.commit('SET_LAYOUT','principal-layout')
        },
        components:{
            'content-header': ContentHeader,
            'roles-view': RolesView,
            'usuarios-view': UsuariosView,
            'permisos-view': PermisosView,
            'permiso-role-view':PermisoRoleView,
            'menu-view':MenuView,
            'menu-role-view': MenuRoleView
        },
        data(){
            return{
                ruta: this.$route,
                titleCard:'Configuración Roles',
                modeloActual:'Roles'
            }
        },
        methods:{
             cambiarVista(modelo)
            {
                this.modeloActual=modelo
                this.titleCard = 'Configuración '+modelo
                //this.ruta.meta.descripcion = "Configuraciones ".modelo
            }
        }
    }
</script>
