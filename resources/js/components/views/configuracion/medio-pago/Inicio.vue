<template>
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado Medio Pagos&nbsp;
                    <button type="button" class="btn bg-maroon btn-sm" @click="nuevo"
                            v-if="$auth.can('medio-pagos.crear')">
                        <i class="fas fa-plus"></i> Nuevo Medio Pago
                    </button>
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <label class="col-form-label col-form-label-sm">Mostrar&nbsp;</label>
                                <select class="custom-select custom-select-sm form-control form-control-sm"
                                        v-model="pagina" @change="cambiarPaginacion">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>&nbsp;
                            <button type="button" class="btn bg-purple btn-sm dropdown-toggle"
                                    data-toggle="dropdown">
                                Filtros
                            </button>
                            <div class="dropdown-menu ">
                                <a class="dropdown-item" href="#" @click="todos">Todos</a>
                                <a class="dropdown-item" href="#" @click="habilitados">Habilitados</a>
                                <a class="dropdown-item" href="#" @click="eliminados">Eliminados</a>
                            </div>
                            &nbsp;
                            <input type="text" name="table-search" id="table-search"
                                class="form-control"  placeholder="Buscar..." v-model="busqueda"
                                @keyup="buscar">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12" id="detalle-tabla">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered table-hover text-nowrap">
                                <thead class="bg-navy">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>C&oacute;digo</th>
                                        <th>Nombre</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="total== 0">
                                        <td colspan="4" class="text-center text-danger">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else-if="total>0" v-for="(medio,index) in medio_pagos.data" :key="medio.id">
                                        <td class="text-center" v-text="(medio_pagos.from+index)"></td>
                                        <td v-text="medio.codigo"></td>
                                        <td v-text="medio.nombre"></td>
                                        <td>
                                            <span v-if="medio.deleted_at==null">
                                                <button type="button" class="btn btn-warning btn-xs"
                                                        @click="editar(medio.id)" title="Editar Medio Pago"
                                                        v-if="$auth.can('medio-pagos.editar')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="eliminar(medio.id)" title="Eliminar Medio Pago"
                                                        v-if="$auth.can('medio-pagos.eliminar')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </span>
                                            <span v-else>
                                                <button type="button" class="btn bg-purple btn-xs"
                                                        @click="restaurar(medio.id)" title="Restaurar Medio Pago"
                                                        v-if="$auth.can('medio-pagos.restaurar')">
                                                    <i class="fas fa-trash-restore"></i>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                Mostrando <b>{{medio_pagos.from}}</b> a <b>{{ medio_pagos.to }}</b> de <b>{{ medio_pagos.total}}</b> Registros
                            </div>
                            <div class="col-md-6 text-right">
                                <pagination :data="medio_pagos" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import MedioPagoForm from './Form'
    export default {
        components:{
            'medio-pago-form':MedioPagoForm
        },
        data() {
            return {
                medio_pagos:{},
                total:0,
                pagina:5,
                form:new form({
                    id:'',
                    codigo:'',
                    nombre:'',
                    estadoCrud:''
                }),
                show_medio_pagos:'habilitados',
                busqueda:'',
                config:{
                    headers:{'Authorization': 'Bearer ' + localStorage.getItem('token-api')}
                }
            }
        },
        created() {
            this.habilitados()
        },
        methods:{
             listar() {
                 axios.get('/api/medio-pago-'+this.show_medio_pagos+'?pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
                .then((respuesta) => {
                    this.medio_pagos=respuesta.data
                    this.total = this.medio_pagos.total
                })
            },
            getResults(page=1) {
                axios.get('/api/medio-pago-'+this.show_medio_pagos+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
                .then(response => {
                    this.medio_pagos = response.data
                    this.total = this.medio_pagos.total
                });
            },
            cambiarPaginacion(event) {
                this.pagina = event.target.value
                this.listar()
                this.getResults()
            },
            todos(){
                this.show_tipo_cuotas = 'todos'
                this.listar()
                this.getResults()
            },
            habilitados(){
                 this.show_tipo_cuotas = 'habilitados'
                this.listar()
                this.getResults()
            },
            eliminados() {
                this.show_tipo_cuotas = 'eliminados'
                this.listar()
                this.getResults()
            },
            buscar() {
                this.busqueda =  event.target.value
                this.listar()
                this.getResults()
            },
            limpiar() {

            },
            nuevo() {

            },
            mostrar(id) {

            },
            editar(id) {

            },
            eliminar(id) {

            },
            eliminarTemporal(id) {

            },
            eliminarPermanente(id) {

            },
            restaurar(id) {

            }
        }
    }
</script>
