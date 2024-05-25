<template>
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white">
            <toolbar title="Purchase-" subtitle="Create Purchase " />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <div class="d-flex w-full gap-4 pt-12 mx-4">
                <v-text-field
                    type="Date"
                    v-model="formData.date"
                    :return-object="false"
                    variant="outlined"
                    label="  Date*"
                    class="pb-4"
                    color="#d3e2f8"
                    density="compact"
                ></v-text-field>

                <v-autocomplete
                    :items="ExpenseRepository.expenseAllData.supplier"
                    v-model="formData.supplierId"
                    :return-object="false"
                    variant="outlined"
                    label=" Supplier* "
                    class="pb-4"
                    item-value="id"
                    item-title="name"
                    density="compact"
                ></v-autocomplete>

                <v-autocomplete
                    :items="ExpenseRepository.expenseAllData.expensePeople"
                    v-model="formData.personId"
                    @update:modelValue="
                        ExpenseRepository.GetCurrency(
                            ExpenseRepository.expenseAllData.currency,
                            formData.personId
                        )
                    "
                    :return-object="false"
                    variant="outlined"
                    label=" Warehouse  * "
                    class="pb-4"
                    item-value="id"
                    item-title="name"
                    density="compact"
                ></v-autocomplete>
                <v-text-field
                    v-model="formData.invoiceNumber"
                    :return-object="false"
                    variant="outlined"
                    label=" Invoice Number *"
                    class="pb-4 mr-8"
                    density="compact"
                ></v-text-field>
            </div>
            <v-card class="rounded px-5 py-4 mb-20 w-full pb-10">
                <v-divider></v-divider>
                <v-row no-gutters class="justify-space-between">
                    <v-col cols="full" class="w-50" sm="12" md="12">
                        <v-text-field
                            v-model="ExpenseRepository.billExpenseSearch"
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
                                        @click="saveData(index)"
                                        class="cursor-pointer pb-2.5 hover:bg-red"
                                    >
                                        {{ index.name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </v-col>

                    <div class="overflow-x-auto pb-6 table">
                        <table
                            class="w-full text-sm text-left bg-blue-darken-500"
                        >
                            <thead class="text-xs thead">
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
                                        COST
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-start"
                                    >
                                        STOCK
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
                                        SUB TOTAL
                                    </th>
                                    <th scope="col" class="py-3">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class=""
                                    v-for="(
                                        pro, index
                                    ) in ExpenseRepository.expenseProduct"
                                    :key="index"
                                >
                                    <td class="px-3 py-3 text-start">
                                        {{
                                            pro.name
                                                ? pro.name
                                                : "Product Removed"
                                        }}
                                    </td>

                                    <td
                                        class="py-3 px-2 pt-8 text-start flex-row"
                                    >
                                        <v-text-field
                                            v-model="pro.quantity"
                                            variant="outlined"
                                            density="compact"
                                            type="number"
                                            class="w-50"
                                        ></v-text-field>
                                    </td>
                                    <td
                                        class="py-3 px-2 pt-8 text-start flex-row"
                                    >
                                        <v-text-field
                                            v-model="pro.quantity"
                                            variant="outlined"
                                            density="compact"
                                            type="number"
                                            class="w-50"
                                        ></v-text-field>
                                    </td>

                                    <td
                                        class="py-3 px-2 pt-8 text-end"
                                        style="
                                            display: flex;
                                            justify-content: flex-start;
                                        "
                                    >
                                        <v-text-field
                                            v-if="formData.personId !== null"
                                            v-model="pro.price"
                                            variant="outlined"
                                            density="compact"
                                            class="custom-width"
                                            type="number"
                                        >
                                            <span class="span mr-2">
                                                {{
                                                    ExpenseRepository.currsymbol
                                                }}
                                            </span>
                                        </v-text-field>
                                    </td>

                                    <td class="text-center">
                                        <span>{{ multiple(pro) }} </span>
                                    </td>

                                    <td class="py-2 pr-6 px-2 text-start">
                                        <v-icon
                                            color="red"
                                            @click="removeProduct(index)"
                                            class="mdi mdi-trash-can-outline text-end"
                                        ></v-icon>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </v-row>
            </v-card>

            <div class="w-100 discount">
                <div>
                    <v-text-field
                        v-model="formData.paid"
                        variant="outlined"
                        class="absolute ml-4"
                        type="number"
                        density="compact"
                        label="paid*"
                    >
                        <span class="span ml-8">{{
                            ExpenseRepository.currsymbol
                        }}</span>
                    </v-text-field>
                </div>
                <div class="d-flex flex-col gap-2 mr-4">
                    <span class="total"> Order Tax : {{ totalSum }}</span>
                    <span class="total"> Discount : {{ totalSum }}</span>
                    <span class="total"> Shipping : {{ totalSum }}</span>
                    <span class="total"> Grand Total : {{ totalSum }}</span>
                </div>
            </div>

            <div></div>
            <div class="d-flex mx-4 mt-4">
                <v-textarea
                    v-model="formData.details"
                    class="textArea"
                    label="details"
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
import Toolbar from "../../Component/UI/Toolbar.vue";
const items = ref([]);

import { useExpenseRepository } from "@/store/ExpenseRepository";
// import { useMoneyAccountRepository } from "../../store/MoneyAccountRepository ";
const ExpenseRepository = useExpenseRepository();

// console.log(ExpenseRepository.expenseAllData.peoples);

console.log(ExpenseRepository.expenseProduct, "thisi ");

// const removeProduct = (index) => {
//     const product = ExpenseRepository.searchFetch[index];
//     ExpenseRepository.searchFetch.splice(index, 1);
//     index.deleted = true;

//     console.log(index);
// };
const clearSearch = () => {
    ExpenseRepository.billExpenseSearch = null;
    ExpenseRepository.searchResults = [];
    ExpenseRepository.searchFetch = "";
};

// console.log(ExpenseRepository.expenseAllData.peoples.currencySymbol, "jawad");

const removeProduct = (index) => {
    ExpenseRepository.expenseProduct.splice(index, 1);
    console.log(ExpenseRepository.expenseProduct);
};
// console.log(
// ExpenseRepository.ExpenseAllData.currency,
// "iddddddddddddddddddddddddddd"
// );
const RemoveProduct = (index) => {
    ExpenseRepository.expenseProduct[index].name = ""; // or null
};
const formData = reactive({
    expenseDetails: ExpenseRepository.expenseProduct,
    total: "",
    personId: "",
    currencyId: null,
    grandTotal: "",
    invoiceNumber: "",
    date: "",
    details: "",
    paid: "",
});
const getCurrencySymbol = () => {
    if (formData.value && formData.value.peopleId !== null) {
        const person =
            ExpenseRepository.expenseAllData.peoples.currencySymbol.find(
                (person) => person === formData.value.peopleId
            );
        return person.currencySymbol;
    } else {
        return "";
    }
};

console.log(getCurrencySymbol(), "man");
const multiple = (pro) => {
    // console.log(pro);
    const add = pro.quantity * pro.price;
    console.log(add);
    return add || 0;
};
watch(
    () => ExpenseRepository.expenseProduct,
    () => {
        ExpenseRepository.expenseProduct.forEach((expenseProduct) => {
            // Update the 'total' property for each product
            expenseProduct.total = multiple(expenseProduct);
            // console.log(" the expense changed");
        });
        // Recalculate the total sum whenever expenseProduct changes
        totalSum.value; // This triggers the computed property
    },
    { deep: true }
);

watch(
    () => formData.paid,
    () => {
        // Deduct the paid amount from the total sum
        const paid = parseFloat(formData.paid) || 0;
        formData.grandTotal = totalSum.value - paid;
        // console.log("paid changed");
    }
);

const totalSum = computed(() => {
    const total = ExpenseRepository.expenseProduct.reduce(
        (acc, item) => acc + multiple(item),
        0
    );
    formData.grandTotal = total;
    formData.total = total;
    return total;
});

// const totalSum = computed(() => {
//     const total = ExpenseRepository.expenseProduct.reduce(
//         (acc, item) => acc + multiple(item),
//         0
//     );
//     formData.grandTotal = total;
//     return total;
// });

const createEarning = async () => {
    // Map the selected product ID to expenseProduct
    formData.expenseDetails.map(
        (data) => (
            (data.expenseProduct = data.productId), data.price, data.quantity
        )
    );
    await ExpenseRepository.CreateBillExpense(formData);
    // Clear search results after creating earning
    clearSearch();
};

const saveData = async (index) => {
    await ExpenseRepository.fetchProduct(index.id);
    // Clear search results after selecting a product
    clearSearch();
};

const deleteItem = async (item) => {
    await ExpenseRepository.deleteEarning(item.id);
};
formData.date = ExpenseRepository.getTodaysDate();
ExpenseRepository.ExpenseAllData();
</script>

<style scoped>
.all-expense {
    width: 100%;
}

/* color: #5784c8; */

.total {
    border-top: 2px dashed #d3e2f8;
    border-bottom: 2px dashed #d3e2f8;
}
.product-table {
    display: flex;
    justify-content: space-between;
    background-color: #ecf1f4;
    border-right: 4px solid #fecd07;
}
.table-row {
    display: flex;
    justify-content: space-between;
    padding: 20px;
}
.table {
    width: 70rem;
}
.thead {
    border-left: 4px solid #1584c4;
    background-color: #ecf1f4;
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
.custom-width {
    width: 110px; /* Set your desired width here */
}
</style>
