<template>
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white">
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <div class="d-flex pt-12 w-full">
                <v-text-field
                    v-model="formData.invoiceNumber"
                    variant="outlined"
                    label="Invice Number* "
                    class="pb-4 pl-4 input"
                    style="width: 45%"
                    density="compact"
                ></v-text-field>
                <v-autocomplete
                    :items="ExpenseRepository.expenseAllData.supplier"
                    v-model="formData.supplierId"
                    variant="outlined"
                    label=" Supplier*"
                    class="pb-4 pl-4 input"
                    style="width: 45%"
                    item-title="name"
                    item-value="id"
                    :return-object="false"
                    density="compact"
                ></v-autocomplete>

                <v-autocomplete
                    :items="ExpenseRepository.expenseAllData.expensePeople"
                    v-model="formData.personId"
                    :return-object="false"
                    variant="outlined"
                    label="  Person* "
                    class="pb-4 pl-4 input"
                    style="width: 45%"
                    item-title="name"
                    item-value="id"
                    density="compact"
                ></v-autocomplete>

                <v-text-field
                    type="Date"
                    v-model="formData.date"
                    :return-object="false"
                    variant="outlined"
                    label=" Date*"
                    class="pb-4 pl-4 input"
                    style="width: 45%"
                    color="#d3e2f8"
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
                                        @click="
                                            ExpenseRepository.fetchProduct(
                                                index.id,
                                                true
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
                        <table class="w-full text-sm bg-blue-darken-500 w-100">
                            <thead
                                class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400 thead"
                            >
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
                                        Grand total
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
                                    ) in ExpenseRepository.expenseProduct"
                                    :return-object="false"
                                    :key="index"
                                >
                                    <td class="px-3 py-3 text-start">
                                        {{ pro.name }}
                                    </td>

                                    <td
                                        class="py-3 px-2 pt-8 text-start flex-row justify-"
                                    >
                                        <v-text-field
                                            v-model="pro.quantity"
                                            variant="outlined"
                                            direction="rtl"
                                            density="compact"
                                            type="number"
                                            class="w-50"
                                        ></v-text-field>
                                    </td>

                                    <td
                                        class="py-3 px-2 pt-8 text-start create-input"
                                        dir="auto"
                                    >
                                        <v-text-field
                                            v-if="formData.peopleId !== null"
                                            v-model="pro.price"
                                            variant="outlined"
                                            class="w-100 input"
                                            type="number"
                                        >
                                            <span class="span">
                                                {{ getCurrencySymbol() }}
                                            </span>
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

            <div class="pt-12 w-100 discount">
                <span dir="rtl" class="total"> Total : {{ totalSum }}</span>

                <div class="w-25">
                    <v-text-field
                        v-model="formData.paid"
                        variant="outlined"
                        class="w-100 input"
                        type="number"
                        label="  Paid *"
                    >
                        <span class="span">{{
                            ExpenseRepository.currsymbol
                        }}</span>
                    </v-text-field>
                </div>
            </div>

            <div></div>
            <div class="d-flex mt-16 pt-16">
                <v-textarea
                    v-model="formData.note"
                    class="textArea"
                    label="Details"
                    variant="outlined"
                >
                </v-textarea>
            </div>
            <div class="d-flex flex-row-reverse mb-6 mx-6">
                <v-btn color="primary" @click="update"> Submit</v-btn>
            </div>
        </div>
    </div>
</template>

<script setup>
// import Menu from "@/components/UI/Menu.vue";
import { reactive, computed, ref, watch } from "vue";
import { useRoute } from "vue-router";
const items = ref([]);

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
    ExpenseRepository.searchFetch = "";
};
// console.log(ExpenseRepository.expenseAllData.peoples.currencySymbol, "jawad");

const removeProduct = (index) => {
    ExpenseRepository.expenseProduct.splice(index, 1);
    // console.log(ExpenseRepository.expenseProduct);
};
const routeParams = useRoute();
let formData = [];
ExpenseRepository.FetchBillExpense(routeParams.params.id).then((res) => {
    formData = reactive({
        id: ExpenseRepository.billExpense.id,
        // currency: ExpenseRepository.billExpense.baseCurrency,
        expenseDetails: ExpenseRepository.billExpense.expenseDetails,

        total: ExpenseRepository.billExpense.total,
        // expenseCategoryId: ExpenseRepository.billExpense.expenseCategoryId,
        // deletedIds: [],
        supplierId: ExpenseRepository.billExpense.supplierId,
        personId: ExpenseRepository.billExpense.personId,
        invoiceNumber: ExpenseRepository.billExpense.invoiceNumber,
        currencyId: ExpenseRepository.billExpense.currencyId,

        date: ExpenseRepository.billExpense.date,
        details: ExpenseRepository.billExpense.details,
        paid: ExpenseRepository.billExpense.paid,
    });
    console.log(formData.invoiceNumber, "invoiceNumber");
    // console.log(formData.expenseDetails, "man");
});

const getCurrencySymbol = () => {
    if (formData.value && formData.value.peopleId !== null) {
        const person = ExpenseRepository.expenseAllData.peoples.currsymbol.find(
            (person) => person === formData.value.peopleId
        );
        return person.currsymbol;
    } else {
        return "";
    }
};
// console.log(getCurrencySymbol(), "man");
const multiple = (pro) => {
    const add = pro.quantity * pro.price;
    // console.log(add);
    return add || 0;
};
watch(
    () => ExpenseRepository.expenseProduct,
    () => {
        ExpenseRepository.expenseProduct.forEach((expenseProduct) => {
            // Update the 'subtotal' property for each service
            expenseProduct.total = multiple(expenseProduct);
            // console.log(expenseProduct);
        });
    },
    { deep: true }
);

const totalSum = computed(() => {
    const total = ExpenseRepository.expenseProduct.reduce(
        (acc, item) => acc + multiple(item),
        0
    );
    formData.grandTotal = total;
    return total;
});

const update = async () => {
    // console.log(formData);
    formData.expenseDetails.map((data) => {
        if (data.expenseProduct && data.expenseProduct.id) {
            data.product = { id: data.expenseProduct.id };
        } else {
            // Handle the case where expenseProduct or its id is not defined
            console.error(
                "expenseProduct or expenseProduct.id is undefined",
                data
            );
        }
    });

    try {
        await ExpenseRepository.UpdateBillExpense(formData.id, formData);
    } catch (error) {
        console.error("Failed to update bill expense:", error);
    }
};

const saveData = async (id) => {
    await ExpenseRepository.fetchProduct(id);
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
</style>
