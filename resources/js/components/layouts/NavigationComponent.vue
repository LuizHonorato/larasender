<template>
    <v-container>
        <v-navigation-drawer
            id="core-navigation-drawer"
            v-model="drawer"
            color="rgba(0, 0, 0, .8), rgba(0, 0, 0, .8)"
            absolute
            dark
            mobile-break-point="960"
            app
            src="images/illus-email-marketing-3.jpg"
        >

            <template v-slot:img="props">
                <v-img
                    gradient="to bottom, rgba(0, 0, 0, .8), rgba(0, 0, 0, .8)"
                    v-bind="props"
                />
            </template>

            <v-list
                dense
                nav
                class="py-0"
            >
                <v-list-item two-line :class="miniVariant && 'px-0'">
                    <div class="title my-2 login-title">
                        { LARASENDER }
                    </div>
                </v-list-item>

                <v-divider></v-divider>

                <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    link
                    :to="item.to"
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-divider></v-divider>

                <v-list-item
                    v-for="item in systemItems"
                    :key="item.title"
                    link
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-divider></v-divider>

                <v-list-item v-on:click="logout()">
                    <v-list-item-icon>
                        <v-icon>mdi-logout-variant</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>Sair</v-list-item-title>
                    </v-list-item-content>

                </v-list-item>

            </v-list>
        </v-navigation-drawer>
    </v-container>
</template>

<script>
    export default {
        name: "NavigationComponent",
        props: {
            expandOnHover: {
                type: Boolean,
                default: false,
            },
        },
        data () {
            return {
                items: [
                    { title: 'Dashboard', icon: 'mdi-view-dashboard', to: '/dashboard' },
                    { title: 'Contatos', icon: 'mdi-account-circle-outline', to: '/contatos' },
                    { title: 'E-mails', icon: 'mdi-email-multiple-outline', to: '/emails' },
                    { title: 'Campanhas', icon: 'mdi-bullhorn-outline', to: '/campanhas'},
                    { title: 'Templates de e-mails', icon: 'mdi-chart-tree', to: '/templates'},
                    { title: 'Landing pages', icon: 'mdi-rocket-outline', to: '/landing-pages'},

                ],
                systemItems: [
                    { title: 'Configurações do sistema', icon: 'mdi-cog' },
                    { title: 'Usuários', icon: 'mdi-account-multiple' },
                    { title: 'Ajuda', icon: 'mdi-help' },
                ],
                right: false,
                miniVariant: false,
            }
        },

        computed: {
            drawer: {
                get () {
                    return this.$store.state.drawer.drawer
                },
                set (val) {
                    this.$store.commit('SET_DRAWER', val)
                },
            },
        },

        methods: {
            logout: function () {
                this.$store.dispatch('logout')
            }
        }
    }
</script>

<style lang="sass">
    @import '~vuetify/src/styles/tools/_rtl.sass'

    #core-navigation-drawer
        .v-list-group__header.v-list-item--active:before
            opacity: .24

        .v-list-item
            &__icon--text,
            &__icon:first-child
                justify-content: center
                text-align: center
                width: 20px

                +ltr()
                    margin-right: 24px
                    margin-left: 12px !important

                +rtl()
                    margin-left: 24px
                    margin-right: 12px !important

        .v-list--dense
            .v-list-item
                &__icon--text,
                &__icon:first-child
                    margin-top: 10px

        .v-list-group--sub-group
            .v-list-item
                +ltr()
                    padding-left: 8px

                +rtl()
                    padding-right: 8px

            .v-list-group__header
                +ltr()
                    padding-right: 0

                +rtl()
                    padding-right: 0

                .v-list-item__icon--text
                    margin-top: 19px
                    order: 0

                .v-list-group__header__prepend-icon
                    order: 2

                    +ltr()
                        margin-right: 8px

                    +rtl()
                        margin-left: 8px
</style>
