<template>
    <CreateExpense v-if="PurchaseRepository.createDailog" />
    <UpdateExpense v-if="PurchaseRepository.updateDailog" />
    <toolbar title="Purchase-" subtitle="All Purchase " />

    <div class="w-full d-flex">
        <div class="w-full">
            <v-layout class="py-5">
                <v-row class="justify-space-between mt-3">
                    <v-col cols="12" sm="3">
                        <v-text-field
                            v-model="PurchaseRepository.purchaseSearch"
                            label="Search"
                            prepend-inner-icon="mdi-magnify"
                            variant="outlined"
                            name="search"
                            density="compact"
                        ></v-text-field>
                    </v-col>
                    <div class="btn d-flex gap-4 mr-4">
                        <v-btn variant="outlined" color="#112F53 "
                            >Filter</v-btn
                        >

                        <router-link to="/createConsume">
                            <v-btn color="primary" variant="flat">
                                Create</v-btn
                            >
                        </router-link>
                    </div>
                </v-row>
            </v-layout>

            <div class="overflow-x-auto pb-10">
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
import { usePurchaseRepository } from "../../store/PurchaseRepository";
// import CreateExpense from "./CreateExpense.vue";
// import UpdateExpense from "./UpdateExpense.vue";

import Toolbar from "../../Component/UI/Toolbar.vue";
import Search from "../../Component/UI/Search.vue";
import CreateButton from "../../Component/UI/CreateButton.vue";

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
        case "received":
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

// const changeStatus = (item) => {
//     console.log(item.status);
//     const formData = {
//         status: !item.status,
//     };
//     PurchaseRepository.UpdateUserStatus(item.id, formData);
// };
const changeStatus = async (user) => {
    try {
        await axios.PUT(`/users/switch/${user.id}`, { status: user.status });
    } catch (error) {
        console.log("the status was not changed", error);
    }
};

const createPopUp = () => {
    PurchaseRepository.createDailog = true;
};
const deleteItem = (id) => {
    PurchaseRepository.DeleteExpense(id);
};
const editItem = (id) => {
    PurchaseRepository.expense = {};
    if (Object.keys(PurchaseRepository.expense).length === 0) {
        PurchaseRepository.FetchExpenseData(id)
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
