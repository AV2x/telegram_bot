<template>
    <v-card>
        <v-card-title style="font-size: 26px">Создание роли</v-card-title>
        <v-divider></v-divider>
        <v-col>
            <v-form fast-fail @submit.prevent v-model="valid">
                <v-row >
                    <v-col
                        cols="12"
                        sm="6"
                        md="6"
                    >
                        <v-text-field
                            label="Название роли"
                            variant="underlined"
                            v-model="name"
                            :rules="nameRules"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-card-title>Доступы</v-card-title>
                        <v-divider></v-divider>
                        <v-card-title>Аналитика</v-card-title>
                    </v-col>
                    <v-col>
                        <v-row justify="start">
                            <v-col sm="3">
                                <v-switch v-model="permissions.analytics.graphics" color="primary" true-value="1" false-value="0" label="Просмотр графиков" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.analytics.pie"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Просмотр пирогов" />
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-divider></v-divider>
                        <v-card-title>Заказы</v-card-title>
                    </v-col>
                    <v-col>
                        <v-row justify="start">
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.orders.view"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Просмотр заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.orders.create"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Создание заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.orders.edit"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Редактирование заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.orders.delete"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Удаление заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.orders.status"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Менять статус заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.orders.export"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Экспорт заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.orders.executor"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Исполнитель заказов" />
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-divider></v-divider>
                        <v-card-title>Пользователи</v-card-title>
                    </v-col>
                    <v-col>
                        <v-row justify="start">
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.users.view"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Просмотр пользователей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.users.create"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Создание пользователей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.users.edit"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Редактирование пользователей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.users.delete"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Удаление пользователей" />
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-divider></v-divider>
                        <v-card-title>Роли</v-card-title>
                    </v-col>
                    <v-col>
                        <v-row justify="start">
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.roles.view"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Просмотр ролей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.roles.create"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Создание ролей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.roles.edit"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Редактирование ролей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.roles.delete"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Удаление ролей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.roles.attach"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Задавать роли пользователям" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.roles.detach"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Отнимать роли у пользователей" />
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-divider></v-divider>
                        <v-card-title>Категории</v-card-title>
                    </v-col>
                    <v-col>
                        <v-row justify="start">
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.categories.view"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Просмотр категорий" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.categories.create"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Создание категорий" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.categories.edit"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Редактирование категорий" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.categories.delete"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Удаление категорий" />
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-divider></v-divider>
                        <v-card-title>Товары</v-card-title>
                    </v-col>
                    <v-col>
                        <v-row justify="start">
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.products.view"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Просмотр товаров" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.products.create"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Создание товаров" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.products.edit"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Редактирование товаров" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.products.delete"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Удаление товаров" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.products.import"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Импорт товаров" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="permissions.products.export"
                                    color="primary"
                                    true-value="1"
                                    false-value="0"
                                    label="Экспорт товаров" />
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-divider></v-divider>
                        <v-card-title>Настройки</v-card-title>
                    </v-col>
                    <v-col sm="3">
                        <v-switch
                            v-model="permissions.settings.view"
                            color="primary"
                            true-value="1"
                            false-value="0"
                            label="Просмотр настроек" />
                    </v-col>
                    <v-col cols="12">
                        <v-row justify="center">
                            <v-col cols="11">
                                <v-col>
                                    <v-divider></v-divider>
                                    <v-card-title>Статусы</v-card-title>
                                </v-col>
                                <v-col>
                                    <v-row justify="start">
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.statuses.view"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Просмотр статусов" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.statuses.create"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Создание статусов" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.statuses.edit"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Редактирование статусов" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.statuses.delete"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Удаление статусов" />
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-col>
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="11">
                                <v-col>
                                    <v-divider></v-divider>
                                    <v-card-title>Реквизиты</v-card-title>
                                </v-col>
                                <v-col>
                                    <v-row justify="start">
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.requisites.view"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Просмотр реквизитов" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.requisites.edit"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Редактирование реквизитов" />
                                        </v-col>

                                    </v-row>
                                </v-col>
                            </v-col>
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="11">
                                <v-col>
                                    <v-divider></v-divider>
                                    <v-card-title>Характеристики</v-card-title>
                                </v-col>
                                <v-col>
                                    <v-row justify="start">
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.properties.view"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Просмотр характеристик" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.properties.create"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Создание характеристик" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.properties.edit"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Редактирование характеристик" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.properties.delete"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Удаление характеристик" />
                                        </v-col>

                                    </v-row>
                                </v-col>
                            </v-col>
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="11">
                                <v-col>
                                    <v-divider></v-divider>
                                    <v-card-title>Хранилище</v-card-title>
                                </v-col>
                                <v-col>
                                    <v-row justify="start">
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.storage.view"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Просмотр хранилища" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.storage.create"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Добавление в хранилище" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.storage.delete"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Удаление из хранилища" />
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-col>
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="11">
                                <v-col>
                                    <v-divider></v-divider>
                                    <v-card-title>Телеграм</v-card-title>
                                </v-col>
                                <v-col>
                                    <v-row justify="start">
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.telegram.view"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Просмотр телеграма" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="permissions.settings.telegram.link"
                                                color="primary"
                                                true-value="1"
                                                false-value="0"
                                                label="Связка телеграма" />
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-btn :loading="loading" :disabled="loading" @click="store" type="submit"  :class="{ 'bg-blue-darken-4 v-btn--variant-flat' : valid, disabled: !valid, 'buttons' : true }">Создать</v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </v-col>
    </v-card>
</template>

<script>
import axios from "axios";

export default {
    data:() => ({
        valid: false,
        loading: false,
        name: null,
        nameRules: [
            (v) => !!v || 'Название роли - обязательное поле',
        ],
        permissions: {
            analytics: {
                graphics: 0,
                pie: 0,
            },
            orders: {
                create: 0,
                edit: 0,
                delete: 0,
                view: 0,
                export: 0,
                status: 0,
                executor: 0,
            },
            users: {
                create: 0,
                edit: 0,
                delete: 0,
                view: 0,
            },
            roles: {
                create: 0,
                edit: 0,
                delete: 0,
                view: 0,
                attach: 0,
                detach: 0,
            },
            categories: {
                create: 0,
                edit: 0,
                delete: 0,
                view: 0,
            },
            products: {
                create: 0,
                edit: 0,
                delete: 0,
                view: 0,
                import: 0,
                export: 0
            },
            settings: {
                view: 0,
                statuses: {
                    view: 0,
                    create: 0,
                    edit: 0,
                    delete: 0,
                },
                requisites: {
                    view: 0,
                    edit: 0,
                },
                properties: {
                    view: 0,
                    create: 0,
                    edit: 0,
                    delete: 0,
                },
                storage: {
                    view: 0,
                    create: 0,
                    delete: 0,
                },
                telegram: {
                    view: 0,
                    link: 0,
                }
            }
        },
    }),
    methods: {
        store()
        {
            this.loading = true;
            axios.post('/api/roles', {
                name: this.name,
                permissions: this.permissions
            }).then(response => {
                this.$router.push('/users');
            });
        }
    },
}
</script>

<style scoped>

</style>
