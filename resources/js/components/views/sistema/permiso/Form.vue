<template>
    <form id="form-permiso" @submit.prevent="guardar">
        <div class="form-group row">
            <label for="nombre" class="col-form-label col-md-3 text-right">Nombre</label>
            <div class="col-md-8">
                <input type="text" name="nombre" v-model="form.nombre" id="nombre"
                    placeholder="Nombrel Permiso" title="Nombre Permiso"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                <has-error :form="form" field="nombre"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="directriz" class="col-form-label col-md-3 text-right">Directriz</label>
            <div class="col-md-8">
                <input type="text" name="directriz" v-model="form.directriz" id="directriz"
                    placeholder="Directriz" title="Directriz Permiso"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('directriz') }">
                <has-error :form="form" field="directriz"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="descripcion" class="col-form-label col-md-3 text-right">Descripci&oacute;n</label>
            <div class="col-md-8">
                <textarea name="descripcion" id="descripcion" v-model="form.descripcion"
                        placeholder="Descripción de Permiso" title="Descripción de Permiso"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('descripcion') }"
                        rows="2"></textarea>
                <has-error :form="form" field="descripcion"></has-error>
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
    data() {
        return {

        }
    },
    created() {

    },
    methods: {
        guardar() {
            switch(this.form.estadoCrud)
            {
                case 'crear' : this.agregar();break;
                case 'editar': this.actualizar();break;
            }
        },
        agregar() {
            this.$Progress.start()
            this.form.post('api/permisos',this.$parent.config)
            .then(respuesta => {
                $('#modal-permiso').modal('hide')
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
            this.form.put('api/permisos/'+this.form.id,this.$parent.config)
            .then(respuesta => {
                $('#modal-permiso').modal('hide')
                swal.fire({icon:'success',title:'Permisos','text':respuesta.data})
                this.$parent.habilitados()
                this.$Progress.finsish()
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
