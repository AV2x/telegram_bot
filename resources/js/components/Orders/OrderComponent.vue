<template>
    <v-data-table-server
        :headers="headers"
        :loading="loadingOrders"
        fixed-header
        height="86vh"
        id="datatable"
        class="elevation-1 dataTable"
        @update:options="options = $event"
        @update:sort-by="sort($event)"
        v-if="auth.permissions.orders_view"
    >
        <template v-slot:top>
            <v-row >
                <v-col cols="5" sm="1" style="margin-left: 15px;">
                    <v-btn
                        variant="outlined"
                        size="small"
                        icon
                        color="info"
                        @click="showOrderModel()"
                        v-if="auth.permissions.orders_create"
                    >
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </v-col>
                <v-col cols="5" sm="2" v-if="auth.permissions.orders_export">
                    <v-btn
                        :loading="loading"
                        :disabled="loading"
                        color="blue-grey"
                        prepend-icon="mdi-cloud-upload"
                        @click="exportOrders()"
                    >
                        Выгрузить
                    </v-btn>
                </v-col>
<!--                                   <v-col cols="10" sm="11">-->
<!--                                       <v-text-field-->
<!--                                           label="Поиск"-->
<!--                                           variant="solo"-->
<!--                                           prepend-inner-icon="mdi-magnify"-->
<!--                                       ></v-text-field>-->
<!--                                   </v-col>-->
            </v-row>
        </template>

        <template v-slot:body="">
            <tr >
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                    <v-text-field @blur="fetchOrders()" v-model="filterId" clearable label="id" variant="underlined"></v-text-field>
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                    <v-autocomplete
                        clearable
                        v-model="filterProduct"
                        :items="products"
                        item-title="name"
                        item-value="id"
                        label="Поиск по товару"
                        variant="underlined"
                        @update:menu = true;
                        @update:modelValue = fetchOrders();
                    />
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                    <v-autocomplete
                        clearable
                        v-model="filterUser"
                        :items="users"
                        item-title="name"
                        item-value="id"
                        label="Поиск по менеджеру"
                        variant="underlined"
                        @update:menu = true;
                        @update:modelValue = fetchOrders();
                    />
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                    <v-text-field @blur="fetchOrders()" v-model="filterClientName" clearable label="Клиент" variant="underlined"></v-text-field>
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                    <v-text-field @blur="fetchOrders()" v-model="filterClientEmail" clearable label="Email" variant="underlined"></v-text-field>
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                    <v-text-field @blur="fetchOrders()" v-model="filterClientTelephone" clearable label="Телефон" variant="underlined"></v-text-field>
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                    <v-select :items="statuses"  v-model="filterStatus" item-value="id"
                              item-title="name" clearable label="Статус" variant="underlined"
                              @update:menu = true;
                              @update:modelValue = fetchOrders();
                    ></v-select>
                </td>
                <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                >
                </td>
            </tr>
            <tr v-for="(order, index) in orders" :key="index">
                <td>{{order.id}}</td>
                <td >
                    <v-list density="compact">
                        <v-list-subheader>Товары</v-list-subheader>

                        <v-list-item
                            v-for="(product, index) in order.products"
                            :key="index"
                            :value="product"
                            active-color="primary"
                        >
                            <template v-slot:prepend>
                                <v-chip>{{product.order_counts}}</v-chip>
                            </template>

                            <v-list-item-title v-text="product.name"></v-list-item-title>
                        </v-list-item>
                    </v-list>
                </td>
                <td>
                    <v-avatar color="surface-variant" v-if="order.manager.avatar">
                    <v-img
                        :src="'/storage/users/avatar/'+order.manager.avatar"
                    ></v-img>
                </v-avatar>
                    <v-avatar color="surface-variant" v-else>
                    </v-avatar>
                    <span v-if="order.manager" style="margin-left: 10px;">
                        {{order.manager.name}}
                    </span>
                </td>
                <td>{{order.client_name}}</td>
                <td>{{order.client_email}}</td>
                <td>{{order.client_telephone}}</td>
                <td>
                    <v-select
                                v-model="order.status_id"
                               :items="statuses"
                               item-value="id"
                               item-title="name"
                               label="Статус"
                               variant="underlined"
                                :disabled="!auth.permissions.orders_status"
                                @update:menu = true;
                                @update:modelValue = updateStatus(order);
                                />
                </td>
                <td>
                    <v-row justify="space-between" class="text-center">
                        <v-col cols="6" v-if="auth.permissions.orders_edit">
                            <v-btn icon="mdi-pencil" size="small" @click="showOrderUpdate(order)"></v-btn>
                        </v-col>
                        <v-col cols="6" v-if="auth.permissions.orders_delete">
                            <v-btn icon="mdi-delete" color="red-accent-4" size="small" @click="removeOrder(order, index)"></v-btn>
                        </v-col>
                    </v-row>
                </td>
            </tr>
        </template>
        <template v-slot:bottom>
        </template>
    </v-data-table-server>
