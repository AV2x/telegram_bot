<template>
        <v-row>
            <v-col cols="12" sm="6" v-if="auth.permissions.users_view">

                <v-data-table-server
                    :loading="loading"
                    :headers="headers"
                    fixed-header
                    height="92vh"
                    loading-text="Подождите, идет загрузка пользователей"
                    id="datatable"
                    class="elevation-1 dataTable"
                    @update:options="options = $event"
                    @update:sort-by="sort($event)"
                    @click:row="rowClick"
                >

                    <template v-slot:body="">
                        <tr >


                            <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                            >
                                <v-btn
                                    variant="outlined"
                                    size="small"
                                    icon
                                    color="info"
                                    :to="'users/create'"
                                    v-if="auth.permissions.users_create"
                                >
                                    <v-icon>mdi-plus</v-icon>
                                </v-btn>
                            </td>
                            <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                            >
                                <v-text-field  v-model="filterName" @blur="fetchUsers()" clearable label="Поиск по имени" variant="underlined"></v-text-field>
                            </td>
                            <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                            >
                                <v-select clearable
                                          v-model="filterRole"
                                          label="Поиск по роли"
                                          variant="underlined"
                                          :items="roles"
                                          item-value="id"
                                          item-title="name"
                                          no-data-text="Нет ни одной роли"
                                          @update:menu = true;
                                          @update:modelValue = fetchUsers();
                                />
                            </td>
                            <td style="position: sticky; z-index: 3; top: calc(var(--v-table-header-height) * 1);"
                            >

                            </td>
                        </tr>

                        <tr v-for="(user, index) in users" :key="index">
                            <td>
                                <v-avatar color="surface-variant" v-if="user.avatar">
                                    <v-img

                                        :src="'/storage/users/avatar/'+user.avatar"
                                    ></v-img>
                                </v-avatar>
                                <v-avatar color="surface-variant" v-else>
                                </v-avatar>
                            </td>
                            <td>{{user.name}}</td>
                            <td>{{user.role?.name}}</td>
                            <td>
                                <v-row justify="space-between" class="text-center">
                                    <v-col cols="6" v-if="auth.permissions.users_edit && user.role?.id !== 1">
                                        <v-btn
                                            size="small"
                                            icon
                                            :to="{ name: 'user_edit', params: { id: user.id }}"
                                        >
                                            <v-icon>mdi-pencil</v-icon>
                                        </v-btn>
                                    </v-col>

                                    <v-col cols="6" v-if="auth.permissions.users_delete && user.role?.id !== 1">
                                        <v-btn @click="remove(index)" icon="mdi-delete" color="red-accent-4" size="small"></v-btn>
                                    </v-col>
                                </v-row>
                            </td>
                        </tr>

                    </template>

                    <template v-slot:bottom>

                    </template>
                </v-data-table-server>
            </v-col>
            <v-col cols="12" sm="6" v-if="auth.permissions.roles_view">
                <v-card
                    width="500"
                >
                    <v-list v-model:opened="open">
                        <v-list-item :to="'/role/create'" prepend-icon="mdi-plus">Создать роль</v-list-item>
                        <v-list-group v-for="(item, index) in roles" :key="index" :value="item.name" >
                            <template v-slot:activator="{ props }">
                                <v-list-item
                                    v-bind="props"
                                    prepend-icon="mdi-account-circle"
                                    :title="item.name"
                                >
                                    <template v-slot:append>
                                        <v-btn
                                            color="grey-lighten-1"
                                            icon="mdi-pencil"
                                            variant="text"
                                            @click="this.$router.push('/role/'+item.id+'/edit')"
                                            v-if="auth.permissions.roles_edit"
                                        ></v-btn>
                                        <v-btn
                                            color="grey-lighten-1"
                                            icon="mdi-delete"
                                            variant="text"
                                            :disabled="loadingRole[item.id]"
                                            :loading="loadingRole[item.id]"
                                            @click="removeRole(item)"
                                            v-if="auth.permissions.roles_delete"
                                        ></v-btn>
                                        <v-btn
                                            color="grey-lighten-1"
                                            icon="mdi-plus"
                                            variant="text"
                                            @click="dialogRole = true; role = item"
                                            v-if="auth.permissions.roles_attach"
                                        ></v-btn>
                                    </template>
                                </v-list-item>
                            </template>
                            <v-list-item
                                v-for="(user, key) in item.users"
                                :key="key"
                                :title="user.name"
                                :prepend-avatar="'/storage/users/avatar/'+user.avatar"
                                :value="user.name"
                            ></v-list-item>
                        </v-list-group>

                    </v-list>
                </v-card>
            </v-col>
        </v-row>
    <v-dialog
        v-model="dialogRole"
        persistent
        width="1024"
        v-if="auth.permissions.roles_attach"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Добавление роли</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-autocomplete
                                v-model="role.users"
                                label="Пользователи"
                                :items="usersRoles"
                                item-title="name"
                                item-value="id"
                                multiple
                                required
                            ></v-autocomplete>
                        </v-col>

                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="dialogRole = false"
                >
                    Закрыть
                </v-btn>
                <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="attachRole()"
                    :disabled="loadingAttach"
                    :loading="loadingAttach"
                >
                    Обновить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

