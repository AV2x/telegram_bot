<template>
    <v-app id="inspire">


        <v-main class="bg-grey-lighten-3">
            <v-container>
                <v-row justify="center">
                    <v-col cols="12" sm="6">
                <v-card
                    class="mx-auto my-12"
                >

                            <div v-if="loginExceptions">
                                <v-alert type="error" v-for="(loginException, index) in loginExceptions" :key="index">
                                    {{loginException[0]}}
                                </v-alert>
                            </div>

                            <v-row dense>
                                <v-col>
                                    <v-card-title class="text-sm-h6">Авторизация</v-card-title>
                                </v-col>
                            </v-row>
                            <v-divider></v-divider>

                            <v-card-text>
                                <v-form v-model="valid" ref="form">
                                    <v-col cols="12">
                                        <v-text-field
                                            label="Логин | Email"
                                            v-model="login"
                                            :rules="emailRules"
                                            variant="outlined"
                                            :error-messages="emailError"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field
                                            label="Пароль"
                                            v-model="password"
                                            :type="e1 ? 'password' : 'text'"
                                            :rules="passwordRules"
                                            variant="outlined"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                    <v-card-actions>
                                        <v-btn :disabled="loading" :loading="loading" @click="submit" :class=" { 'bg-blue-darken-4 v-btn--variant-flat' : valid, disabled: !valid, 'buttons' : true }">Авторизоваться</v-btn>
                                    </v-card-actions>

                                </v-form>
                            </v-card-text>


                </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>

import axios from 'axios';

export default {
    data () {
        return {
            valid: false,
            e1: false,
            password: null,
            passwordRules: [
                (v) => !!v || 'Пароль обязательное поле',
            ],
            login: null,
            emailRules: [
                (v) => !!v || 'Логин обязательное поле',
            ],
            loginExceptions: false,
            loading: false,
            emailError: '',
        }
    },
    methods: {
        submit () {
            this.emailError = '';
            if(this.valid)
            {
                this.loading = true;
                axios.post('/api/login', {
                    email: this.login,
                    password: this.password,
                }).then(response => {
                    console.log(response)
                    window.location.replace("/home");
                }).catch(error => {
                    this.loading = false;
                    this.emailError = error.response.data.message
                });
            }
        },
        clear () {
            this.$refs.form.reset()
        }
    },
    mounted() {
        this.login = 'oleg@gmail.com';
        this.password = '1234567';
    }
}
</script>
