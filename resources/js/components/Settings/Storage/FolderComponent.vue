<template>
    <v-list-group v-for="(dir, index) in storage" :value="index">
        <template v-slot:activator="{ props }">
            <template v-if="dir.length > 0">
                <v-list-group v-for="(dir, index) in storage" :value="index">
                    <template v-slot:activator="{ props }">
                        <template v-if="dir.length > 0">
                        </template>
                        <template>
                            <file-component />
                        </template>
                    </template>
                </v-list-group>
            </template>
            <template>
                <file-component />
            </template>
        </template>
    </v-list-group>
</template>

<script>
import FileComponent from "./FileComponent.vue";
export default {
    components: {FileComponent},
    props: ['storage']
}
</script>

<style scoped>

</style>
