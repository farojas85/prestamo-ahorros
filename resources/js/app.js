require('./bootstrap');

import VueRouter from 'vue-router'
//import VueAxios from 'vue-axios'
// import Axios from 'axios'
import Form  from 'vform'
import * as VeeValidate from 'vee-validate'
import es from 'vee-validate/dist/locale/es'
import Swal from 'sweetalert2'
import VueProgressBar from 'vue-progressbar'
import App from './components/App.vue'
import {store} from './store'
import routes from './routes'
import Auth from './auth'
import moment from 'moment-timezone/builds/moment-timezone-with-data'
import { jsPDF } from "jspdf";

window.Vue = require('vue')
window.swal = Swal
window.form = Form
window.moment = moment
window.jsPDF = jsPDF

Vue.prototype.$auth = new Auth(localStorage.getItem('user-logged'));

Vue.use(VueRouter)
Vue.use(VeeValidate);
VeeValidate.localize("es",es)
Vue.use(VueProgressBar,{
    color: 'rgb(143,255,199)',
    failedColor: 'red',
    height: '30px'
})

//Vue.use(VueAxios)
//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//Pequeñas ALertas
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
})
window.toast = toast

require('./componentes')
require('./filtros')

const router = new VueRouter({
    mode:'history',
    routes
})

const app = new Vue({
    el: '#app',
    store,
    router,
    render: h=> h(App)
});
