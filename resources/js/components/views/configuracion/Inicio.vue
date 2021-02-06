'<template>
    <div>
        <content-header :ruta="this.ruta" :title="this.titleCard"></content-header>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-pills ">
                                    <li class="nav-item" v-if="$auth.can('tipo-documentos.inicio')">
                                        <a class="nav-link active" href="" data-toggle="tab" @click="cambiarVista('Tipo Documentos')">Tipo Documentos</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('tipo-cuotas.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Tipo Cuotas')">Tipo Cuotas</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('valoraciones.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Valoraciones')">Valoraciones</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('tasa-intereses.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Tasa Interes')">Tasa Inter&eacute;s</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('monedas.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Monedas')">Monedas</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('medio-pagos.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Medio Pagos')">Medio Pagos</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('entidad-financieras.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Entidad Financieras')">Entidad Financieras</a>
                                    </li>
                                    <li class="nav-item" v-if="$auth.can('tipo-movimientos.inicio')">
                                        <a class="nav-link " href="" data-toggle="tab" @click="cambiarVista('Tipo Movimientos')">Tipo Movimientos</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body" id="contenido-modelos">
                                <tipo-documento-view v-if="modeloActual=='Tipo Documentos'"></tipo-documento-view>
                                <tipo-cuota-view v-else-if="modeloActual=='Tipo Cuotas'"></tipo-cuota-view>
                                <valoracion-view v-else-if="modeloActual=='Valoraciones'"></valoracion-view>
                                <tasa-interes-view v-else-if="modeloActual=='Tasa Interes'"></tasa-interes-view>
                                <moneda-view v-else-if="modeloActual=='Monedas'"></moneda-view>
                                <medio-pago-view v-else-if="modeloActual=='Medio Pagos'"></medio-pago-view>
                                <entidad-financiera-view v-else-if="modeloActual=='Entidad Financieras'"></entidad-financiera-view>
                                <tipo-movimiento-view v-else-if="modeloActual=='Tipo Movimientos'"></tipo-movimiento-view>
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
    import TipoDocumentoView from './tipo-documento/Inicio'
    import TipoCuotaView from './tipo-cuota/Inicio'
    import ValoracionView from './valoracion/Inicio'
    import TasaInteresView from './tasa-interes/Inicio'
    import MonedaView from './moneda/Inicio'
    import MedioPagoView from './medio-pago/Inicio'
    import EntidadFinancieraView from './entidad-financiera/Inicio'
    import TipoMovimientoView from './tipo-movimiento/Inicio'

    export default {
        data(){
            return {
                ruta: this.$route,
                titleCard:'Configuración Tipo Documentos',
                modeloActual:'Tipo Documentos'
            }
        },
        components:{
            'content-header': ContentHeader,
            'tipo-documento-view':TipoDocumentoView,
            'tipo-cuota-view':TipoCuotaView,
            'valoracion-view':ValoracionView,
            'tasa-interes-view':TasaInteresView,
            'moneda-view':MonedaView,
            'medio-pago-view':MedioPagoView,
            'entidad-financiera-view':EntidadFinancieraView,
            'tipo-movimiento-view':TipoMovimientoView
        },
        created()
        {
            this.$store.commit('SET_LAYOUT','principal-layout')
        },
        methods:{
            cambiarVista(modelo)
            {
                this.modeloActual=modelo
                this.titleCard='Configuración '+modelo
            }
        }
    }
</script>'