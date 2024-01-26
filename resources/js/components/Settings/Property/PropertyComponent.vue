<template>

    <v-data-table-server
        :headers="headers"
        :loading="loading"
        style="margin-top: 15px;"
        fixed-header
        height="92vh"
        id="datatable"
        class="elevation-1 dataTable"
        @update:options="options = $event"
        @update:sort-by="sort($event)"
        @click:row="rowClick"
        v-if="auth.permissions.settings_properties_view"
    >
        <template v-slot:top>
            <v-btn
                variant="outlined"
                size="small"
                icon
                color="info"
                @click="showPropertyModel()"
                v-if="auth.permissions.settings_properties_create"
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
<!--                        @click="showPropertyModel()"-->
<!--                        v-if="auth.permissions.settings_properties_create"-->
<!--                    >-->
<!--                        <v-icon>mdi-plus</v-icon>-->
<!--                    </v-btn>-->
<!--                </td>-->
<!--                <td style="position: sticky; z-index: 3; top: calc(var(&#45;&#45;v-table-header-height) * 1);"-->
<!--                >-->
<!--                    <v-text-field   clearable label="Поиск по характеристики" variant="underlined"></v-text-field>-->
<!--                </td>-->
<!--                <td style="position: sticky; z-index: 3; top: calc(var(&#45;&#45;v-table-header-height) * 1);"-->
<!--                >-->

<!--                </td>-->
<!--            </tr>-->

            <tr v-for="(property, index) in properties" :key="index">
                <td>{{property.id}}</td>
                <td>{{property.name}}</td>
                <td>
                    <v-row justify="space-between" class="text-center">
                        <v-col cols="6" v-if="auth.permissions.settings_properties_edit">
                            <v-btn icon="mdi-pencil" size="small" @click="showPropertyUpdate(property)"></v-btn>
                        </v-col>

                        <v-col cols="6" v-if="auth.permissions.settings_properties_edit">
                            <v-btn icon="mdi-delete" color="red-accent-4" size="small" @click="removeProperty(property, index)"></v-btn>
                        </v-col>
                    </v-row>
                </td>
            </tr>

        </template>

        <template v-slot:bottom>

        </template>
    </v-data-table-server>
    <property-create-component v-if="auth.permissions.settings_properties_create" ref="property" @updateParent="getProperty"></property-create-component>
    <property-edit-component v-if="auth.permissions.settings_properties_edit" ref=update @updateParent="setProperty" />
</template>

<script>

import { VDataTableServer } from 'vuetify/labs/VDataTable'
import StatusCreateComponent from "../Status/StatusCreateComponent.vue";
import PropertyCreateComponent from "./PropertyCreateComponent.vue";
import axios from "axios";
import PropertyEditComponent from "./PropertyEditComponent.vue";

export default {
    components: {PropertyEditComponent, PropertyCreateComponent, StatusCreateComponent, VDataTableServer},
    data: () => ({
        drawer:true,
        loading: true,
        dialog: false,
        options: {
            pageCount: 1,
        },
        properties: [],
        sortby: {
            key: null,
            order: null,
        },
        headers: [
            { title: '', key: '', sortable: false, },
            { title: 'Название', key: 'name', sortable: false, },
            { title: 'Действия', key: 'actions', sortable: false, width:'150px'},
        ],
    }),
    methods: {
        fetchProperties(){
            axios.get('/api/properties').then(response => {
                this.properties = response.data;
                this.loading = false;
            });
        },
        getProperty(property)
        {
            this.properties.push(property);
        },
        showPropertyModel()
        {
            this.$refs.property.showDialog();
        },
        showPropertyUpdate(property)
        {
            this.$refs.update.showDialog(property);
        },
        setProperty(property)
        {
            this.properties = this.properties.map(p => {
                if(p.id == property.id){
                    p = property;
                }
                return p;
            });
        },
        removeProperty(property, index)
        {
            if(confirm('Вы действительно хотите удалить?')){
                this.properties = this.properties.filter(function( obj ) {
                    return obj.id !== property.id;
                });
                axios.delete('/api/properties/'+property.id);
            }
        },

        rowClick: function (item, row) {
            row.select(true);
            //item.name - selected id
        },
        load (i) {
            this.loading[i] = true
            setTimeout(() => (this.loading[i] = false), 4000)
        },
    },
    mounted() {
        this.fetchProperties();
    }
}
</script>

<style scoped>

</style>
