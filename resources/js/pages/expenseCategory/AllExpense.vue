<template>
    <CreateExpensecategory v-if="SettingRepository.createDailog" />
    <UpdateExpensecategory v-if="SettingRepository.updateDailog" />
    <toolbar title="Setting-" subtitle="Expense Category" />

    <div class="w-full d-flex">
        <productMenu />
        <div class="w-full">
            <v-layout class="py-5">
                <v-row class="justify-space-between mt-6">
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
                                    :items="SettingRepository.expenseCategories"
                                    :loading="SettingRepository.loading"
                                    :search="SettingRepository.ServiceSearch"
                                    item-value="id"
                                    @update:options="
                                        SettingRepository.FetchExpenseCategoriesData
                                    "
                                    :item-key="
                                        SettingRepository.expenseCategories
                                    "
                                    itemKey="id"
                                    hover
                                >
                                    <template
                                        v-slot:item.actions="{ item }"
                                        class="right"
                                    >
                                        <v-menu>
                                            <template
                                                v-slot:activator="{ props }"
                                            >
                                                <v-btn
                                                    icon="mdi-dots-vertical"
                                                    v-bind="props"
                                                    variant="text"
                                                ></v-btn>
                                            </template>

                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title
                                                        @click="
                                                            editItem(item.id)
                                                        "
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                    >
                                                        <v-icon color="gray"
                                                            >mdi-square-edit-outline</v-icon
                                                        >
                                                        Edit
                                                    </v-list-item-title>

                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="
                                                            deleteItem(item.id)
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
    </div>
</template>

<script setup>
import { useSettingRepository } from "../../store/SettingRepository";
import productMenu from "../productSetup/productMenu.vue";

import CreateExpensecategory from "./CreateExpensecategory.vue";
import UpdateExpensecategory from "./UpdateExpensecategory.vue";
import Toolbar from "../../Component/UI/Toolbar.vue";
import Search from "../../Component/UI/Search.vue";
import CreateButton from "../../Component/UI/CreateButton.vue";
let SettingRepository = useSettingRepository();

const headers = [
    { title: "CATEGORY", key: "name", sortable: false },
    { title: "DETAILS", key: "details", sortable: false },

    { title: "Action", key: "actions", sortable: false, align: "end" },
];

const createPopUp = () => {
    SettingRepository.createDailog = true;
};
const deleteItem = (id) => {
    SettingRepository.DeleteExpenseCategory(id);
};
const editItem = (id) => {
    SettingRepository.expenseCategory = {};
    if (Object.keys(SettingRepository.expenseCategory).length === 0) {
        SettingRepository.FetchExpenseCategoryData(id)
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
