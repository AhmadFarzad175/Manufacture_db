<template>
    <Update v-if="MoneyAccountRepository.updateDailog" />
    <Create v-if="MoneyAccountRepository.createDailog" />
    <div class="w-full">
        <toolbar title="Setting-" subtitle="Money Account" />
        <v-layout class="py-5">
            <v-row class="justify-space-between">
                <v-col cols="12" sm="3">
                    <v-text-field
                        v-model="MoneyAccountRepository.Search"
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
                                    MoneyAccountRepository.itemsPerPage
                                "
                                :headers="headers"
                                :items-length="
                                    MoneyAccountRepository.totalItems
                                "
                                :items="MoneyAccountRepository.accounts"
                                :loading="MoneyAccountRepository.loading"
                                :search="MoneyAccountRepository.ServiceSearch"
                                item-value="id"
                                @update:options="
                                    MoneyAccountRepository.FetchAccountsData
                                "
                                :item-key="MoneyAccountRepository.accounts"
                                itemKey="id"
                                hover
                            >
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
import { useMoneyAccountRepository } from "../../store/MoneyAccountRepository ";
import Create from "./Create.vue";
import Update from "./Update.vue";
import Toolbar from "../../Component/UI/Toolbar.vue";
import Search from "../../Component/UI/Search.vue";
import CreateButton from "../../Component/UI/CreateButton.vue";
let MoneyAccountRepository = useMoneyAccountRepository();

const headers = [
    { title: "MONEY ACCOUNT", key: "name", sortable: false },
    { title: "AMOUNT", key: "price", sortable: false },

    { title: "Action", key: "actions", sortable: false, align: "end" },
];

const createPopUp = () => {
    MoneyAccountRepository.createDailog = true;
};
const deleteItem = (id) => {
    MoneyAccountRepository.DeleteCurrency(id);
};
const editItem = (id) => {
    MoneyAccountRepository.currency = {};
    if (Object.keys(MoneyAccountRepository.currency).length === 0) {
        MoneyAccountRepository.FetchCurrencyData(id)
            .then(() => {
                // Data has been fetched successfully, now set dialog to true
                MoneyAccountRepository.updateDailog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
                // Display  message
            });
    }
};
</script>
