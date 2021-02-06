<template>
    <div class="col-md-12">
        <div class="card mt-3 card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado Men&uacute;&nbsp;
                    <button type="button" class="btn bg-maroon btn-sm" @click="nuevo"
                        v-if="$auth.can('menus.crear')">
                        <i class="fas fa-plus"></i> Nuevo Men&uacute;
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
                                @keyup="buscarMenu">
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
                                        <th>ruta</th>
                                        <th>Icono</th>
                                        <th>Padre</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="total== 0">
                                        <td colspan="6" class="text-center text-danger">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else-if="total>0" v-for="(menu,index) in menus.data" :key="menu.id">
                                        <td class="text-center" v-text="(menus.from+index)"></td>
                                        <td v-text="menu.nombre"></td>
                                        <td v-text="menu.enlace"></td>
                                        <td  class="text-center"><i :class="menu.icono"></i></td>
                                        <td class="text-center">
                                            <span v-if="menu.padre" v-text="menu.padre.nombre"></span>
                                            <span v-else>--</span>
                                        </td>
                                        <td>
                                            <span v-if="menu.deleted_at==null">
                                                <button type="button" class="btn btn-warning btn-xs"
                                                        @click="editar(menu.id)" title="Editar Rol"
                                                        v-if="$auth.can('menus.editar')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="eliminar(menu.id)" title="Eliminar Rol"
                                                        v-if="$auth.can('menus.eliminar')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </span>
                                            <span v-else>
                                                <button type="button" class="btn bg-purple btn-xs"
                                                        @click="restaurar(menu.id)" title="Restaurar Rol"
                                                        v-if="$auth.can('menus.restaurar')">
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
                                Mostrando <b>{{menus.from}}</b> a <b>{{ menus.to }}</b> de <b>{{ menus.total}}</b> Registros
                            </div>
                            <div class="col-md-6 text-right">
                                <pagination :data="menus" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-menu">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-menu-title">Default Modal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-menu-body">
                            <menus-form :form='form'></menus-form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                    </div>
                <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import MenuForm from '../menu/Form'
    export default {
        components:{
            'menus-form' :MenuForm
        },
        data() {
            return {
                menus:{},
                total:0,
                pagina:5,
                form: new form({
                    id:'',
                    nombre:'',
                    enlace:'',
                    icono:'',
                    padre_id:'',
                    orden:'',
                    estadoCrud:''
                }),
                show_menus:'habilitados',
                buscar:'',
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
                axios.get('/api/menu-'+this.show_menus+'?pagina='+this.pagina+'&buscar='+this.buscar,this.config)
                .then((respuesta) => {
                    this.menus=respuesta.data
                    this.total = this.menus.total
                })
            },
            getResults(page=1)
            {
                axios.get('/api/menu-'+this.show_menus+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.buscar,this.config)
                .then(response => {
                    this.menus = response.data
                    this.total = this.menus.total
                });
            },
            cambiarPaginacion(event){
                this.pagina = event.target.value
                this.listar()
                this.getResults()
            },
            habilitados() {
                this.show_menus = 'habilitados'
                this.listar()
                this.getResults()
            },
            todos() {
                this.show_menus = 'todos'
                this.listar()
                this.getResults()
            },
            eliminados() {
                this.show_menus = 'eliminados'
                this.listar()
                this.getResults()
            },
            limpiar() {
                this.form.clear()
                this.form.reset()
            },
            nuevo() {
                this.limpiar()
                $('#modal-menu-title').html('Nuevo Menú')
                $('#modal-menu').modal('show')
                this.form.estadoCrud =  'crear'
            },
            mostrar(id) {
                axios.get('api/menus/'+id,this.config)
                .then(respuesta => {
                    let menu = respuesta.data
                    this.form.id = menu.id
                    this.form.nombre = menu.nombre
                    this.form.enlace = menu.enlace
                    this.form.icono = menu.icono
                    this.form.padre_id = (menu.padre_id ) ? menu.padre_id : ''
                })
            },
            editar(id) {
                this.mostrar(id)
                this.form.estadoCrud =  'editar'
                $('#modal-menu-title').html('Editar Menú')
                $('#modal-menu').modal('show')
            },
            buscarMenu(event) {
                this.buscar =  event.target.value
                this.listar()
                this.getResults()
            },
            eliminar(id) {
                swal.fire({
                    title:"Menús",
                    text:'¿Está Seguro de Eliminar el Menú?',
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
                axios.post('api/menu-destroy-temporal',{id:id},this.config)
                .then((response) => (
                    swal.fire({
                        icon : 'success',
                        title : 'Menús',
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
                this.form.delete('api/menus/'+id,this.config)
                .then( (respuesta) => {
                    swal.fire({
                        title:"Menús",
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
                    title:"Menús",
                    text:'¿Está Seguro de Restaurar el Menú?"',
                    icon:"question",
                    showCancelButton: true,
                    confirmButtonText:"Si",
                    confirmButtonColor:"#28a745",
                    cancelButtonText:"No",
                    cancelButtonColor:"#dc3545"
                }).then( (response) => {
                    if(response.value) {
                        axios.post('/api/menu-restaurar',{id:id},this.config)
                        .then((response) => (
                            swal.fire({
                                icon : 'success',
                                title : 'Menú',
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