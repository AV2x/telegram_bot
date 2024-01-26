<template>
    <v-col>
        <v-col sm="12" md="6" lg="6">
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
                        @update:modelValue = fetchData();
                    />
                </v-col>
                <v-col cols="12" xs="12" sm="12" md="6" lg="6" xl="6" v-if="type === 2">
                    <v-row>
                        <v-col sm="6">
                            <v-text-field type="date" label="Дата с" v-model="dateFrom" :enable-time-picker="false" locale="ru"
                                          @update:menu = true;
                                          @update:modelValue = fetchData()></v-text-field>
                        </v-col>
                        <v-col sm="6">
                            <v-text-field type="date" label="Дата по" v-model="dateTo" :enable-time-picker="false" locale="ru"
                                          @update:menu = true;
                                          @update:modelValue = fetchData() />
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>
    </v-col>
    <v-row>
        <v-col cols="12" xl="4" lg="4" md="6" xs="12" sm="12">
            <v-chart class="chart" autoresize :option="option[0]" />
        </v-col>
        <v-col cols="12" xl="4" lg="4" md="6" xs="12" sm="12">
            <v-chart class="chart" autoresize :option="option[1]" />
        </v-col>
        <v-col cols="12" xl="4" lg="4" md="6" xs="12" sm="12">
            <v-chart class="chart" autoresize :option="option[2]" />
        </v-col>
    </v-row>
</template>

<script>
import { use } from "echarts/core";
import { CanvasRenderer } from "echarts/renderers";
import { PieChart } from "echarts/charts";
import {
    TitleComponent,
    TooltipComponent,
    LegendComponent
} from "echarts/components";
import VChart, { THEME_KEY } from "vue-echarts";
import { ref, defineComponent } from "vue";
import axios from "axios";
use([
    CanvasRenderer,
    PieChart,
    TitleComponent,
    TooltipComponent,
    LegendComponent
]);
export  default  {
    components: {
        VChart
    },
    data:() => ({
        option: [{
            title: {
                text: 'Менеджеры',
                left: 'center',
            },
            tooltip: {
                trigger: 'item',
                formatter: '{a} <br/>{b} : {c} ({d}%)',
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: [],
            },
            series: [
                {
                    name: 'Менеджеры',
                    type: 'pie',
                    radius: '55%',
                    center: ['50%', '60%'],
                    data: [
                    ],
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)',
                        },
                    },
                },
            ],
        },
            {
                title: {
                    text: 'Категории',
                    left: 'center',
                },
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b} : {c} ({d}%)',
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: [],
                },
                series: [
                    {
                        name: 'Категории',
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '60%'],
                        data: [
                        ],
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)',
                            },
                        },
                    },
                ],
            },
            {
                title: {
                    text: 'Товары',
                    left: 'center',
                },
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b} : {c} ({d}%)',
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: [],
                },
                series: [
                    {
                        name: 'Товары',
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '60%'],
                        data: [
                        ],
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)',
                            },
                        },
                    },
                ],
            }],
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
        type: 1,
    }),
    methods: {
        fetchData()
        {
            axios.get('api/dashboard/price?users=true&type='+this.type+'&date_from='+this.dateFrom+'&date_to='+this.dateTo).then(response => {
                this.option[0].series[0].data = [];
                this.option[0].legend.data = []
                    response.data.forEach((item, index) => {
                        this.option[0].series[0].data.push({value: item.amount, name: item.type})
                        //this.option[0].legend.data.push(item.type)
                    })
            });
            axios.get('api/dashboard/price?categories=true&type='+this.type+'&date_from='+this.dateFrom+'&date_to='+this.dateTo).then(response => {
                this.option[1].series[0].data = [];
                this.option[1].legend.data = []
                response.data.forEach((item, index) => {
                    this.option[1].series[0].data.push({value: item.amount, name: item.type})
                    //this.option[1].legend.data.push(item.type)
                })
            });
            axios.get('api/dashboard/price?products=true&type='+this.type+'&date_from='+this.dateFrom+'&date_to='+this.dateTo).then(response => {
                this.option[2].series[0].data = [];
                this.option[2].legend.data = []
                response.data.forEach((item, index) => {
                    this.option[2].series[0].data.push({value: item.amount, name: item.type})
                    //this.option[2].legend.data.push(item.type)
                })
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
    },
    mounted() {
        this.fetchData();
    }
}
</script>

<style scoped>
.chart {
    height: 500px;
}
</style>
