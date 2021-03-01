<template>
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title" id="card-title-prestamo">
                <span v-if="form.estadoCrud=='crear'">
                    Nuevo
                </span>
                <span v-else-if="form.estadoCrud=='editar'">
                    Editar
                </span> Pr&eacute;stamo
                <button type="button" class="btn btn-success btn-sm" @click="$parent.nuevo('')"
                        v-if="$auth.can('prestamos.crear')">
                    <i class="fas fa-undo-alt"></i> Retornar
                </button>
            </h3>
        </div>
        <div class="card-body">
            <form id="form-prestamo" @submit.prevent="guardarPrestamo">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <div class="card card-info border border-info">
                            <div class="card-header">
                                <h3 class="card-title">Datos Cliente / Cobrador</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="nombre" class="col-form-label  col-form-label-sm col-md-1 text-right">Cliente</label>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <button class="btn bg-danger" title="Nuevo Cliente" @click="nuevoCliente" type="button"><i class="fas fa-plus"></i></button>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Nombre Cliente" :value="cliente_seleccionado.nombres+' '+cliente_seleccionado.apellidos">
                                                <div class="input-group-append">
                                                </div>
                                            </div>
                                            <has-error :form="form" field="cliente_id"></has-error>
                                        </div>
                                        <label for="nombre" class="col-form-label col-form-label-sm col-md-1 text-right col-form-label-sm">DNI/RUC</label>
                                        <div class="col-md-4">
                                            <input type="text"  class="form-control form-control-sm" placeholder=" DNI/RUC Cliente" :value="cliente_seleccionado.numero_documento" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <label for="nombre" class="col-form-label col-form-label-sm col-md-1 text-right">Direcci&oacute;n</label>
                                        <div class="col-md-11">
                                            <input type="text"  class="form-control form-control-sm" :value='cliente_seleccionado.direccion' readonly>
                                        </div>
                                    </div>
                                     <div class="row mt-1" v-if="$auth.hasRole('super-usuario') || $auth.hasRole('administrador')">
                                        <label class="col-form-label col-form-label-sm col-md-1 text-right">Cobrador</label>
                                        <div class="col-md-11">
                                            <input type="text"  class="form-control form-control-sm" :value='cliente_seleccionado.cobrador' readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-warning border border-warning">
                            <div class="card-header">
                                <h3 class="card-title">Datos Pr&eacute;stamo</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-4 mb-2">
                                         <div class="row">
                                            <label for="fecha_prestamo" class="col-form-label col-form-label-sm col-md-3">Fecha</label>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control form-control-sm" v-model="form.fecha_prestamo" title="Fecha Préstamo"
                                                    :class="{ 'is-invalid': form.errors.has('fecha_prestamo') }"
                                                    id="fecha_prestamo">
                                                <has-error :form="form" field="fecha_prestamo"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4  mb-2">
                                        <div class="row">
                                            <label for="moneda_id" class="col-form-label col-form-label-sm col-md-3">Moneda</label>
                                            <div class="col-md-9">
                                                <select class="form-control form-control-sm" v-model="form.moneda_id" @change="obtenerTipoCambio">
                                                    <option value="">-SELECCIONAR-</option>
                                                    <option v-for="moneda in monedas" :key="moneda.id" :value="moneda.id"
                                                            v-text="moneda.nombre+' - '+moneda.pais"></option>
                                                </select>
                                                <has-error :form="form" field="moneda_id"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4  mb-2">
                                        <div class="row">
                                            <label for="tipo_cambio" class="col-form-label col-form-label-sm col-md-4">Tipo Cambio</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm" v-model="form.tipo_cambio" title="Tipo Cambio"
                                                    :class="{ 'is-invalid': form.errors.has('tipo_cambio') }"
                                                    placeholder="0.00">
                                                <has-error :form="form" field="tipo_cambio"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4 mb-2">
                                        <div class="row">
                                            <label for="monto" class="col-form-label col-form-label-sm col-md-3">Monto</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" v-model="form.monto" title="Monto"
                                                    :class="{ 'is-invalid': form.errors.has('monto') }" placeholder="0.00">
                                                <has-error :form="form" field="monto"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="row">
                                            <label for="tasa_interese_id" class="col-form-label col-form-label-sm col-md-3">Tasa Int.</label>
                                            <div class="col-md-9">
                                                <select class="form-control form-control-sm"
                                                    v-model="form.tasa_interes_id" @change="calcularImporte">
                                                    <option value="">-TASA INTER&Eacute;S-</option>
                                                    <option v-for="tasa in tasa_intereses" :key="tasa.id" :value="tasa.id"
                                                            v-text="tasa.nombre"></option>
                                                </select>
                                                <has-error :form="form" field="tasa_interes_id"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="row">
                                            <label for="interes" class="col-form-label col-form-label-sm col-md-4">Inter&eacute;s</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm" v-model="form.interes" title="Interés"
                                                    :class="{ 'is-invalid': form.errors.has('interes') }" placeholder="0.00"
                                                    readonly="">
                                                <has-error :form="form" field="interes"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4 mb-2">
                                        <div class="row">
                                            <label for="tipo_cambio" class="col-form-label col-form-label-sm col-md-3">Tipo Ct.</label>
                                            <div class="col-md-9">
                                                <select class="form-control form-control-sm" v-model="form.tipo_cuota_id">
                                                    <option value="">-TIPO CUOTA-</option>
                                                    <option v-for="tipo in tipoCuotas" :key="tipo.id" :value="tipo.id"
                                                            v-text="tipo.nombre"></option>
                                                </select>
                                                <has-error :form="form" field="tipo_cuota_id"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="row">
                                            <label for="numero_cuotas" class="col-form-label col-form-label-sm col-md-3">N. Cuota</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" v-model="form.numero_cuotas"
                                                    placeholder="Número de Cuotas" :class="{ 'is-invalid': form.errors.has('numero_cuotas') }">
                                                <has-error :form="form" field="numero_cuotas"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="form-control form-control-sm" v-model="form.forma_pago_id">
                                                    <option value="">-FORMA COBRANZA-</option>
                                                    <option v-for="tipo in formaPagos" :key="tipo.id" :value="tipo.id"
                                                            v-text="tipo.nombre"></option>
                                                </select>
                                                <has-error :form="form" field="forma_pago_id"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted text-center">
                                <!-- <button type="button" @click="generarPdf">
                                    descargar
                                </button> -->
                                <span v-if="form.estadoCrud!='mostrar'">
                                    <button type="submit" class="btn btn-success">
                                        <span v-if="form.estadoCrud=='crear'"><i class="fas fa-save"></i> Guardar</span>
                                        <span v-else-if="form.estadoCrud=='editar'"><i class="fas fa-sync-alt"></i> Actualizar</span>
                                    </button>
                                </span>
                                <button type="button" class="btn btn-danger" @click="cancelar">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal fade" id="modal-cliente-prestamo">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-cliente-prestamo-title">Default Modal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal-cliente-prestamo-body">
                            <form id="form-cliente" @submit.prevent="guardarCliente">
                                <div class="form-group row">
                                    <label for="nombre" class="col-form-label col-md-3">Tipo Doc.</label>
                                    <div class="col-md-8">
                                        <select class="form-control" v-model="cliente.tipo_documento_id" title="Tipo Documento"
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
                                    <label for="nombre" class="col-form-label col-md-3">Numero Doc.</label>
                                    <div class="col-md-8">
                                        <input type="text" v-model="cliente.numero_documento" id="numero_documento"
                                            placeholder="Número Documento" title="Número Documento"
                                            class="form-control" :class="{ 'is-invalid': cliente.errors.has('numero_documento') }"
                                            @keypress="esNumero" @change="verificarNumeroDocumento" maxlength="15"
                                            :readonly="cliente.estadoCrud=='mostrar'">
                                        <has-error :form="cliente" field="numero_documento"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nombres" class="col-form-label col-md-3">Nombres</label>
                                    <div class="col-md-8">
                                        <input type="text" v-model="cliente.nombres" id="nombres" placeholder="Nombres"
                                            title="Nombres" class="form-control"
                                            :class="{ 'is-invalid': cliente.errors.has('nombres') }"
                                            :readonly="cliente.estadoCrud=='mostrar'">
                                        <has-error :form="cliente" field="nombres"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="apellidos" class="col-form-label col-md-3">Apellidos</label>
                                    <div class="col-md-8">
                                        <input type="text" v-model="cliente.apellidos" id="apellidos" placeholder="Apellidos"
                                            title="Apellidos" class="form-control"
                                            :class="{ 'is-invalid': cliente.errors.has('apellidos') }"
                                            :readonly="cliente.estadoCrud=='mostrar'">
                                        <has-error :form="cliente" field="apellidos"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sexo" class="col-form-label col-md-3">Sexo</label>
                                    <div class="col-md-8">
                                        <select class="form-control" v-model="cliente.sexo" title="Sexo"
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
                                    <label for="telefono" class="col-form-label col-md-3">Tel&eacute;fono</label>
                                    <div class="col-md-8">
                                        <input type="text" v-model="cliente.telefono" id="telefono" placeholder="telefono"
                                            title="Telefono" class="form-control"
                                            :class="{ 'is-invalid': cliente.errors.has('telefono') }"
                                            :readonly="cliente.estadoCrud=='mostrar'">
                                        <has-error :form="cliente" field="telefono"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="direccion" class="col-form-label col-md-3">Direcci&oacute;n</label>
                                    <div class="col-md-8">
                                        <input type="text" v-model="cliente.direccion" id="direccion" placeholder="Dirección"
                                            title="Dirección" class="form-control"
                                            :class="{ 'is-invalid': cliente.errors.has('direccion') }"
                                            :readonly="cliente.estadoCrud=='mostrar'">
                                        <has-error :form="cliente" field="direccion"></has-error>
                                    </div>
                                </div>
                                <div class="form-group row" v-if="$auth.hasRole('administrador') || $auth.hasRole('super-usuario')">
                                    <label for="direccion" class="col-form-label col-md-3">Cobrador</label>
                                     <div class="col-md-8">
                                        <select class="form-control" v-model="cliente.user_id" title="Cobrador"
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
                                    <button type="button" class="btn btn-danger" @click="cancelar">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import ClienteForm from '../ClienteForm'
    export default {
        props:['form'],
        components:{
            'cliente-form':ClienteForm
        },
        data() {
            return {
                config:{
                    headers:{'Authorization': 'Bearer ' + localStorage.getItem('token-api')}
                },
                cliente: new form({
                    id:'',
                    tipo_documento_id:'',
                    numero_documento:'',
                    nombres:'',
                    apellidos:'',
                    sexo:'',
                    telefono:'',
                    direccion:'',
                    valoracion:'',
                    user_id:'',
                    cobrador:'',
                    estadoCrud:''
                }),
                tipoDocumentos:[],
                monedas:[],
                tasa_intereses:[],
                tipoCuotas:[],
                formaPagos:[],
                cliente_seleccionado:{
                    id:'',
                    nombres:'',
                    apellidos:'',
                    numero_documento:'',
                    direccion:'',
                    user_id:(this.$auth.hasRole('cobrador')) ? this.$auth.user.id : '',
                },
                cobradores:[],
                // docPdf: new jsPDF({
                //     orientation: "portrait",
                //     unit: "mm",
                //     format: [4, 2]
                // })
            }
        },
        created() {
            //this.obtenerTipoCambio()
            this.listadoMonedas()
            this.listarTasaInteres()
            this.listarTipoCuotas()
            this.listarFormaPagos()
        },
        methods:{
            cancelar() {
                this.form.reset()
                this.form.clear()
                this.form.estadoCrud =''
            },
            obtenerTipoCambio(e) {
                this.form.tipo_cambio =''
                if(e.target.value != 1)
                {
                    axios.get('/api/prestamo-tipo-cambio',this.$parent.config)
                    .then(respuesta => {
                        this.form.tipo_cambio = respuesta.data.Cotizacion[0].Venta
                    })
                }
            },
            obtenerCobradores() {
                axios.get('api/cobrador-listar',this.$parent.config)
                .then(respuesta => {
                    this.cobradores = respuesta.data
                })
            },
            listadoMonedas()
            {
                axios.get('api/moneda-listar',this.$parent.config)
                .then(respuesta => {
                    this.monedas = respuesta.data
                })
            },
            listarTasaInteres()
            {
                axios.get('api/tasa-interes-listar',this.$parent.config)
                .then(respuesta => {
                    this.tasa_intereses = respuesta.data
                })
            },
            listarTipoCuotas()
            {
                axios.get('api/tipo-cuota-listar',this.$parent.config)
                .then(respuesta => {
                    this.tipoCuotas = respuesta.data
                })
            },
            listarFormaPagos()
            {
                axios.get('api/forma-pago-listar',this.$parent.config)
                .then(respuesta => {
                    this.formaPagos = respuesta.data
                })
            },
            calcularImporte(event)
            {
                axios.get('api/obtener-interes?monto='+this.form.monto+'&tasa='+event.target.value,this.$parent.config)
                .then(respuesta => {
                    this.form.interes = respuesta.data
                })
            },
            nuevoCliente() {
                this.cliente.clear()
                this.cliente.reset()
                this.cliente.estadoCrud = 'crear'
                this.listarTipoDocumentos()
                this.obtenerCobradores()
                $('#modal-cliente-prestamo').modal('show')
                $('#modal-cliente-prestamo-title').html('Nuevo Cliente')
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
            verificarNumeroDocumento(e)
            {
                axios.get('api/cliente-verificar-documento?tipo_documento_id='+this.cliente.tipo_documento_id+'&numero_documento='+e.target.value,this.$parent.config)
                this.cliente.post('api/cliente-verificar-documento',this.config)
                .then(respuesta => {
                    var encontrado = respuesta.data.encontrado
                    var persona_buscar = respuesta.data.persona_buscar
                    var persona = JSON.parse(respuesta.data.persona)

                    $('#tipo_documento_id').addClass('is-valid');
                    $('#numero_documento').addClass('is-valid');

                    if(encontrado == 1)
                    {
                        if(persona_buscar)
                        {
                            this.cliente.id = persona_buscar.cliente_id
                            this.cliente.nombres = persona_buscar.nombres
                            this.cliente.apellidos = persona_buscar.apellidos
                            this.cliente.sexo = persona_buscar.sexo
                            this.cliente.telefono = persona_buscar.telefono
                            this.cliente.direccion =persona_buscar.direccion
                            this.cliente.estadoCrud ='editar'
                            this.cliente.user_id= (persona_buscar.user_id) ? persona_buscar.user_id : ''
                            this.cliente.cobrador = (persona_buscar.user_id) ? persona_buscar.cobrador : ''
                        }
                    } else {
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
            listarTipoDocumentos() {
                axios.get('api/tipo-documento-lista',this.config)
                .then(respuesta => {
                    this.tipoDocumentos=respuesta.data
                })
            },
            guardarCliente() {
                switch(this.cliente.estadoCrud){
                    case 'crear':this.agregarCliente();break;
                    case 'editar':this.actualizarCliente();break;
                }
            },
            agregarCliente() {
                this.cliente.post('api/clientes',this.config)
                .then(respuesta => {
                    if(respuesta.data.ok == 1)
                    {
                        swal.fire({icon:'success',text:respuesta.data.mensaje,title:'Clientes'})
                        window.location='/prestamos'
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
            actualizarCliente() {
                this.cliente.put('api/clientes/'+this.cliente.id,this.$parent.config)
                .then(respuesta => {
                    if(respuesta.data.ok==1)
                    {
                        this.cliente_seleccionado = respuesta.data.cliente
                        this.form.cliente_id = this.cliente_seleccionado.cliente_id
                        $('#modal-cliente-prestamo').modal('hide')
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
            },
            guardarPrestamo() {
                switch(this.form.estadoCrud)
                {
                    case 'crear': this.agregar();break;
                    case 'editar': this.actualizar();break;
                }
            },
            agregar(){
                 this.form.post('api/prestamos',this.$parent.config)
                .then(respuesta => {
                    if(respuesta.data.ok == 1)
                    {
                        swal.fire({icon:'success',text:respuesta.data.mensaje,title:'Préstamos'})
                        this.generarPdf(respuesta.data.prestamo.id)
                        this.$parent.habilitados()
                        window.location="prestamo"
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
                this.form.put('api/prestamos/'+this.form.id,this.$parent.config)
                .then(respuesta => {
                    if(respuesta.data.ok==1)
                    {
                        swal.fire({icon:'success',text:respuesta.data.mensaje,title:'Préstamos'})
                        this.$parent.habilitados()
                        window.location="prestamo"
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
            },
            generarPdf(id)
            {
                window.open('api/prestamo-imprimir-pdf?d='+id,'_BLANK')
            }
        }
    }
</script>
