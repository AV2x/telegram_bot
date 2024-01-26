<template>
    <v-dialog
        v-model="dialog"
        persistent
        width="1024"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Обновление характеристики</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                label="Название характеристики"
                                v-model="property.name"
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
                    @click="updateProperty"
                    :loading="loading"
                    :disabled="loading"
                >
                    Обновить
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
        dialog:false,
        property: null,
        loading: false,
    }),
    methods: {
        showDialog(property){
            this.dialog = true;
            this.property = property;
        },
        updateProperty()
        {
            this.loading = true;
            axios.post('/api/properties/'+this.property.id, {
                _method: 'PUT',
                name: this.property.name
            }).then(response => {
                this.$emit('updateParent', this.property)
                this.loading = false;
            });
            this.dialog = false;
        }
    }
}
</script>

<style scoped>

</style>
