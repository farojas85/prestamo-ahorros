<template>
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado Tipo Cuotas&nbsp;
                    <button type="button" class="btn bg-maroon btn-sm" @click="nuevo"
                            v-if="$auth.can('tipo-cuotas.crear')">
                        <i class="fas fa-plus"></i> Nuevo Tipo Cuota
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
                                        <th class="text-center">D&iacute;as</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="total== 0">
                                        <td colspan="4" class="text-center text-danger">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else-if="total>0" v-for="(tipo,index) in tipo_cuotas.data" :key="tipo.id">
                                        <td class="text-center" v-text="(tipo_cuotas.from+index)"></td>
                                        <td v-text="tipo.nombre"></td>
                                        <td class="text-center" v-text="tipo.dias"></td>
                                        <td>
                                            <span v-if="tipo.deleted_at==null">
                                                <button type="button" class="btn btn-warning btn-xs"
                                                        @click="editar(tipo.id)" title="Editar Tipo Documento"
                                                        v-if="$auth.can('tipo-cuotas.editar')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="eliminar(tipo.id)" title="Eliminar Tipo Documento"
                                                        v-if="$auth.can('tipo-cuotas.eliminar')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </span>
                                            <span v-else>
                                                <button type="button" class="btn bg-purple btn-xs"
                                                        @click="restaurar(tipo.id)" title="Restaurar Tipo Documento"
                                                        v-if="$auth.can('tipo-cuotas.restaurar')">
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
                                Mostrando <b>{{tipo_cuotas.from}}</b> a <b>{{ tipo_cuotas.to }}</b> de <b>{{ tipo_cuotas.total}}</b> Registros
                            </div>
                            <div class="col-md-6 text-right">
                                <pagination :data="tipo_cuotas" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-tipo-cuota">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal-tipo-cuota-title">Default Modal</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="modal-tipo-cuota-body">
                                <tipo-cuota-form :form='form'></tipo-cuota-form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import TipoCuotaForm from '../tipo-cuota/Form'
    export default {
        components:{
            'tipo-cuota-form':TipoCuotaForm
        },
        data() {
            return {
                tipo_cuotas:{},
                total:0,
                pagina:5,
                form:new form({
                    id:'',
                    nombre:'',
                    dias:'',
                    estadoCrud:''
                }),
                show_tipo_cuotas:'habilitados',
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
                 axios.get('/api/tipo-cuota-'+this.show_tipo_cuotas+'?pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
                .then((respuesta) => {
                    this.tipo_cuotas=respuesta.data
                    this.total = this.tipo_cuotas.total
                })
            },
            getResults(page=1) {
                axios.get('/api/tipo-cuota-'+this.show_tipo_cuotas+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
                .then(response => {
                    this.tipo_cuotas = response.data
                    this.total = this.tipo_cuotas.total
                });
            },
            cambiarPaginacion(event) {
                this.pagina = event.target.value
                this.listar()
                this.getResults()
            },
            limpiar() {
                this.form.clear()
                this.form.reset()
            },
            nuevo() {
                this.limpiar()
                $('#modal-tipo-cuota-title').html('Nuevo Tipo Cuota')
                $('#modal-tipo-cuota').modal('show')
                this.form.estadoCrud =  'crear'
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
            mostrar(id) {
                axios.get('api/tipo-cuotas/'+id,this.config)
                .then(respuesta => {
                    let tipo = respuesta.data
                    this.form.id = tipo.id
                    this.form.nombre = tipo.nombre
                    this.form.dias = tipo.dias
                })
            },
            editar(id) {
                this.mostrar(id)
                this.form.estadoCrud =  'editar'
                $('#modal-tipo-cuota-title').html('Editar Tipo Cuota')
                $('#modal-tipo-cuota').modal('show')
            },
            eliminar(id) {
                swal.fire({
                    title:"Tipo Cuotas",
                    text:'¿Está Seguro de Eliminar el Tipo Cuota?',
                    icon:"question",
                    showCancelButton: true,
                    confirmButtonText:"<i class='fas fa-trash-alt'></i> A Papelera",
                    confirmButtonColor:"#6610f2",
                    cancelButtonText:"<i class='fas fa-eraser'></i> Permanentemente",
                    cancelButtonColor:"#e3342f"
                }).then( (response) => {
                    if(response.value) {
                        this.eliminarTemporal(id)
                    }
                    else if( response.dismiss === swal.DismissReason.cancel) {
                    this.eliminarPermanente(id)
                    }
                }).catch(error => {
                    swal.showValidationError(
                        `Ocurrió un Error: ${error.response.status}`
                    )
                })
            },
            eliminarTemporal(id) {
                axios.post('api/tipo-cuota-destroy-temporal',{id:id},this.config)
                .then((response) => (
                    swal.fire({
                        icon : 'success',
                        title : 'Tipo Usuarios',
                        text : response.data,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            this.habilitados()
                        }
                    })
                ))
                .catch((errors) => {
                    if(response = errors.response) {
                        this.errores = response.data.errors
                    }
                })
            },
            eliminarPermanente(id) {
                this.$Progress.start()
                this.form.delete('api/tipo-cuotas/'+id,this.config)
                .then( (respuesta) => {
                    swal.fire({
                        title:"Tipo Cuotas",
                        text:respuesta.data,
                        icon:"success",
                        confirmButtonColor:"#148f77",
                        confirmButtonText:"Aceptar"
                    }).then(response => {
                        if(response.value) {
                            this.habilitados()
                            this.$Progress.finish()
                        }
                    })
                })
                .catch((errors) => {
                    if(response = errors.response) {
                        this.errores = response.data.errors
                    }
                })
            },
            restaurar(id) {
                swal.fire({
                    title:"Usuarios",
                    text:'¿Está Seguro de Restaurar el Tipo Cuota?"',
                    icon:"question",
                    showCancelButton: true,
                    confirmButtonText:"Si",
                    confirmButtonColor:"#28a745",
                    cancelButtonText:"No",
                    cancelButtonColor:"#dc3545"
                }).then( (response) => {
                    if(response.value) {
                        axios.post('/api/tipo-cuota-restaurar',{id:id},this.config)
                        .then((response) => (
                            swal.fire({
                                icon : 'success',
                                title : 'Usuarios',
                                text : response.data,
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor:"#1abc9c",
                            }).then(respuesta => {
                                if(respuesta.value) {
                                    this.habilitados()
                                }
                            })
                        ))
                        .catch((errors) => {
                            if(response = errors.response) {
                                this.errores = response.data.errors
                                swal.fire({
                                    icon : 'error',
                                    title : 'Tipo Cuotas',
                                    text : this.errores,
                                    confirmButtonText: 'Aceptar',
                                    confirmButtonColor:"#1abc9c",
                                })
                            }
                        })
                    }
                }).catch((errors) => {
                    if(response = errors.response) {
                        this.errores = response.data.errors
                        swal.fire({
                            icon : 'error',
                            title : 'Tipo Cuotas',
                            text : this.errores,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        })
                    }
                })
            }
        }
    }
</script>