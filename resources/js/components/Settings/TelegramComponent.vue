<template>
    <v-card>
        <v-col>
            <v-card-title>Настройки телеграм</v-card-title>
            <v-form v-model="valid" ref="form">
            <v-row dense>

                    <v-col cols="3" sm="2" >
                        <v-switch
                            v-model="telegramOn"
                            hide-details
                            :true-value="true"
                            :false-value="false"
                            :label="'Вкл'"
                            color="primary"
                        ></v-switch>
                    </v-col>
                    <v-col cols="9" sm="10" >
                        <v-text-field
                            v-model="token"
                            label="Телеграм token"
                            :disabled="!telegramOn"
                            :rules="tokenRules"
                            variant="outlined"
                            placeholder="0123456789:A3gj34gjsdg023sd092gj344g4g">

                        </v-text-field>
                    </v-col>
                    <v-btn :disabled="!telegramOn" :class=" { 'bg-blue-darken-4 v-btn--variant-flat' : valid, disabled: !valid, 'buttons' : true }">
                        Проверить
                    </v-btn>
            </v-row>
            </v-form>

        </v-col>
        <v-divider></v-divider>
        <v-col>

        </v-col>
    </v-card>
</template>

<script>
export default {
    data:() => ({
       telegramOn: false,
        valid: false,
        e1: false,
        token: '',
        tokenRules: [
            (v) => !!v || 'Токен обязательное поле',
        ],
    }),
}
</script>

<style scoped>

</style>
