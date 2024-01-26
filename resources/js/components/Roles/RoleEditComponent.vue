<template>
    <v-card>
        <v-card-title style="font-size: 26px">Обновление роли</v-card-title>
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
                            v-model="role.name"
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
                                <v-switch v-model="role.permissions.analytics_graphics" color="primary" :true-value="1" :false-value="0" label="Просмотр графиков" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.analytics_pie"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
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
                                    v-model="role.permissions.orders_view"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Просмотр заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.orders_create"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Создание заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.orders_edit"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Редактирование заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.orders_delete"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Удаление заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.orders_status"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Менять статус заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.orders_export"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Экспорт заказов" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.orders_executor"
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
                                    v-model="role.permissions.users_view"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Просмотр пользователей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.users_create"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Создание пользователей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.users_edit"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Редактирование пользователей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.users_delete"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
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
                                    v-model="role.permissions.roles_view"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Просмотр ролей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.roles_create"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Создание ролей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.roles_edit"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Редактирование ролей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.roles_delete"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Удаление ролей" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.roles_attach"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Задавать роли пользователям" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.roles_detach"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
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
                                    v-model="role.permissions.categories_view"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Просмотр категорий" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.categories_create"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Создание категорий" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.categories_edit"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Редактирование категорий" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.categories_delete"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
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
                                    v-model="role.permissions.products_view"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Просмотр товаров" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.products_create"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Создание товаров" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.products_edit"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Редактирование товаров" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.products_delete"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Удаление товаров" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.products_import"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
                                    label="Импорт товаров" />
                            </v-col>
                            <v-col sm="3">
                                <v-switch
                                    v-model="role.permissions.products_export"
                                    color="primary"
                                    :true-value="1"
                                    :false-value="0"
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
                            v-model="role.permissions.settings_view"
                            color="primary"
                            :true-value="1"
                            :false-value="0"
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
                                                v-model="role.permissions.settings_statuses_view"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
                                                label="Просмотр статусов" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="role.permissions.settings_statuses_create"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
                                                label="Создание статусов" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="role.permissions.settings_statuses_edit"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
                                                label="Редактирование статусов" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="role.permissions.settings_statuses_delete"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
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
                                                v-model="role.permissions.settings_requisites_view"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
                                                label="Просмотр реквизитов" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="role.permissions.settings_requisites_edit"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
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
                                                v-model="role.permissions.settings_properties_view"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
                                                label="Просмотр характеристик" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="role.permissions.settings_properties_create"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
                                                label="Создание характеристик" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="role.permissions.settings_properties_edit"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
                                                label="Редактирование характеристик" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="role.permissions.settings_properties_delete"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
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
                                                v-model="role.permissions.settings_storage_view"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
                                                label="Просмотр хранилища" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="role.permissions.settings_storage_create"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
                                                label="Добавление в хранилище" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="role.permissions.settings_storage_delete"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
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
                                                v-model="role.permissions.settings_telegram_view"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
                                                label="Просмотр телеграма" />
                                        </v-col>
                                        <v-col sm="3">
                                            <v-switch
                                                v-model="role.permissions.settings_telegram_link"
                                                color="primary"
                                                :true-value="1"
                                                :false-value="0"
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
                        <v-btn :loading="loading" :disabled="loading" @click="update" type="submit"  :class="{ 'bg-blue-darken-4 v-btn--variant-flat' : valid, disabled: !valid, 'buttons' : true }">Обновить</v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </v-col>
    </v-card>
</template>

<script>
import axios from "axios";

export default {
    props: ['id'],
    data:() => ({
        valid: false,
        name: null,
        nameRules: [
            (v) => !!v || 'Название роли - обязательное поле',
        ],
        role: {
            name: null,
            permissions: {},
        },
        loading: false,
    }),
    methods: {
        fetchRole()
        {
            axios.get('/api/roles/'+this.id+'/edit').then(response => {
                this.role = response.data;
            });
        },
        update()
        {
            this.loading = true;
            axios.put('/api/roles/'+this.role.id, this.role).then(response => {
                this.$router.push('/users');
            });
        }
    },
    created() {
        this.fetchRole();
    }
}
</script>

<style scoped>

</style>
