<template>
    <div class="card border border-info">
        <div class="card-header bg-info text-white">
            <h3 class="card-title">Permisos para:... {{ form.role_nombre}}</h3>
        </div>
        <div class="card-body">
            <div class="tab-content pt-0" id="tab-contenido">
                <div v-for="permiso in permisos" :key="permiso.id" >
                    <label>
                        <input type="checkbox"  :value="permiso.id" v-model="form.permiso_id">
                        {{ permiso.directriz }} (<small>{{ permiso.descripcion }}</small>)
                    </label>
                </div>
                <div class="row container-fluid text-center" v-if="form.modelo">
                    <button type="button" class="btn btn-success" @click="guardar"
                        v-if="$auth.can('permiso-role.guardar')">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:['form','permisos'],
        data()
        {
            return {
            }
        },
        created() {
            //this.listarPermisos()
        },
        methods:{
            guardar()
            {
                //this.$Progress.start()
                this.form.post('api/permiso-role-guardar',this.$parent.config)
                .then(respuesta => {
                    swal.fire({icon:'success',text:respuesta.data,title:'Permisos/Roles'})
                    .then(respuesta => {
                        if(respuesta.value)
                        {
                            this.form.clear()
                            this.form.reset()
                        }
                    })                      
                    //this.$Progress.finsish()
                })
            },
            cargarDatosUsuario()
            {
                axios.get('usuario-logged',{params: {user_id:this.$auth.id}},this.$parent.config)
                .then(respuesta => {
                    localStorage.setItem('user-logged',JSON.stringify(respuesta.data.user))
                })
            }
        }
    }
</script>
