<template>
    <v-dialog
        v-model="dialog"
        persistent
        width="1024"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Новая категория</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                v-model="category"
                                label="Название категории"
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
                    @click="storeCategory()"
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
        category: null,
        dialog:false,
        loading: false,
    }),
    methods: {
        showDialog(){
            this.dialog = true;
        },
        storeCategory()
        {
            this.loading = true;
            axios.post('/api/categories', {
                name: this.category
            }).then(response => {
                this.$emit('updateParent', response.data)
                this.dialog = false;
                this.loading = false;
            });

        }
    }
}
</script>

<style scoped>

</style>
