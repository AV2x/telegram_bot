<template>
    <v-card>
        <v-card-title style="font-size: 26px">Обновление пользователя</v-card-title>
        <v-divider></v-divider>
        <v-card-title>Контактная информация</v-card-title>
        <v-col>
            <v-form fast-fail @submit.prevent v-model="valid">
                <v-row justify="center">
                    <v-col
                        cols="12"
                        sm="6"
                        md="6"
                    >
                        <v-text-field
                            label="Имя Фамилия"
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
                            label="Роль"
                            required
                            v-model="role"
                            :rules="roleRules"
                            :items="roles"
                            item-value="id"
                            item-title="name"
                            variant="underlined"
                        ></v-select>
                    </v-col>
                    <v-col
                        cols="12"
                        sm="6"
                        md="6"
                    >
                        <v-text-field
                            label="Email"
                            variant="underlined"
                            v-model="email"
                            :rules="emailRules"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                        sm="6"
                        md="6"
                    >
                        <v-text-field
                            label="Пароль"
                            variant="underlined"
                            v-model="password"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-row justify="start">
                            <v-col cols="1">
                                <v-avatar v-if="showPreview">
                                    <v-img v-bind:src="imagePreview" />
                                </v-avatar>
                                <v-avatar color="surface-variant" v-else-if="avatar">
                                    <v-img
                                        :src="'/storage/users/avatar/'+avatar"
                                    ></v-img>
                                </v-avatar>
                            </v-col>
                            <v-col >
                                <v-file-input @change="setAvatar(this)" v-model="file" label="Аватар" variant="underlined">
                                </v-file-input>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-btn @click="updateUser()" :loading="loading" :disabled="loading" type="submit"  :class="{ 'bg-blue-darken-4 v-btn--variant-flat' : valid, disabled: !valid, 'buttons' : true }">Обновить</v-btn>
            </v-form>
        </v-col>
    </v-card>
</template>

<script>

import NavigationComponent from "../NavigationComponent.vue";
import { VDataTable } from 'vuetify/labs/VDataTable'
import axios from "axios";
import { routes } from '../../router';

export default {
    props: ['id'],
    components: {NavigationComponent, VDataTable},
    data: () => ({
        imagePreview: null,
        showPreview: false,
        drawer:true,
        dialog:false,
        valid: false,
        e1: false,
        password: null,
        email: null,
        role: null,
        name: null,
        avatar: null,
        file: null,
        roles: [],
        loading: false,
        roleRules: [
            (v) => !!v || 'Роль обязательное поле',
        ],
        nameRules: [
            (v) => !!v || 'Имя обязательное поле',
        ],

        emailRules: [
            (v) => !!v || 'Email обязательное поле',
        ],
    }),
    methods: {
        fetchUser()
        {
            axios.get('/api/users/'+this.id+'/edit').then(response => {
                this.name = response.data.name;
                this.email = response.data.email;
                this.role = response.data.role_id;
                this.avatar = response.data.avatar;
            });
        },
        updateUser(){
            if(this.valid)
            {
                this.loading = true;
                let formData = new FormData();
                formData.append('avatar', this.avatar);
                formData.append('email', this.email);
                formData.append('password', this.password);
                formData.append('role', this.role);
                formData.append('name', this.name);
                formData.append('_method', 'PUT');
                axios.post('/api/users/'+this.id, formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                    this.$router.push({ name: 'user' });
                });
            }
        },
        setAvatar(event)
        {
            this.avatar = event.file[0];
            if(this.avatar){
                let reader  = new FileReader();
                reader.addEventListener("load", function () {
                    this.showPreview = true;
                    this.imagePreview = reader.result;
                }.bind(this), false);
                if( this.avatar ){
                    if ( /\.(jpe?g|png|gif)$/i.test( this.avatar.name ) ) {
                        reader.readAsDataURL( this.avatar );
                    }
                }
            }


        },
        fetchRoles(){
            axios.get('/api/roles').then(response => {
                this.roles = response.data;
            });
        },
    },
    mounted() {
        this.fetchUser();
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
</style>
