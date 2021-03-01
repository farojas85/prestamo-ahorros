<template>
    <div class="row">
        <div class="col-md-12 mb-1" v-if="form.estadoCrud == '' || form.estadoCrud == null">
            <div class="card card-outline card-info">
                <div class="card-header ">
                    <h3 class="card-title">
                        Listado de Cobranzas&nbsp;
                        <button type="button" class="btn bg-maroon btn-sm mb-1" @click="nuevo('crear')"
                                v-if="$auth.can('cobranzas.crear')">
                            <i class="fas fa-plus"></i> Nueva Cobranza
                        </button>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-1">
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
                    <div class="row">
                        <div class="col-md-12 mb-1" id="detalle-tabla">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered table-hover text-nowrap">
                                    <thead class="bg-navy">
                                        <tr>
                                            <th></th>
                                            <th class="text-center">#</th>
                                            <th>Fecha</th>
                                            <th>Serie/N&uacute;mero</th>
                                            <th>Cliente</th>
                                            <th v-if="$auth.hasRole('administrador') || $auth.hasRole('super-usuario')">Cobrador</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-1" v-if="form.estadoCrud=='crear'">
            <div class="card card-outline card-info mb-1">
                <div class="card-header ">
                    <h3 class="card-title">
                        Nueva Cobranza&nbsp;
                        <button type="button" class="btn bg-warning btn-sm mb-1" @click="nuevo('')">
                            <i class="fas fa-undo-alt"></i> Retornar
                        </button>
                    </h3>
                </div>
                <div class="card-body">
                    <cobranza-form :form="form"></cobranza-form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CobranzaForm from './forms/CobranzaForm'

export default {
    components:{
        CobranzaForm
    },
    data() {
        return{
            busqueda:'',
            pagina:10,
            form: new form({
                estadoCrud:''
            })
        }
    },
    created() {

    },
    methods:{
        listar() {

        },
        getResults(page=1) {

        },
        cambiarPaginacion(event) {

        },
        todos() {

        },
        habilitados() {

        },
        eliminados() {

        },
        buscar(){

        },
        limpiar() {
            this.form.clear()
            this.form.reset()
        },
        nuevo(valor) {
            this.limpiar()
            this.form.estadoCrud =valor
        }
    }

}
</script>
