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
                                    <li class="nav-item" v-if="$auth.can('prestamos.inicio')">
                                        <a class="nav-link active" href="" data-toggle="tab" @click="cambiarVista('Préstamos')">Pr&eacute;stamos</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('clientes.inicio')">
                                        <a class="nav-link" href="" data-toggle="tab" @click="cambiarVista('Clientes')">Clientes</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body" id="contenido-modelos">
                                <prestamo-view v-if="modeloActual=='Préstamos'"></prestamo-view>
                                <cliente-view v-else-if="modeloActual == 'Clientes'"></cliente-view>
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
    import PrestamoView from './Listado'
    import ClienteView from './cliente/Inicio'

    export default {
        created()
        {   
            this.$store.commit('SET_LAYOUT','principal-layout')
        },
        components:{
            'content-header': ContentHeader,
            'prestamo-view': PrestamoView,
            'cliente-view': ClienteView
        },
        data(){
            return{
                ruta: this.$route,
                titleCard:'Préstamos',
                modeloActual:'Préstamos'
            }
        },
        methods:{
             cambiarVista(modelo)
            {
                this.modeloActual=modelo
                this.titleCard = modelo
            }
        }
    }
</script>