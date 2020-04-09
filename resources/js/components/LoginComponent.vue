<template>
    <v-form style="height: 100%;">
        <v-container style="height: 100%;">
            <v-row style="height: 100%;"
                   align="center"
                   justify="center"
            >
                <v-col cols="12" sm="12" md="6" order="2" order-sm="1">
                    <v-row
                        align="center"
                        justify="center"
                    >
                        <v-img src="images/illus-email-marketing-2.jpg" aspect-ratio="1.7" />
                    </v-row>
                </v-col>
                <v-col cols="12" sm="12" md="6" order="1" order-sm="2">
                    <v-row
                        align="center"
                        justify="center"
                    >
                        <div class="display-1 my-2 login-title">
                            { LARASENDER }
                        </div>
                        <v-col cols="12" sm="6" md="8">
                            <v-text-field
                                label="E-mail"
                                v-model="email"
                                type="email"
                                outlined
                            />
                            <v-text-field
                                label="Senha"
                                v-model="password"
                                type="password"
                                outlined
                            />
                            <div class="my-md-2">
                                <v-btn depressed large block color="primary" @click="login()">Entrar</v-btn>
                            </div>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
    </v-form>
</template>

<script>
    export default {
        name: "LoginComponent",
        data: function() {
            return {
                email: '',
                password: ''
            }
        },
        methods: {
            login: function () {
                this.$store.dispatch('login', {
                    email: this.email,
                    password: this.password
                })
                .then(() => {
                    this.$router.push({name: 'Dashboard'})
                })
                .catch(err => {
                    console.log(err)
                })
            }
        }
    }
</script>

<style scoped>
    * {
        background-color: #fff;
    }
</style>
