<template>
    <v-dialog
        v-model="dialog"
        persistent
        width="1024"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Новая характеристика</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                v-model="name"
                                label="Название характеристики"
                                required
                            ></v-text-field>
                        </v-col>

                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="dialog = false"
                >
                    Закрыть
                </v-btn>
                <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="storeProperty()"
                    :loading="loading"
                    :disabled="loading"
                >
                    Создать
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

import { VDataTable } from 'vuetify/labs/VDataTable'
import axios from "axios";

export default {
    components: {VDataTable},
    data: () => ({
        name: null,
        dialog:false,
        loading: false,
    }),
    methods: {
        showDialog(){
            this.dialog = true;
        },
        storeProperty()
        {
            this.loading = true;
            axios.post('/api/properties', {
                name: this.name
            }).then(response => {
                this.$emit('updateParent', response.data)
                this.loading = false;
            });
            this.dialog = false;
        }
    }
}
</script>

<style scoped>

</style>
