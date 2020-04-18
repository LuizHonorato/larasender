<template>
    <v-container>
        <v-row>
            <v-col cols="12" sm="12" md="6">
                <v-text-field
                    placeholder="Pesquisar contatos"
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
                        <v-btn color="primary" v-on="on">Novo contato</v-btn>
                    </template>
                    <v-form v-model="isValid">
                        <v-card>
                            <v-card-title>
                                <span class="headline">Inserindo contato</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <input type="hidden" name="id" v-model="id" />
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                ref="name"
                                                v-model="name"
                                                placeholder="Nome"
                                                type="text"
                                                :rules="[() => !!name || 'Esse campo é obrigatório']"
                                                outlined
                                            />
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                ref="email"
                                                v-model="email"
                                                placeholder="E-mail"
                                                type="text"
                                                :rules="[() => !!email || 'Esse campo é obrigatório']"
                                                outlined
                                            />
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12" sm="12" md="6">
                                            <v-text-field
                                                ref="phone"
                                                v-model="phone"
                                                v-mask="'(##) #####-####'"
                                                placeholder="Celular"
                                                type="text"
                                                outlined
                                            />
                                        </v-col>
                                        <v-col cols="12" sm="12" md="6">
                                            <v-file-input
                                                ref="profile_pic"
                                                v-model="profile_pic"
                                                color="deep-purple accent-4"
                                                placeholder="Selecione uma foto"
                                                prepend-icon=""
                                                prepend-inner-icon="mdi-camera"
                                                outlined
                                                :show-size="1000">
                                                <template v-slot:selection="{ index, text }">
                                                    <v-chip
                                                        color="deep-purple accent-4"
                                                        dark
                                                        label
                                                        small
                                                    >
                                                        {{ text }}
                                                    </v-chip>
                                                </template>
                                            </v-file-input>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="dialog = false">Cancelar</v-btn>
                                <v-btn color="blue darken-1" :disabled="!isValid" text @click="submit()">Salvar</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-form>
                </v-dialog>

                <v-snackbar
                    v-model="snackbar"
                    :bottom="y === 'right'"
                    :color="color"
                    :right="x === 'right'"
                    :timeout="timeout"
                    :top="y === 'right'"
                >
                    {{ snackbarText }}
                    <v-btn
                        color="red"
                        text
                        @click="snackbar = false"
                    >
                        Fechar
                    </v-btn>
                </v-snackbar>

            </v-col>
        </v-row>

        <v-divider></v-divider>

        <v-row>
            <v-col cols="12" v-if="contacts.contacts.length > 0">
                <v-data-table
                    :headers="headers"
                    :items="this.contacts.contacts"
                    :items-per-page="5"
                    locale="pt">
                    <template v-slot:item.actions="{ item }">
                        <v-icon
                            small
                            class="mr-2"
                            @click="edit(item.id)"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon small>
                            mdi-delete
                        </v-icon>
                    </template>
                </v-data-table>
            </v-col>
            <v-col cols="12" v-else>
                <div class="d-flex justify-center align-center subtitle-1">
                    <strong class="blue-grey--text text--lighten-3">Nenhum contato cadastrado</strong>
                </div>
            </v-col>
        </v-row>

    </v-container>
</template>

<script>
    import {mapState} from "vuex";
    import {mask} from 'vue-the-mask'

    export default {
        name: "ContactsComponent",
        directives: {mask},
        data: function() {
            return {
                dialog: false,
                update: false,
                id: '',
                name: '',
                email: '',
                phone: '',
                profile_pic: null,
                errorMessages: '',
                formHasErrors: false,
                isValid: true,
                color: '',
                mode: '',
                snackbar: false,
                snackbarText: 'Contato salvo com sucesso',
                timeout: 6000,
                x: 'right',
                y: 'top',
                headers: [
                    {
                        text: 'ID',
                        align: 'start',
                        sortable: true,
                        value: 'id',
                    },
                    {
                        text: 'Nome',
                        align: 'start',
                        sortable: false,
                        value: 'name',
                    },
                    {
                        text: 'E-mail',
                        align: 'start',
                        sortable: false,
                        value: 'email',
                    },
                    {
                        text: 'Ações',
                        align: 'start',
                        sortable: false,
                        value: 'actions',
                    },
                ]
            }
        },
        computed: {
            ...mapState(['contacts']),
            form () {
                return {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    profile_pic: this.profile_pic
                }
            },
        },
        methods: {
            submit() {
                this.formHasErrors = false;

                Object.keys(this.form).forEach(f => {
                    if (!this.form[f]) this.formHasErrors = true;

                    this.$refs[f].validate(true);
                });

                let action = this.update ? 'updateContact' : 'storeContact';

                this.$store.dispatch(action, {
                    id: this.id,
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    profile_pic: this.profile_pic
                })
                .then(() => {
                    this.dialog = false;
                    this.update = false;
                    this.$store.dispatch('getContacts');
                    this.reset();
                    this.snackbar = true;
                })
                .catch(err => {
                    console.log(err)
                });
            },
            edit(id) {
                this.$store.dispatch('getContact', id)
                    .then(res => {
                        this.id = res.data.id;
                        this.name = res.data.name;
                        this.email = res.data.email;
                        this.phone = res.data.phone;
                        //this.profile_pic = res.data.profile_pic;

                        this.update = true;

                        this.dialog = true;
                    })
                    .catch(err => console.log(err));
            },
            reset () {
                this.errorMessages = [];
                this.formHasErrors = false;
                this.id = '';
                this.name = '';
                this.email = '';
                this.phone = '';
                this.profile_pic = null;
            },
        },
        created(){
            this.$store.dispatch('getContacts')
        }
    }
</script>

<style scoped>

</style>
