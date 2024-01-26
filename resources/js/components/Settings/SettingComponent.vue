<template>
    <v-tabs
        v-model="tab"
        color="primary"
    >
        <v-tab :value="1" v-if="auth.permissions.settings_statuses_view">Статусы</v-tab>
<!--        <v-tab :value="2">Доступы</v-tab>-->
        <v-tab :value="3" v-if="auth.permissions.settings_requisites_view" disabled>Реквизиты</v-tab>
        <v-tab :value="4" v-if="auth.permissions.settings_properties_view">Характеристики</v-tab>
        <v-tab :value="5" v-if="auth.permissions.settings_storage_view">Хранилище</v-tab>
        <v-tab :value="6" v-if="auth.permissions.settings_telegram_view" disabled>
            Телеграм
                <v-badge
                    color="info"
                    content="New"
                    inline
                ></v-badge>
        </v-tab>
    </v-tabs>
    <v-window v-model="tab">
        <v-window-item :value="1" v-if="auth.permissions.settings_statuses_view">
            <status-component v-if="auth.permissions.settings_statuses_view"></status-component>
        </v-window-item>
<!--        <v-window-item :value="2">-->
<!--            ddd-->
<!--        </v-window-item>-->
        <v-window-item :value="3" v-if="auth.permissions.settings_requisites_view">
            <requisite-component v-if="auth.permissions.settings_requisites_view"></requisite-component>
        </v-window-item>
        <v-window-item :value="4" v-if="auth.permissions.settings_properties_view">
            <property-component v-if="auth.permissions.settings_properties_view"></property-component>
        </v-window-item>
        <v-window-item :value="5" v-if="auth.permissions.settings_storage_view">
            <storage-component v-if="auth.permissions.settings_storage_view"></storage-component>
        </v-window-item>
        <v-window-item :value="6" v-if="auth.permissions.settings_telegram_view">
            <telegram-component v-if="auth.permissions.settings_telegram_view"></telegram-component>
        </v-window-item>
    </v-window>

</template>

<script>
import StatusComponent from "./Status/StatusComponent.vue";
import RequisiteComponent from "./RequisiteComponent.vue";
import PropertyComponent from "./Property/PropertyComponent.vue";
import TelegramComponent from "./TelegramComponent.vue";
import StorageComponent from "./Storage/StorageComponent.vue";
export default {
    components: {StorageComponent, TelegramComponent, PropertyComponent, RequisiteComponent, StatusComponent},
    data:() => ({
        tab:1,
    }),
}
</script>

<style scoped>

</style>
