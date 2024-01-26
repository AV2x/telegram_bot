<template>
    <v-col>
        <v-col sm="12" md="6" lg="6">
            <v-row>
                <v-col>
                    <v-select
                        label="Фильтр"
                        v-model="filter"
                        :items="['Всего', 'Категория', 'Товар', 'Менеджер']"
                        variant="underlined"
                        @update:menu = true;
                        @update:modelValue = typeFilterUpdate();
                    />
                </v-col>
                <v-col>
                    <v-autocomplete
                        :label="filter"
                        :items="filterItems"
                        v-model="typeFilter"
                        variant="underlined"
                        :disabled="checkFilter()"
                        item-title="name"
                        item-value="id"
                        @update:menu = true;
                        @update:modelValue = fetchGraphics();
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" xs="12" sm="12" md="6" lg="6" xl="6">
                    <v-select
                        label="Тип"
                        v-model="type"
                        :items="dates"
                        variant="underlined"
                        item-value="id"
                        item-title="name"
                        @update:menu = true;
                        @update:modelValue = fetchGraphics();
                    />
                </v-col>
                <v-col cols="12" xs="12" sm="12" md="6" lg="6" xl="6" v-if="type == 2">
                    <v-row>
                        <v-col sm="6">
                            <v-text-field type="date" label="Дата с" v-model="dateFrom" :enable-time-picker="false" locale="ru"
                                           @update:menu = true;
                                           @update:modelValue = fetchGraphics()></v-text-field>
                        </v-col>
                        <v-col sm="6">
                            <v-text-field type="date" label="Дата по" v-model="dateTo" :enable-time-picker="false" locale="ru"
                                           @update:menu = true;
                                           @update:modelValue = fetchGraphics() />
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>
    </v-col>
    <vue-highcharts
        type="chart"
        :options="chartOptions"
        :redrawOnUpdate="true"
        :oneToOneUpdate="false"
        :animateOnUpdate="true"
        @rendered="onRender"/>
</template>

<script>
import VueHighcharts from 'vue3-highcharts';
import { ref } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import axios from 'axios';

export default {
    components: {VueHighcharts, VueDatePicker},
    data:() => ({
        dates: [
            {name: 'Сегодня', id: 1},
            {name: 'Своя дата', id: 2},
            {name: 'Вчера', id: 3},
            {name: 'Неделя', id: 4},
            {name: 'Месяц', id: 5},
            // {name: 'Квартал', id: 6},
            // {name: 'Год', id: 7}
        ],
        dateFrom: null,
        dateTo: null,
        filter:'Всего',
        type: 1,
        typeFilter: null,
        filterItems: [],
        chartOptions: {
            chart: {
                type: 'line',
            },
            title: {
                text: 'Продаж за сегодня',
            },
            xAxis: {
                categories: [],
            },
            yAxis: {
                title: {
                    text: 'Сколько заработано',
                },
            },
            series: [{
                name: 'Сколько заработано',
                data: [],
            }],
        }
    }),
    methods: {
        fetchGraphics()
        {
            let filters = '&'+null;
            if(this.filter === 'Категория'){
                filters = '&category_id='+this.typeFilter;
            }
            else if(this.filter === 'Товар'){
                filters = '&product_id='+this.typeFilter;
            }
            else if(this.filter === 'Менеджер'){
                filters = '&user_id='+this.typeFilter;
            }
            if(this.type === 2 && this.dateFrom && this.dateTo || this.type !== 2)
            axios.get('api/dashboard/graphics?type='+this.type+'&date_from='+this.dateFrom+'&date_to='+this.dateTo+filters).then(response => {
                this.chartOptions.xAxis.categories = [];
                this.chartOptions.series[0].data = [];
                response.data.forEach((item, index) => {
                    this.chartOptions.xAxis.categories.push(item.type);
                    this.chartOptions.series[0].data.push(item.amount);
                });
                this.chartOptions.xAxis.categories = ref(this.chartOptions.xAxis.categories);
                this.chartOptions.series[0].data = ref(this.chartOptions.series[0].data);
            });
        },
        onRender(){

        },
        checkFilter()
        {
            return this.filter == 'Всего'
        },
        fetchUsers(){
            axios.get('/api/users').then(response => {
                this.filterItems = response.data;
            });
        },
        fetchProducts(){
            axios.get('/api/products').then(response => {
                this.filterItems = response.data;
            });
        },
        fetchCategories()
        {
            axios.get('/api/categories').then(response => {
                this.filterItems = response.data;
            });
        },
        typeFilterUpdate()
        {
            if(this.filter === 'Категория')
            {
                this.fetchCategories();
            }
            else if(this.filter === 'Товар')
            {
                this.fetchProducts();
            }
            else if(this.filter === 'Менеджер')
            {
                this.fetchUsers();
            }
            else if(this.filter === 'Всего')
            {
                this.fetchGraphics();
            }

        }
    },
    mounted() {
        this.fetchGraphics();
    }

}
</script>

<style scoped>

</style>
