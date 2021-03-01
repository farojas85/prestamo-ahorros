<template>
    <div class="row">
        <div class="col-md-12 mb-1" v-if="(form.estadoCrud == '' || form.estadoCrud == null) && cobranza.estadoCrud == ''" >
            <div class="card card-outline card-info">
                <div class="card-header ">
                    <h3 class="card-title">
                        Listado de P&eacute;stamos&nbsp;
                        <button type="button" class="btn bg-maroon btn-sm" @click="nuevo('crear')"
                                v-if="$auth.can('prestamos.crear')">
                            <i class="fas fa-plus"></i> Nuevo Pr&eacute;stamo
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
                                            <th></th>
                                            <th class="text-center">#</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th v-if="$auth.hasRole('administrador') || $auth.hasRole('super-usuario')">Cobrador</th>
                                            <th>Monto</th>
                                            <th>Interes</th>
                                            <th>Monto Final</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="total == 0">
                                            <td class="text-danger text-center" colspan="9">
                                                -- DATOS NO REGISTRADOS - TABLA VACÍA --
                                            </td>
                                        </tr>
                                        <tr v-else-if="total>0" v-for="(prestamo,fila) in prestamos.data" :key="prestamo.id">
                                            <td>
                                                <span v-if="prestamo.deleted_at == null">
                                                    <button type="button" class="btn bg-pink btn-xs"
                                                            @click="mostrarCuotas(prestamo.id)" title="Mostrar Cuotas del Préstamo"
                                                            v-if="$auth.can('prestamos.mostrar-cuotas')">
                                                        <i class="fas fa-closed-captioning"></i>
                                                    </button>
                                                    <button type="button" class="btn bg-olive btn-xs"
                                                            @click="nuevaCobranza('crear',prestamo.id)" title="Cobrar Cuota"
                                                            v-if="$auth.can('cobranzas.crear')">
                                                        <i class="fas fa-shopping-basket"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-warning btn-xs"
                                                            @click="editar(prestamo.id)" title="Editar Préstamo"
                                                            v-if="$auth.can('prestamos.editar')">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-xs"
                                                            @click="eliminar(prestamo.id)" title="Eliminar Préstamo"
                                                            v-if="$auth.can('prestamos.eliminar')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </span>
                                                <span v-else>
                                                    <button type="button" class="btn bg-purple btn-xs"
                                                            @click="restaurar(prestamo.id)" title="Restaurar Préstamo"
                                                            v-if="$auth.can('prestamos.restaurar')">
                                                        <i class="fas fa-trash-restore"></i>
                                                    </button>
                                                </span>
                                            </td>
                                            <td v-text="fila+prestamos.from"></td>
                                            <td>{{ prestamo.fecha_prestamo | miFecha }}</td>
                                            <td>{{ prestamo.cliente.persona.nombres }} {{ prestamo.cliente.persona.apellidos }}</td>
                                            <td v-if="$auth.hasRole('administrador') || $auth.hasRole('super-usuario')">
                                                {{ prestamo.user.persona.nombres }} {{ prestamo.user.persona.apellidos }}
                                            </td>
                                            <td>{{ prestamo.monto }}</td>
                                            <td>{{ prestamo.interes }}</td>
                                            <td>{{ (parseFloat(prestamo.monto) + parseFloat(prestamo.interes)).toFixed(2) }}</td>
                                            <td>
                                                <span :class="prestamo.estado_operacion.clase">{{ prestamo.estado_operacion.nombre }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-1" v-else-if="form.estadoCrud == 'crear' || form.estadoCrud == 'editar'">
            <prestamo-form :form="form"></prestamo-form>
        </div>
        <div class="col-md-12 mb-1" v-if="cobranza.estadoCrud=='crear'">
            <div class="card card-outline card-info">
                <div class="card-header ">
                    <h3 class="card-title">
                        Nueva Cobranza&nbsp;
                        <button type="button" class="btn bg-green btn-sm" @click="nuevaCobranza('','')"
                                v-if="$auth.can('cobranzas.crear')">
                            <i class="fas fa-undo-alt"></i> retornar
                        </button>
                    </h3>
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-cuota">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-cuota-title">Large Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-cuota-body">
                        <cuota-form :cuota="cuota" v-if="cuota.prestamo_id"></cuota-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import PrestamoForm from './forms/PrestamoForm'
import CuotaForm from './forms/CuotaForm'
import CobranzaForm from './forms/CobranzaForm'

export default {
    components:{
        PrestamoForm,CuotaForm,CobranzaForm
    },
    data() {
        return {
            prestamos:{},
            total:0,
            pagina:10,
            form:new form({
                id:'',
                cliente_id:'',
                user_id:'',
                fecha_prestamo: moment(new Date()).tz('America/Lima').format('YYYY-MM-DD'),
                moneda_id:1,
                tipo_cambio:'',
                tasa_interes_id:'',
                monto:'',
                interes:'',
                tipo_cuota_id:'',
                numero_cuotas:'',
                dias_morosos:'',
                forma_pago_id:1,
                cuotas:[],
                estado_operacion_id:'',
                estadoCrud:'',
                usuario_id:this.$auth.user.id
            }),
            cuota: new form({
                prestamo_id:'',
                cliente:'',
                cobrador:'',
                fecha:'',
                tipo_cambio:'',
                moneda:'',
                monto:'',
                tasa_interes:'',
                interes:'',
                tipo_cuota:'',
                numero_cuotas:'',
                total:'',
                saldo:'',
                estado:'',
                estado_clase:'',
                pago:'',
                fecha_cuota:'',
                cuotas:[]
            }),
            cobranza: new form({
                estadoCrud:'',
                prestamo_id:'',
                cliente:'',
                cobrador:'',
                fecha:'',
                tipo_cambio:'',
                moneda:'',
                monto:'',
                tasa_interes:'',
                interes:'',
                tipo_cuota:'',
                numero_cuotas:'',
                total:'',
                saldo:'',
                estado:'',
                estado_clase:'',
            }),
            show_prestamos:'habilitados',
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
            axios.get('/api/prestamo-'+this.show_prestamos+'?pagina='+this.pagina
                                    +'&buscar='+this.busqueda+'&usuario='+this.$auth.user.id,this.config)
            .then((respuesta) => {
                this.prestamos=respuesta.data
                this.total = this.prestamos.total
            })
        },
        getResults(page=1) {
            axios.get('/api/prestamo-'+this.show_prestamos+'?page='+page+'&pagina='+this.pagina
                                    +'&buscar='+this.busqueda+'&usuario='+this.$auth.user.id,this.config)
            .then(response => {
                this.prestamos = response.data
                this.total = this.prestamos.total
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
        buscar(event) {
            this.busqueda =  event.target.value
            this.listar()
            this.getResults()
        },
        limpiar() {
            this.form.reset()
            this.form.clear()
        },
        nuevo(estado) {
            this.limpiar()
            this.form.estadoCrud = estado
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

        },
        obtenerCuotas(id)
        {
            axios.get('api/prestamo-cuotas?id='+id,this.config)
            .then(respuesta => {
                var prestamo = respuesta.data.prestamo
                var cliente = respuesta.data.cliente
                var cobrador = respuesta.data.cobrador
                var cuotas = respuesta.data.cuotas
                if(respuesta.data)
                {
                    this.cuota.prestamo_id = id
                    this.cuota.cliente = cliente
                    this.cuota.cobrador = cobrador
                    this.cuota.fecha = prestamo.fecha
                    this.cuota.tipo_cambio = prestamo.tipo_cambio
                    this.cuota.moneda = prestamo.moneda
                    this.cuota.monto = prestamo.monto
                    this.cuota.tasa_interes = prestamo.tasa_interes
                    this.cuota.interes = prestamo.interes
                    this.cuota.tipo_cuota = prestamo.tipo_cuota
                    this.cuota.numero_cuotas = prestamo.numero_cuotas
                    this.cuota.total = prestamo.total
                    this.cuota.saldo = prestamo.saldo
                    this.cuota.estado = prestamo.estado
                    this.cuota.estado_clase = prestamo.estado_clase
                    this.cuota.pago = prestamo.pago
                    this.cuota.cuotas = cuotas
                }
            })
        },
        mostrarCuotas(id) {
            this.cuota.clear()
            this.cuota.reset()
            this.obtenerCuotas(id)
            $('#modal-cuota-title').html('Cuotas Préstamo')
            $('#modal-cuota').modal('show')
        },
        nuevaCobranza(estado,id) {
            this.cobranza.clear()
            this.cobranza.reset()
            this.cobranza.estadoCrud =estado
        }
    }
}
</script>
