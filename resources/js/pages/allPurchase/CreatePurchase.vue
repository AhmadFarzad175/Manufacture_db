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
                    label="Date*"
                    class="pb-4"
                    color="#d3e2f8"
                    density="compact"
                ></v-text-field>

                <v-autocomplete
                    :items="PurchaseRepository.wharehouseSuplier.supplier"
                    v-model="formData.supplierId"
                    :return-object="false"
                    variant="outlined"
                    label="Supplier*"
                    class="pb-4"
                    item-value="id"
                    item-title="name"
                    density="compact"
                ></v-autocomplete>

                <v-autocomplete
                    :items="PurchaseRepository.wharehouseSuplier.warehouse"
                    v-model="formData.personId"
                    :return-object="false"
                    variant="outlined"
                    label="Warehouse*"
                    class="pb-4"
                    item-value="id"
                    item-title="name"
                    density="compact"
                ></v-autocomplete>
                <v-text-field
                    v-model="formData.invoiceNumber"
                    :return-object="false"
                    variant="outlined"
                    label="Invoice Number *"
                    class="pb-4 mr-8"
                    density="compact"
                ></v-text-field>
            </div>
            <v-card class="rounded px-5 py-4 mb-20 w-full pb-10">
                <v-divider></v-divider>
                <v-row no-gutters class="justify-space-between">
                    <v-col cols="full" class="w-50" sm="12" md="12">
                        <v-text-field
                            v-model="PurchaseRepository.purchaseSearch"
                            @keyup.enter="PurchaseRepository.SearchFetchData"
                            @input="PurchaseRepository.SearchFetchData"
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
                            v-if="PurchaseRepository.searchFetch.length > 0"
                        >
                            <div>
                                <div
                                    v-for="index in PurchaseRepository.searchFetch"
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
                                        class="px-6 py-3 text-center"
                                    >
                                        COST
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center"
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
                                        class="px-6 py-3 text-center"
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
                                    ) in PurchaseRepository.expenseProduct"
                                    :key="index"
                                >
                                    <td class="px-3 py-3 text-start">
                                        {{
                                            pro.name
                                                ? pro.name
                                                : "Product Removed"
                                        }}
                                    </td>
                                    <td class="w-[8rem] pt-8">
                                        <v-text-field
                                            v-model="pro.quantity"
                                            variant="outlined"
                                            density="compact"
                                            type="number"
                                        >
                                            <span class="pr-1">USD</span>
                                        </v-text-field>
                                    </td>
                                    <td class="text-center text-green-500">
                                        {{
                                            pro.stock
                                                ? pro.stock
                                                : "Product Removed"
                                        }}
                                    </td>
                                    <td class="pt-8 text-start">
                                        <v-text-field
                                            v-model="pro.price"
                                            variant="outlined"
                                            density="compact"
                                            class="custom-width"
                                            type="number"
                                        >
                                        </v-text-field>
                                    </td>
                                    <td class="text-center">
                                        <span>{{
                                            calculateSubtotal(pro)
                                        }}</span>
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

            <div class="flex justify-end">
                <div class="d-flex flex-col gap-4 text-end">
                    <div class="total py-1 d-flex gap-10">
                        <span>{{ "Tax:" }}</span>
                        <span>
                            <span>{{ taxAmount }}</span>
                            <span class="px-3 py-2"
                                >( {{ formData.tax }} % )</span
                            >
                        </span>
                    </div>
                    <span class="total mr-8 d-flex py-2 gap-8">
                        Discount :
                        <p>USD {{ discount }}</p>
                    </span>
                    <span class="total mr-8 d-flex py-2 gap-8">
                        Shipping :
                        <p>USD {{ shipping }}</p>
                    </span>
                    <span class="total mr-8 d-flex py-2 gap-8">
                        Grand Total:
                        <p>USD {{ grandTotal }}</p>
                    </span>
                </div>
            </div>
            <div class="d-flex gap-4 w-[98%] mx-auto mt-8">
                <v-text-field
                    v-model="formData.tax"
                    variant="outlined"
                    label="Tax"
                    class="pb-4 relative"
                    density="compact"
                >
                    <span
                        class="absolute right-0 py-2 px-2 rounded-r-lg bg-gray-200"
                        >%</span
                    >
                </v-text-field>
                <v-text-field
                    v-model="discount"
                    variant="outlined"
                    label="Discount"
                    class="pb-4 relative"
                    density="compact"
                >
                    <span
                        class="absolute right-0 py-2 px-2 rounded-r-lg bg-gray-200"
                        >USD</span
                    >
                </v-text-field>
                <v-text-field
                    v-model="formData.shipping"
                    variant="outlined"
                    label="Shipping"
                    class="pb-4 relative"
                    density="compact"
                >
                    <span
                        class="absolute right-0 py-2 px-2 rounded-r-lg bg-gray-200"
                        >USD</span
                    >
                </v-text-field>
                <v-text-field
                    v-model="formData.status"
                    variant="outlined"
                    label="Status"
                    class="pb-4 relative"
                    density="compact"
                >
                    <span
                        class="absolute right-0 py-2 px-2 rounded-r-lg bg-gray-200"
                        >USD</span
                    >
                </v-text-field>
            </div>

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
                <v-btn color="primary" @click="createEarning">Create</v-btn>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, computed, ref, watch } from "vue";
