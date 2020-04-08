<template>
    <v-app>
        <AppBar />
        <Navigation />
        <ViewComponent />
    </v-app>
</template>

<script>
    import AppBar from '../components/layouts/AppBarComponent'
    import Navigation from '../components/layouts/NavigationComponent'
    import ViewComponent from '../components/core/ViewComponent'
    export default {
        name: "Dashboard",
        components: {AppBar, Navigation, ViewComponent},
        created() {
            const userInfo = localStorage.getItem('user')
            if(userInfo) {
                const userData = JSON.parse(userInfo)
                this.$store.commit('SET_USER', userData)
            }
        }
    }
</script>

<style scoped>

</style>
