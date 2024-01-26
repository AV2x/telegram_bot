<template>
    <v-card>
        <v-card-title style="font-size: 26px">Редактирование товара</v-card-title>
        <v-divider></v-divider>
        <v-card-title>Контактная информация</v-card-title>
        <v-col>
            <v-form fast-fail @submit.prevent v-model="valid">
                <v-row justify="center">
                    <v-col cols="12" sm="8">
                    <v-row>
                    <v-col
                        cols="12"
                        sm="6"
                        md="6"
                    >
                        <v-text-field
                            label="Название"
                            variant="underlined"
                            v-model="name"
                            :rules="nameRules"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="11"
                        sm="5"
                        md="5"
                    >
                        <v-select
                            label="Категория"
                            required
                            v-model="category"
                            :rules="categoryRules"
                            :items="categories"
                            item-title="name"
                            item-value="id"
                            variant="underlined"
                            no-data-text="Нет ни одной категории"
                        ></v-select>
                    </v-col>
                    <v-col
                        cols="1"
                        sm="1"
                        md="1"
                    >
                        <v-btn
                            variant="outlined"
                            size="small"
                            icon
                            color="info"
                            @click="showCategoryModel()"
                        >
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                        <category-create-component ref="category" @updateParent="getCategory"></category-create-component>
                    </v-col>
                    <v-col
                        cols="5"
                        sm="4"
                        md="4"
                    >
                        <v-text-field
                            label="Цена"
                            variant="underlined"
                            v-model="price"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="3"
                        sm="3"
                        md="3"
                    >
                        <v-text-field
                            label="Количество"
                            variant="underlined"
                            v-model="counts"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="3"
                        sm="4"
                        md="4"
                    >
                        <v-text-field
                            label="Название ед."
                            variant="underlined"
                            placeholder="штук/рулон/метр"
                            v-model="count_type"
                            required
                        ></v-text-field>
                    </v-col>

                    <v-col cols="12" v-if="images.length > 0">

                        <draggable
                            :list="images"
                            item-key="id"
                            ghost-class="ghost"
                            class="v-row"
                            :move="checkMove"
                            @start="dragging = true"
                            @end="dragging = false"
                            @change="log"
                        >
                            <template #item="{ element }">

                                        <v-col cols="1" >
                                            <v-img v-if="!element.file_name" v-bind:src="element" />
                                            <v-img
                                                v-else
                                                :src="'/storage/products/'+element.file_name"
                                                height="70"
                                                class="bg-grey-lighten-2"
                                            ></v-img>
                                            <v-btn size="x-small" @click="removeImage(element.id)">
                                                Удалить
                                            </v-btn>
                                        </v-col>

                            </template>
                        </draggable>
                    </v-col>
                    <v-col cols="12">
                        <v-file-input multiple show-size
                                      @change="setImage(this)"
                                      counter
                                      v-model="files"
                                      label="Картинки"
                                      variant="underlined">
                        </v-file-input>
                    </v-col>
                    </v-row>
                        <v-btn type="submit" @click="updateProduct()" :loading="updateLoading"
                               :disabled="updateLoading" :class="{ 'bg-blue-darken-4 v-btn--variant-flat' : valid, disabled: !valid, 'buttons' : true }">Обновить</v-btn>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-row>
                            <template v-for="(i, index) in countsProperties">
                                <v-col cols="12" sm="6">
                                    <v-select
                                        label="Название характеристики"
                                        required
                                        v-model="property[index]"
                                        :items="properties"
                                        item-title="name"
                                        item-value="id"
                                        variant="underlined"
                                        no-data-text="Нет ни одной характеристики"
                                    >
                                        <template v-slot:prepend-item>
                                            <v-list-item
                                                :subtitle="'Создать новую характеристику'"
                                                :title="'Создать'"
                                                @click="showPropertyModel(index)"
                                            >
                                                <template v-slot:prepend>
                                                    <v-avatar icon="mdi-plus" color="primary">
                                                        mdi-plus
                                                    </v-avatar>
                                                </template>
                                            </v-list-item>
                                            <v-divider class="mb-2"></v-divider>
                                        </template>
                                    </v-select>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field
                                        label="Описание характеристики"
                                        variant="underlined"
                                        placeholder="Intel i7 12830"
                                        :append-inner-icon="'mdi-window-close'"
                                        v-model="property_value[index]"
                                        @click:appendInner="removeProperty(index)"
                                        required
                                    ></v-text-field>
                                </v-col>
                            </template>
                            <v-col cols="12" sm="6">
                                <v-btn
                                    variant="outlined"
                                    size="small"
                                    icon
                                    color="info"

                                    @click="countsProperties.push(countsProperties[countsProperties.length - 1]+1)"
                                >
                                    <v-icon>mdi-plus</v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>

            </v-form>
        </v-col>
    </v-card>
    <property-create-component ref="property" @updateParent="getProperty"></property-create-component>
