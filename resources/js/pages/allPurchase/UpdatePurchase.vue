<template>
    <toolbar title="Purchase-" subtitle="Update Purchase " />
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white">
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <div class="d-flex pt-12 w-full">
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

                <v-autocomplete
                    :items="PurchaseRepository.wharehouseSuplier.supplier"
                    v-model="formData.supplier"
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
                    :items="PurchaseRepository.wharehouseSuplier.warehouse"
                    v-model="formData.warehouse"
                    @update:modelValue="
                        PurchaseRepository.GetCurrency(
                            PurchaseRepository.wharehouseSuplier.currency,
                            formData.warehouse
                        )
                    "
                    :return-object="false"
                    variant="outlined"
                    label="  Wharehouse* "
                    class="pb-4 pl-4 input"
                    style="width: 45%"
                    item-title="name"
                    item-value="id"
                    density="compact"
                ></v-autocomplete>

                <v-text-field
                    v-model="formData.invoiceNumber"
                    variant="outlined"
                    label="Invice Number* "
                    class="pb-4 pl-4 input"
                    style="width: 45%"
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
                                        @click="
                                            PurchaseRepository.fetchMaterial(
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
                                            class="w-2/5"
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
                    type="number"
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
                    type="number"
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
                    type="number"
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
                <v-btn color="primary" @click="update">update</v-btn>
            </div>
        </div>
    </div>
</template>

<script setup>
// import Menu from "@/components/UI/Menu.vue";
import { reactive, computed, ref, watch } from "vue";
import { useRoute } from "vue-router";
import Toolbar from "../../Component/UI/Toolbar.vue";
const items = ref([]);

import { usePurchaseRepository } from "@/store/PurchaseRepository";
const PurchaseRepository = usePurchaseRepository();

// const removeProduct = (index) => {
//     const product = PurchaseRepository.searchFetch[index];
//     PurchaseRepository.searchFetch.splice(index, 1);
//     index.deleted = true;

//     console.log(index);
// };
const clearSearch = () => {
    PurchaseRepository.purchaseSearch = null;
    PurchaseRepository.searchResults = [];
    PurchaseRepository.searchFetch = "";
};

// console.log(PurchaseRepository.wharehouseSuplier.peoples.currencySymbol, "jawad");

const removeProduct = (index) => {
    PurchaseRepository.purchaseMaterial.splice(index, 1);
    // console.log(PurchaseRepository.purchaseMaterial);
};
const routeParams = useRoute();
let formData = [];
PurchaseRepository.FetchPurchase(routeParams.params.id).then((res) => {
    formData = reactive({
        id: PurchaseRepository.purchase.id,

        purchaseDetails: PurchaseRepository.purchase.purchaseDetails,

        grandTotal: PurchaseRepository.purchase.grandTotal,
        details: PurchaseRepository.purchase.details,
        supplier: PurchaseRepository.purchase.supplier.id,
        warehouse: PurchaseRepository.purchase.warehouse.id,
        invoiceNumber: PurchaseRepository.purchase.invoiceNumber,
        currency: PurchaseRepository.purchase.currency.id,

        shipping: PurchaseRepository.purchase.shipping,
        discount: PurchaseRepository.purchase.discount,
        status: PurchaseRepository.purchase.status.id,
        tax: PurchaseRepository.purchase.tax,
        date: PurchaseRepository.purchase.date,
    });
    console.log(formData.supplier);
    // console.log(formData.expenseDetails, "man");
});
const statusOptions = [
    { id: 0, name: "ordered" },
    { id: 1, name: "pending" },
    { id: 2, name: "received" },
];

// console.log(getCurrencySymbol(), "man");
// Function to calculate the total for a product
const multiple = (pro) => {
    const add = pro.quantity * pro.price;
    // console.log(add);
    return add || 0;
};

// Watch function to update the total for each expense product
watch(
    () => PurchaseRepository.purchaseMaterial,
    () => {
        if (Array.isArray(PurchaseRepository.purchaseMaterial)) {
            PurchaseRepository.purchaseMaterial.forEach((purchaseMaterial) => {
                // Update the 'subtotal' property for each service
                purchaseMaterial.total = multiple(purchaseMaterial);
                // console.log(purchaseMaterial);
            });
        } else {
            console.warn(
                "PurchaseRepository.purchaseMaterial is not an array:",
                PurchaseRepository.purchaseMaterial
            );
        }
    },
    { deep: true }
);

// Computed property for total sum
const calculateSubtotal = (pro) => {
    return pro.quantity * pro.unitCost || 0;
};

const totalSum = computed(() => {
    console.log(
        "PurchaseRepository.purchaseMaterial:",
        PurchaseRepository.purchaseMaterial
    );
    const materials = PurchaseRepository.purchaseMaterial || [];

    return materials.reduce((acc, item) => {
        console.log("Item:", item);
        return acc + (item ? calculateSubtotal(item) : 0);
    }, 0);
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

// Update function to handle form data
const update = async () => {
    console.log(
        "Original purchaseDetails:",
        JSON.stringify(formData.purchaseDetails, null, 2)
    );

    formData.purchaseDetails = formData.purchaseDetails
        .map((data) => {
            // Assuming data already contains the required fields directly
            if (data.id && data.quantity && data.unitCost) {
                return {
                    id: data.id,
                    quantity: data.quantity,
                    unitCost: data.unitCost,
                };
            } else {
                console.error("Missing id, quantity, or unitCost", data);
                return null;
            }
        })
        .filter((data) => data !== null);

    console.log(
        "Updated purchaseDetails:",
        JSON.stringify(formData.purchaseDetails, null, 2)
    );

    try {
        await PurchaseRepository.UpdatePurchase(formData.id, formData);
    } catch (error) {
        console.error("Failed to update bill expense:", error);
    }
};
const saveData = async (id) => {
    await ExpenseRepository.fetchMaterial(id);
};

const deleteItem = async (item) => {
    await PurchaseRepository.deleteEarning(item.id);
};
formData.date = PurchaseRepository.getTodaysDate();
PurchaseRepository.GetWharehouseSuplier();
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
    border-left: 4px solid #0872d4;
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
