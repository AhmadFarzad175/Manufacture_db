<template>
    <CreateTransfer v-if="SettingRepository.createDailog" />
    <Update v-if="SettingRepository.updateDailog" />
    <div class="w-full">
        <toolbar title="Setting-" subtitle="Transfer" />
        <v-layout class="py-5">
            <v-row class="justify-space-between">
                <v-col cols="12" sm="3">
                    <v-text-field
                        v-model="SettingRepository.Search"
                        label="Search"
                        prepend-inner-icon="mdi-magnify"
                        variant="outlined"
                        name="search"
                        density="compact"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="2">
                    <v-btn
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
                                :items="SettingRepository.transfers"
                                :loading="SettingRepository.loading"
                                :search="SettingRepository.ServiceSearch"
                                item-value="id"
                                @update:options="
                                    SettingRepository.FetchTransfersData
                                "
                                :item-key="SettingRepository.transfers"
                                itemKey="id"
                                hover
                            >
                                <template v-slot:item.status="{ item }">
                                    <!-- Status Cell -->
                                    <div
                                        v-bind:class="
                                            getStatusClasses(item.status)
                                        "
                                    >
                                        {{ item.status }}
                                    </div>
                                </template>
                                <template
                                    v-slot:item.actions="{ item }"
                                    class="right"
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
                                                    @click="editItem(item.id)"
                                                    class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                >
                                                    <v-icon color="gray"
                                                        >mdi-square-edit-outline</v-icon
                                                    >
                                                    Edit
                                                </v-list-item-title>

                                                <v-list-item-title
                                                    class="cursor-pointer d-flex gap-3"
                                                    @click="deleteItem(item.id)"
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

<script setup>
import { useSettingRepository } from "../../store/SettingRepository";
// import Create from "./Create.vue";
// import Update from "./Update.vue";
import CreateTransfer from "./CreateTransfer.vue";
import Toolbar from "../../Component/UI/Toolbar.vue";
import Search from "../../Component/UI/Search.vue";
import CreateButton from "../../Component/UI/CreateButton.vue";
let SettingRepository = useSettingRepository();
const getStatusClasses = (status) => {
    // Map status to Tailwind classes
    switch (status) {
        case "pending":
            return "border-2 border-orange-500 text-orange-500 text-center   rounded";
        case "order":
            return "border-2 text-gray-700 text-gray-700 px-2 py-1 text-center rounded";
        case "Completed":
            return "border-2 border-green-500 text-green-500  text-center rounded";
        case "sent":
            return "border-2 border-blue-500 text-blue-500 text-center  rounded";
        default:
            return " text-gray-500   text-center  rounded";
    }
};

const headers = [
    { title: "DATE", key: "date", sortable: false },
    { title: "REFERENCE", key: "references", sortable: false },
    { title: "FROM WAREHOUSE", key: "fromWarehouse.name", sortable: false },
    { title: "TO WAREHOUSE", key: "toWarehouse.name", sortable: false },
    { title: "ITEMS", key: "items", sortable: false },
    { title: "GRAND TOTAL", key: "total", sortable: false },
    { title: "STATUS", key: "status", sortable: false },
    { title: "Action", key: "actions", sortable: false, align: "end" },
];

const createPopUp = () => {
    SettingRepository.createDailog = true;
};
const deleteItem = (id) => {
    SettingRepository.DeleteWharehouse(id);
};
const editItem = (id) => {
    SettingRepository.wharehouse = {};
    if (Object.keys(SettingRepository.wharehouse).length === 0) {
        SettingRepository.FetchWharehouseData(id)
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
</script>
