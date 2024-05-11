<template>
    <CreateExpense v-if="ExpensRepository.createDailog" />
    <UpdateExpense v-if="ExpensRepository.updateDailog" />
    <toolbar title="Expense-" subtitle="Create Expense " />

    <div class="w-full d-flex mt-4">
        <div class="w-full">
            <div class="overflow-x-auto pb-10">
                <v-divider :thickness="2" class="border-opacity-50"></v-divider>
                <v-app>
                    <v-main>
                        <div
                            class="d-flex w-full gap-4 px-4 mt-10 justify-between"
                        >
                            <v-text-field
                                class="mt-2"
                                variant="outlined"
                                label="Date *"
                                density="compact"
                                type="date"
                            ></v-text-field>

                            <v-autocomplete
                                class="mt-2"
                                variant="outlined"
                                label="Person *"
                                density="compact"
                            ></v-autocomplete>
                            <v-autocomplete
                                class="mt-2"
                                variant="outlined"
                                label="Supplier *"
                                density="compact"
                            ></v-autocomplete>
                            <v-text-field
                                class="mt-2"
                                variant="outlined"
                                label="Invoice Number * *"
                                density="compact"
                            ></v-text-field>
                        </div>
                        <div class="px-4">
                            <v-text-field
                                variant="outlined"
                                label="Search"
                                density="compact"
                                append-inner-icon="mdi-magnify"
                                clearable
                                class="border-none"
                            ></v-text-field>
                        </div>

                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    v-model:items-per-page="
                                        ExpensRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="ExpensRepository.totalItems"
                                    :items="ExpensRepository.expenses"
                                    :loading="ExpensRepository.loading"
                                    :search="ExpensRepository.userSearch"
                                    item-value="id"
                                    @update:options="
                                        ExpensRepository.FetchExpensesData
                                    "
                                    :item-key="ExpensRepository.expenses"
                                    itemKey="id"
                                    hover
                                >
                                    <template v-slot:item.reference="{ item }">
                                        <div
                                            class="border border-gray-300 rounded px-1 py-2"
                                        >
                                            <span>
                                                USD {{ item.reference }}
                                            </span>
                                        </div>
                                    </template>
                                    <template
                                        v-slot:item.addedBy.name="{ item }"
                                    >
                                        <div
                                            class="border border-gray-300 rounded px-1 py-2"
                                        >
                                            <span
                                                >{{ item.addedBy.name }}
                                            </span>
                                        </div>
                                    </template>
                                    <template
                                        v-slot:item.actions="{ item }"
                                        class="right"
                                    >
                                        <v-btn
                                            class="text-red"
                                            icon
                                            @click="deleteItem(item.id)"
                                        >
                                            <v-icon>mdi-delete-outline</v-icon>
                                        </v-btn>
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

import Toolbar from "../../Component/UI/Toolbar.vue";
// import Search from "../../Component/UI/Search.vue";
// import CreateButton from "../../Component/UI/CreateButton.vue";

let ExpensRepository = useExpenseRepository();

const headers = [
    { title: "PRODUCTS", key: "date", sortable: false },

    { title: "PRICE", key: "reference", align: "center", sortable: false },
    {
        title: "AMOUNT",
        key: "addedBy.name",
        sortable: false,
        align: "center",
    },
    {
        title: "GRAND TOTAL",
        key: "person.name",

        sortable: false,
        align: "center",
    },

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
const changeStatus = async (user) => {
    try {
        await axios.PUT(`/users/switch/${user.id}`, { status: user.status });
    } catch (error) {
        console.log("the status was not changed", error);
    }
};

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
