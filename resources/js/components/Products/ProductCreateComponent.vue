<template>
    <v-card>
        <v-card-title style="font-size: 26px">Создание товара</v-card-title>
        <v-divider></v-divider>
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
                       <v-btn type="submit" @click="storeProduct()" :loading="storeLoading"
                              :disabled="storeLoading"  :class="{ 'bg-blue-darken-4 v-btn--variant-flat' : valid, disabled: !valid, 'buttons' : true }">Создать</v-btn>
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

export default {
    components: {PropertyCreateComponent, CategoryCreateComponent, NavigationComponent, VDataTable},
    data: () => ({
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
        property_value: [],
        count_type: null,
        files: null,
        imageFiles:  null,
        propertyIndex: 0,
        storeLoading: false,
        categoryRules: [
            (v) => !!v || 'Категория обязательное поле',
        ],
        nameRules: [
            (v) => !!v || 'Имя обязательное поле',
        ],
        priceRules: [
            (v) => !!v || 'Пароль обязательное поле',
        ],
        countsProperties: [0],
    }),
    methods: {
        storeProduct()
        {
            this.storeLoading = true;
            let formData = new FormData();
            formData.append('name', this.name);
            formData.append('category_id', this.category);
            formData.append('price', this.price);
            formData.append('counts', this.counts);
            formData.append('property_key', this.property);
            formData.append('property_value', this.property_value);
            formData.append('count_type', this.count_type);
            if(this.imageFiles)
            {
                this.imageFiles.forEach((file, index) => {
                    formData.append('files[' + index + ']', file)
                });
            }

            axios.post('/api/products', formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
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
            this.properties.push(property);

        },
        setImage(event)
        {
            console.log(event);
            this.imageFiles = event.files;
            // this.avatar = event.file[0];
            // if(this.avatar){
            //     let reader  = new FileReader();
            //     reader.addEventListener("load", function () {
            //         this.showPreview = true;
            //         this.imagePreview = reader.result;
            //     }.bind(this), false);
            //     if( this.avatar ){
            //         if ( /\.(jpe?g|png|gif)$/i.test( this.avatar.name ) ) {
            //             reader.readAsDataURL( this.avatar );
            //         }
            //     }
            // }


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
        this.fetchProperties()
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
