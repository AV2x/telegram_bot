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
                        :to="'products/create'"
                        v-if="auth.permissions.products_create"
                    >
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                    <v-text-field v-model="filterProduct" @update:menu = true;
                                  @update:modelValue = fetchProducts(); clearable label="Поиск по названию" variant="underlined"></v-text-field>
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                    <v-select clearable
                              v-model="filterCategory"
                              label="Поиск по категории"
                              variant="underlined"
                              :items="categories"
                              item-value="id"
                              item-title="name"
                              no-data-text="Нет ни одной категории"
                              @update:menu = true;
                              @update:modelValue = fetchProducts();></v-select>
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >

                </td>
            </tr>

            <tr v-for="(product, index) in products" :key="index" >
                <td >
                    <v-img
                        v-if="product.images.length > 0"
                        :src="'/storage/products/'+product.images[0].file_name"
                    ></v-img>
                </td>
                <td>{{product.name}}</td>
                <td>{{product.category.name}}</td>
                <td>{{product.orders_count}}</td>
                <td>{{product.counts}}</td>
                <td>{{product.price}} руб</td>
                <td>
                    <v-row justify="space-between" class="text-center">
                        <v-col cols="6" v-if="auth.permissions.products_edit">
                            <v-btn
                                size="small"
                                icon
                                :to="{ name: 'product_edit', params: { id: product.id }}"
                            >
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                        </v-col>

                        <v-col cols="6" v-if="auth.permissions.products_delete">
                            <v-btn icon="mdi-delete" color="red-accent-4" size="small" @click="removeProduct(product, index)"></v-btn>
                        </v-col>
                    </v-row>
                </td>
            </tr>

        </template>

        <template v-slot:bottom>

        </template>
    </v-data-table-server>
</template>

<script>

import { VDataTable } from 'vuetify/labs/VDataTable'
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import axios from "axios";

export default {
    components: {VDataTable, VDataTableServer},
    data: () => ({
        dialog: false,
        loading: true,
        options: {
            pageCount: 1,
        },
        sortby: {
            key: null,
            order: null,
        },
        categories: [],
        products: null,
        filterCategory: null,
        filterProduct: null,
        headers: [
            { title: '', key: '', sortable: false, },
            { title: 'Название', key: 'name' },
            { title: 'Категория', key: 'category_id' },
            { title: 'Продано', key: 'orders_count' },
            { title: 'Количество', key: 'counts' },
            { title: 'Цена', key: 'price' },
            { title: 'Действия', key: 'actions', sortable: false, width:'150px'},
        ],
    }),
    methods: {
        fetchProducts(){
            this.loading = true;
            axios.get('/api/products?product_name='+this.filterProduct+'&category_id='+this.filterCategory+'&sortBy'+this.sortby.order+'='+this.sortby.key).then(response => {
                this.products = response.data;
                this.loading = false;
            });
        },
        fetchCategories()
        {
            axios.get('/api/categories').then(response => {
                this.categories = response.data;
            });
        },
        removeProduct(product, index)
        {

            if(confirm('Вы действительно хотите удалить?')){
                this.products = this.products.filter(function( obj ) {
                    return obj.id !== product.id;
                });
                axios.delete('/api/products/'+product.id);
            }
        },
        sort(event)
        {
            if(event.length == 0){
                this.sortby.key =  null;
                this.sortby.order = null;
                this.fetchProducts();
                return true;
            }
            this.sortby.key = event[0].key;
            let order = event[0].order;
            this.sortby.order = order[0].toUpperCase() + order.slice(1);
            this.fetchProducts();
        },
        setLoad(load)
        {
            this.fetchProducts();
            this.loading = load;

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
        this.fetchCategories();
        this.fetchProducts();

    }
}
</script>

<style scoped>
.v-data-table__progress
{
    height:2px;
}
</style>
