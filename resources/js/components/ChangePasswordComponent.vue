<template>
    <v-dialog
        v-model="dialog"
        persistent
        width="1024"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Смена пароля</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-form v-model="valid" ref="form">
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                v-model="old_password"
                                :rules="oldpasswordRules"
                                :error-messages="passwordError"
                                label="Старый пароль"
                                required
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                v-model="new_password"
                                :rules="newpasswordRules"
                                label="Новый пароль"
                                required
                                variant="outlined"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="dialog = false"
                >
                    Закрыть
                </v-btn>
                <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="changePassword()"
                >
                    Обновить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-snackbar
        v-model="snackbar"
        :timeout="2000"
    >
        Пароль успешно изменен

        <template v-slot:actions>
            <v-btn
                color="pink"
                variant="text"
                @click="snackbar = false"
            >
                Закрыть
            </v-btn>
        </template>

    </v-snackbar>
</template>

<script>

import { VDataTable } from 'vuetify/labs/VDataTable'
import axios from "axios";

export default {
    components: {VDataTable},
    data: () => ({
        old_password: null,
        new_password: null,
        snackbar: false,
        dialog:false,
        valid: false,
        passwordError: '',
        oldpasswordRules: [
            (v) => !!v || 'Старый пароль - обязательное поле',
        ],
        newpasswordRules: [
            (v) => !!v || 'Новый пароль - обязательное поле',
        ],
    }),
    methods: {
        showDialog(){
            this.dialog = true;
        },
        changePassword()
        {
            this.passwordError = '';
            if(this.valid)
            {
                axios.post('/api/change-password', {
                    oldPassword: this.old_password,
                    newPassword: this.new_password,
                }).then(response => {
                    this.dialog = false;
                    this.old_password = null;
                    this.new_password = null;
                    this.snackbar = true;
                }).catch(error => {
                    this.passwordError = error.response.data.message
                });
            }


        }
    }
}
</script>

<style scoped>

</style>
