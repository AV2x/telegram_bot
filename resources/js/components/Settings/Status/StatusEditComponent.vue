<template>
    <v-dialog
        v-model="dialog"
        persistent
        width="1024"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Обновление статуса</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                label="Название статуса"
                                v-model="status.name"
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
                    @click="updateStatus"
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

export default {
    components: {VDataTable},
    data: () => ({
        dialog:false,
        status: null,
        loading: false,
    }),
    methods: {
        showDialog(status){
            this.dialog = true;
            this.status = status;
        },
        updateStatus()
        {
            this.loading = true;
            axios.post('/api/statuses/'+this.status.id, {
                _method: 'PUT',
                name: this.status.name
            }).then(response => {
                this.$emit('updateParent', this.status)
                this.loading = false;
            });
            this.dialog = false;
        }
    }
}
</script>

<style scoped>

</style>
