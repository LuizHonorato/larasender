<template>
    <h1>Dashboard</h1>
</template>

<script>
    export default {
        name: "Dashboard",

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
