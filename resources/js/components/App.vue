<template>
   <component :is="layout"></component>
</template>
<script>
    import {mapState} from 'vuex'
    import LandingLayout from './layouts/Landing'
    import LoginLayout from './layouts/Login'
    import PrincipalLayout from './layouts/Principal'

    export default {
        components:{LandingLayout,LoginLayout,PrincipalLayout},
        computed:mapState(['layout'])
    }
</script>
