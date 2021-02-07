<template>
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado de Clientes&nbsp;
                </h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn bg-maroon btn-sm" @click="nuevo"
                        v-if="$auth.can('clientes.crear')">
                    <i class="fas fa-plus"></i> Nuevo Cliente
                </button>
                <descargar-excel :data="clientes_reporte"  class="btn btn-success btn-sm"
                    v-if="$auth.can('clientes.reporte')">
                    <i class="fas fa-file-excel"></i> Descargar
                </descargar-excel>
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
                                @keyup="buscarCliente">
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
                                        <th title="Valoración">Valor.</th>
                                        <th>Cobrador</th>
                                        <th>Cliente</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="total== 0">
                                        <td colspan="5" class="text-center text-danger">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                     <tr v-else-if="total>0" v-for="(cliente,index) in clientes.data" :key="cliente.id">
                                        <td class="text-center" v-text="(clientes.from+index)"></td>
                                        <td :title="cliente.valoracion.nombre" class="text-center">
                                            <i :class="cliente.valoracion.icono+' '+cliente.valoracion.clase"></i>
                                        </td>
                                        <td>
                                            <template v-for="cobrador in cliente.users">
                                                {{ cobrador.persona.nombres }} {{ cobrador.persona.apellidos }}
                                            </template>
                                        </td>
                                        <td v-text="cliente.persona.nombres+' '+cliente.persona.apellidos"></td>
                                        <td>
                                            <span v-if="cliente.deleted_at==null">
                                                 <button type="button" class="btn btn-info btn-xs"
                                                        @click="mostrarCliente(cliente.id)" title="Mostrar Cliente"
                                                        v-if="$auth.can('clientes.mostrar')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-warning btn-xs"
                                                        @click="editar(cliente.id)" title="Editar Cliente"
                                                        v-if="$auth.can('clientes.editar')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="eliminar(cliente.id)" title="Eliminar Cliente"
                                                        v-if="$auth.can('clientes.eliminar')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </span>
                                            <span v-else>
                                                <button type="button" class="btn btn-danger btn-xs"
                                                        @click="restaurar(cliente.id)" title="Restaurar Cliente"
                                                        v-if="$auth.can('clientes.restaurar')">
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
                                Mostrando <b>{{clientes.from}}</b> a <b>{{ clientes.to }}</b> de <b>{{ clientes.total}}</b> Registros
                            </div>
                            <div class="col-md-6 text-right">
                                <pagination :data="clientes" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-cliente">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-cliente-title">Default Modal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-cliente-body">
                            <clientes-form :cliente='cliente'></clientes-form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ClienteForm from '../cliente/Form'
export default {
    components:{
        'clientes-form':ClienteForm
    },
    data() {
        return {
            usuario_id:this.$auth.user.id,
            clientes:{},
            clientes_reporte:[],
            total:0,
            pagina:5,
            cliente: new form({
                id:'',
                persona_id:'',
                tipo_documento_id:'',
                numero_documento:'',
                nombres:'',
                apellidos:'',
                sexo:'',
                telefono:'',
                direccion:'',
                valoracion:'',
                user_id:'',
                estadoCrud:'',
                valora:{},
                usuario_id:this.$auth.user.id,
            }),
            show_clientes:'habilitados',
            buscar:'',
            config:{
                headers:{'Authorization': 'Bearer ' + localStorage.getItem('token-api')}
            }
        }
    },
    created() {
        this.listar();
        this.getResults();

    },
    methods:{
        listar(){
            axios.get('/api/cliente-'+this.show_clientes+'?pagina='+this.pagina+'&buscar='+this.buscar+'&usuario='+this.usuario_id,this.config)
            .then((respuesta) => {
                this.clientes=respuesta.data
                this.total = this.clientes.total
            })
            this.reporteCliente();
        },
        getResults(page=1){
            axios.get('/api/cliente-'+this.show_clientes+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.buscar+'&usuario='+this.usuario_id,this.config)
            .then(response => {
                this.clientes = response.data
                this.total = this.clientes.total
            });
            this.reporteCliente();
        },
        cambiarPaginacion(event)
        {
            this.pagina = event.target.value
            this.listar()
            this.getResults()
        },
        habilitados() {
            this.show_clientes = 'habilitados'
            this.listar()
            this.getResults()
        },
        todos() {
            this.show_clientes = 'todos'
            this.listar()
            this.getResults()
        },
        eliminados() {
            this.show_clientes = 'eliminados'
            this.listar()
            this.getResults()
        },
        buscarCliente()
        {

        },
        mostrar(id) {
            axios.get('api/cliente-mostrar?id='+id,this.config)
            .then(respuesta => {
                let cliente = respuesta.data.cliente
                let persona = respuesta.data.persona
                let cobrador = respuesta.data.cobrador
                let valoracion = respuesta.data.valoracion
                this.cliente.id = cliente.id
                this.cliente.persona_id = cliente.persona_id
                this.cliente.tipo_documento_id = persona.tipo_documento_id
                this.cliente.numero_documento = persona.numero_documento
                this.cliente.nombres = persona.nombres
                this.cliente.apellidos = persona.apellidos
                this.cliente.sexo = persona.sexo
                this.cliente.telefono = persona.telefono
                this.cliente.direccion = persona.direccion
                this.cliente.valoracion = cliente.valoracion_id
                this.cliente.user_id = cobrador.id
                this.cliente.valora = valoracion
            })
        },
        mostrarCliente(id)
        {
            this.cliente.estadoCrud = 'mostrar'
            this.mostrar(id)
            $('#modal-cliente-title').html("Mostrar Cliente")
            $('#modal-cliente').modal('show')
        },
        limpiar() {
            this.cliente.clear()
            this.cliente.reset()
        },
        nuevo() {
            this.limpiar()
            this.cliente.estadoCrud='crear'
            $('#modal-cliente-title').html("Nuevo Cliente")
            $('#modal-cliente').modal('show')
        },
        editar(id)
        {
            this.cliente.estadoCrud = 'editar'
            this.mostrar(id)
            $('#modal-cliente-title').html("Editar Cliente")
            $('#modal-cliente').modal('show')
        },
        eliminar(id) {
            swal.fire({
                title:"Clientes",
                text:'¿Está Seguro de Eliminar el Cliente?',
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
            axios.post('api/cliente-destroy-temporal',{id:id},this.config)
            .then((response) => (
                swal.fire({
                    icon : 'success',
                    title : 'Clientes',
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
            this.form.delete('api/clientes/'+id,this.config)
            .then( (respuesta) => {
                swal.fire({
                    title:"Cliente",
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
                title:"Clientes",
                text:'¿Está Seguro de Restaurar el Cliente?"',
                icon:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('/api/cliente-restaurar',{id:id},this.config)
                    .then((response) => (
                        swal.fire({
                            icon : 'success',
                            title : 'Clientes',
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
        },
        reporteCliente()
        {
            axios.get('api/cliente-reporte?usuario='+this.usuario_id,this.config)
            .then(respuesta => {
                this.clientes_reporte = respuesta.data
            })
        }
    }
}
</script>
