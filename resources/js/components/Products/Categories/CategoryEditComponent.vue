<template>
    <v-dialog
        v-model="dialog"
        persistent
        width="1024"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Обновление категории</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                v-model="category.name"
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
                    @click="updateCategory()"
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
        category: null,
        dialog:false,
        loading: false,
    }),
    methods: {
        showDialogEdit(category){
            this.dialog = true;
             this.category = category;
        },
        updateCategory()
        {
            this.loading = true;
            axios.post('/api/categories/'+this.category.id, {
                name: this.category.name,
                _method: 'PUT',
            }).then(response => {
                this.$emit('updateParent', this.category)
                this.dialog = false;
                this.loading = false;
            });
        },

    }
}
</script>

<style scoped>

</style>
