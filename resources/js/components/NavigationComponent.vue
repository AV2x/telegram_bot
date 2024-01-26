<template>
    <v-app-bar>
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

    </v-app-bar>
    <v-navigation-drawer v-model="drawer" style="border:0;">
        <v-row justify="center" style="padding-top: 15px;">
            <v-col cols="5">
                <v-menu :location="'end'" >
                    <template v-slot:activator="{ props }">
                        <v-avatar color="surface-variant" size="80" v-if="auth?.avatar" v-bind="props">
                            <v-img
                                :src="'/storage/users/avatar/'+auth?.avatar"
                            ></v-img>
                        </v-avatar>
                        <v-avatar color="surface-variant" v-else v-bind="props">
                        </v-avatar>
                    </template>
                    <v-list>
                        <v-list-item @click="changePasswordDialog()">
                            <v-list-item-title>Сменить пароль</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="logout">
                            <v-list-item-title >Выйти</v-list-item-title>
                        </v-list-item>
                        <v-list-item href="/telegram-auth">
                            <v-list-item-title >Авторизоваться в телеграм</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-col>

            <v-col cols="8"><v-card-subtitle>{{auth?.name}}</v-card-subtitle></v-col>
            <v-col cols="11" >

                <v-list density="compact">

                    <v-list-item
                        active-color="primary"
                        :to="'/home'"
                        v-if="auth.permissions.analytics_pie || auth.permissions.analytics_graphics"
                    >
                        <template v-slot:prepend>
                            <v-icon :icon="'mdi-home-analytics'"></v-icon>
                        </template>

                        <v-list-item-title v-text="'Главная'"></v-list-item-title>
                    </v-list-item>
                    <v-list-item
                        active-color="primary"
                        :to="'/orders'"
                        v-if="auth.permissions.orders_view"
                    >
                        <template v-slot:prepend>
                            <v-icon :icon="'mdi-currency-usd'"></v-icon>
                        </template>

                        <v-list-item-title v-text="'Заказы'"></v-list-item-title>
                    </v-list-item>
                    <v-list-item
                        active-color="primary"
                        :to="'/users'"
                        v-if="auth.permissions.users_view || auth.permissions.roles_view"
                    >
                        <template v-slot:prepend>
                            <v-icon :icon="'mdi-account'"></v-icon>
                        </template>

                        <v-list-item-title v-text="'Пользователи'"></v-list-item-title>
                    </v-list-item>
                    <v-list-item
                        active-color="primary"
                        :to="'/products'"
                        v-if="auth.permissions.products_view"
                    >
                        <template v-slot:prepend>
                            <v-icon :icon="'mdi-basket-outline'"></v-icon>
                        </template>

                        <v-list-item-title v-text="'Товары'"></v-list-item-title>
                    </v-list-item>
                    <v-list-item
                        active-color="primary"
                        :to="'/site'"
                        disabled
                    >
                        <template v-slot:prepend>
                            <v-icon :icon="'mdi-application-braces-outline'"></v-icon>
                        </template>

                        <v-list-item-title v-text="'Сайт'"></v-list-item-title>
                    </v-list-item>
                    <v-list-item
                        active-color="primary"
                        :to="'/settings'"
                        v-if="auth.permissions.settings_view"
                    >
                        <template v-slot:prepend>
                            <v-icon :icon="'mdi-cog'"></v-icon>
                        </template>

                        <v-list-item-title v-text="'Настройки'"></v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-col>
        </v-row>
    </v-navigation-drawer>
<change-password-component ref="password" />



</template>

<script>

import axios from "axios";
import ChangePasswordComponent from "./ChangePasswordComponent.vue";

export default {
    components: {ChangePasswordComponent},
    data: () => ({
        drawer:true,
        location: window.location.pathname,
        drop: false,
    }),
    methods: {
        logout()
        {
            axios.post('/api/logout').then(response => {
                window.location.replace("/login");
            });
        },
        changePasswordDialog()
        {
            this.$refs.password.showDialog();
        }
    },
    mounted() {
        console.log(this.auth.permissions.analytics_graphics || this.auth.permissions.analytics_pie);
    }
}
</script>

<style scoped>

</style>
