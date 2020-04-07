<template>
    <v-container>
        <v-navigation-drawer
            color="rgba(0, 0, 0, .8), rgba(0, 0, 0, .8)"
            absolute
            dark
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
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
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
                    { title: 'Dashboard', icon: 'mdi-view-dashboard' },
                    { title: 'Clientes', icon: 'mdi-account-circle-outline' },
                    { title: 'Caixas de e-mail', icon: 'mdi-email-multiple-outline' },
                    { title: 'Campanhas', icon: 'mdi-bullhorn-outline' },
                    { title: 'Templates', icon: 'mdi-chart-tree' },

                ],
                right: false,
                miniVariant: false,
                expandOnHover: false,
            }
        }
    }
</script>

<style scoped>

</style>
