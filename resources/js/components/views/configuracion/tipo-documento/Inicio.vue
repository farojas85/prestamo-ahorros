<template>
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado Tipo Documentos&nbsp;
                    <button type="button" class="btn bg-maroon btn-sm" @click="nuevo"
                            v-if="$auth.can('tipo-documentos.crear')">
                        <i class="fas fa-plus"></i> Nuevo Tipo Documento
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
                                        <th class="text-center">ID</th>
                                        <th>Nombre Corto</th>
                                        <th>Nombre Largo</th>
                                        <th class="text-center">Longitud</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="total== 0">
                                        <td colspan="6" class="text-center text-danger">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else-if="total>0" v-for="(tipo,index) in tipo_documentos.data" :key="tipo.id">
                                        <td class="text-center" v-text="(tipo_documentos.from+index)"></td>
                                        <td class="text-center" v-html="tipo.tipo"></td>
                                        <td v-text="tipo.nombre_corto"></td>
                                        <td v-text="tipo.nombre_largo"></td>
                                        <td  class="text-center" v-text="tipo.longitud"></td>
                                        <td>
                                            <span v-if="tipo.deleted_at==null">
                                                <button type="button" class="btn btn-warning btn-xs"
                                                        @click="editar(tipo.id)" title="Editar Tipo Documento"
                                                        v-if="$auth.can('tipo-documentos.editar')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="eliminar(tipo.id)" title="Eliminar Tipo Documento"
                                                        v-if="$auth.can('tipo-documentos.eliminar')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </span>
                                            <span v-else>
                                                <button type="button" class="btn bg-purple btn-xs"
                                                        @click="restaurar(tipo.id)" title="Restaurar Tipo Documento"
                                                        v-if="$auth.can('tipo-documentos.restaurar')">
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
                                Mostrando <b>{{tipo_documentos.from}}</b> a <b>{{ tipo_documentos.to }}</b> de <b>{{ tipo_documentos.total}}</b> Registros
                            </div>
                            <div class="col-md-6 text-right">
                                <pagination :data="tipo_documentos" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import TipoDocumentoForm from './Form'
    export default {
        components:{
            'tipo-documento-form':TipoDocumentoForm
        },
        data() {
            return {
                tipo_documentos:{},
                total:0,
                pagina:5,
                form:new form({

                }),
                show_tipo_documentos:'habilitados',
                busqueda:'',
                config:{
                    headers:{'Authorization': 'Bearer ' + localStorage.getItem('token-api')}
                }
            }
        },
        created(){
            this.habilitados()
        },
        methods:{
            listar() {
                 axios.get('/api/tipo-documento-'+this.show_tipo_documentos+'?pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
                .then((respuesta) => {
                    this.tipo_documentos=respuesta.data
                    this.total = this.tipo_documentos.total
                })
            },
            getResults(page=1) {
                axios.get('/api/tipo-documento-'+this.show_tipo_documentos+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
                .then(response => {
                    this.tipo_documentos = response.data
                    this.total = this.tipo_documentos.total
                });
            },
            cambiarPaginacion(event) {
                this.pagina = event.target.value
                this.listar()
                this.getResults()
            },
            nuevo() {

            },
            todos(){
                this.show_tipo_documentos = 'todos'
                this.listar()
                this.getResults()
            },
            habilitados(){
                 this.show_tipo_documentos = 'habilitados'
                this.listar()
                this.getResults()
            },
            eliminados() {
                this.show_tipo_documentos = 'eliminados'
                this.listar()
                this.getResults()
            },
            limpiar() {

            },
            buscar() {

            },
            editar() {

            },
            eliminar() {

            },
            restaurar() {

            }
        }
    }
</script>