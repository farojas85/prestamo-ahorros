import Landing from './components/views/Landing'
import Login from './components/views/Login'
import Principal from './components/views/Principal'
import Sistema from './components/views/sistema/Inicio'
import Configuracion from './components/views/configuracion/Inicio'
import Prestamo from './components/views/prestamo/Inicio'
import Cobranza from './components/views/cobranza/Inicio'

let routes = [
    { path: '/',name:'Landing', component: Landing },
    { path:'/login',name:'Login', component: Login},
    { path:'/principal',name:'Principal', component: Principal,meta:{descripcion:'Principal',icono:'fas fa-th'}},
    { path: '/sistema',name:"Sistema", component: Sistema, meta:{ descripcion: 'Configuraciones Sistema',icono:'fab fa-windows'}},
    { path: '/configuracion',name:"Configuracion",component: Configuracion,meta:{descripcion:'Configuraciones Módulos',icono:'fas fa-cogs'}},
    { path: '/prestamo',name:"Prestamo",component: Prestamo,meta:{descripcion:'Préstamos',icono:'fas fa-money-bill-alt'}},
    { path: '/cobranza',name:"Cobranza",component: Cobranza,meta:{descripcion:'Cobranzas',icono:'fas fa-shopping-bag'}}

]

export default routes
