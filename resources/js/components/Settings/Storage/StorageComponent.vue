<template>
    <v-card>
        <v-col>
            <v-card-title>Файловое хранилище</v-card-title>
        </v-col>
        <v-divider></v-divider>
        <v-row>
            <v-col cols="12" sm="4">
                <v-list v-model:opened="open" height="75vh">
                    <v-list-group v-for="(dir, indexDir) in storage" :value="indexDir">
                        <template v-slot:activator="{ props }">
                            <v-list-item
                                v-bind="props"
                                prepend-icon="mdi-folder"
                                :title="indexDir"
                            >
                                <template v-slot:append>
                                    <v-btn
                                        icon="mdi-plus"
                                        variant="text"
                                        @click="addFileDialog(indexDir)"
                                        v-if="auth.permissions.settings_storage_create"
                                    ></v-btn>
                                </template>
                            </v-list-item>
                        </template>
                        <!--                    <template v-if="dir.length > 0">-->
                        <!--                        <v-list-group v-for="(dir2, indexDir2) in dir" :value="indexDir2">-->
                        <!--                            <template v-slot:activator="{ props }">-->
                        <!--                                <v-list-item-->
                        <!--                                    v-bind="props"-->
                        <!--                                    prepend-icon="mdi-folder"-->
                        <!--                                    :title="indexDir2"-->
                        <!--                                ></v-list-item>-->
                        <!--                            </template>-->

                        <!--                            <v-list-item-->
                        <!--                                v-for="(file, indexFile) in dir2"-->
                        <!--                                :key="indexFile"-->
                        <!--                                :title="file.file_name"-->
                        <!--                                :prepend-icon="file.icon"-->
                        <!--                                :value="file.file_name"-->
                        <!--                            ></v-list-item>-->
                        <!--                        </v-list-group>-->
                        <!--                    </template>-->
                        <div v-if="dir[0]?.file_name">
                        <v-list-item
                            v-for="(file, indexFile) in dir"
                            :key="indexFile"
                            :title="file.file_name"
                            :prepend-icon="file.icon"
                            :value="file.file_name"
                            @click="pushFile(indexDir+'/'+file.file_name, file.type)"
                        >
                            <template v-slot:append>
                                <v-btn
                                    color="grey-lighten-1"
                                    icon="mdi-window-close"
                                    variant="text"
                                    @click="remove(indexDir, file.file_name)"
                                    v-if="auth.permissions.settings_storage_delete"
                                ></v-btn>
                            </template>
                        </v-list-item>
                        </div>
                        <div v-else-if="dir">
                            <v-list-group v-for="(dir2, indexDir2) in dir">
                                <template v-slot:activator="{ props }">
                                    <v-list-item
                                        v-bind="props"
                                        prepend-icon="mdi-folder"
                                        :title="indexDir2"
                                    >
                                        <template v-slot:append>
                                            <v-btn
                                                icon="mdi-plus"
                                                variant="text"
                                                @click="addFileDialog(indexDir+'/'+indexDir2)"
                                                v-if="auth.permissions.settings_storage_create"
                                            ></v-btn>
                                        </template>
                                    </v-list-item>
                                </template>
                                <v-list-item
                                    v-for="(file, indexFile) in dir2"
                                    :key="indexFile"
                                    :title="file.file_name"
                                    :prepend-icon="file.icon"
                                    :value="file.file_name"
                                    @click="pushFile(indexDir+'/'+indexDir2+'/'+file.file_name, file.type)"
                                >
                                    <template v-slot:append>
                                        <v-btn
                                            color="grey-lighten-1"
                                            icon="mdi-window-close"
                                            variant="text"
                                            @click="remove(indexDir, file.file_name, indexDir2)"
                                            v-if="auth.permissions.settings_storage_delete"
                                        ></v-btn>
                                    </template>
                                </v-list-item>
                            </v-list-group>
                        </div>

                    </v-list-group>
                </v-list>
            </v-col>
            <v-col cols="12" sm="6">
                <v-img
                    v-if="file"
                    :src="'/storage/'+file"
                    style="height: 400px;"
                    class="bg-grey-lighten-2"
                ></v-img>
            </v-col>
        </v-row>
    </v-card>
    <v-dialog
        v-model="dialog"
        persistent
        width="1024"
    >
        <v-card>
            <v-card-title>
                <span class="text-h5">Загрузка файлов</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-file-input
                                @change="setFile(this)"
                                multiple
                                v-model="files"
                                label="Файлы"
                                required
                            ></v-file-input>
                        </v-col>

                    </v-row>
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
                    @click="store()"
                    :loading="storeLoading"
                >
                    Загрузить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

import axios from 'axios';

export default {
    data:() => ({
        open: ['banners'],
        storage: [],
        file: null,
        dialog: false,
        dir: null,
        files: [],
        storageFiles: [],
        storeLoading: false,
    }),
    methods: {
      fetchStorage()
      {
          axios.get('/api/storage/index').then(response => {
              this.storage = response.data;
              console.log(response.data);
          });
      },
        pushFile(file, type)
        {
            if(type == 'jpg' || type == 'png' || type == 'webp' || type == 'jpeg')
            {
                this.file = file;
            }
            else{
                this.file = null;
            }
        },
        remove(index, fileName, dir2 = null)
        {
            if(!dir2){
                this.storage[index] = this.storage[index].filter(file => {
                    return  file.file_name !== fileName;
                });
                axios.post('/api/storage/delete', {
                    file: index+'/'+fileName,
                });
            }
            if(dir2)
            {
                this.storage[index][dir2] = this.storage[index][dir2].filter(file => {
                    return  file.file_name !== fileName;
                });
                axios.post('/api/storage/delete', {
                    file: index+'/'+dir2+'/'+fileName,
                });
            }

        },
        addFileDialog(indexDir)
        {
            this.dialog = true;
            this.dir = indexDir;
        },
        setFile(event)
        {
            this.storageFiles = event.files;
        },
        store()
        {
            this.storeLoading = true;
            let formData = new FormData();
            if(this.storageFiles)
            {
                formData.append('dir', this.dir)
                this.storageFiles.forEach((file, index) => {
                    formData.append('files[' + index + ']', file)
                });
                axios.post('/api/storage/store', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                    this.fetchStorage();
                    this.files = [];
                    this.open = [this.dir];
                    this.storeLoading = false;
                    this.dialog = false;
                });
            }
        }
    },
    mounted() {
        this.fetchStorage();
    }
}
</script>

<style scoped>

</style>
