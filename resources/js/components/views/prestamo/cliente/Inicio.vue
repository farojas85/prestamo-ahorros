<template>
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado de Clientes&nbsp;
                    <button type="button" class="btn bg-maroon btn-sm" @click="nuevo"
                            v-if="$auth.can('prestamos.crear')">
                        <i class="fas fa-plus"></i> Nuevo Cliente
                    </button>
                </h3>
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
</template>
<script>
export default {
    components:{

    },
    data() {
        return {
            clientes:{},
            total:0,
            pagina:10,
            form:new form({
                id:'',
                nombre:'',
                icono:'',
                clase:'',
                estadoCrud:''
            }),
            show_clientes:'habilitados',
            busqueda:'',
            config:{
                headers:{'Authorization': 'Bearer ' + localStorage.getItem('token-api')}
            }
        }
    },
    created() {

    },
    methods:{
        nuevo() {

        }
    }
}
</script>