import Toolbar from "../../Component/UI/Toolbar.vue";
import { usePurchaseRepository } from "@/store/PurchaseRepository";

const PurchaseRepository = usePurchaseRepository();
const formData = reactive({
    expenseDetails: PurchaseRepository.expenseProduct,
    total: "",
    personId: "",
    currencyId: null,
    grandTotal: "",
    invoiceNumber: "",
    date: "",
    details: "",
    paid: "",
    tax: "",
    status: "",
    shipping: "",
});

const discount = ref(0);
const shipping = ref(0);
const taxAmount = ref(0);

const clearSearch = () => {
    PurchaseRepository.purchaseSearch = null;
    PurchaseRepository.searchResults = [];
    PurchaseRepository.searchFetch = "";
};

const removeProduct = (index) => {
    PurchaseRepository.expenseProduct.splice(index, 1);
};

const calculateSubtotal = (pro) => {
    return pro.quantity * pro.price || 0;
};

const fetchDiscountAndShipping = async () => {
    // Fetch discount and shipping from backend and set them
    const { discount: fetchedDiscount, shipping: fetchedShipping } =
        await PurchaseRepository.fetchDiscountAndShipping();
    discount.value = fetchedDiscount;
    shipping.value = fetchedShipping;
};

const totalSum = computed(() => {
    return PurchaseRepository.expenseProduct.reduce(
        (acc, item) => acc + calculateSubtotal(item),
        0
    );
});

const grandTotal = computed(() => {
    const subtotal = totalSum.value;
    const taxRate = parseFloat(formData.tax) || 0;
    taxAmount.value = (taxRate / 100) * subtotal;
    const total = subtotal + taxAmount.value - discount.value - shipping.value;
    formData.grandTotal = total;
    return Math.max(total, 0);
});

watch(
    () => formData.tax,
    () => {
        grandTotal.value;
    }
);

const createEarning = async () => {
    formData.expenseDetails = PurchaseRepository.expenseProduct.map((data) => ({
        ...data,
        expenseProduct: data.productId,
        price: data.price,
        quantity: data.quantity,
    }));
    await PurchaseRepository.CreateBillExpense(formData);
    clearSearch();
};

const saveData = async (index) => {
    await PurchaseRepository.fetchMaterial(index.id);
    clearSearch();
};

formData.date = PurchaseRepository.getTodaysDate();
PurchaseRepository.GetWharehouseSuplier();
fetchDiscountAndShipping();
</script>

<style scoped>
.all-expense {
    width: 100%;
}
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
    width: 110px;
}
</style>
