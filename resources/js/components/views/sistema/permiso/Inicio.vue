<template>
    <div class="col-md-12">
        <div class="card mt-3 card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado Permisos&nbsp;
                    <button type="button" class="btn bg-maroon btn-sm" @click="nuevo"
                        >
                        <i class="fas fa-plus"></i> Nuevo Permiso
                    </button>
                </h3>
            </div>
            <div class="card-body">
                <div class="row mt-2">
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
                                class="form-control"  placeholder="Buscar..." v-model="buscar"
                                @change="buscarPermiso">
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
                                        <th>nombre</th>
                                        <th>Directriz</th>
                                        <th>Descripci&oacute;n</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="total== 0">
                                        <td colspan="5" class="text-center text-danger">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else-if="total>0" v-for="(permiso,index) in permisos.data" :key="permiso.id">
                                        <td class="text-center" v-text="(permisos.from+index)"></td>
                                        <td v-text="permiso.nombre"></td>
                                        <td v-text="permiso.directriz"></td>
                                        <td v-text="permiso.descripcion"></td>
                                        <td>
                                            <span v-if="permiso.deleted_at==null">
                                                <button type="button" class="btn btn-warning btn-xs"
                                                        @click="editar(permiso.id)" title="Editar Permiso">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="eliminar(permiso.id)" title="Eliminar Permiso"
                                                        v-if="$auth.can('permisos.eliminar')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </span>
                                            <span v-else>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="restaurar(permiso.id)" title="Restaurar Permiso"
                                                        v-if="$auth.can('permisos.restaurar')">
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
                                Mostrando <b>{{permisos.from}}</b> a <b>{{ permisos.to }}</b> de <b>{{ permisos.total}}</b> Registros
                            </div>
                            <div class="col-md-6 text-right">
                                <pagination :data="permisos" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-permiso">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal-permiso-title">Default Modal</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="modal-permiso-body">
                                <permisos-form :form='form'></permisos-form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import PermisoForm from  '../permiso/Form'
    export default {
        components:{
            'permisos-form': PermisoForm
        },
        data() {
            return {
                permisos:{},
                total:0,
                pagina:10,
                form: new form({
                    id:'',
                    nombre:'',
                    directriz:'',
                    descripcion:'',
                    estadoCrud:''
                }),
                show_permisos:'habilitados',
                buscar:'',
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
                axios.get('/api/permiso-'+this.show_permisos+'?pagina='+this.pagina+'&buscar='+this.buscar,this.config)
                .then((respuesta) => {
                    this.permisos=respuesta.data
                    this.total = this.permisos.total
                })
            },
            getResults(page=1) {
                axios.get('/api/permiso-'+this.show_permisos+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.buscar,this.config)
                .then(response => {
                    this.permisos = response.data
                    this.total = this.permisos.total
                });
            },
            cambiarPaginacion() {
                this.pagina = event.target.value
                this.listar()
                this.getResults()
            },
            habilitados() {
                this.show_permisos ='habilitados';
                this.listar()
                this.getResults()
            },
            todos() {
                this.show_permisos ='todos';
                this.listar()
                this.getResults()
            },
            eliminados() {
                this.show_permisos ='eliminados';
                this.listar()
                this.getResults()
            },
            limpiar() {
                this.form.clear()
                this.form.reset()
            },
            nuevo() {
                this.limpiar()
                $('#modal-permiso-title').html('Nuevo Permiso')
                $('#modal-permiso').modal('show')
                this.form.estadoCrud =  'crear'
            },
            mostrar(id) {
                axios.get('api/permisos/'+id,this.config)
                .then(respuesta => {
                    let permiso = respuesta.data
                    if(permiso)
                    {
                        this.form.id=permiso.id
                        this.form.nombre=permiso.nombre
                        this.form.directriz=permiso.directriz
                        this.form.descripcion=permiso.descripcion
                    }
                })
            },
            editar(id) {
                this.mostrar(id)
                this.form.estadoCrud = 'editar'
                $('#modal-permiso-title').html('Editar Permiso')
                $('#modal-permiso').modal('show')
            },
            buscarPermiso(event) {
                this.buscar =  event.target.value
                this.listar()
                this.getResults()
            },
            eliminar(id) {
                swal.fire({
                    title:"Permisos",
                    text:'¿Está Seguro de Eliminar el Permiso?',
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
                axios.post('api/permiso-destroy-temporal',{id:id},this.config)
                .then((response) => (
                    swal.fire({
                        icon : 'success',
                        title : 'Permisos',
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
                this.form.delete('api/permisos/'+id,this.config)
                .then( (respuesta) => {
                    swal.fire({
                        title:"Permisos",
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
                    title:"Permisos",
                    text:'¿Está Seguro de Restaurar el Permiso?"',
                    icon:"question",
                    showCancelButton: true,
                    confirmButtonText:"Si",
                    confirmButtonColor:"#28a745",
                    cancelButtonText:"No",
                    cancelButtonColor:"#dc3545"
                }).then( (response) => {
                    if(response.value) {
                        axios.post('/api/permiso-restaurar',{id:id},this.config)
                        .then((response) => (
                            swal.fire({
                                icon : 'success',
                                title : 'Permisos',
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
                                    title : 'Clientes',
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
                            title : 'Usuario',
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
