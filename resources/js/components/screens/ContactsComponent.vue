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
                    <v-form ref="form" v-model="isValid">
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
                                                v-model="phone"
                                                v-mask="'(##) #####-####'"
                                                placeholder="Celular"
                                                type="text"
                                                outlined
                                            />
                                        </v-col>
                                        <v-col cols="12" sm="12" md="6" style="text-align: center">
                                            <div v-if="imagePreview != null">
                                                <v-avatar size="62">
                                                    <img
                                                        :src="imagePreview"
                                                        alt="avatar"
                                                    >
                                                </v-avatar>
                                                <v-btn text small color="error" @click="resetImage">Remover</v-btn>
                                            </div>
                                            <div v-else>
                                                <v-file-input
                                                    v-model="profile_pic"
                                                    @change="onFileChange"
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
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDialog">Cancelar</v-btn>
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

                <v-snackbar
                    v-model="snackbarError"
                    :bottom="y === 'right'"
                    color="red"
                    :right="x === 'right'"
                    :timeout="timeout"
                    :top="y === 'right'"
                >
                    {{ snackbarErrorText }}
                    <v-btn
                        color="white"
                        text
                        @click="snackbarError = false"
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
                        <v-icon small @click="dialogDelete = true">
                            mdi-delete
                        </v-icon>

                        <v-dialog
                            v-model="dialogDelete"
                            max-width="290"
                        >
                            <v-card>
                                <v-card-title class="headline">Deseja excluir?</v-card-title>

                                <v-card-text>
                                    Deseja realmente excluir este contato?
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>

                                    <v-btn
                                        color="green darken-1"
                                        text
                                        @click="dialogDelete = false"
                                    >
                                        Não
                                    </v-btn>

                                    <v-btn
                                        color="green darken-1"
                                        text
                                        @click="deleteContact(item.id)"
                                    >
                                        Sim
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>

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
                dialogDelete: false,
                update: false,
                id: '',
                name: '',
                email: '',
                phone: '',
                profile_pic: null,
                imagePreview: null,
                errorMessages: '',
                formHasErrors: false,
                isValid: true,
                color: '',
                mode: '',
                snackbar: false,
                snackbarError: false,
                snackbarErrorText: '',
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
                    this.$store.dispatch('getContacts');
                    this.reset();
                    this.snackbar = true;
                })
                .catch(err => {
                    this.snackbarErrorText = 'Algo errado';
                    this.snackbarError = true;
                });
            },
            edit(id) {
                let _this = this;
                this.$store.dispatch('getContact', id)
                    .then(res => {
                        this.id = res.data.id;
                        this.name = res.data.name;
                        this.email = res.data.email;
                        this.phone = res.data.phone;

                        if(res.data.profile_pic !== 'null') {
                            let path = [`/storage/contacts/${res.data.profile_pic}`];

                            let blob = null;
                            let xhr = new XMLHttpRequest();
                            xhr.open("GET", path[0]);
                            xhr.responseType = "blob";
                            xhr.onload = function () {
                                blob = xhr.response;
                                _this.previewImage(blob);
                            };
                            xhr.send();
                        }

                        this.update = true;

                        this.dialog = true;
                    })
                    .catch(err => {
                        console.log(err);
                        this.snackbarErrorText = 'Algo errado.'
                        this.snackbarError = true;
                    });
            },

            deleteContact(id) {
                this.$store.dispatch('deleteContact', id)
                    .then(res => {
                        this.dialogDelete = false;
                        this.$store.dispatch('getContacts');
                        this.reset();
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
                this.update = false;
                this.resetImage();
            },

            resetImage() {
                this.imagePreview = null;
                this.profile_pic = null;
            },

            closeDialog() {
                this.dialog = false;
                this.$refs.form.reset();
                this.reset();
            },

            onFileChange(e) {
                if(!e) {
                    return;
                }

                this.previewImage(e);
            },

            previewImage(file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        created(){
            this.$store.dispatch('getContacts')
        }
    }
</script>

<style scoped>

</style>
