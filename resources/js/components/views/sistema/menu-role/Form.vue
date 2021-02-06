<template>
    <div class="card border border-info">
        <div class="card-header bg-info text-white">
            <h3 class="card-title">Men&uacute;s para:... {{ form.role_nombre}}</h3>
        </div>
        <div class="card-body">
            <div class="tab-content pt-0" id="tab-contenido">
                <div v-for="menu in menus" :key="menu.id" >
                    <label>
                        <input type="checkbox"  :value="menu.id" v-model="form.menu_id">
                        {{ menu.nombre }} <small v-if="menu.enlace">(Enlace: {{ menu.enlace }})</small>
                    </label>
                    <ul v-if="menu.menus.length>0">
                        <li v-for="submenu in menu.menus" :key="submenu.id">
                            <label>
                                <input type="checkbox"  :value="submenu.id" v-model="form.menu_id">
                                {{ submenu.nombre }} <small v-if="submenu.enlace">(Enlace: {{ submenu.enlace }})</small>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="row container-fluid text-center" v-if="form.role_nombre">
                    <button type="button" class="btn btn-success" @click="guardar"
                        v-if="$auth.can('menu-role.guardar')">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:['form','menus'],
        data() {
            return {

            }
        },
        methods:{
            guardar() {
                this.$Progress.start()
                this.form.post('api/menu-role-guardar',this.$parent.config)
                .then(respuesta => {
                    swal.fire({icon:'success',text:respuesta.data,title:'Menús/Roles'})
                    .then(respuesta => {
                        if(respuesta.value)
                        {
                            this.form.clear()
                            this.form.reset()
                        }
                    })
                    this.$Progress.finish()
                })
            }
        }
    }
</script>
