<template>
    <v-tabs
        v-model="tab"
        color="primary"
    >
        <v-tab :value="1" v-if="auth.permissions.analytics_graphics">Графики</v-tab>
        <!--        <v-tab :value="2">Доступы</v-tab>-->
        <v-tab :value="2" v-if="auth.permissions.analytics_pie">Пирог</v-tab>
    </v-tabs>
    <v-window v-model="tab">
        <v-window-item :value="1" v-if="auth.permissions.analytics_graphics">
            <gragics-component></gragics-component>
        </v-window-item>
        <v-window-item :value="2" v-if="auth.permissions.analytics_pie">
            <price-component></price-component>
        </v-window-item>
    </v-window>



</template>

<script>
import GragicsComponent from "./GragicsComponent.vue";
import PriceComponent from "./PriceComponent.vue";
export default {
    components: {PriceComponent, GragicsComponent},
    data:() => ({
        tab:1,
    }),

}
</script>
