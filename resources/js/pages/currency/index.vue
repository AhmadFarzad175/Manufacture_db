<script setup>
import Header from "@/components/UI/Header.vue";
import { useSettingRepository } from "@/store/SettingRepository";
import { useAuthRepository } from "@/store/AuthRepository";
import Create from "./Create.vue";
import Update from "./Update.vue";
import { ref } from "vue";
let SettingRepository = useSettingRepository();
let AuthRepository = useAuthRepository();
SettingRepository.fetchServicesData();

const selectedIds = ref([]);
const selectAll = false;
const showSelect = true;
const headers = [
    { title: "Name", key: "name", sortable: false },
    { title: "Details", key: "details", sortable: false },
    { title: "Action", key: "actions", sortable: false, align: "end" },
];
const editItem = (item) => {
    SettingRepository.service = {};
    if (Object.keys(SettingRepository.service).length === 0) {
        SettingRepository.fetchServiceData(item.id)
            .then(() => {
                // Data has been fetched successfully, now set dialog to true
                SettingRepository.updateDailog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
                // Display  message
            });
    }
};
const deleteItems = async () => {
    const idsToDelete = selectedIds._rawValue;
    const idsObject = {
        serviceIds: idsToDelete,
    };
    // Convert the object to a JSON string
    const ids = idsObject;
    if (ids.length === 0) {
        return;
    }
    await SettingRepository.DeleteMultipleService(ids);
    // Clear the selected items after deletion
    selectedIds.value = [];
};
const deleteItem = async (item) => {
    await SettingRepository.DeleteService(item.id);
};
const createPopUp = (item) => {
    SettingRepository.createDailog = true;
};
</script>
<template>
    <Update v-if="SettingRepository.updateDailog" />
    <Create v-if="SettingRepository.createDailog" />
    <div class="relative sm:rounded-lg pt-20 px-8 pl-20">
        <!-- in this part i import header for breadcrumbs  -->
        <Header mainTitle="Setting" subTitle="Services" />
        <v-layout class="py-5">
            <v-row class="justify-space-between">
                <v-col cols="12" sm="3">
                    <v-text-field
                        v-model="SettingRepository.ServiceSearch"
                        label="Search"
                        prepend-inner-icon="mdi-magnify"
                        variant="outlined"
                        name="search"
                        density="compact"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="2">
                    <v-btn
                        v-if="
                            AuthRepository.permissions &&
                            AuthRepository.permissions.includes('createService')
                        "
                        @click="createPopUp"
                        color="light-blue-darken-1"
                        size="large"
                    >
                        <span>Create</span>
                        <v-icon right large>mdi-plus</v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-layout>

        <div class="overflow-x-auto pb-10">
            <v-app>
                <v-main>
                    <v-row>
                        <v-col>
                            <v-data-table-server
                                v-model:items-per-page="
                                    SettingRepository.itemsPerPage
                                "
                                :headers="headers"
                                :items-length="SettingRepository.totalItems"
                                :items="SettingRepository.services"
                                :loading="SettingRepository.loading"
                                :search="SettingRepository.ServiceSearch"
                                item-value="id"
                                @update:options="
                                    SettingRepository.fetchServicesData
                                "
                                :item-key="SettingRepository.services"
                                itemKey="id"
                                :select-all="selectAll"
                                :show-select="showSelect"
                                v-model="selectedIds"
                                hover
                            >
                                <template
                                    v-slot:top
                                    v-if="
                                        AuthRepository.permissions &&
                                        AuthRepository.permissions.includes(
                                            'deleteAllService'
                                        )
                                    "
                                >
                                    <v-toolbar v-if="selectedIds.length !== 0">
                                        <v-toolbar-title class="text-red"
                                            >{{ selectedIds.length }} Row
                                            Selected</v-toolbar-title
                                        >
                                        <v-divider
                                            class="mx-4"
                                            inset
                                            vertical
                                        ></v-divider>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            @click="deleteItems"
                                            :disabled="selectedIds.length === 0"
                                            class="bg-red-darken-1 text-white"
                                        >
                                            Delete Selected
                                        </v-btn>
                                    </v-toolbar>
                                </template>
                                <template
                                    v-slot:item.actions="{ item }"
                                    class="right"
                                    v-if="
                                        AuthRepository.permissions &&
                                        (AuthRepository.permissions.includes(
                                            'editService'
                                        ) ||
                                            AuthRepository.permissions.includes(
                                                'deleteService'
                                            ))
                                    "
                                >
                                    <v-menu>
                                        <template v-slot:activator="{ props }">
                                            <v-btn
                                                icon="mdi-dots-vertical"
                                                v-bind="props"
                                                variant="text"
                                            ></v-btn>
                                        </template>

                                        <v-list>
                                            <v-list-item>
                                                <v-list-item-title
                                                    v-if="
                                                        AuthRepository.permissions &&
                                                        AuthRepository.permissions.includes(
                                                            'editService'
                                                        )
                                                    "
                                                    @click="editItem(item)"
                                                    class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                >
                                                    <v-icon color="gray"
                                                        >mdi-square-edit-outline</v-icon
                                                    >
                                                    Edit
                                                </v-list-item-title>

                                                <v-list-item-title
                                                    class="cursor-pointer d-flex gap-3"
                                                    @click="deleteItem(item)"
                                                    v-if="
                                                        AuthRepository.permissions.includes(
                                                            'deleteService'
                                                        )
                                                    "
                                                >
                                                    <v-icon color="gray"
                                                        >mdi-delete-outline</v-icon
                                                    >
                                                    Delete
                                                </v-list-item-title>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>
                                </template>
                            </v-data-table-server>
                        </v-col>
                    </v-row>
                </v-main>
            </v-app>
        </div>
    </div>
</template>
