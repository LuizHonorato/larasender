<template>
    <Navigation />
</template>

<script>
    import Navigation from '../components/layouts/NavigationComponent'
    export default {
        name: "Dashboard",
        components: {Navigation},
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
