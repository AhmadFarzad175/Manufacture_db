<template>
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white">
            <toolbar title="Product Management-" subtitle="Create Consume " />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <v-container fluid>
                <v-row class="pt-12" align="start">
                    <v-col cols="12" md="6">
                        <v-text-field
                            type="date"
                            v-model="formData.date"
                            variant="outlined"
                            label="* Date"
                            class="pb-4 input"
                            color="#d3e2f8"
                            density="compact"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-autocomplete
                            :items="
                                ProductManagementRepository.expenseAllData
                                    .warehouse
                            "
                            v-model="formData.warehouse"
                            variant="outlined"
                            label="Warehouse *"
                            class="pb-4 input"
                            item-value="id"
                            item-title="name"
                            density="compact"
                        ></v-autocomplete>
                    </v-col>
                </v-row>
            </v-container>

            <v-card class="rounded px-5 py-4 mb-20 w-full pb-10">
                <v-divider></v-divider>
                <v-row no-gutters class="justify-space-between">
                    <v-col cols="full" class="w-50" sm="12" md="12">
                        <v-text-field
                            v-model="
                                ProductManagementRepository.billExpenseSearch
                            "
                            @keyup.enter="
                                ProductManagementRepository.SearchFetchData
                            "
                            @input="ProductManagementRepository.SearchFetchData"
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
                            v-if="
                                ProductManagementRepository.searchFetch.length >
                                0
                            "
                        >
                            <div>
                                <div
                                    v-for="index in ProductManagementRepository.searchFetch"
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
                            class="w-full text-sm text-left bg-blue-darken-500 w-100"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400 thead"
                            >
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-start"
                                    >
                                        RAW MATERIAL
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-start"
                                    >
                                        QTY
                                    </th>

                                    <th scope="col" class="py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class=""
                                    v-for="(
                                        pro, index
                                    ) in ProductManagementRepository.expenseProduct"
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

            <div></div>
            <div class="d-flex mt-16 pt-16">
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

import { useProductManagementRepository } from "@/store/ProductManagementRepository";
// import { useMoneyAccountRepository } from "../../store/MoneyAccountRepository ";
const ProductManagementRepository = useProductManagementRepository();

// console.log(ProductManagementRepository.expenseAllData.peoples);

console.log(ProductManagementRepository.expenseProduct, "thisi ");

// const removeProduct = (index) => {
//     const product = ProductManagementRepository.searchFetch[index];
//     ProductManagementRepository.searchFetch.splice(index, 1);
//     index.deleted = true;

//     console.log(index);
// };
const clearSearch = () => {
    ProductManagementRepository.billExpenseSearch = "";
    ProductManagementRepository.searchResults = [];
    ExpenseRepository.searchFetch = "";
};

// console.log(ProductManagementRepository.expenseAllData.peoples.currencySymbol, "jawad");

const removeProduct = (index) => {
    ProductManagementRepository.expenseProduct.splice(index, 1);
    console.log(ProductManagementRepository.expenseProduct);
};
// console.log(
// ProductManagementRepository.ExpenseAllData.currency,
// "iddddddddddddddddddddddddddd"
// );
const RemoveProduct = (index) => {
    ProductManagementRepository.expenseProduct[index].name = ""; // or null
};
const formData = reactive({
    expenseDetails: ProductManagementRepository.expenseProduct,
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
            ProductManagementRepository.expenseAllData.peoples.currencySymbol.find(
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
    () => ProductManagementRepository.expenseProduct,
    () => {
        ProductManagementRepository.expenseProduct.forEach((expenseProduct) => {
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
    const total = ProductManagementRepository.expenseProduct.reduce(
        (acc, item) => acc + multiple(item),
        0
    );
    formData.grandTotal = total;
    formData.total = total;
    return total;
});

// const totalSum = computed(() => {
//     const total = ProductManagementRepository.expenseProduct.reduce(
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
    await ProductManagementRepository.CreateBillExpense(formData);
    // Clear search results after creating earning
    clearSearch();
};

const saveData = async (index) => {
    await ProductManagementRepository.fetchProduct(index.id);
    // Clear search results after selecting a product
    clearSearch();
};

const deleteItem = async (item) => {
    await ProductManagementRepository.deleteEarning(item.id);
};
formData.date = ProductManagementRepository.getTodaysDate();
ProductManagementRepository.ExpenseAllData();
</script>

<style scoped>
.all-expense {
    width: 100%;
}
.input > :nth-child(1) > :nth-child(1) {
    height: 3rem;
    border: none;
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
    border-right: 4px solid #fecd07;
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
