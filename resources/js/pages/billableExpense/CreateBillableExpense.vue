<template>
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
                                v-model="formData.date"
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
                                v-model="ExpenseRepository.expenseSearch"
                                @keyup.enter="ExpenseRepository.SearchFetchData"
                                @input="ExpenseRepository.SearchFetchData"
                                @click:clear="clearSearch"
                                variant="outlined"
                                label="Search"
                                density="compact"
                                append-inner-icon="mdi-magnify"
                                clearable
                                class="border-none"
                            ></v-text-field>
                            <div
                                class="rounded shadow-lg px-5 mb-12 w-[83vw]"
                                v-if="ExpenseRepository.searchFetch.length > 0"
                            >
                                <div>
                                    <div
                                        v-for="index in EarningRepository.searchFetch"
                                        :key="index"
                                    >
                                        <p
                                            @click="
                                                EarningRepository.fetchProduct(
                                                    index.id
                                                )
                                            "
                                            class="cursor-pointer pb-2.5 hover:bg-red"
                                        ></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <table
                                class="w-full text-sm text-left bg-blue-darken-500 w-100"
                            >
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-start"
                                        >
                                            PRODUCTS
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-start"
                                        >
                                            AMOUNT
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-start"
                                        >
                                            PRICE
                                        </th>

                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-start"
                                        >
                                            GRAND TOTAL
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-end"
                                        >
                                            ACTIONS
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class=""
                                        v-for="(
                                            pro, index
                                        ) in ExpenseRepository.product"
                                        :key="index"
                                    >
                                        <td class="px-3 py-3 text-start">
                                            {{ pro.name }}
                                        </td>

                                        <td
                                            class="py-3 px-2 pt-8 text-start flex-row justify-"
                                            dir="rtl"
                                        >
                                            <v-text-field
                                                v-model="pro.amount"
                                                variant="outlined"
                                                density="compact"
                                                type="number"
                                                class="w-50"
                                                >1</v-text-field
                                            >
                                        </td>

                                        <td
                                            class="py-3 px-2 pt-8 text-start create-input"
                                            dir="auto"
                                        >
                                            <v-text-field
                                                v-model="pro.price"
                                                variant="outlined"
                                                density="compact"
                                                type="number"
                                                class="w-50"
                                            ></v-text-field>
                                        </td>
                                        <td class="text-start">
                                            <span></span>
                                        </td>

                                        <td class="py-2 pr-6 px-2 text-end">
                                            <v-icon
                                                color="red"
                                                @click="removeProduct(index)"
                                                class="mdi mdi-trash-can-outline"
                                            ></v-icon>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pt-12 w-100 discount">
                            <span class="total"> </span>
                            <div class="pt-12 w-100 discount" dir="rtl">
                                <span class="total">Total: {{ totalSum }}</span>

                                <div class="w-25">
                                    <v-text-field
                                        v-model="formData.discount"
                                        variant="outlined"
                                        class="w-100 input"
                                        type="number"
                                    >
                                        <span class="span">{{
                                            ExpenseRepository.symbol
                                        }}</span>
                                    </v-text-field>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row-reverse mb-16 mx-6">
                            <v-btn color="primary" @click="createExpense">
                                Create</v-btn
                            >
                        </div>
                    </v-main>
                </v-app>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, computed, ref, watch } from "vue";
const items = ref([]);
import Toolbar from "../../Component/UI/Toolbar.vue";
import { useExpenseRepository } from "../../store/ExpenseRepository";
const ExpenseRepository = useExpenseRepository();
// const staticAmount = ref(1);

const clearSearch = () => {
    ExpenseRepository.earningSearch.value = "";
};

const removeProduct = (index) => {
    ExpenseRepository.expense.splice(index, 1);
    console.log(ExpenseRepository.expense);
};

const formData = reactive({
    ncy: null,
    earningDetails: ExpenseRepository.expense,
    grandTotal: "",
    discount: null,
    date: "",
    note: "",
});
const multiple = (pro) => {
    const add = pro.amount * pro.price;
    return add || 0;
};
watch(
    () => ExpenseRepository.expense,
    () => {
        ExpenseRepository.expense.forEach((expense) => {
            // Update the 'subtotal' property for each service
            expense.total = multiple(expense);
            console.log(expense);
        });
    },
    { deep: true }
);

const totalSum = computed(() => {
    const total = ExpenseRepository.expense.reduce(
        (acc, item) => acc + multiple(item),
        0
    );
    formData.grandTotal = total;
    return total;
});

const createExpense = async () => {
    formData.earningDetails.map((data) => (data.expense = data.id));
    await ExpenseRepository.CreateBillableExpense(formData);
};

const saveData = async (id) => {
    await ExpenseRepository.fetchProduct(id);
};

const deleteItem = async (item) => {
    await ExpenseRepository.deleteEarning(item.id);
};
formData.date = ExpenseRepository.getCurrentDate();
// ExpenseRepository.ExpenseAllData();
</script>
