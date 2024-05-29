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
                    type="date"
                    v-model="formData.date"
                    variant="outlined"
                    label="Date*"
                    class="pb-4"
                    color="#d3e2f8"
                    density="compact"
                ></v-text-field>
                <v-autocomplete
                    :items="PurchaseRepository.wharehouseSuplier.supplier"
                    v-model="formData.supplierId"
                    variant="outlined"
                    label="Supplier*"
                    class="pb-4"
                    item-value="id"
                    item-title="name"
                    density="compact"
                ></v-autocomplete>
                <v-autocomplete
                    :items="PurchaseRepository.wharehouseSuplier.warehouse"
                    v-model="formData.warehouseId"
                    @update:modelValue="
                        PurchaseRepository.GetCurrency(
                            PurchaseRepository.wharehouseSuplier.currency,
                            formData.warehouseId
                        )
                    "
                    variant="outlined"
                    label="Warehouse*"
                    class="pb-4"
                    item-value="id"
                    item-title="name"
                    density="compact"
                ></v-autocomplete>
                <v-text-field
                    v-model="formData.invoiceNumber"
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
                                    v-for="item in PurchaseRepository.searchFetch"
                                    :key="item.id"
                                >
                                    <p
                                        @click="saveData(item)"
                                        class="cursor-pointer pb-2.5 hover:bg-red"
                                    >
                                        {{ item.name }}
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
                                        AMOUNT
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
                                        COST
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
                                    v-for="(
                                        pro, index
                                    ) in PurchaseRepository.purchaseMaterial"
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
                                        ></v-text-field>
                                    </td>
                                    <td class="text-center text-green-500">
                                        {{ pro.stock }}
                                    </td>
                                    <td class="pt-8 text-start">
                                        <v-text-field
                                            v-model="pro.unitCost"
                                            variant="outlined"
                                            density="compact"
                                            class="custom-width"
                                            type="number"
                                        >
                                            <span class="pr-1">{{
                                                PurchaseRepository.currsymbol
                                            }}</span>
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
                            <span
                                >{{ taxAmount }}
                                {{ PurchaseRepository.currsymbol }}</span
                            >
                            <span class="px-3 py-2"
                                >( {{ formData.tax }} % )</span
                            >
                        </span>
                    </div>
                    <span class="total mr-8 d-flex py-2 gap-8">
                        Discount :
                        <p>
                            {{ PurchaseRepository.currsymbol }}
                            {{ formData.discount }}
                        </p>
                    </span>
                    <span class="total mr-8 d-flex py-2 gap-8">
                        Shipping :
                        <p>
                            {{ PurchaseRepository.currsymbol }}
                            {{ formData.shipping }}
                        </p>
                    </span>
                    <span class="total mr-8 d-flex py-2 gap-8">
                        Grand Total:
                        <p>
                            {{ PurchaseRepository.currsymbol }} {{ grandTotal }}
                        </p>
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
                    v-model="formData.discount"
                    variant="outlined"
                    label="Discount"
                    class="pb-4 relative"
                    density="compact"
                >
                    <span
                        class="absolute right-0 py-2 px-2 rounded-r-lg bg-gray-200"
                        >{{ PurchaseRepository.currsymbol }}</span
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
                        >{{ PurchaseRepository.currsymbol }}</span
                    >
                </v-text-field>
                <v-autocomplete
                    v-model="formData.status"
                    :items="statusOptions"
                    item-value="id"
                    item-title="name"
                    variant="outlined"
                    label="Status"
                    class="pb-4 relative"
                    density="compact"
                ></v-autocomplete>
            </div>
            <div class="d-flex mx-4 mt-4">
                <v-textarea
                    v-model="formData.note"
                    class="textArea"
                    label="Details"
                    variant="outlined"
                ></v-textarea>
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
    purchaseDetails: PurchaseRepository.purchaseMaterial,
    warehouseId: "",
    supplierId: "",
    total: "",
    discount: "",

    invoiceNumber: "",
    currencyId: null, // default currency ID
    date: "",
    note: "",
    shipping: "",
    tax: "",
    status: "",
});

const statusOptions = [
    { id: 0, name: "pending" },
    { id: 1, name: "received" },
    { id: 2, name: "ordered" },
];

const clearSearch = () => {
    PurchaseRepository.purchaseSearch = null;
    PurchaseRepository.searchResults = [];
    PurchaseRepository.searchFetch = "";
};

const removeProduct = (index) => {
    PurchaseRepository.purchaseMaterial.splice(index, 1);
};

const calculateSubtotal = (pro) => {
    return pro.quantity * pro.unitCost || 0;
};

const totalSum = computed(() => {
    return PurchaseRepository.purchaseMaterial.reduce(
        (acc, item) => acc + calculateSubtotal(item),
        0
    );
});

const taxAmount = computed(() => {
    const taxRate = parseFloat(formData.tax) || 0;
    return (taxRate / 100) * totalSum.value;
});

const grandTotal = computed(() => {
    const subtotal = totalSum.value;
    const discount = parseFloat(formData.discount) || 0;
    const shipping = parseFloat(formData.shipping) || 0;
    const total = subtotal + taxAmount.value - discount + shipping;
    formData.total = total;
    return Math.max(total, 0);
});

watch(
    [() => formData.tax, () => formData.discount, () => formData.shipping],
    () => {
        grandTotal.value;
    }
);

const createEarning = async () => {
    formData.purchaseDetails = PurchaseRepository.purchaseMaterial.map(
        (data) => ({
            ...data,
            purchaseMaterial: data.productId,
            unitCost: data.unitCost,
            quantity: data.quantity,
        })
    );
    await PurchaseRepository.CreatePurchase(formData);
    clearSearch();
};

const saveData = async (item) => {
    await PurchaseRepository.fetchMaterial(item.id);
    clearSearch();
};

formData.date = PurchaseRepository.getTodaysDate();
PurchaseRepository.GetWharehouseSuplier();
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
