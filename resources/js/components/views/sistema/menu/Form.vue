<template>
    <form id="form-menu" @submit.prevent="guardar">
        <div class="form-group row">
            <label for="nombre" class="col-form-label col-md-3 text-right">Nombre</label>
            <div class="col-md-8">
                <input type="text" v-model="form.nombre"
                    placeholder="Nombrel Menú" title="Nombre Menú"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                <has-error :form="form" field="nombre"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="enlace" class="col-form-label col-md-3 text-right">Enlace</label>
            <div class="col-md-8">
                <input type="text" v-model="form.enlace"
                    placeholder="Enlace Menú" title="Enlace Menú"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('enlace') }">
                <has-error :form="form" field="enlace"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="icono" class="col-form-label col-md-3 text-right">&Iacute;cono</label>
            <div class="col-md-8">
                <input type="text" name="icono" id="icono" v-model="form.icono"
                        placeholder="Ícono" title="Ícono"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('icono') }">
                <has-error :form="form" field="icono"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="padre_id" class="col-form-label col-md-3 text-right">Padre</label>
            <div class="col-md-8">
                <select v-model="form.padre_id" class="form-control">
                    <option value="">-Seleccionar-</option>
                    <option v-for="padre in padres" :key="padre.id" :value="padre.id">
                        {{ padre.nombre }}
                    </option>
                </select>
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
                padres:[]
            }
        },
        created() {
            this.obtenerPadres()
        },
        methods:{
            obtenerPadres() {
                axios.get('api/menus-padres',this.$parent.config)
                .then(respuesta => {
                    this.padres = respuesta.data
                })
            },
            guardar() {
                switch(this.form.estadoCrud){
                    case 'crear':this.agregar();break;
                    case 'editar':this.actualizar();break;
                }
            },
            agregar() {
                this.$Progress.start()
                this.form.post('api/menus',this.$parent.config)
                .then(respuesta => {
                    $('#modal-menu').modal('hide')
                    swal.fire({icon:'success',title:'Menús','text':respuesta.data})
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
                this.form.put('api/menus/'+this.form.id,this.$parent.config)
                .then(respuesta => {
                    $('#modal-menu').modal('hide')
                    swal.fire({icon:'success',title:'Menús',text:respuesta.data})
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
