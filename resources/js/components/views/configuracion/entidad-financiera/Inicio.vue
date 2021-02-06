<template>
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado Entidad Financieras&nbsp;
                    <button type="button" class="btn bg-maroon btn-sm" @click="nuevo"
                            v-if="$auth.can('medio-pagos.crear')">
                        <i class="fas fa-plus"></i> Nueva Entidad Financiera
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
                                    <tr v-else-if="total>0" v-for="(entidad,index) in entidad_financieras.data" :key="entidad.id">
                                        <td class="text-center" v-text="(entidad_financieras.from+index)"></td>
                                        <td v-text="entidad.codigo"></td>
                                        <td v-text="entidad.nombre"></td>
                                        <td>
                                            <span v-if="entidad.deleted_at==null">
                                                <button type="button" class="btn btn-warning btn-xs"
                                                        @click="editar(entidad.id)" title="Editar Entidad Financiera"
                                                        v-if="$auth.can('entidad-financieras.editar')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="eliminar(entidad.id)" title="Eliminar Entidad Financiera"
                                                        v-if="$auth.can('entidad-financieras.eliminar')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </span>
                                            <span v-else>
                                                <button type="button" class="btn bg-purple btn-xs"
                                                        @click="restaurar(entidad.id)" title="Restaurar Entidad Financiera"
                                                        v-if="$auth.can('entidad-financieras.restaurar')">
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
                                Mostrando <b>{{entidad_financieras.from}}</b> a <b>{{ entidad_financieras.to }}</b> de <b>{{ entidad_financieras.total}}</b> Registros
                            </div>
                            <div class="col-md-6 text-right">
                                <pagination :data="entidad_financieras" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import EntidadFinancieraForm from './Form'
    export default {
        components:{
            'entidad-financiera-form':EntidadFinancieraForm
        },
        data() {
            return {
                entidad_financieras:{},
                total:0,
                pagina:5,
                form:new form({
                    id:'',
                    codigo:'',
                    nombre:'',
                    estadoCrud:''
                }),
                show_entidad_financieras:'habilitados',
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
                 axios.get('/api/entidad-financiera-'+this.show_entidad_financieras+'?pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
                .then((respuesta) => {
                    this.entidad_financieras=respuesta.data
                    this.total = this.entidad_financieras.total
                })
            },
            getResults(page=1) {
                axios.get('/api/entidad-financiera-'+this.show_entidad_financieras+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
                .then(response => {
                    this.entidad_financieras = response.data
                    this.total = this.entidad_financieras.total
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
