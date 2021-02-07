<template>
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h3">{{ empresa }}</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Iniciar Sesi&oacute;n</p>
                <form id="form-login" @submit.prevent="loginUser">
                    <input type="hidden" v-model="form.id">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nombre de Usuario" id="name"
                                    name="name" v-model="form.name"
                                    :class="{ 'is-invalid': form.errors.has('name') }">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                                <has-error :form="form" field="name"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Contraseña"
                                        v-model="form.password"
                                         :class="{ 'is-invalid': form.errors.has('password') }">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                <has-error :form="form" field="password"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8">
                            <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Recordarme
                            </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-block">Acceder</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        created()
        {
            this.$store.commit('SET_LAYOUT','login-layout')
        },
        data() {
            return{
                empresa:process.env.MIX_EMPRESA,
                form: new form({
                    id:'',
                    name:'',
                    password:''
                }),
            }
        },
        methods:{
            loginUser()
            {
                this.$Progress.start()
                this.form.post('api/login-user')
                .then(respuesta=>{
                    //console.log(respuesta.data)
                    if(respuesta.data.token)
                    {
                        localStorage.setItem('token-api',respuesta.data.token)
                    }
                    if(respuesta.data.user){
                        localStorage.setItem('user-logged',JSON.stringify(respuesta.data.user))
                        this.$router.push('/principal')
                    }
                    this.$Progress.finish()
                })
                .catch(error => {
                    if(error.response.status == 422)
                    {
                        this.$Progress.fail()
                        console.clear()
                    } else {
                        //swal.fire('Error', `Ocurrió un Error: ${error.response.status}`,'error')
                    }
                })
            }
        }
    }
</script>
