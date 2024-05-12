<!-- <template>
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
                                type="person"
                                v-model="formData.personId"
                                @create:modelValue="
                                    ExpenseRepository.GetPersonSuplier(
                                        ExpenseRepository.expenseAllData
                                            .expensePeople,
                                        formData.expensePeople
                                    )
                                "
                                :items="
                                    ExpenseRepository.expenseAllData
                                        .expensePeople
                                "
                                class="mt-2"
                                variant="outlined"
                                label="Person *"
                                density="compact"
                                item-value="id"
                                item-title="name"
                            ></v-autocomplete>
                            <v-autocomplete
                                v-model="formData.supplier"
                                @create:modelValue="
                                    ExpenseRepository.GetPersonSuplier(
                                        ExpenseRepository.expenseAllData
                                            .supplier,
                                        formData.supplier
                                    )
                                "
                                :items="
                                    ExpenseRepository.expenseAllData.supplier
                                "
                                class="mt-2"
                                variant="outlined"
                                label="Supplier *"
                                density="compact"
                                item-value="id"
                                item-title="name"
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
                                        >
                                            {{ index.name }}
                                        </p>
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
                                    <tr>
                                        <td class="px-3 py-3 text-start">
                                            hello
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
                                            <span>{{ multiple(pro) }}</span>
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

<script setup> -->
<!-- import { reactive, computed, ref, watch } from "vue";
const items = ref([]);
import Toolbar from "../../Component/UI/Toolbar.vue";
import { useExpenseRepository } from "@/store/ExpenseRepository";
const ExpenseRepository = useExpenseRepository();
// const staticAmount = ref(1);

ExpenseRepository.GetPersonSuplier();

const clearSearch = () => {
    ExpenseRepository.expenseSearch.value = "";
};

const removeProduct = (index) => {
    ExpenseRepository.expense.splice(index, 1);
    console.log(ExpenseRepository.expense);
};

