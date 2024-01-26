<template>
    <v-data-table-server
        :loading="loading"
        :headers="headers"
        fixed-header
        height="92vh"
        id="datatable"
        class="elevation-1 dataTable"
        @update:options="options = $event"
        @update:sort-by="sort($event)"
        @click:row="rowClick"
        v-if="auth.permissions.categories_view"
    >

        <template v-slot:body="">
            <tr >


                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                    <v-btn
                        variant="outlined"
                        size="small"
                        icon
                        color="info"
                        @click="showCategoryModel()"
                        v-if="auth.permissions.categories_create"
                    >
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                    <category-create-component v-if="auth.permissions.categories_create" ref="category" @updateParent="getCategory"></category-create-component>
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                    <v-text-field
                        v-model="filterCategory"
                        clearable
                        label="Поиск по названию"
                        variant="underlined"
                        @blur="fetchCategories()"
                    ></v-text-field>
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                </td>

                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >

                </td>
            </tr>

            <tr v-for="(category, index) in categories" :key="index">
                <td><v-avatar color="surface-variant"></v-avatar></td>
                <td>{{category.name}}</td>
                <td>{{category.products_count}}</td>

                <td>
                    <v-row justify="space-between" class="text-center">
                        <v-col cols="6" v-if="auth.permissions.categories_edit">
                            <v-btn icon="mdi-pencil" size="small"
                                @click="editCategory(category)"
                            ></v-btn>
                        </v-col>

                        <v-col cols="6" v-if="auth.permissions.categories_delete">
                            <v-btn icon="mdi-delete" color="red-accent-4" size="small"
                                   @click="removeCategory(category.id)"></v-btn>
                        </v-col>
                    </v-row>
                </td>
            </tr>

        </template>

        <template v-slot:bottom>

        </template>
    </v-data-table-server>
    <category-edit-component v-if="auth.permissions.categories_edit" @updateParent="updateCategory" ref="categoryUpdate"></category-edit-component>
</template>

<script>

import { VDataTable, VDataTableServer } from 'vuetify/labs/VDataTable'
import CategoryCreateComponent from "./CategoryCreateComponent.vue";
import axios from "axios";
import CategoryEditComponent from "./CategoryEditComponent.vue";

export default {
    components: {CategoryEditComponent, CategoryCreateComponent, VDataTable, VDataTableServer},
    data: () => ({
        loading: true,
        dialog: false,
        options: {
            pageCount: 1,
        },
        sortby: {
            key: null,
            order: null,
        },
        filterCategory: null,
        categories: [],
        headers: [
            { title: '', key: '', sortable: false, },
            { title: 'Название', key: 'name' },
            { title: 'Количество товаров', key: 'products_count' },
            { title: 'Действия', key: 'actions', sortable: false, width:'150px'},
        ],
    }),
    methods: {
        fetchCategories()
        {
            this.loading = true;
            axios.get('/api/categories?category_name='+this.filterCategory+'&sortBy'+this.sortby.order+'='+this.sortby.key).then(response => {
                this.categories = response.data;
                this.loading = false;
            });
        },
        showCategoryModel()
        {
            this.$refs.category.showDialog();
        },
        getCategory(category)
        {
            this.categories.push(category);
            this.category = category

        },
        editCategory(category)
        {
            this.$refs.categoryUpdate.showDialogEdit(category);
        },
        updateCategory(category)
        {
            this.categories.forEach((item, index) => {
                if(item.id == category.id){
                    this.categories[index] = category
                }
            })
        },
        removeCategory(id)
        {
            axios.post('/api/categories/'+id, {
                _method: 'DELETE',
            });
            this.categories = this.categories.filter(function( obj ) {
                return obj.id !== id;
            });
        },
        sort(event)
        {
            if(event.length == 0){
                this.sortby.key =  null;
                this.sortby.order = null;
                this.fetchCategories();
                return true;
            }
            this.sortby.key = event[0].key;
            let order = event[0].order;
            this.sortby.order = order[0].toUpperCase() + order.slice(1);
            this.fetchCategories();
        },
    },
    mounted() {
        this.fetchCategories();
    }
}
</script>

<style scoped>
.v-data-table__progress
{
    height:2px;
}
</style>
