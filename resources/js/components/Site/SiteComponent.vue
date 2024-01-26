<template>
    <v-tabs
        v-model="tab"
        color="primary"
    >
        <v-tab :value="1">Брендинг</v-tab>
        <v-tab :value="2">О Компании</v-tab>
        <v-tab :value="3">Контакты</v-tab>
    </v-tabs>
    <v-window v-model="tab">
        <v-window-item :value="1">
            <branding-component></branding-component>
        </v-window-item>
        <v-window-item :value="2">
            <company-component></company-component>
        </v-window-item>
        <v-window-item :value="3">
            <contact-component></contact-component>
        </v-window-item>
    </v-window>
</template>

<script>
import BrandingComponent from "./BrandingComponent.vue";
import CompanyComponent from "./CompanyComponent.vue";
import ContactComponent from "./ContactComponent.vue";
export default {
    components: {ContactComponent, CompanyComponent, BrandingComponent},
    data:() => ({
        tab:1,
    }),
}
</script>

<style scoped>

</style>