import NavigationComponent from "../NavigationComponent.vue";
import { VDataTable,VDataTableServer } from 'vuetify/labs/VDataTable'
import axios from "axios";

export default {
    components: {NavigationComponent, VDataTable, VDataTableServer},
    data: () => ({
        open: [],
        dialogRole: false,
        users: null,
        drawer:true,
        loading: true,
        loadingAttach: false,
        dialog: false,
        options: {
            pageCount: 1,
        },
        sortby: {
            key: null,
            order: null,
        },
        filterName: null,
        filterRole: null,
        roles: null,
        role: null,
        loadingRole: [],
        usersRoles: [],
        headers: [
            { title: '', key: '', sortable: false, },
            { title: 'Имя', key: 'name' },
            { title: 'Роль', key: 'role_id' },

            { title: 'Действия', key: 'actions', sortable: false, width:'150px'},
        ],
    }),
    methods: {
        fetchUsers(){
            this.loading = true;
            axios.get('/api/users?user_name='+this.filterName+'&role_id='+this.filterRole+'&sortBy'+this.sortby.order+'='+this.sortby.key).then(response => {
                this.users = response.data;
                this.users.forEach(user => {
                    if(user.role?.id !== 1){
                        this.usersRoles.push(user);
                    }
                });
                this.loading = false;
            });
        },
        fetchRoles(){
            axios.get('/api/roles').then(response => {
                this.roles = response.data;
                this.roles.forEach(item => {
                    this.open.push(item.name);
                })

            });
        },
        rowClick: function (item, row) {
            row.select(true);
            //item.name - selected id
        },
        load (i) {
            this.loading[i] = true
            setTimeout(() => (this.loading[i] = false), 4000)
        },
        attachRole()
        {
            this.loadingAttach = true;
            axios.post('/api/roles/attach', {
                role: this.role
            }).then(response => {
                this.fetchUsers();
                this.fetchRoles();
                this.dialogRole = false;
                this.loadingAttach = false;
            });
        },
        remove(index){
            if(confirm('Вы действительно хотите удалить?')){
                let id = this.users[index].id
                this.users = this.users.filter(function( obj ) {
                    return obj.id !== id;
                });
                axios.delete('/api/users/'+id ).then(response => {

                });
            }
        },
        removeRole(role)
        {
            this.loadingRole[role.id] = true;
            if(confirm('Вы действительно хотите удалить?')){
                axios.delete('/api/roles/'+role.id ).then(response => {
                    this.fetchRoles();
                    this.fetchUsers();
                    this.loadingRole[role.id] = false;
                });
            }
            else{
                this.loadingRole[role.id] = false;
            }

        },
        sort(event)
        {
            if(event.length == 0){
                this.sortby.key =  null;
                this.sortby.order = null;
                this.fetchUsers();
                return true;
            }
            this.sortby.key = event[0].key;
            let order = event[0].order;
            this.sortby.order = order[0].toUpperCase() + order.slice(1);
            this.fetchUsers();
        },
    },
    mounted() {
        this.fetchUsers();
        this.fetchRoles();
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
.v-data-table__progress
{
    height:2px;
}
</style>
