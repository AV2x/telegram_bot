<template>
    <v-card>
        <v-card-title>О компании</v-card-title>
        <v-row dense>
            <v-col cols="12">
                <v-text-field
                    label="Заголовок"

                    variant="outlined">

                </v-text-field>
            </v-col>
            <v-col cols="12">
                <v-textarea
                            label="Описание"
                            rows="8"
                            row-height="30"
                            variant="outlined">

                </v-textarea>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
export default {
    data:() => ({
        tab:1,
    }),
}
</script>

<style scoped>

</style>
