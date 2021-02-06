<template>
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado Usuarios&nbsp;
                    <button type="button" class="btn bg-maroon btn-sm" @click="nuevoUsuario"
                            v-if="$auth.can('usuarios.crear')">
                        <i class="fas fa-plus"></i> Nuevo Usuario
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
                                @keyup="buscarUsuario">
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
                                        <th>Foto</th>
                                        <th>Usuario</th>
                                        <th>Nombres Y Apellidos</th>
                                        <th>Correo Elec.</th>
                                        <th>Rol</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="total== 0">
                                        <td colspan="5" class="text-center text-danger">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                     <tr v-else-if="total>0" v-for="(usuario,index) in usuarios.data" :key="usuario.id">
                                        <td class="text-center" v-text="(usuarios.from+index)"></td>
                                        <td><img :src="usuario.foto" class="img-circle img-size-32"></td>
                                        <td v-text="usuario.name"></td>
                                        <td v-text="usuario.persona.nombres+' '+usuario.persona.apellidos"></td>
                                        <td v-text="usuario.email"></td>
                                        <td class="text-center">
                                            <span v-for="rol in usuario.roles" :key="rol.id">
                                                <span v-if="rol.directriz=='super-usuario'" class="badge badge-primary" v-text="rol.nombre"></span>
                                                <span v-else-if="rol.directriz=='administrador'" class="badge badge-success" v-text="rol.nombre"></span>
                                                <span v-else-if="rol.directriz=='cobrador'" class="badge bg-maroon" v-text="rol.nombre"></span>
                                                <span v-else-if="rol.directriz=='secretario'" class="badge badge-warning" v-text="rol.nombre"></span>
                                                <span v-else-if="rol.directriz=='usaurio'" class="badge bg-purple" v-text="rol.nombre"></span>
                                            </span>
                                        </td>
                                        <td>
                                            <span v-if="usuario.deleted_at==null">
                                                <button type="button" class="btn btn-warning btn-xs"
                                                        @click="editar(usuario.id)" title="Editar Usuario"
                                                        v-if="$auth.can('usuarios.editar')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="eliminar(usuario.id)" title="Eliminar Usuario"
                                                        v-if="$auth.can('usuarios.eliminar')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </span>
                                            <span v-else>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="restaurar(usuario.id)" title="Restaurar Usuario"
                                                        v-if="$auth.can('usuarios.restaurar')">
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
                                Mostrando <b>{{usuarios.from}}</b> a <b>{{ usuarios.to }}</b> de <b>{{ usuarios.total}}</b> Registros
                            </div>
                            <div class="col-md-6 text-right">
                                <pagination :data="usuarios" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-usuario">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-usuario-title">Default Modal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-usuario-body">
                            <usuarios-form :form='form'></usuarios-form>
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
    import UsuarioForm from '../usuario/Form'
export default {
    components: {
        'usuarios-form': UsuarioForm
    },
    created() {
        this.listar();
        this.getResults();
    },
    data() {
        return{
            usuarios:{},
            total:0,
            pagina:5,
            form:new form({
                id:'',
                name:'',
                email:'',
                password:'',
                password_confirmation:'',
                foto:'images/user_male.png',
                persona_id:'',
                role_id:[],
                tipo_documento_id:'',
                numero_documento:'',
                nombres:'',
                apellidos:'',
                sexo:'',
                telefono:'',
                direccion:'',
                estadoCrud:''
            }),
            show_usuarios:'habilitados',
            buscar:'',
            config:{
                headers:{'Authorization': 'Bearer ' + localStorage.getItem('token-api')}
            }
        }
    },
    methods:{
        listar(){
            axios.get('/api/usuario-'+this.show_usuarios+'?pagina='+this.pagina+'&buscar='+this.buscar,this.config)
            .then((respuesta) => {
                this.usuarios=respuesta.data
                this.total = this.usuarios.total
            })
        },
        getResults(page=1){
            axios.get('/api/usuario-'+this.show_usuarios+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.buscar,this.config)
            .then(response => {
                this.usuarios = response.data
                this.total = this.usuarios.total
            });
        },
        cambiarPaginacion(event)
        {
            this.pagina = event.target.value
            this.listar()
            this.getResults()
        },
        habilitados() {
            this.show_usuarios = 'habilitados'
            this.listar()
            this.getResults()
        },
        todos() {
            this.show_usuarios = 'todos'
            this.listar()
            this.getResults()
        },
        eliminados() {
            this.show_usuarios = 'eliminados'
            this.listar()
            this.getResults()
        },
        limpiar() {
            this.form.clear()
            this.form.reset()
        },
        buscarUsuario(event) {
            this.buscar =  event.target.value
            this.listar()
            this.getResults()
        },
        nuevoUsuario(){
            this.limpiar()
            $('#modal-usuario-title').html('Nuevo Rol')
            $('#modal-usuario').modal('show')
            this.form.estadoCrud =  'crear'
        },
        mostrar(id) {
            axios.get('api/usuario-mostrar?id='+id,this.config)
            .then(respuesta => {
                let usuario = respuesta.data.usuario
                let persona = respuesta.data.persona
                let roles = respuesta.data.roles
                this.form.id = usuario.id
                this.form.persona_id = usuario.persona_id
                this.form.tipo_documento_id = persona.tipo_documento_id
                this.form.numero_documento = persona.numero_documento
                this.form.nombres = persona.nombres
                this.form.apellidos = persona.apellidos
                this.form.sexo = persona.sexo
                this.form.telefono = persona.telefono
                this.form.direccion = persona.direccion
                this.form.name = usuario.name
                this.form.email = usuario.email
                this.form.role_id =  roles
            })
        },
        editar(id) {
            this.mostrar(id)
            this.form.estadoCrud =  'editar'
            $('#modal-usuario-title').html('Editar Usuario')
            $('#modal-usuario').modal('show')
        },
        eliminar(id) {
            swal.fire({
                title:"Usuarios",
                text:'¿Está Seguro de Eliminar el Usuario?',
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
            axios.post('api/usuario-destroy-temporal',{id:id},this.config)
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
                }
            })
        },
        eliminarPermanente(id) {
            this.$Progress.start()
            this.form.delete('api/user/'+id,this.config)
            .then( (respuesta) => {
                swal.fire({
                    title:"Usuarios",
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
                title:"Usuarios",
                text:'¿Está Seguro de Restaurar el Usuario?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('/api/usuario-restaurar',{id:id},this.config)
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
                                title : 'Usuarios',
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
