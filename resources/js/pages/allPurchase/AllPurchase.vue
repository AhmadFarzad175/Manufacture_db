<template>
    <CreateExpense v-if="PurchaseRepository.dailog" />
    <UpdateExpense v-if="PurchaseRepository.updateDailog" />
    <toolbar title="Purchase-" subtitle="All Purchase " />

    <div class="w-full d-flex">
        <div class="w-full">
            <v-layout class="py-5">
                <v-row class="justify-space-between mt-2">
                    <div class="text-field w-1/5 ml-4">
                        <v-text-field
                            :loading="loading"
                            color="#D3E2F8"
                            density="compact"
                            variant="outlined"
                            label="Search templates"
                            append-inner-icon="mdi-magnify"
                            single-line
                            hide-details
                            v-model="PurchaseRepository.purchaseSearch"
                        ></v-text-field>
                    </div>
                    <div class="btn d-flex gap-4 mr-4">
                        <v-btn variant="outlined" color="#112F53 "
                            >Filter</v-btn
                        >

                        <router-link to="/createPurchase">
                            <v-btn color="primary" variant="flat">
                                Create</v-btn
                            >
                        </router-link>
                    </div>
                </v-row>
            </v-layout>

            <div class="overflow-x-auto pb-10 mt-6">
                <v-app>
                    <v-main>
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    v-model:items-per-page="
                                        PurchaseRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="
                                        PurchaseRepository.totalItems
                                    "
                                    :items="PurchaseRepository.purchases"
                                    :loading="PurchaseRepository.loading"
                                    :search="PurchaseRepository.purchaseSearch"
                                    item-value="id"
                                    @update:options="
                                        PurchaseRepository.FetchPurchasesData
                                    "
                                    :item-key="PurchaseRepository.purchases"
                                    itemKey="id"
                                    hover
                                >
                                    <template v-slot:item.status="{ item }">
                                        <v-layout
                                            class="flex justify-center text-center gap-1"
                                        >
                                            <div
                                                v-bind:class="
                                                    getStatusClasses(
                                                        item.status
                                                    )
                                                "
                                            >
                                                {{ item.status }}
                                            </div>
                                        </v-layout>
                                    </template>
                                    <template
                                        v-slot:item.paymentStatus="{ item }"
                                    >
                                        <v-layout
                                            class="flex justify-center text-center gap-1"
                                        >
                                            <div
                                                v-bind:class="
                                                    pyamentStatus(
                                                        item.paymentStatus
                                                    )
                                                "
                                            >
                                                {{ item.paymentStatus }}
                                            </div>
                                        </v-layout>
                                        <!-- Display the.symbol -->
                                    </template>
                                    <template v-slot:item.due="{ item }">
                                        <v-layout
                                            class="flex justify-center text-center gap-1"
                                        >
                                            <div class="text-red">
                                                {{ item.due }}
                                            </div>
                                        </v-layout>
                                        <!-- Display the.symbol -->
                                    </template>
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

                                            <v-list class="px-4">
                                                <v-list-item-title
                                                    class="cursor-pointer flex justify-start items-center gap-3 pb-3"
                                                    @click="createExpense(item)"
                                                >
                                                    <v-icon
                                                        >mdi-currency-usd</v-icon
                                                    >
                                                    Create Expense
                                                </v-list-item-title>
                                                <v-list-item>
                                                    <router-link
                                                        :to="
                                                            '/updatePurchasse/' +
                                                            item.id
                                                        "
                                                    >
                                                        <v-list-item-title
                                                            class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                        >
                                                            <v-icon color="gray"
                                                                >mdi
                                                                mdi-square-edit-outline</v-icon
                                                            >
                                                            Edit
                                                        </v-list-item-title>
                                                    </router-link>

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
import { usePurchaseRepository } from "../../store/PurchaseRepository";
// import CreateExpense from "./CreateExpense.vue";
// import UpdateExpense from "./UpdateExpense.vue";

import Toolbar from "../../Component/UI/Toolbar.vue";
import Search from "../../Component/UI/Search.vue";
import CreateButton from "../../Component/UI/CreateButton.vue";
import CreateExpense from "./CreateExpense.vue";

let PurchaseRepository = usePurchaseRepository();
const getStatusClasses = (paymentStatus) => {
    // Map status to Tailwind classes
    switch (paymentStatus) {
        case "pending":
            return " border-2 border-orange-500 text-orange-500 text-center px-3 py-[1px]   rounded-lg";
        case "ordered":
            return "border-2 border-purple-500 text-purple-500  text-purple-500  px-3 py-[1px]   rounded-lg text-center rounded";
        case "received":
            return "border-2 border-green-500 text-green-500  text-center px-3 py-[1px]   rounded-lg";
        case "sent":
            return "border-2 border-blue-500 text-blue-500 text-center px-3 py-[1px]   rounded-lg";
        default:
            return " text-gray-500   text-center px-3 py-[1px]   rounded-lg";
    }
};
const pyamentStatus = (status) => {
    // Map status to Tailwind classes
    switch (status) {
        case "partial":
            return "  text-orange-500 text-center px-3 py-[1px]   ";
        case "paid":
            return " text-green-500  text-purple-500  px-3 py-[1px]   rounded-lg text-center rounded";
        case "pending":
            return " text-red-500  text-center px-3 py-[1px]   rounded-lg";

        default:
            return " text-gray-500   text-center px-3 py-[1px]   rounded-lg";
    }
};

const headers = [
    { title: "DATE", key: "date", sortable: false, align: "start" },

    { title: "REFERENCE", key: "reference", sortable: false, align: "center" },
    {
        title: "SUPPLIER",
        key: "supplier.name",
        sortable: false,
        align: "center",
    },
    {
        title: "ADDED BY",
        key: "addedBy.name",

        sortable: false,
        align: "center",
    },

    { title: "WAREHOUSE", key: "warehouse.name", sortable: false },
    { title: "STATUS", key: "status", sortable: false, align: "cneter" },
    { title: "GRAND TOTAL", key: "grandTotal", sortable: false },
    { title: "PAID", key: "paid", sortable: false },
    { title: "DUE", key: "due", sortable: false },
    { title: "PAYMENT STATUS", key: "paymentStatus", sortable: false },

    {
        title: "Action",
        key: "actions",
        sortable: false,
        align: "end",
    },
];
const createExpense = (item) => {
    PurchaseRepository.dailog = true;
    PurchaseRepository.purchaseId.push({ id: item.id });
};
const createPopUp = () => {
    PurchaseRepository.createDailog = true;
};
const deleteItem = (id) => {
    PurchaseRepository.DeletePurchase(id);
};
const editItem = (id) => {
    PurchaseRepository.purchase = {};
    if (Object.keys(PurchaseRepository.purchase).length === 0) {
        PurchaseRepository.FetchPurchase(id)
            .then(() => {
                // Data has been fetched successfully, now set dialog to true
                PurchaseRepository.updateDailog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
                // Display  message
            });
    }
};
</script>
