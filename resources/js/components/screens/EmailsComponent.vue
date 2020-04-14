<template>
    <v-container>
        <v-row>
            <v-col cols="12" sm="12" md="6">
                <v-text-field
                    placeholder="Pesquisar e-mail"
                    type="text"
                    outlined
                    prepend-inner-icon="mdi-magnify"
                />
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="1">
                <v-dialog v-model="dialog" persistent max-width="600px">
                    <template v-slot:activator="{ on }">
                        <v-btn color="primary" v-on="on">Novo e-mail</v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">Escrever e-mail</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                        
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="dialog = false">Cancelar</v-btn>
                            <v-btn color="blue darken-1" text @click="dialog = false">Enviar</v-btn>
                        </v-card-actions>
                    </v-card>

                </v-dialog>
            </v-col>
        </v-row>

        <v-divider></v-divider>

        <v-row>
            <v-col cols="12" v-if="email.emails.length > 0">
                <p>tem e-mail</p>
            </v-col>
            <v-col cols="12" v-else>
                <div class="d-flex justify-center align-center subtitle-1">
                    <strong class="blue-grey--text text--lighten-3">Nenhum e-mail no momento</strong>
                </div>
            </v-col>
        </v-row>

    </v-container>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "EmailsComponent",
        data: function() {
            return {
                dialog: false
            }
        },
        computed: {
            ...mapState(['email']),
        },
        created(){
            this.$store.dispatch('getEmails')
        }
    }
</script>

<style scoped>

</style>
