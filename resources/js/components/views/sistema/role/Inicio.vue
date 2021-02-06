<template>
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado Roles&nbsp;
                    <button type="button" class="btn bg-maroon btn-sm" @click="nuevo"
                            v-if="$auth.can('roles.crear')">
                        <i class="fas fa-plus"></i> Nuevo Rol
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
                                @keyup="buscarRole">
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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="total== 0">
                                        <td colspan="5" class="text-center text-danger">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                     <tr v-else-if="total>0" v-for="(role,index) in roles.data" :key="role.id">
                                        <td class="text-center" v-text="(roles.from+index)"></td>
                                        <td v-text="role.nombre"></td>
                                        <td v-text="role.directriz"></td>
                                        <td>
                                            <span v-if="role.deleted_at==null">
                                                <button type="button" class="btn btn-warning btn-xs"
                                                        @click="editar(role.id)" title="Editar Rol"
                                                        v-if="$auth.can('roles.editar')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="eliminar(role.id)" title="Eliminar Rol"
                                                        v-if="$auth.can('roles.eliminar')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </span>
                                            <span v-else>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="restaurar(role.id)" title="Restaurar Rol"
                                                        v-if="$auth.can('roles.restaurar')">
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
                                Mostrando <b>{{roles.from}}</b> a <b>{{ roles.to }}</b> de <b>{{ roles.total}}</b> Registros
                            </div>
                            <div class="col-md-6 text-right">
                                <pagination :data="roles" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-role">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-role-title">Default Modal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-role-body">
                            <roles-form :form='form'></roles-form>
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
    import RoleForm from '../role/Form'
export default {
    components: {
        'roles-form': RoleForm
    },
    created() {
        this.listar()
        this.getResults()
        //this.getTimeZone()
    },
    data() {
        return{
            roles:{},
            total:0,
            pagina:5,
            form:new form({
                id:'',
                nombre:'',
                directriz:'',
                estadoCrud:''
            }),
            show_roles:'habilitados',
            buscar:'',
            config:{
                headers:{'Authorization': 'Bearer ' + localStorage.getItem('token-api')}
            }
        }
    },
    methods:{
        listar(){
            axios.get('/api/role-'+this.show_roles+'?pagina='+this.pagina+'&buscar='+this.buscar,this.config)
            .then((respuesta) => {
                this.roles=respuesta.data
                this.total = this.roles.total
            })
        },
        getResults(page=1){
            axios.get('/api/role-'+this.show_roles+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.buscar,this.config)
            .then(response => {
                this.roles = response.data
                this.total = this.roles.total
            });
        },
        cambiarPaginacion(event)
        {
            this.pagina = event.target.value
            this.listar()
            this.getResults()
        },
        habilitados() {
            this.show_roles = 'habilitados'
            this.listar()
            this.getResults()
        },
        todos() {
            this.show_roles = 'todos'
            this.listar()
            this.getResults()
        },
        eliminados() {
            this.show_roles = 'eliminados'
            this.listar()
            this.getResults()
        },
        limpiar() {
            this.form.clear()
            this.form.reset()
        },
         buscarRole(event) {
            this.buscar =  event.target.value
            this.listar()
            this.getResults()
        },
        nuevo(){
             this.limpiar()
            $('#modal-role-title').html('Nuevo Rol')
            $('#modal-role').modal('show')
            this.form.estadoCrud =  'crear'
        },
        mostrar(id) {
            axios.get('api/roles/'+id,this.config)
            .then(respuesta => {
                let role = respuesta.data
                this.form.id = role.id
                this.form.nombre = role.nombre
                this.form.directriz = role.directriz
            })
        },
        editar(id) {
            this.mostrar(id)
            this.form.estadoCrud =  'editar'
            $('#modal-role-title').html('Editar Rol')
            $('#modal-role').modal('show')
        },
        eliminar(id) {
            swal.fire({
                title:"ROLES",
                text:'¿Está Seguro de Eliminar el rOL?',
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
            axios.post('api/role-destroy-temporal',{id:id},this.config)
            .then((response) => (
                swal.fire({
                    icon : 'success',
                    title : 'ROLES',
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
            this.form.delete('api/roles/'+id,this.config)
            .then( (respuesta) => {
                swal.fire({
                    title:"Roles",
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
        restaurar(id){
            swal.fire({
                title:"Roles",
                text:'¿Está Seguro de Restaurar el Rol?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('/api/role-restaurar',{id:id},this.config)
                    .then((response) => (
                        swal.fire({
                            icon : 'success',
                            title : 'Roles',
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
        },
        getTimeZone()
        {
            axios.get('api/time-zone',this.config)
            .then(respuesta=>{
                console.log(respuesta.data)
            })
        }
    }
}
</script>
