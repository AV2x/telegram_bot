<template>
    <v-tabs
        v-model="tab"
        color="primary"
    >
        <v-tab :value="1" v-if="auth.permissions.products_view">Товары</v-tab>
        <v-tab :value="2" v-if="auth.permissions.categories_view">Категории</v-tab>
        <v-menu
            v-if="auth.permissions.products_export || auth.permissions.products_import"
        >
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="plain"
                    rounded="0"
                    class="align-self-center me-4"
                    height="100%"
                    v-bind="props"
                    :loading="loading"
                >
                    Импорт
                    <v-icon end>
                        mdi-menu-down
                    </v-icon>
                </v-btn>
            </template>
            <v-list class="bg-grey-lighten-3">
                <v-list-item
                    @click="showImport()"
                    v-if="auth.permissions.products_import"
                >
                    Загрузить
                </v-list-item>
                <v-list-item
                    @click="downloadExport()"
                    v-if="auth.permissions.products_export"
                >
                    Выгрузить данные
                </v-list-item>
                <v-list-item
                    @click="downloadTemplate"
                    v-if="auth.permissions.products_export"
                >
                    Скачать шаблон импорта
                </v-list-item>
            </v-list>
        </v-menu>
    </v-tabs>
    <v-window v-model="tab">
        <v-window-item :value="1" v-if="auth.permissions.products_view">
            <product-table-companent ref="productTable" v-if="auth.permissions.products_view"></product-table-companent>
        </v-window-item>
        <v-window-item :value="2" v-if="auth.permissions.categories_view">
            <category-component v-if="auth.permissions.categories_view"></category-component>
        </v-window-item>
    </v-window>
    <product-import-component ref="import" @updateParent="getLoad" v-if="auth.permissions.products_import"></product-import-component>
</template>

<script>

import NavigationComponent from "../NavigationComponent.vue";
import { VDataTable } from 'vuetify/labs/VDataTable'
import ProductTableCompanent from "./ProductTableCompanent.vue";
import CategoryComponent from "./Categories/CategoryComponent.vue";
import ProductImportComponent from "./ProductImportComponent.vue";
import axios from "axios";

export default {
    components: {ProductImportComponent, CategoryComponent, ProductTableCompanent, NavigationComponent, VDataTable},
    data: () => ({
        tab:1,
        drawer:true,
        loading: false,
    }),
    methods: {
        showImport()
        {
            this.$refs.import.showDialog();
        },
        downloadExport()
        {
            this.loading = true;
            this.$refs.productTable.setLoad(true);
            axios.get('/api/products/export').then(response => {
                window.open(response.data, '_blank');
                this.$refs.productTable.setLoad(false);
                this.loading = false;
            });
        },
        downloadTemplate()
        {
            this.loading = true;
            this.$refs.productTable.setLoad(true);
            axios.get('/api/products/template').then(response => {
                window.open(response.data, '_blank');
                this.$refs.productTable.setLoad(false);
                this.loading = false;
            });
        },
        getLoad(load){
            this.loading = load;
            this.$refs.productTable.setLoad(load);
        }
    }
}
</script>
<style>

.form-sheet {
    padding-bottom: 15px;
}
.v-table.v-table--fixed-header > .v-table__wrapper > table > thead > tr > th{
    box-shadow: none;
}
*, :after, :before {
    border: 0;
}
tr.v-data-table__selected {
    background: #7d92f5 !important;
}
</style>
