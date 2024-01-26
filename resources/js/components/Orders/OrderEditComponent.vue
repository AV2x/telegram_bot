<template>
    <v-dialog
        v-model="dialog"
        width="1024"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Новый заказ</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-window v-model="tab">
                        <v-window-item :value="1">
                            <v-row>

                                <v-col
                                    cols="12"
                                    sm="6"
                                    md="4"
                                >
                                    <v-autocomplete
                                        multiple
                                        v-model="product_id"
                                        label="Товар"
                                        :items="products"
                                        item-title="name"
                                        item-value="id"
                                        chips
                                        closable-chips
                                        required
                                    >
                                        <template v-slot:chip="{ props, item }">
                                            <v-chip
                                                v-bind="props"
                                                :prepend-avatar="'/storage/products/'+item?.raw?.images[0]?.file_name"
                                                :text="item?.raw?.name"
                                            ></v-chip>
                                        </template>

                                        <template v-slot:item="{ props, item }">
                                            <v-list-item
                                                v-bind="props"
                                                :prepend-avatar="'/storage/products/'+item?.raw?.images[0]?.file_name"
                                                :title="item?.raw?.name"
                                                :subtitle="'В наличии '+ item?.raw?.counts"
                                            ></v-list-item>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                                <v-col
                                    cols="12"
                                    sm="6"
                                    md="4"
                                >
                                    <v-select
                                        v-model="user_id"
                                        label="Менеджер"
                                        :items="manages"
                                        item-title="name"
                                        item-value="id"
                                        required
                                    ></v-select>
                                </v-col>
                                <v-col
                                    cols="12"
                                    sm="6"
                                    md="4"
                                >
                                    <v-text-field
                                        v-model="client_name"
                                        label="Имя клиента"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="client_email"
                                        label="Email*"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="client_telephone"
                                        label="Номер телефона"
                                        required
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-window-item>
                        <v-window-item :value="2">
                            <v-row>

                                <v-col
                                    cols="12"
                                    sm="12"
                                    md="12"
                                >
                                    <v-row>
                                        <v-col cols="3">
                                            Название товара
                                        </v-col>
                                        <v-col cols="3">
                                            Сколько осталось
                                        </v-col>
                                        <v-col cols="3">
                                            Сколько списать
                                        </v-col>
                                    </v-row>
                                    <v-row v-for="(product, index) in selectedProducts" :key="index">
                                        <v-col cols="3">
                                            <v-avatar>
                                                <v-img :src="'/storage/products/'+product?.images[0]?.file_name">

                                                </v-img>
                                            </v-avatar>
                                            {{product.name}}
                                        </v-col>
                                        <v-col cols="3">
                                            {{product.counts}}
                                        </v-col>
                                        <v-col cols="3">
                                            <v-text-field v-model="product.order_counts" placeholder="3" label="Солько списать" variant="underlined"></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>

                            </v-row>
                        </v-window-item>
                    </v-window>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="tab == 2"
                    color="blue-darken-1"
                    variant="text"
                    @click="tab = 1; this.selectedProducts = []"
                >
                    Назад
                </v-btn>
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
                    @click="storeOrder"
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
import axios from "axios";

export default {
    data: () => ({
        id: null,
        dialog: false,
        tab: 1,
        product_id: null,
        orderProducts: [],
        user_id: null,
        client_name: null,
        client_email: null,
        client_telephone: null,
        selectedProducts: [],
        loading: false,
        order: null,
        manages: [
            'Дима',
            'Паша'
        ],
        statuses: [
            'Новый заказ',
            'В работе'
        ],
        products: [
            'Товар 1',
            'Товар 2'
        ],

    }),
    methods: {
        fetchUsers(){
            axios.get('/api/executors').then(response => {
                this.manages = response.data
            });
        },

        fetchProducts(){
            axios.get('/api/products').then(response => {
                this.products = response.data
            });
        },
        showDialog(order){
            this.dialog = true;
            this.orderProducts = order.products;
            this.product_id = order.products.map(product => {return product.id});
            this.client_email = order.client_email;
            this.client_name = order.client_name;
            this.client_telephone = order.client_telephone;
            this.user_id = order.user_id
            this.id = order.id;
            this.order = order;
        },
        storeOrder()
        {
            if(this.tab == 2)
            {
                this.loading = true;
                let productsArray = [];
                this.selectedProducts.forEach((product, index) => {
                    productsArray[product.id] = [{'counts': product.order_counts}];
                });
                axios.post('/api/orders/'+this.id, {
                    _method: 'PUT',
                    product_id: productsArray,
                    user_id: this.user_id,
                    client_name: this.client_name,
                    client_email: this.client_email,
                    client_telephone: this.client_telephone,
                }).then(response => {
                    this.order.products = this.selectedProducts;
                   this.$emit('updateParent', this.order)
                   this.dialog = false;
                    this.tab = 1;
                    this.loading = false;
                });
            }
            else{
                this.tab = 2;
                this.selectedProducts = [];
                this.checkProducts();
            }




        },
        checkProducts()
        {
            this.product_id.forEach(product_id => {
                this.selectedProducts.push(this.products.filter(obj => {
                   return  obj.id === product_id;
                })[0]);
            })

            // this.selectedProducts = this.products.filter(obj => {
            //
            //     let test = this.product_id.map((product_id, index) => {
            //
            //         return obj.id == product_id.id;
            //     })[0];
            //     //console.log(test);
            //     return  test;
            // });
            // console.log(this.selectedProducts);
            this.selectedProducts.map(product => {
              this.orderProducts.forEach((product_id, index) => {
                   if(product.id == product_id.id)
                   {
                       product.order_counts = product_id.order_counts
                   }
               });
                return product;
            });
            console.log(this.selectedProducts);
        }
    },
    mounted() {
        this.fetchUsers();
        this.fetchProducts();
    }
}
</script>

<style scoped>

</style>
