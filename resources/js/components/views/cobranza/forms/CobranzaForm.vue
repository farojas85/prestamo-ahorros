<template>
<div class="">
   <div class="form-group row">
       <label  class="col-form-label col-form-label-sm col-md-1">Cliente:</label>
       <div class="col-md-6">
           <input type="text" class="form-control form-control-sm" v-model="buscarCliente"
            placeholder="Ingrese Apellidos o nombres o número documento">
       </div>
   </div>
   <div class="row">
       <div class="col-md-12 table-responsive">

       </div>
   </div>
</div>
</template>

<script>
export default {
    props:['form'],
    components:{

    },
    data(){
        return {
            buscarCliente:'',
        }
    },
    created() {

    },
    methods:{
        busquedaCliente() {

        }
    }
}
</script>
