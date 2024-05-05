<script setup>
import { usePeopleRepository } from "@/store/PeopleRepository";
import Toolbar from "../../Component/UI/Toolbar.vue";
import CreateSupplier from "./CreateSupplier.vue";

let PeopleRepository = usePeopleRepository();

const headers = [
    { title: "NAME", key: "name", sortable: false },
    { title: "PHONE NUMBER", key: "phone", sortable: false },
    { title: "EMAIL", key: "email", sortable: false },
    {
        title: "TOTAL PURCHASE DUE",
        key: "purchaseDue",
        sortable: false,
        align: "center",
    },
    {
        title: "TOTAL PURCHASE RETURN DUE",
        key: "returnDue",
        sortable: false,
        align: "center",
    },

    { title: "Action", key: "actions", sortable: false },
];
const editItem = (item) => {
    PeopleRepository.supplier = {};
    if (Object.keys(PeopleRepository.supplier).length === 0) {
        PeopleRepository.fetchExpensePeopleData(item.id)
            .then(() => {
                PeopleRepository.updateDailog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};

const deleteItem = async (item) => {
    await PeopleRepository.DeleteSupplier(item.id);
};
</script>
<template>
    <CreateSupplier v-if="PeopleRepository.createDailog" />
    <UpdateExpensePeople v-if="PeopleRepository.updateDailog" />
    <toolbar title="People-" subtitle="Supplier" />
    <divider></divider>
    <div class="w-full mt-4">
        <!-- in this part i import header for breadcrumbs  -->

        <v-layout class="py-5 flex justify-between">
            <div class="w-[20%]">
                <v-text-field
                    v-model="PeopleRepository.supplierSearch"
                    label="Search"
                    prepend-inner-icon="mdi-magnify"
                    variant="outlined"
                    name="search"
                    density="compact"
                    class="ml-4"
                ></v-text-field>
            </div>
            <div class="flex gap-2 justify-end">
                <v-btn color="blue" variant="outlined" size="large">
                    <v-icon>mdi-filter-outline</v-icon>
                    <span class="pl-2">FILTER</span>
                </v-btn>
                <v-btn
                    @click="createPopUp"
                    color="light-blue-darken-1"
                    size="large"
                >
                    <span>Create</span>
                    <v-icon right large>mdi-plus</v-icon>
                </v-btn>
            </div>
        </v-layout>

        <div class="overflow-x-auto pb-10">
            <v-app>
                <v-main>
                    <v-row>
                        <v-col>
                            <v-data-table-server
                                v-model:items-per-page="
                                    PeopleRepository.itemsPerPage
                                "
                                :headers="headers"
                                :items-length="PeopleRepository.totalItems"
                                :items="PeopleRepository.suppliers"
                                :loading="PeopleRepository.loading"
                                :search="PeopleRepository.supplierSearch"
                                item-value="id"
                                @update:options="
                                    PeopleRepository.FetchSuppliersData
                                "
                                :item-key="PeopleRepository.suppliers"
                                itemKey="id"
                                hover
                            >
                                <template v-slot:item.purchaseDue="{ item }">
                                    <v-layout
                                        class="flex justify-center gap-1"
                                        :style="{
                                            color: 'red',
                                        }"
                                    >
                                        <!-- Display the name -->
                                        <div>{{ item.purchaseDue }}</div>
                                        <!-- <span>{{ item.currency?.symbol }}</span> -->
                                    </v-layout>
                                </template>
                                <template v-slot:item.returnDue="{ item }">
                                    <v-layout
                                        class="flex justify-center gap-1"
                                        :style="{
                                            color: 'red',
                                        }"
                                    >
                                        <!-- Display the.symbol -->
                                        <div>{{ item.returnDue }}</div>
                                        <!-- <span>{{ item.currency?.symbol }}</span> -->
                                    </v-layout>
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
