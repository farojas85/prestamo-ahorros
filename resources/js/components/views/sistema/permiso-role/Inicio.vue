<template>
    <div class="col-md-12">
        <div class="card mt-3 card-outline card-info">
            <div class="card-header ">
                <h3 class="card-title">
                    Listado Permiso/Roles
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
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-form-label-sm col-md-3">Modelo</label>
                                    <div class="col-md-9">
                                        <select class="form-control form-control-sm" v-model="form.modelo"
                                                @change="mostrarRolePermisos">
                                            <option value="">-SELECCIONAR-</option>
                                            <option v-for="modelo in modelos" :key="modelo.nombre" :value="modelo.nombre" v-text="modelo.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <permiso-role-form :form="form" :permisos="permisos"  v-if="form.role_nombre"></permiso-role-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import PermisoRoleForm from '../permiso-role/Form'
    export default {
        components:{
            'permiso-role-form' : PermisoRoleForm
        },
        data() {
            return {
                roles:[],
                modelos:[],
                form: new form({
                    role_id:'',
                    role_nombre:'',
                    modelo:'',
                    permiso_id:[]
                }),
                permisos:[],
                config:{
                    headers:{'Authorization': 'Bearer ' + localStorage.getItem('token-api')}
                }
            }
        },
        created () {
            this.listarRoles()
            this.listarModelos()
        },
        methods:{
            listarRoles(){
                axios.get('api/role-lista',this.config)
                .then(respuesta => {
                    this.roles = respuesta.data
                })
            },
            listarModelos() {
                axios.get('api/mostrar-modelos',this.config)
                .then(respuesta => {
                    this.modelos = respuesta.data
                })
            },
            mostrarRolePermisos()
            {
                axios.get('api/permiso-roles?role_id='+this.form.role_id,this.config)
                .then(respuesta => {
                    let role =respuesta.data.role
                    let role_permisos = respuesta.data.role_permisos
                    this.form.role_nombre = role.directriz
                    this.form.permiso_id=[]
                    role_permisos.forEach(p => {
                        this.form.permiso_id.push(p.id)
                    });
                    this.listarPermisos()
                })
            },
            listarPermisos()
            {
                this.permisos=[]
                axios.get('api/mostrar-permisos?modelo='+this.form.modelo,this.config)
                .then(respuesta => {
                    this.permisos = respuesta.data
                })
            },
            cambioVista() {
                this.$parent.cambiarVista('permiso-role')
            }
        }
    }
</script>
