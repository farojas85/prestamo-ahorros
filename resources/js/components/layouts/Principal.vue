<template>
    <div class="wrapper">
        <NavBar></NavBar>
        <SideBar :ruta="this.ruta"></SideBar>
        <div class="content-wrapper">
            <router-view></router-view>
        </div>
        <Footer></Footer>
        <RightBar></RightBar>
    </div>
</template>
<script>
    import NavBar from './navbar'
    import SideBar from './Sidebar'
    import ContentHeader from './ContentHeader'
    import Footer from './Footer'
    import RightBar from './RightBar'
    export default {
        components: {NavBar,SideBar,ContentHeader,Footer,RightBar},
        data() {
            return{
                ruta:this.$route
            }
        }
    }

</script>
