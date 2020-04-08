<template>
    <v-app-bar
        id="app-bar"
        absolute
        app
        color="transparent"
        flat
        height="75"
    >

        <v-btn
            class="mr-3"
            color="#fff"
            elevation="0"
            fab
            small
            v-on:click="setDrawer(!drawer.drawer)"
        >
            <v-icon v-if="value">
                mdi-view-quilt
            </v-icon>

            <v-icon v-else>
                mdi-menu
            </v-icon>
        </v-btn>

        <v-toolbar-title
            class="hidden-sm-and-down font-weight-light"
            v-text="$route.name"
        />

    </v-app-bar>
</template>

<script>
    import { mapState, mapMutations } from 'vuex';

    export default {
        name: "AppBarComponent",

        props: {
            value: {
                type: Boolean,
                default: false,
            },
        },

        computed: {
            ...mapState(['drawer']),
        },

        methods: {
            ...mapMutations({
                setDrawer: 'SET_DRAWER',
            }),
        }
    }
</script>

<style scoped>

</style>
