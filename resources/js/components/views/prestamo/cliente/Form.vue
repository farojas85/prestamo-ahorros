<template>
    <form id="form-cliente" @submit.prevent="guardar">
        <div class="form group row text-center" v-if="cliente.valora">
            <div class="col-md-12">
                <i :class="cliente.valora.icono+' '+cliente.valora.clase+' fa-2x'"></i>
            </div>
             <div class="col-md-12">
                {{ cliente.valora.nombre }}
            </div>
        </div>
        <div class="form-group row mt-2">
            <label for="nombre" class="col-form-label col-form-label-sm col-md-3">Tipo Doc.</label>
            <div class="col-md-8">
                <select class="form-control form-control-sm" v-model="cliente.tipo_documento_id" title="Tipo Documento"
                    :class="{ 'is-invalid': cliente.errors.has('tipo_documento_id') }"
                    id="tipo_documento_id" @change="cambiarTipo" :disabled="cliente.estadoCrud=='mostrar'">
                    <option value="">-SELECCIONAR-</option>
                    <option v-for="tipo in tipoDocumentos" :key='tipo.id' :value="tipo.id"
                        :title="tipo.nombre_largo">
                        {{tipo.nombre_corto}}
                    </option>
                </select>
                <has-error :form="cliente" field="tipo_documento_id"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="nombre" class="col-form-label col-form-label-sm col-md-3">Numero Doc.</label>
            <div class="col-md-8">
                <input type="text" v-model="cliente.numero_documento" id="numero_documento"
                    placeholder="Número Documento" title="Número Documento"
                    class="form-control form-control-sm" :class="{ 'is-invalid': cliente.errors.has('numero_documento') }"
                    @keypress="esNumero" @change="verificarNumeroDocumento" maxlength="15"
                    :readonly="cliente.estadoCrud=='mostrar'">
                <has-error :form="cliente" field="numero_documento"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="nombres" class="col-form-label col-form-label-sm col-md-3">Nombres</label>
            <div class="col-md-8">
                <input type="text" v-model="cliente.nombres" id="nombres" placeholder="Nombres"
                    title="Nombres" class="form-control form-control-sm"
                    :class="{ 'is-invalid': cliente.errors.has('nombres') }"
                    :readonly="cliente.estadoCrud=='mostrar'">
                <has-error :form="cliente" field="nombres"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="apellidos" class="col-form-label col-form-label-sm col-md-3">Apellidos</label>
            <div class="col-md-8">
                <input type="text" v-model="cliente.apellidos" id="apellidos" placeholder="Apellidos"
                    title="Apellidos" class="form-control form-control-sm"
                    :class="{ 'is-invalid': cliente.errors.has('apellidos') }"
                    :readonly="cliente.estadoCrud=='mostrar'">
                <has-error :form="cliente" field="apellidos"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="sexo" class="col-form-label col-form-label-sm col-md-3">Sexo</label>
            <div class="col-md-8">
                <select class="form-control form-control-sm" v-model="cliente.sexo" title="Sexo"
                    :class="{ 'is-invalid': cliente.errors.has('sexo') }"
                    id="sexo" :disabled="cliente.estadoCrud=='mostrar'">
                    <option value="">-SELECCIONAR-</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
                <has-error :form="cliente" field="sexo"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="telefono" class="col-form-label col-form-label-sm col-md-3">Tel&eacute;fono</label>
            <div class="col-md-8">
                <input type="text" v-model="cliente.telefono" id="telefono" placeholder="telefono"
                    title="Telefono" class="form-control form-control-sm"
                    :class="{ 'is-invalid': cliente.errors.has('telefono') }"
                    :readonly="cliente.estadoCrud=='mostrar'">
                <has-error :form="cliente" field="telefono"></has-error>
            </div>
        </div>
        <div class="form-group row">
            <label for="direccion" class="col-form-label col-form-label-sm col-md-3">Direcci&oacute;n</label>
            <div class="col-md-8">
                <input type="text" v-model="cliente.direccion" id="direccion" placeholder="Dirección"
                    title="Dirección" class="form-control form-control-sm"
                    :class="{ 'is-invalid': cliente.errors.has('direccion') }"
                    :readonly="cliente.estadoCrud=='mostrar'">
                <has-error :form="cliente" field="direccion"></has-error>
            </div>
        </div>
        <div class="form-group row">
        <label class="col-form-label col-form-label-sm col-md-3">Cobrador</label>
            <div class="col-md-8">
            <select class="form-control form-control-sm" v-model="cliente.user_id" title="Cobrador"
                :class="{ 'is-invalid': cliente.errors.has('user_id') }"
                id="user_id"  :disabled="cliente.estadoCrud=='mostrar'">
                <option value="">-SELECCIONAR-</option>
                <option v-for="cobrador in cobradores" :key='cobrador.id' :value="cobrador.id">
                    {{cobrador.nombre}}
                </option>
            </select>
            <has-error :form="cliente" field="user_id"></has-error>
        </div>
    </div>
        <div class="modal-footer ">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-times"></i> Cerrar
            </button>
            <span v-if="cliente.estadoCrud!='mostrar'">
                <button type="submit" class="btn btn-success">
                    <span v-if="cliente.estadoCrud=='crear'"><i class="fas fa-save"></i> Guardar</span>
                    <span v-else-if="cliente.estadoCrud=='editar'"><i class="fas fa-sync-alt"></i> Actualizar</span>
                </button>
            </span>
        </div>
    </form>
