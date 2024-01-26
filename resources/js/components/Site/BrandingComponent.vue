<template>
    <v-card>
        <v-card-title>Логотип</v-card-title>
        <v-row dense>

            <v-col>
                <v-img src="/storage/banners/631738a73a7cd.webp"></v-img>
            </v-col>
            <v-col cols="12">
                <v-file-input
                              label="Логотип"
                              variant="underlined">
                </v-file-input>
            </v-col>
        </v-row>
        <v-col>
            <v-card-title>Главный банер</v-card-title>
            <v-row dense>

                <v-col>
                    <v-img src="/storage/banners/631738a73a7cd.webp"></v-img>
                </v-col>
                <v-col cols="12">
                    <v-file-input multiple show-size
                                  counter
                                  label="Баннер"
                                  variant="underlined">
                    </v-file-input>
                </v-col>
            </v-row>
        </v-col>
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
