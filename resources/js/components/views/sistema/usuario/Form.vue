<template>
    <form id="form-role" @submit.prevent="guardar">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-maroon">
                    <div class="card-header">
                        <h3 class="card-title">Datos Personales</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="nombre" class="col-form-label col-md-3">Tipo Doc.</label>
                            <div class="col-md-8">
                                <select class="form-control" v-model="form.tipo_documento_id" title="Tipo Documento"
                                    :class="{ 'is-invalid': form.errors.has('tipo_documento_id') }"
                                    id="tipo_documento_id" @change="cambiarTipo" :disabled="form.estadoCrud=='mostrar'">
                                    <option value="">-SELECCIONAR-</option>
                                    <option v-for="tipo in tipoDocumentos" :key='tipo.id' :value="tipo.id"
                                        :title="tipo.nombre_largo">
                                        {{tipo.nombre_corto}}
                                    </option>
                                </select>
                                <has-error :form="form" field="tipo_documento_id"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombre" class="col-form-label col-md-3">Numero Doc.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="form.numero_documento" id="numero_documento"
                                    placeholder="Número Documento" title="Número Documento"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('numero_documento') }"
                                    @keypress="esNumero" @change="verificarNumeroDocumento" maxlength="15"
                                    :readonly="form.estadoCrud=='mostrar'">
                                <has-error :form="form" field="numero_documento"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombres" class="col-form-label col-md-3">Nombres</label>
                            <div class="col-md-8">
                                <input type="text" v-model="form.nombres" id="nombres" placeholder="Nombres"
                                    title="Nombres" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('nombres') }"
                                    :readonly="form.estadoCrud=='mostrar'">
                                <has-error :form="form" field="nombres"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="apellidos" class="col-form-label col-md-3">Apellidos</label>
                            <div class="col-md-8">
                                <input type="text" v-model="form.apellidos" id="apellidos" placeholder="Apellidos"
                                    title="Apellidos" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('apellidos') }"
                                    :readonly="form.estadoCrud=='mostrar'">
                                <has-error :form="form" field="apellidos"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sexo" class="col-form-label col-md-3">Sexo</label>
                            <div class="col-md-8">
                                <select class="form-control" v-model="form.sexo" title="Sexo"
                                    :class="{ 'is-invalid': form.errors.has('sexo') }"
                                    id="sexo" :disabled="form.estadoCrud=='mostrar'">
                                    <option value="">-SELECCIONAR-</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                                <has-error :form="form" field="sexo"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telefono" class="col-form-label col-md-3">Tel&eacute;fono</label>
                            <div class="col-md-8">
                                <input type="text" v-model="form.telefono" id="telefono" placeholder="telefono"
                                    title="Telefono" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('telefono') }"
                                    :readonly="form.estadoCrud=='mostrar'">
                                <has-error :form="form" field="telefono"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="direccion" class="col-form-label col-md-3">Direcci&oacute;n</label>
                            <div class="col-md-8">
                                <input type="text" v-model="form.direccion" id="direccion" placeholder="Dirección"
                                    title="Dirección" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('direccion') }"
                                    :readonly="form.estadoCrud=='mostrar'">
                                <has-error :form="form" field="direccion"></has-error>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Datos Usuarios</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-form-label col-md-3">Nombre Usu.</label>
                            <div class="col-md-8">
                                <input type="text" v-model="form.name" id="name" placeholder="Nombre Usuario"
                                    title="Nombre Usuario" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('name') }"
                                    :readonly="form.estadoCrud=='mostrar'">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-form-label col-md-3">Correo Elec.</label>
                            <div class="col-md-8">
                                <input type="email" v-model="form.email" id="email" placeholder="Correo Electrónico"
                                    title="Correo Electrónico" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('email') }"
                                    :readonly="form.estadoCrud=='mostrar'">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                        </div>
                        <div class="form-group row" v-if="form.estadoCrud=='crear'">
                            <label for="password" class="col-form-label col-md-3">Contrase&ntilde;a</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="password" v-model="form.password" id="password" placeholder="Contraseña"
                                        title="Contraseña" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('password') }"
                                        v-if="pass_view==false" >
                                    <input type="text" v-model="form.password" id="password" placeholder="Contraseña"
                                        title="Contraseña" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('password') }"
                                        v-else>
                                    <div class="input-group-append" @click="verContrasena">
                                        <span class="input-group-text bg-info" style="cursor:pointer">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <has-error :form="form" field="password"></has-error>
                            </div>
                        </div>
                        <div class="form-group row" v-if="form.estadoCrud=='crear'">
                            <label for="password_confirmation" class="col-form-label col-md-3">Repite Contraseña</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="password" v-model="form.password_confirmation" id="password_confirmation" placeholder="Repite Contraseña"
                                        title="Repite Contraseña" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                                        v-if="!repite_pass">
                                    <input type="text" v-model="form.password_confirmation" id="password_confirmation" placeholder="Repite Contraseña"
                                        title="Repite Contraseña" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                                        v-else>
                                    <div class="input-group-append" @click="verRepiteContrasena">
                                        <span class="input-group-text bg-info" style="cursor:pointer">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <has-error :form="form" field="password_confirmation"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <h3 class="col-md-12">Roles</h3>
                            <div class="form-group" v-for="rol in roles" :key="rol.id">
                                <input type="checkbox" v-model="form.role_id" :value="rol.id" >
                                <label class="form-check-label">{{ rol.nombre }}</label>
                                &nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer ">
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
            antNum:0,
            tipoDocumentos:[],
            roles:[],
            pass_view:false,
            repite_pass:false
        }
    },
    created() {
        this.listarTipoDocumentos()
        this.listarRoles()
    },
    methods:{
        esNumero: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
        listarTipoDocumentos() {
            axios.get('api/tipo-documento-lista',this.$parent.config)
            .then(respuesta => {
                this.tipoDocumentos=respuesta.data
            })
        },
        listarRoles()
        {
            axios.get('api/role-lista',this.$parent.config)
            .then(respuesta => {
                this.roles = respuesta.data
            })
        },
        cambiarTipo()
        {
            this.form.numero_documento =''
            this.form.nombres = ''
            this.form.apellidos=''
            $('#tipo_documento_id').removeClass('is-valid');
            $('#numero_documento').removeClass('is-valid');
            $('#nombres').removeClass('is-valid');
            $('#apellidos').removeClass('is-valid');
        },
        verificarNumeroDocumento()
        {
            this.form.post('api/verificar-numero-documento',this.$parent.config)
            .then(respuesta => {
                let persona = respuesta.data
                $('#tipo_documento_id').addClass('is-valid');
                $('#numero_documento').addClass('is-valid');
                if(persona)
                {
                    if(this.form.numero_documento.length == 8)
                    {
                        this.form.nombres   = persona.nombres
                        this.form.apellidos = persona.apellidoPaterno+' '+persona.apellidoMaterno
                        $('#nombres').addClass('is-valid');
                        $('#apellidos').addClass('is-valid');
                    }
                    else if(this.form.numero_documento.length == 11)
                    {
                        this.form.nombres   = persona.razonSocial
                        this.form.apellidos = '*'
                        $('#nombres').addClass('is-valid');
                    }
                }
            })
            .catch(error => {
                if(error.response.status == 422)
                {
                    console.clear()
                } else {
                    swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                }
            })
        },
        verContrasena()
        {
            this.pass_view = !this.pass_view
        },
        verRepiteContrasena()
        {
            this.repite_pass = !this.repite_pass
        },
        guardar() {
            switch(this.form.estadoCrud)
            {
                case 'crear': this.agregar();break;
                case 'editar': this.actualizar();break;
            }
        },
        agregar()
        {
            this.$Progress.start()
            this.form.post('api/user',this.$parent.config)
            .then(respuesta => {
                $('#modal-usuario').modal('hide')
                swal.fire({icon:'success',text:respuesta.data,title:'Usuarios'})
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
        actualizar()
        {
            this.$Progress.start()
            this.form.put('api/user/'+this.form.id,this.$parent.config)
            .then(respuesta => {
                $('#modal-usuario').modal('hide')
                swal.fire({icon:'success',text:respuesta.data,title:'Usuarios'})
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
