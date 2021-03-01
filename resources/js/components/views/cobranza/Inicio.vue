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
                                    <li class="nav-item" v-if="$auth.can('cobranzas.inicio')">
                                        <a class="nav-link active" href="" data-toggle="tab" @click="cambiarVista('Cobranzas')">Cobranzas</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('clientes.inicio')">
                                        <a class="nav-link" href="" data-toggle="tab" @click="cambiarVista('Clientes')">Clientes</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body" id="contenido-modelos">
                                <listado-view v-if="modeloActual=='Cobranzas'"></listado-view>
                                <!-- <cliente-view v-else-if="modeloActual == 'Clientes'"></cliente-view> -->
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
    import ListadoView from './Listado'

    export default {
        components:{
            'content-header': ContentHeader,
            'listado-view': ListadoView,
            // 'cliente-view': ClienteView
        },
        data(){
            return{
                ruta: this.$route,
                titleCard:'Cobranzas',
                modeloActual:'Cobranzas'
            }
        },
        created()
        {
            this.$store.commit('SET_LAYOUT','principal-layout')
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
