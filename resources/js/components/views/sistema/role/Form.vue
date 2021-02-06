<template>
    <div>
        <form id="form-role" @submit.prevent="guardar">
            <div class="form-group row">
                <label for="nombre" class="col-form-label col-md-3 text-right">Nombre</label>
                <div class="col-md-8">
                    <input type="text" name="nombre" v-model="form.nombre" id="nombre"
                        placeholder="Nombrel Rol" title="Nombre Rol"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                    <has-error :form="form" field="nombre"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <label for="directriz" class="col-form-label col-md-3 text-right">Directriz</label>
                <div class="col-md-8">
                    <input type="text" name="directriz" v-model="form.directriz" id="directriz"
                        placeholder="Directriz" title="Nombre de Usuario"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('directriz') }">
                    <has-error :form="form" field="directriz"></has-error>
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
    </div>
</template>
<script>
export default {
    props:['form'],
    data() {
        return {

        }
    },
    created() {
    },
    methods:{
        guardar() {
            switch(this.form.estadoCrud)
            {
                case 'crear': this.agregar();break;
                case 'editar': this.actualizar();break;
            }
        },
        agregar(){
            this.$Progress.start()
            this.form.post('api/roles',this.$parent.config)
            .then(respuesta => {
                $('#modal-role').modal('hide')
                toast.fire({icon:'success',title:respuesta.data})
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
            this.form.put('api/roles/'+this.form.id,this.$parent.config)
            .then(respuesta => {
                $('#modal-role').modal('hide')
                toast.fire({icon:'success',title:respuesta.data})
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
        }

    }
}
</script>