const formData = reactive({
    ncy: null,

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
</script> -->
<template>
    <toolbar title="Expense-" subtitle="Create Expense " />
    <div class="all-expense w-full rounded-xl m-4">
        <div class="card rounded-xl w-full bg-white">
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <div class="d-flex w-full pt-12">
                <v-text-field
                    type="Date"
                    v-model="formData.date"
                    :return-object="false"
                    variant="outlined"
                    label=" * Date"
                    class="pb-4 pl-4 input"
                    color="#d3e2f8"
                ></v-text-field>
                <v-autocomplete
                    variant="outlined"
                    label="  Person *"
                    class="pb-4 pl-4 input"
                    item-value="id"
                    item-title="symbol"
                    color="customPrimary"
                    base-color="customPrimary"
                ></v-autocomplete>

                <v-autocomplete
                    variant="outlined"
                    label=" * Person"
                    class="pb-4 pl-4 input"
                    item-value="id"
                    item-title="name"
                ></v-autocomplete>
            </div>
            <v-card class="rounded px-5 py-4 mb-20 w-full pb-10">
                <v-divider></v-divider>
                <v-row no-gutters class="justify-space-between">
                    <v-col cols="full" class="w-50" sm="12" md="12">
                        <v-text-field
                            v-model="ExpenseRepository.earningSearch"
                            @keyup.enter="ExpenseRepository.SearchFetchData"
                            @input="ExpenseRepository.SearchFetchData"
                            @click:clear="clearSearch"
                            variant="outlined"
                            label="Products"
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
                                    v-for="index in ExpenseRepository.searchFetch"
                                    :key="index"
                                >
                                    <p
                                        @click="
                                            ExpenseRepository.fetchProduct(
                                                index.id
                                            )
                                        "
                                        class="cursor-pointer pb-2.5 hover:bg-red"
                                    >
                                        {{ index.name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </v-col>

                    <div class="overflow-x-auto pb-6 table">
                        <table class="w-full w-100">
                            <thead class="text-lg bg-slate-200 thead">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-start"
                                    >
                                        Product
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-start"
                                    >
                                        Amount
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-start"
                                    >
                                        Price
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-start"
                                    >
                                        Gound total
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-start"
                                    >
                                        Action
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
                                    >
                                        <v-text-field
                                            v-model="pro.quentity"
                                            variant="outlined"
                                            direction="rtl"
                                            density="compact"
                                            type="number"
                                            class="w-50"
                                        ></v-text-field>
                                    </td>

                                    <td
                                        class="py-3 px-2 pt-8 text-start create-input"
                                    >
                                        <v-text-field
                                            v-model="pro.price"
                                            direction="rtl"
                                            variant="outlined"
                                            density="compact"
                                            type="number"
                                            class="w-50"
                                        >
                                            <span class="bg-[#ecf1f4] span">{{
                                                ExpenseRepository.symbol
                                            }}</span>
                                        </v-text-field>
                                    </td>
                                    <td class="text-start">
                                        <span>{{ multiple(pro) }}</span>
                                    </td>

                                    <td class="py-2 pr-6 px-2 text-start">
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
                </v-row>
            </v-card>

            <div class="pt-12 w-100 discount" dir="rtl">
                <span dir="rtl" class="total"> Total : {{ totalSum }}</span>

                <div class="w-25">
                    <v-text-field
                        dir="rtl"
                        direction="ltr"
                        v-model="formData.discount"
                        variant="outlined"
                        class="w-100 input"
                        type="number"
                    >
                        <span class="span">{{ ExpenseRepository.symbol }}</span>
                    </v-text-field>
                </div>
            </div>

            <div></div>
            <div class="d-flex mt-16 pt-16">
                <v-textarea
                    v-model="formData.note"
                    class="textArea"
                    label="Ditails"
                    variant="outlined"
                >
                </v-textarea>
            </div>
            <div class="d-flex flex-row-reverse mb-6 mx-6">
                <v-btn color="primary" @click="createEarning"> Create</v-btn>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, computed, ref, watch } from "vue";
const items = ref([]);

import Toolbar from "../../Component/UI/Toolbar.vue";
import { useExpenseRepository } from "@/store/ExpenseRepository";
const ExpenseRepository = useExpenseRepository();

// const removeProduct = (index) => {
//     const product = ExpenseRepository.searchFetch[index];
//     ExpenseRepository.searchFetch.splice(index, 1);
//     index.deleted = true;

//     console.log(index);
// };
const clearSearch = () => {
    ExpenseRepository.earningSearch.value = "";
};

const removeProduct = (index) => {
    ExpenseRepository.product.splice(index, 1);
    console.log(ExpenseRepository.product);
};

const formData = reactive({
    ncy: null,
    earningDetails: ExpenseRepository.product,
    grandTotal: "",
    discount: null,
    date: "",
    note: "",
});
const multiple = (pro) => {
    const add = pro.quentity * pro.price;
    return add || 0;
};
watch(
    () => ExpenseRepository.product,
    () => {
        ExpenseRepository.product.forEach((product) => {
            // Update the 'subtotal' property for each service
            product.total = multiple(product);
            console.log(product);
        });
    },
    { deep: true }
);

const totalSum = computed(() => {
    const total = ExpenseRepository.product.reduce(
        (acc, item) => acc + multiple(item),
        0
    );
    formData.grandTotal = total;
    return total;
});

const createEarning = async () => {
    formData.earningDetails.map((data) => (data.product = data.id));
    await ExpenseRepository.CreateEarning(formData);
};

const saveData = async (id) => {
    await ExpenseRepository.fetchProduct(id);
};

const deleteItem = async (item) => {
    await ExpenseRepository.deleteEarning(item.id);
};
formData.date = ExpenseRepository.getCurrentDate();
ExpenseRepository.ExpenseAllData();
</script>

<style scoped>
.input > :nth-child(1) > :nth-child(1) {
    height: 3rem;
    border: none;
}

.product-table {
    display: flex;
    justify-content: space-between;

    border-right: 4px solid #fecd07;
}
.table-row {
    display: flex;
    justify-content: space-between;
    padding: 20px;
}
.table {
    width: 100rem;
}
.thead {
    border-right: 4px solid #fecd07;
}
.v-input__control {
    width: 70rem;
}
.discount {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
}
</style>
