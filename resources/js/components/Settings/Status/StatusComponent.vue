<template>

    <v-data-table-server
        style="margin-top: 15px;"
        :headers="headers"
        :loading="loading"
        fixed-header
        height="84vh"
        id="datatable"
        class="elevation-1 dataTable"
        @update:options="options = $event"
        @update:sort-by="sort($event)"
        @click:row="rowClick"
        v-if="auth.permissions.settings_statuses_view"

    >
        <template v-slot:top>
                                <v-btn
                                    variant="outlined"
                                    size="small"
                                    icon
                                    color="info"
                                    @click="showStatusModel()"
                                    v-if="auth.permissions.settings_statuses_create"
                                >
                                    <v-icon>mdi-plus</v-icon>
                                </v-btn>
        </template>
        <template v-slot:body="">
<!--            <tr >-->


<!--                <td style="position: sticky; z-index: 3; top: calc(var(&#45;&#45;v-table-header-height) * 1);"-->
<!--                >-->
<!--                    <v-btn-->
<!--                        variant="outlined"-->
<!--                        size="small"-->
<!--                        icon-->
<!--                        color="info"-->
<!--                        @click="showStatusModel()"-->
<!--                        v-if="auth.permissions.settings_statuses_create"-->
<!--                    >-->
<!--                        <v-icon>mdi-plus</v-icon>-->
<!--                    </v-btn>-->
<!--                </td>-->
<!--                <td style="position: sticky; z-index: 3; top: calc(var(&#45;&#45;v-table-header-height) * 1);"-->
<!--                >-->
<!--                    <v-text-field   clearable label="Поиск по статусу" variant="underlined"></v-text-field>-->
<!--                </td>-->
<!--                <td style="position: sticky; z-index: 3; top: calc(var(&#45;&#45;v-table-header-height) * 1);"-->
<!--                >-->

<!--                </td>-->
<!--            </tr>-->

            <tr v-for="(status, index) in statuses" :key="index">
                <td>{{status.id}}</td>
                <td>{{status.name}}</td>
                <td>
                    <v-row justify="space-between" class="text-center">
                        <v-col cols="6" v-if="auth.permissions.settings_statuses_edit">
                            <v-btn icon="mdi-pencil" size="small" @click="showStatusUpdate(status)"></v-btn>
                        </v-col>

                        <v-col cols="6" v-if="auth.permissions.settings_statuses_delete">
                            <v-btn icon="mdi-delete" color="red-accent-4" size="small" @click="removeStatus(status, index)"></v-btn>
                        </v-col>
                    </v-row>
                </td>
            </tr>

        </template>

        <template v-slot:bottom>

        </template>
    </v-data-table-server>
    <status-create-component v-if="auth.permissions.settings_statuses_create" ref="status" @updateParent="getStatus"></status-create-component>
    <status-edit-component v-if="auth.permissions.settings_statuses_edit" ref="update" @updateParent="setStatus"></status-edit-component>
</template>

<script>

import { VDataTableServer } from 'vuetify/labs/VDataTable'
import StatusCreateComponent from "./StatusCreateComponent.vue";
import StatusEditComponent from "./StatusEditComponent.vue";
import axios from "axios";

export default {
    components: {StatusEditComponent, StatusCreateComponent, VDataTableServer},
    data: () => ({
        drawer:true,
        loading: true,
        dialog: false,
        options: {
            pageCount: 1,
        },
        sortby: {
            key: null,
            order: null,
        },
        statuses: [],
        headers: [
            { title: '', key: '', sortable: false, },
            { title: 'Название', key: 'name', sortable: false,},
            { title: 'Действия', key: 'actions', sortable: false, width:'150px'},
        ],
    }),
    methods: {
        fetchStatuses(){
          axios.get('/api/statuses').then(response => {
              this.statuses = response.data;
              this.loading = false;
          });
        },
        getStatus(status)
        {
            this.statuses.push(status);
        },
        rowClick: function (item, row) {
            row.select(true);
            //item.name - selected id
        },
        load (i) {
            this.loading[i] = true
            setTimeout(() => (this.loading[i] = false), 4000)
        },
        showStatusModel()
        {
            this.$refs.status.showDialog();
        },
        showStatusUpdate(status)
        {
            this.$refs.update.showDialog(status);
        },
        setStatus(status)
        {
            this.statuses = this.statuses.map(s => {
                if(s.id == status.id){
                    s = status;
                }
                return s;
            });
        },
        removeStatus(status, index)
        {
            if(confirm('Вы действительно хотите удалить?')){
                this.statuses.splice(this.statuses.indexOf(index), 1);
                axios.delete('/api/statuses/'+status.id);
            }
        }
    },
    mounted() {
        this.fetchStatuses();
    }
}
</script>

<style scoped>

</style>
