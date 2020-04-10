<template>
    <v-container>
        <v-row>
            <v-col cols="12" sm="12" md="6">
                <v-text-field
                    placeholder="Buscar campanhas..."
                    type="text"
                    outlined
                    prepend-inner-icon="mdi-magnify"
                />
            </v-col>
            <v-col cols="2" sm="2" md="1">
                <div class="title my-md-2 mx-md-4 login-title">
                    ou
                </div>
            </v-col>
            <v-col class="mt-md-2" cols="5" sm="5" md="2">
                <v-menu
                    ref="startMenu"
                    v-model="startMenu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    :return-value.sync="start"
                    transition="scale-transition"
                    offset-y
                >
                    <template v-slot:activator="{ on }">
                        <v-text-field
                            v-model="startDateText"
                            label="Data início"
                            prepend-inner-icon="mdi-calendar"
                            dense
                            readonly
                            outlined
                            hide-details
                            v-on="on"
                        />
                    </template>
                    <v-date-picker
                        v-model="startDate"
                        no-title
                        scrollable
                        locale="pt"
                    >
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="primary"
                            @click="startMenu = false"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            text
                            color="primary"
                            @click="$refs.startMenu.save(start)"
                        >
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-menu>
            </v-col>
            <v-col class="mt-md-2" cols="5" sm="5" md="2">
                <v-menu
                    ref="startMenu"
                    v-model="startMenu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    :return-value.sync="start"
                    transition="scale-transition"
                    offset-y
                >
                    <template v-slot:activator="{ on }">
                        <v-text-field
                            v-model="finishDateText"
                            label="Data fim"
                            prepend-inner-icon="mdi-calendar"
                            dense
                            readonly
                            outlined
                            hide-details
                            v-on="on"
                        />
                    </template>
                    <v-date-picker
                        v-model="finishDate"
                        no-title
                        scrollable
                        locale="pt"
                    >
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="primary"
                            @click="startMenu = false"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            text
                            color="primary"
                            @click="$refs.startMenu.save(start)"
                        >
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-menu>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "CampaignsComponent",
        data: function() {
            return {
                startDate: new Date().toISOString().substr(0, 10),
                finishDate : new Date().toISOString().substr(0, 10),
            }
        },

        computed: {
            startDateText() {
                return this.formatDate(this.startDate);
            },
            finishDateText() {
                return this.formatDate(this.finishDate);
            }
        },

        methods: {
            formatDate: function (date) {
                if (!date) return null

                const [year, month, day] = date.split('-')
                return `${day}/${month}/${year}`
            },
        }

    }
</script>

<style scoped>

</style>
