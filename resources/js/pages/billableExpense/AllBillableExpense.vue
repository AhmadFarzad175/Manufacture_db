<template>
    <CreatePayment v-if="ExpenseRepository.createDailog" />
    <ViewCreatePayment v-if="ExpenseRepository.ViewEarning" />
    <toolbar title="Expennse-" subtitle="BillableExpense" />
    <div class="all-expense rounded-xl w-full">
        <div class="card rounded-xl bg-white">
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>

            <div class="btn-search pt-12 full pb-6 d-flex justify-between">
                <div class="text-field w-1/5">
                    <v-text-field
                        :loading="loading"
                        color="#D3E2F8"
                        density="compact"
                        variant="outlined"
                        label="Search templates"
                        append-inner-icon="mdi-magnify"
                        single-line
                        hide-details
                        v-model="ExpenseRepository.billExpenseSearch"
                    ></v-text-field>
                </div>
                <div class="btn d-flex gap-4">
                    <v-btn variant="outlined" color="#112F53 ">Filter</v-btn>

                    <router-link to="/ceateBillableExpense">
                        <v-btn color="primary" variant="flat"> Create</v-btn>
                    </router-link>
                </div>
            </div>
            <!-- v-table server  -->
            <div class="overflow-x-hidden">
                <v-app>
                    <v-main class="main">
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    theme="cursor-pointer"
                                    v-model:items-per-page="
                                        ExpenseRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="ExpenseRepository.totalItems"
                                    :items="ExpenseRepository.billExpenses"
                                    :loading="ExpenseRepository.loading"
                                    :search="
                                        ExpenseRepository.billExpenseSearch
                                    "
                                    @update:options="
                                        ExpenseRepository.FetchBillExpenses
                                    "
                                    :item-key="ExpenseRepository.billExpenses"
                                    hover
                                    class="w-full mx-auto"
                                >
                                    <template v-slot:item.due="{ item }">
                                        <span class="text-red">{{
                                            item.due
                                        }}</span>
                                    </template>
                                    <template v-slot:item.action="{ item }">
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
                                                    <v-list-item>
                                                        <v-button
                                                            class="cursor-pointer d-flex gap-3 py-1"
                                                            @click="createPopUp"
                                                        >
                                                            <v-icon color="gray"
                                                                >mdi
                                                                mdi-cash-edit</v-icon
                                                            >
                                                            CreatePayment
                                                        </v-button>
                                                    </v-list-item>

                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3 py-1"
                                                        @click="
                                                            ViewPaymentDialog(
                                                                item
                                                            )
                                                        "
                                                    >
                                                        <v-icon color="gray"
                                                            >mdi
                                                            mdi-cash-sync</v-icon
                                                        >
                                                        &nbsp; ViewPayment
                                                    </v-list-item-title>

                                                    <router-link
                                                        :to="
                                                            '/billableExpenses/' +
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
                                                            deleteItem(item)
                                                        "
                                                    >
                                                        <v-icon color="gray"
                                                            >mdi-delete-outline</v-icon
                                                        >
                                                        &nbsp; Delete
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
import { useExpenseRepository } from "@/store/ExpenseRepository";
import toolbar from "../../Component/UI/Toolbar.vue";
import CreatePayment from "./CreatePayment.vue";

// ignore

// import CreatePayment from "../paymentSent/CreatePaymentSents.vue";
// import ViewCreatePayment from "./ViewCreatePayment.vue";
// import Menu from "@/components/UI/Menu.vue";

const ExpenseRepository = useExpenseRepository();

// delete and update
const deleteItem = async (item) => {
    await ExpenseRepository.DeleteBillExpense(item.id);
};
const createPopUp = () => {
    ExpenseRepository.createDailog = true;
};
const editItem = (id) => {
    ExpenseRepository.expense = {};
    if (Object.keys(ExpenseRepository.expense).length === 0) {
        ExpenseRepository.FetchExpenseData(id)
            .then(() => {
                // Data has been fetched successfully, now set dialog to true
                ExpenseRepository.updateDailog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
                // Display  message
            });
    }
};

const headers = [
    { title: "DATE", key: "date", align: "start", sortable: false },

    {
        title: "   PAID",
        key: "paid",
        align: "end",
        sortable: false,
    },

    {
        title: "SUPLIER  ",
        key: "supplier.name",
        align: "end",
        sortable: false,
    },
    {
        title: "PERSON ",
        key: "expensePeople.name",
        align: "end",
        sortable: false,
    },
    {
        title: "ADDED BY  ",
        key: "addedBy.name",
        align: "end",
        sortable: false,
    },
    { title: "REFERENCE ", key: "reference", align: "end", sortable: false },
    {
        title: "DUE",
        align: "end",
        sortable: false,
        key: "due",
        color: "red",
    },

    { title: "ACTION", key: "action", align: "start", sortable: false },
];

const CreateDialogShow = () => {
    ExpenseRepository.createDialog = true;
};
const CreatePaymentDialog = (id) => {
    ExpenseRepository.productId = id;
    ExpenseRepository.createPayment = true;
};
// const ViewPaymentDialog = () => {
//     ExpenseRepository.ViewEarning = true;
// };
</script>

<style scoped></style>
