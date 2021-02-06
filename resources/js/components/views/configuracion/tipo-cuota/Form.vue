<template>
    <form id="form-menu" @submit.prevent="guardar">
        <div class="form-group row">
            <label for="nombre" class="col-form-label col-md-3 text-right">Nombre</label>
            <div class="col-md-8">
                <input type="text" v-model="form.nombre"
                    placeholder="Nombre Tipo Cuota" title="Nombre Tipo Cuota"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                <has-error :form="form" field="nombre"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="nombre" class="col-form-label col-md-3 text-right">D&iacute;as</label>
            <div class="col-md-8">
                <input type="text" v-model="form.dias"
                    placeholder="Días" title="Días"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('dias') }">
                <has-error :form="form" field="dias"></has-error>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-times"></i> Cerrar
            </button>
            <span v-if="form.estadoCrud!='mostrar'">
                <button type="submit" class="btn btn-success">
                    <span v-if="form.estadoCrud=='crear'"><i class="fas fa-save"></i> Guardar</span>
                    <span v-else-if="form.estadoCrud=='editar'"><i class="fas fa-sync-alt"></i> Actualizar</span>
                </button>
            </span>
        </div>
    </form>
</template>
<script>
export default {
    props:['form'],
    data(){
        return{

        }
    },
    created() {

    },
    methods:{
        guardar() {
            switch(this.form.estadoCrud){
                case 'crear':this.agregar();break;
                case 'editar':this.actualizar();break;
            }
        },
        agregar() {
            this.$Progress.start()
            this.form.post('api/tipo-cuotas',this.$parent.config)
            .then(respuesta => {
                $('#modal-tipo-cuota').modal('hide')
                swal.fire({icon:'success',title:'Tipo Cuotas','text':respuesta.data})
                this.$parent.habilitados()
                this.$Progress.finish()
            })
            .catch(error => {
                this.$Progress.fail()
                if(error.response.status == 422)
                {
                    console.clear()
                } else {
                    swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                }
            })
        },
        actualizar() {
            this.$Progress.start()
            this.form.put('api/tipo-cuotas/'+this.form.id,this.$parent.config)
            .then(respuesta => {
                $('#modal-tipo-cuota').modal('hide')
                swal.fire({icon:'success',text:respuesta.data,title:'Tipo Cuotas'})
                this.$parent.habilitados()
                this.$Progress.finish()
            })
            .catch(error => {
                this.$Progress.fail()
                if(error.response.status == 422)
                {
                    console.clear()
                } else {
                    swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                }
            })
        },
    }
}
</script>