<order-create-component ref="order" @newOrder="getOrder" v-if="auth.permissions.orders_create"></order-create-component>
    <order-edit-component ref="update" @updateParent="setOrder" v-if="auth.permissions.orders_edit"></order-edit-component>
</template>

<script>

import NavigationComponent from "../NavigationComponent.vue";
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import axios from 'axios';
import OrderCreateComponent from "./OrderCreateComponent.vue";
import OrderEditComponent from "./OrderEditComponent.vue";

export default {
    components: {OrderEditComponent, OrderCreateComponent, NavigationComponent, VDataTableServer},
    data: () => ({
        expanded: ['Donut'],
        singleExpand: false,
        drawer:true,
        loading: false,
        loadingOrders: true,
        dialog: false,
        page: 1,
        nextPage: 1,
        products: [],
        users: [],
        filterProduct: null,
        filterId: null,
        filterUser: null,
        filterClientTelephone: null,
        filterClientEmail: null,
        filterClientName: null,
        filterStatus: null,
        options: {
            pageCount: 1,
        },
        sortby: {
            key: null,
            order: null,
        },
        statuses: [],
        headers: [
            {
                title: 'id',
                align: 'start',
                key: 'id',
            },
            { title: 'Товар', key: 'product_id',  },
            { title: 'Менеджер', key: 'user_id' },
            { title: 'Клиент', key: 'client_name' },
            { title: 'Email', key: 'client_email' },
            { title: 'Телефон', key: 'client_telephone' },
            { title: 'Статус', key: 'status_id', sortable: false },
            { title: 'Действия', key: 'actions', sortable: false, width:'150px'},
        ],
        orders: [],
    }),
    methods: {
        showOrderUpdate(order)
        {
            this.$refs.update.showDialog(order);
        },
        fetchOrders(concat = false){
            if(!concat)
            {
                this.loadingOrders = true;
            }
            axios.get('/api/orders?page='+this.nextPage+'&id='+this.filterId+'&user_id='+this.filterUser+'&product_id='+this.filterProduct+'&client_name='+this.filterClientName+'&client_email='+this.filterClientEmail+'&client_telephone='+this.filterClientTelephone+'&status_id='+this.filterStatus+'&sortBy'+this.sortby.order+'='+this.sortby.key).then(response => {
                this.page = response.data.current_page;
                this.options.pageCount = response.data.last_page
                if(concat){
                    this.orders = this.orders.concat(response.data.data);
                    return true;
                }
                this.orders = response.data.data
                this.loading = false;
                this.loadingOrders = false;
            });
        },
        fetchStatuses()
        {
            axios.get('/api/statuses').then(response => {
                this.statuses = response.data;
            });
        },
        updateStatus(order){
            if(confirm('Сменить статус?')){
                axios.put('/api/orders/'+order.id+'/update-status', order);
            }
        },
        showOrderModel()
        {
            this.$refs.order.showDialog();
        },
        getOrder(order)
        {
            this.orders.unshift(order);
        },
        setOrder(order)
        {
            this.orders = this.orders.map(o => {
                if(o.id == order.id){
                    o = order;
                }
                return o;
            });
        },
        removeOrder(order, index)
        {

            if(confirm('Вы действительно хотите удалить?')){
                this.orders = this.orders.filter(function( obj ) {
                    return obj.id !== order.id;
                });
                axios.delete('/api/orders/'+order.id);
            }
        },
        clicked(value) {
            this.expanded.push(value)
        },
        exportOrders()
        {
            this.loading = true;
            axios.get('/api/orders/export').then(response => {
                window.open(response.data, '_blank');
                this.loading = false;
            });
        },
        fetchProducts(){
            axios.get('/api/products').then(response => {
                this.products = response.data;
            });
        },
        fetchUsers(){
            axios.get('/api/users').then(response => {
                this.users = response.data;
            });
        },
        sort(event)
        {
            if(event.length == 0){
                this.sortby.key =  null;
                this.sortby.order = null;
                this.fetchOrders();
                return true;
            }
            this.sortby.key = event[0].key;
            let order = event[0].order;
            this.sortby.order = order[0].toUpperCase() + order.slice(1);
            this.fetchOrders();
        },
    },
    mounted() {
        this.fetchOrders();
        this.fetchStatuses();
        this.fetchProducts();
        this.fetchUsers();
        const scrollContent = document.querySelector('.v-table__wrapper'); // store in a variable so we can reference the element in multiple locations
        scrollContent.addEventListener('scroll', () => {
            if ((scrollContent.clientHeight +scrollContent.scrollTop) >= scrollContent.scrollHeight
                && this.nextPage < this.options.pageCount
            )
            {
                this.nextPage = this.page +1;
                this.fetchOrders(true);
            }
        }, {passive: true});
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
.v-data-table__progress
{
    height:2px;
}
</style>