</template>
<script>
    export default {
        props:['cliente'],
        data() {
            return {
                tipoDocumentos:[],
                cobradores:[],
                config:{
                    headers:{'Authorization': 'Bearer ' + localStorage.getItem('token-api')}
                }
            }
        },
        created() {
            this.listarTipoDocumentos()
            this.obtenerCobradores()
        },
        methods:{
            obtenerCobradores() {
                axios.get('api/cobrador-listar',this.$parent.config)
                .then(respuesta => {
                    this.cobradores = respuesta.data
                })
            },
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
                axios.get('api/tipo-documento-lista',this.config)
                .then(respuesta => {
                    this.tipoDocumentos=respuesta.data
                })
            },
            cambiarTipo()
            {
                this.cliente.numero_documento =''
                this.cliente.nombres = ''
                this.cliente.apellidos=''
                $('#tipo_documento_id').removeClass('is-valid');
                $('#numero_documento').removeClass('is-valid');
                $('#nombres').removeClass('is-valid');
                $('#apellidos').removeClass('is-valid');
            },
            verificarNumeroDocumento()
            {
                this.cliente.post('api/verificar-numero-documento',this.config)
                .then(respuesta => {
                    var persona = respuesta.data
                    $('#tipo_documento_id').addClass('is-valid');
                    $('#numero_documento').addClass('is-valid');
                    if(persona)
                    {
                        if(this.cliente.numero_documento.length == 8)
                        {
                            this.cliente.nombres   = persona.nombres
                            this.cliente.apellidos = persona.apellidoPaterno+' '+persona.apellidoMaterno
                            $('#nombres').addClass('is-valid');
                            $('#apellidos').addClass('is-valid');
                        }
                        else if(this.cliente.numero_documento.length == 11)
                        {
                            this.cliente.nombres   = persona.razonSocial
                            this.cliente.apellidos = '*'
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
            guardar() {
                switch(this.cliente.estadoCrud)
                {
                    case 'crear': this.agregar();break;
                    case 'editar': this.actualizar();break;
                }
            },
            agregar()
            {
                this.cliente.post('api/clientes',this.config)
                .then(respuesta => {
                    if(respuesta.data.ok == 1)
                    {
                        swal.fire({icon:'success',text:respuesta.data.mensaje,title:'Clientes'})
                        this.$parent.habilitados()
                        $('#modal-cliente').modal('hide')
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
            actualizar()
            {
                this.cliente.put('api/clientes/'+this.cliente.id,this.$parent.config)
                .then(respuesta => {
                    if(respuesta.data.ok==1)
                    {
                        swal.fire({icon:'success',text:respuesta.data.mensaje,title:'Clientes'})
                        this.$parent.habilitados()
                        $('#modal-cliente').modal('hide')
                    }
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
