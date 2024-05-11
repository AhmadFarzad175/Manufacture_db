<template>
    <CreateBillableExpense v-if="ExpensRepository.createDailog" />
    <UpdateBillableExpense v-if="ExpensRepository.updateDailog" />
    <toolbar title="Expense-" subtitle="Billable Expense " />

    <div class="w-full d-flex">
        <div class="w-full">
            <v-layout class="py-5">
                <v-row class="justify-space-between mt-6">
                    <v-col cols="12" sm="3">
                        <v-text-field
                            v-model="ExpensRepository.Search"
                            label="Search"
                            prepend-inner-icon="mdi-magnify"
                            variant="outlined"
                            name="search"
                            density="compact"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2" class="d-flex mr-28 gap-2">
                        <v-btn color="blue" variant="outlined" size="large">
                            <v-icon>mdi-filter-outline</v-icon>
                            <span class="">FILTER</span>
                        </v-btn>
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
                                        ExpensRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="ExpensRepository.totalItems"
                                    :items="ExpensRepository.billableExpenses"
                                    :loading="ExpensRepository.loading"
                                    :search="ExpensRepository.userSearch"
                                    item-value="id"
                                    @update:options="
                                        ExpensRepository.FetchBillableExpensesData
                                    "
                                    :item-key="
                                        ExpensRepository.billableExpenses
                                    "
                                    itemKey="id"
                                    hover
                                >
                                    <template v-slot:item.due="{ item }">
                                        <!-- Status Cell -->
                                        <div v-bind:class="dueColor(item.due)">
                                            {{ item.due }}
                                        </div>
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
                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="
                                                            deleteItem(item.id)
                                                        "
                                                    >
                                                        <v-icon color="gray"
                                                            >mdi-eye-outline</v-icon
                                                        >
                                                        Show
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
import { useExpenseRepository } from "../../store/ExpenseRepository";
import CreateBillableExpense from "./CreateBillableExpense.vue";
import UpdateBillableExpense from "./UpdateBillableExpense.vue";

import Toolbar from "../../Component/UI/Toolbar.vue";
import Search from "../../Component/UI/Search.vue";
import CreateButton from "../../Component/UI/CreateButton.vue";

let ExpensRepository = useExpenseRepository();
const dueColor = (due) => {
    // Always return classes to make text red
    return "text-red-500 text-center rounded";
};

const headers = [
    { title: "DATE", key: "date", sortable: false },

    { title: "REFERENCE", key: "reference", sortable: false },
    {
        title: "ADDED BY",
        key: "addedBy.name",
        sortable: false,
        align: "center",
    },
    {
        title: "PERSON",
        key: "expensePeople.name",

        sortable: false,
        align: "center",
    },
    {
        title: "SUPPLIER",
        key: "supplier.name",

        sortable: false,
        align: "center",
    },

    { title: "AMOUNT", key: "amount", sortable: false },
    { title: "PAID", key: "paid", sortable: false },
    { title: "DUE", key: "due", align: "center", sortable: false },

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
//     ExpensRepository.UpdateUserStatus(item.id, formData);
// };
// const changeStatus = async (user) => {
//     try {
//         await axios.PUT(`/users/switch/${user.id}`, { status: user.status });
//     } catch (error) {
//         console.log("the status was not changed", error);
//     }
// };

const createPopUp = () => {
    ExpensRepository.createDailog = true;
};
const deleteItem = (id) => {
    ExpensRepository.DeleteExpense(id);
};
const editItem = (id) => {
    ExpensRepository.expense = {};
    if (Object.keys(ExpensRepository.expense).length === 0) {
        ExpensRepository.FetchExpenseData(id)
            .then(() => {
                // Data has been fetched successfully, now set dialog to true
                ExpensRepository.updateDailog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
                // Display  message
            });
    }
};
</script>
