<template>
    <div class="row">
        <div class="col-md-12" v-if="form.estadoCrud == '' || form.estadoCrud == null">
            <div class="card card-outline card-info">
                <div class="card-header ">
                    <h3 class="card-title">
                        Listado de P&eacute;stamos&nbsp;
                        <button type="button" class="btn bg-maroon btn-sm" @click="nuevo"
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
                </div>
            </div>
        </div>
        <div class="col-md-12" v-else-if="form.estadoCrud == 'crear' || form.estadoCrud == 'editar'">
            <prestamo-form :form="form"></prestamo-form>
        </div>
    </div>
</template>
<script>
import PrestamoForm from './Form'
export default {
    components:{
        'prestamo-form':PrestamoForm
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
                fecha_prestamo:'',
                moneda_id:'',
                tipo_cambio:'',
                tasa_interes_id:'',
                monto:'',
                interes:'',
                tipo_cuota_id:'',
                numero_cuotas:'',
                dias_morosos:'',
                incluye_feriados:'',
                incluye_sabdom:'',
                cuotas:[],
                estado_operacion_id:'',
                estadoCrud:''
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
            axios.get('/api/prestamo-'+this.show_prestamos+'?pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
            .then((respuesta) => {
                this.prestamos=respuesta.data
                this.total = this.prestamos.total
            })
        },
        getResults(page=1) {
            axios.get('/api/prestamo-'+this.show_prestamos+'?page='+page+'&pagina='+this.pagina+'&buscar='+this.busqueda,this.config)
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
        buscar() {
            this.busqueda =  event.target.value
            this.listar()
            this.getResults()
        },
        limpiar() {
            this.form.reset()
            this.form.clear()
        },
        nuevo() {
            this.limpiar()
            this.form.estadoCrud = 'crear'
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