</template>

<script>

import NavigationComponent from "../NavigationComponent.vue";
import { VDataTable } from 'vuetify/labs/VDataTable'
import CategoryCreateComponent from "./Categories/CategoryCreateComponent.vue";
import PropertyCreateComponent from "../Settings/Property/PropertyCreateComponent.vue";
import axios from "axios";
import draggable from 'vuedraggable'

export default {
    props: ['id'],

    components: {draggable, PropertyCreateComponent, CategoryCreateComponent, NavigationComponent, VDataTable},
    data: () => ({
        dragging:false,
        drawer:true,
        dialog:false,
        dialogP:false,
        valid: false,
        e1: false,
        category: null,
        name: null,
        price: null,
        counts: null,
        property: [],
        categories: [],
        properties: [],
        files: null,
        imageFiles:  null,
        images: [],
        countsProperties: [0],
        property_value: [],
        count_type: null,
        propertyIndex: 0,
        updateLoading: false,
        categoryRules: [
            (v) => !!v || 'Категория обязательное поле',
        ],
        nameRules: [
            (v) => !!v || 'Имя обязательное поле',
        ],
        priceRules: [
            (v) => !!v || 'Пароль обязательное поле',
        ],
    }),
    methods: {
        checkMove: function(evt){
            return true;
        },
        fetchProduct()
        {
            axios.get('/api/products/'+this.id+'/edit').then(response => {

                this.name = response.data.name;
                this.category = response.data.category;
                this.price = response.data.price;
                this.counts = response.data.counts;
                this.images = response.data.images;
                this.count_type = response.data.count_type;
                if(response.data.properties.length > 0) { this.countsProperties = []; }
                response.data.properties.forEach((property, index) => {
                    this.property.push(property.id);
                    this.property_value.push(property.value);

                    this.countsProperties.push(index);
                });
            });
        },
        updateProduct()
        {
            this.updateLoading = true;
            axios.post('/api/products/'+this.id, {
                    _method: 'PUT',
                     name: this.name,
                    category_id: this.category.id,
                    price: this.price,
                    counts: this.counts,
                    property_key: this.property,
                    property_value: this.property_value,
                    count_type: this.count_type,
                }
            ).then(response => {
                this.$router.push({ name: 'product' });
            });
        },
        fetchCategories()
        {
            axios.get('/api/categories').then(response => {
                this.categories = response.data;
            });
        },
        fetchProperties()
        {
            axios.get('/api/properties').then(response => {
                this.properties = response.data;
            });
        },
        getCategory(category)
        {
            this.categories.push(category);
            this.category = category

        },
        showCategoryModel()
        {
            this.$refs.category.showDialog();
        },
        showPropertyModel(index)
        {
            this.propertyIndex = index;
            this.$refs.property.showDialog();
        },
        getProperty(property)
        {

            this.property[this.propertyIndex] = property;
            console.log(this.propertyIndex);
            this.properties.push(property);
        },
        removeImage(id)
        {
            this.images = this.images.filter(function( obj ) {
                return obj.id !== id;
            });
            axios.delete('/api/product/image/'+id+'/destroy');
        },
        setImage(event)
        {
            let formData = new FormData();
            event.files.forEach((file, index) => {
                formData.append('files[' + index + ']', file)
            });
            axios.post('/api/products/'+this.id+'/add-images',formData).then(response => {
                this.images = response.data;
            });
            // console.log(formData);
            // axios.post('/api/products', formData,
            //     {
            //         headers: {
            //             'Content-Type': 'multipart/form-data'
            //         }
            //     }
            // ).then(response => {
            //     this.$router.push({ name: 'product' });
            // });
        //     this.imageFiles = event.files;
        //     this.imageFiles.forEach(file => {
        //         let reader  = new FileReader();
        //         reader.addEventListener("load", function () {
        //             // this.showPreview = true;
        //             this.images.push(reader.result);
        //         }.bind(this), false);
        //         if( file ){
        //             if ( /\.(jpe?g|png|gif)$/i.test( file.name ) ) {
        //                 reader.readAsDataURL( file );
        //             }
        //         }
        //     })
        // console.log(this.images);



        },
        log(event){
            console.log(event);
            axios.put('/api/products/'+this.id+'/sort-images',
                {
                   old: event.moved.oldIndex,
                   new: event.moved.newIndex,
                });
        },
        removeProperty(index)
        {
            this.property = this.property.filter((item, key) => {
               return key !== index;
            });
            this.property_value = this.property_value.filter((item, key) => {
                return key !== index;
            });
            this.countsProperties = this.countsProperties.filter((item, key) => {
                return key !== index;
            });
        }
    },
    mounted() {
        this.fetchCategories();
        this.fetchProperties();
        this.fetchProduct();
    },
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
