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
            <v-col class="mt-md-2" cols="10" sm="10" md="4">
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
                            v-model="dateRangeText"
                            label="ou filtre por data"
                            prepend-inner-icon="mdi-calendar"
                            dense
                            readonly
                            outlined
                            hide-details
                            v-on="on"
                        />
                    </template>
                    <v-date-picker
                        v-model="dates"
                        no-title
                        scrollable
                        range
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
                dates: ['2020-04-02', '2020-04-05'],
            }
        },

        computed: {
            dateRangeText () {
                return this.dates.join(' ~ ')
            },
        },
    }
</script>

<style scoped>

</style>
