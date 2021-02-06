<template>
    <div class="col-md-12">
        <div class="card mt-3 card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado Menús/Roles
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card border border-danger">
                            <div class="card-header bg-maroon">
                                <h3 class="card-title">Roles</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-form-label-sm col-md-3">Rol</label>
                                    <div class="col-md-9">
                                        <select class="form-control form-control-sm" v-model='form.role_id'
                                                :class="{ 'is-invalid': form.errors.has('role_id') }">
                                            <option value="">-SELECCIONAR-</option>
                                            <option v-for="rol in roles" :key="rol.nombre" :value="rol.id" v-text="rol.directriz"></option>
                                        </select>
                                        <has-error :form="form" field="role_id"></has-error>
                                    </div>
                                </div>
                                <div class="form group row text-center">
                                    <div class="col-md-12">
                                        <button class="btn btn-success" type="button" @click="mostrarRoleMenus">
                                            <i class="fas fa-check"></i> Asignar Men&uacute;s
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <menu-role-form :form="form" :menus="menus" v-if="form.role_nombre"></menu-role-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import MenuRoleForm from '../menu-role/Form'
    export default {
        components:{
            'menu-role-form':MenuRoleForm
        },
        data(){
            return{
                roles:[],
                form : new form({
                    role_id:'',
                    role_nombre:'',
                    menu_id:[]
                }),
                menus:[],
                config:{
                    headers:{'Authorization': 'Bearer ' + localStorage.getItem('token-api')}
                }
            }
        },
        created() {
            this.listarRoles()
        },
        methods:{
            listarRoles(){
                axios.get('api/role-lista',this.config)
                .then(respuesta => {
                    this.roles = respuesta.data
                })
            },
            mostrarRoleMenus()
            {
                this.form.get('api/menu-roles?role_id='+this.form.role_id,this.config)
                .then(respuesta => {
                    let role =respuesta.data.role
                    this.form.role_nombre = role.directriz
                    this.form.menu_id=[]
                    if(role.menus)
                    {
                        role.menus.forEach(m => {
                            this.form.menu_id.push(m.id)
                        })
                    }
                    this.listarMenus()
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
            listarMenus() {
                this.menus =[]
                axios.get('api/mostrar-menus',this.config)
                .then(respuesta => {
                    this.menus = respuesta.data
                })
            }
        }
    }
</script>
