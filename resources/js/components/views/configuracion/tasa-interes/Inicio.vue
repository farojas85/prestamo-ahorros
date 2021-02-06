<template>
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado Tasa Intereses&nbsp;
                    <button type="button" class="btn bg-maroon btn-sm" @click="nuevo"
                            v-if="$auth.can('tasa-intereses.crear')">
                        <i class="fas fa-plus"></i> Nueva Tasa Inter&eacute;s
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
                                        <th>Nombre</th>
                                        <th class="text-center">Valor</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="total== 0">
                                        <td colspan="5" class="text-center text-danger">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else-if="total>0" v-for="(valo,index) in tasa_intereses.data" :key="valo.id">
                                        <td class="text-center" v-text="(tasa_intereses.from+index)"></td>
                                        <td v-text="valo.nombre"></td>
                                        <td class="text-center" v-text="valo.valor"></td>
                                        <td>
                                            <span v-if="valo.deleted_at==null">
                                                <button type="button" class="btn btn-warning btn-xs"
                                                        @click="editar(valo.id)" title="Editar Valoración"
                                                        v-if="$auth.can('tasa-intereses.editar')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="eliminar(valo.id)" title="Eliminar Valoración"
                                                        v-if="$auth.can('tasa-intereses.eliminar')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </span>
                                            <span v-else>
                                                <button type="button" class="btn bg-purple btn-xs"
                                                        @click="restaurar(valo.id)" title="Restaurar Valoración"
                                                        v-if="$auth.can('tasa-intereses.restaurar')">
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
                                Mostrando <b>{{tasa_intereses.from}}</b> a <b>{{ tasa_intereses.to }}</b> de <b>{{ tasa_intereses.total}}</b> Registros
                            </div>
                            <div class="col-md-6 text-right">
                                <pagination :data="tasa_intereses" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import TasaInteresForm from './Form'
    export default {
        components:{
            'tasa-interes-form':TasaInteresForm
        },
        data() {
            return {
                tasa_intereses:{},
                total:0,
                pagina:5,
                form:new form({
                    id:'',
                    nombre:'',
                    icono:'',
                    clase:'',
                    estadoCrud:''
                }),
                show_tasa_intereses:'habilitados',
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
                 axios.get('/api/tasa-interes-'+this.show_tasa_intereses+'?pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
                .then((respuesta) => {
                    this.tasa_intereses=respuesta.data
                    this.total = this.tasa_intereses.total
                })
            },
            getResults(page=1) {
                axios.get('/api/tasa-interes-'+this.show_tasa_intereses+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
                .then(response => {
                    this.tasa_intereses = response.data
                    this.total = this.tasa_intereses.total
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