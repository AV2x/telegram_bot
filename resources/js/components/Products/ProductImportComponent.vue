<template>
    <v-dialog
        v-model="dialog"
        persistent
        width="1024"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Импорт товаров</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-file-input
                                @change="setFile(this)"
                                v-model="file"
                                label="Excel файл с товарами"
                                required
                            ></v-file-input>
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
                    @click="importProducts()"
                >
                    Импортировать
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
        file: null,
        excel: null,
        dialog:false,
    }),
    methods: {
        showDialog(){
            this.dialog = true;
        },
        importProducts()
        {
            let formData = new FormData();
            formData.append('file', this.excel);
            this.$emit('updateParent', true)
            axios.post('/api/products/import', formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                this.$emit('updateParent', false)
            });
            this.dialog = false;

        },
        setFile(event){
            this.excel = event.file[0];
        }
    }
}
</script>

<style scoped>

</style>
