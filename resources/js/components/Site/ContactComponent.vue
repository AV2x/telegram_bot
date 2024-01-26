<template>
    <v-card>
    <v-card-title>Контакты</v-card-title>
    <v-row dense>
        <v-col cols="12">
            <v-text-field
                label="Офис"
                variant="outlined"
                placeholder="Главный офис продаж">

            </v-text-field>
        </v-col>
        <v-col cols="12">
            <v-text-field
                label="Номер телефона"
                variant="outlined"
                placeholder="+7 (800) 600-68-93">

            </v-text-field>
        </v-col>
        <v-col cols="12">
            <v-text-field
                label="Адрес"
                variant="outlined"
                placeholder="наб. реки Карповки, 39, лит. Б, Санкт-Петербург">

            </v-text-field>
        </v-col>
        <v-col cols="12">
            <v-text-field
                label="Время работы в будни"
                variant="outlined"
                placeholder="10:00–20:00">

            </v-text-field>
        </v-col>
        <v-col cols="12">
            <v-text-field
                label="Время работы в выходные"
                variant="outlined"
                placeholder="10:00–20:00">

            </v-text-field>
        </v-col>
    </v-row>
    </v-card>
</template>

<script>
export default {

}
</script>

<style scoped>

</style>
