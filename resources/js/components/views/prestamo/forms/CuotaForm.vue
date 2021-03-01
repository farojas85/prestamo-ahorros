<template>
    <div class="row">
        <div class="col-md-6">
            <div class="card border border-info">
                <div class="card-header bg-info">
                    <h3 class="card-title">Datos Pr&eacute;stamo</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row mb-1">

                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-md-2 col-form-label col-form-label-sm">Cliente</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.cliente" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1" v-if="this.$auth.hasRole('administrador') || this.$auth.hasRole('super-usuario')">
                        <label class="col-md-2 col-form-label col-form-label-sm">Cobrador</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.cobrador" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-md-2 col-form-label col-form-label-sm">Fecha</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control form-control-sm" v-model="cuota.fecha" disabled>
                        </div>
                        <label class="col-md-3 col-form-label col-form-label-sm">Tipo Cambio</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.tipo_cambio" readonly="">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-md-2 col-form-label col-form-label-sm">Moneda</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.moneda" readonly>
                        </div>
                        <label class="col-md-2 col-form-label col-form-label-sm">Monto</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.monto" readonly="">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-md-2 col-form-label col-form-label-sm">Tasa Int.</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.tasa_interes" readonly>
                        </div>
                        <label class="col-md-2 col-form-label col-form-label-sm">Inter&eacute;s</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.interes" readonly="">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-md-2 col-form-label col-form-label-sm">Tipo Cuota</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.tipo_cuota" readonly>
                        </div>
                        <label class="col-md-2 col-form-label col-form-label-sm">N&deg; Cuotas</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.numero_cuotas" readonly="">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-md-2 col-form-label col-form-label-sm">Total</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.total" readonly>
                        </div>
                        <label class="col-md-2 col-form-label col-form-label-sm">Saldo</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.saldo" readonly="">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-md-2 col-form-label col-form-label-sm">Estado</label>
                        <div class="col-md-2">
                            <span :class="cuota.estado_clase" v-html="cuota.estado"></span>
                        </div>
                        <label class="col-md-2 col-form-label col-form-label-sm">Forma</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm" v-model="cuota.pago" readonly="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border border-danger">
                <div class="card-header bg-maroon">
                    <h3 class="card-title">Cuotas</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm nowrap">
                            <thead class="thead-navy">
                                <tr>
                                    <th>Cuota</th>
                                    <th>Fecha Venc.</th>
                                    <th>Monto</th>
                                    <th>saldo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cuo in cuota.cuotas.data" :key="cuo.id">
                                    <td v-text="cuo.numero_cuota" class="text-center"></td>
                                    <td>{{ cuo.fecha_vencimiento | miFecha}}</td>
                                    <td v-text="cuo.monto_cuota"></td>
                                    <td v-text="cuo.saldo"></td>
                                    <td>
                                        <span :class="cuo.estado_operacion.clase">
                                            {{ cuo.estado_operacion.nombre }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-6">
                                Mostrando <b>{{cuota.cuotas.from}}</b> a <b>{{ cuota.cuotas.to }}</b> de <b>{{ cuota.cuotas.total}}</b> Registros
                            </div>
                            <div class="col-md-6 text-right">
                                <pagination :data="cuota.cuotas" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['cuota'],
        data(){
            return {

            }
        },
        methods:{
            getResults(page=1)
            {
                axios.get('/api/cuotas-listado?page='+page+'&id='+this.cuota.prestamo_id,this.$parent.config)
                .then(response => {
                    this.cuota.cuotas = response.data.cuotas
                });
            },
            diferenciaDias(fechaInicio)
            {
                var fecha1 = moment(fechaInicio).tz('America/Lima');
                var fecha2 = moment(new Date()).tz('America/Lima');

                if(fechaInicio == null || fechaInicio =='')
                {
                    return null;
                }
                return fecha2.diff(fecha1,'days');
            },
        }
    }
</script>
