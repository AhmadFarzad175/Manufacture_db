<template>
    <div class="all-expense rounded-xl m-4">
        <div class="card rounded-xl bg-white">
            <toolbar title="Product Management-" subtitle="Update Consume " />
            <v-divider
                :thickness="1"
                class="border-opacity-100"
                color="success"
            ></v-divider>
            <div class="d-flex pt-12 w-[100%] gap-4 px-4">
                <v-text-field
                    type="date"
                    v-model="formData.date"
                    :return-object="false"
                    variant="outlined"
                    label=" Date*"
                    class="pb-2"
                    style="width: 50%"
                    color="#d3e2f8"
                    density="compact"
                ></v-text-field>
                <v-autocomplete
                    v-model="formData.warehouseId"
                    :return-object="false"
                    variant="outlined"
                    label="  Warehouse * "
                    :items="
                        ProductManagementRepository.consumeAllData.warehouse
                    "
                    class="pb-2"
                    style="width: 50%"
                    item-title="name"
                    item-value="id"
                    density="compact"
                ></v-autocomplete>
            </div>
            <v-card class="rounded px-5 py-4 mb-20 w-[100%] mx-auto pb-10">
                <v-divider></v-divider>
                <v-row no-gutters class="justify-space-between">
                    <v-col cols="full" class="w-50" sm="12" md="12">
                        <v-text-field
                            v-model="ProductManagementRepository.consumeSearch"
                            @keyup.enter="
                                ProductManagementRepository.SearchFetchData(
                                    formData.warehouseId
                                )
                            "
                            @input="
                                ProductManagementRepository.SearchFetchData(
                                    formData.warehouseId
                                )
                            "
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
                                        @click="
                                            ProductManagementRepository.fetchMaterial(
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
                                        RAW MATERIAL
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-start"
                                    >
                                        QTY
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-end">
                                        ACTION
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class=""
                                    v-for="(
                                        pro, index
                                    ) in ProductManagementRepository.consumeMaterial"
                                    :return-object="false"
                                    :key="index"
                                >
                                    <td class="px-3 py-3 text-start">
                                        {{ pro.name }}
                                    </td>

                                    <td
                                        class="py-3 pt-8 flex-row justify-center"
                                    >
                                        <v-text-field
                                            v-model="pro.quantity"
                                            variant="outlined"
                                            density="compact"
                                            type="number"
                                            class="w-1/5"
                                        ></v-text-field>
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
                </v-row>
            </v-card>

            <div class="d-flex mt-16 pt-3 mx-4">
                <v-textarea
                    v-model="formData.details"
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

import { useProductManagementRepository } from "@/store/ProductManagementRepository";
import Toolbar from "../../Component/UI/Toolbar.vue";
import productMenuVue from "../productSetup/productMenu.vue";
const ProductManagementRepository = useProductManagementRepository();

const clearSearch = () => {
    ProductManagementRepository.earningSearch.value = "";
    ProductManagementRepository.searchFetch = "";
};
// console.log(ProductManagementRepository.expenseAllData.peoples.currencySymbol, "jawad");

const removeProduct = (index) => {
    ProductManagementRepository.consumeMaterial.splice(index, 1);
    // console.log(ProductManagementRepository.consumeMaterial);
};
const routeParams = useRoute();
let formData = [];
ProductManagementRepository.FetchConsume(routeParams.params.id).then((res) => {
    formData = reactive({
        id: ProductManagementRepository.consume.id,
        consumeDetails: ProductManagementRepository.consume.consumeDetails,

        warehouseId: ProductManagementRepository.consume.warehouseId,

        date: ProductManagementRepository.consume.date,
        details: ProductManagementRepository.consume.details,
    });

    // console.log(formData.expenseDetails, "man");
});
const update = async () => {
    // console.log(formData);
    formData.consumeDetails.map((data) => {
        if (data.consumeMaterial && data.consumeMaterial.id) {
            data.matrial = { id: data.consumeMaterial.id };
        } else {
            // Handle the case where expenseProduct or its id is not defined
            console.error(
                "expenseProduct or expenseProduct.id is undefined",
                data
            );
        }
    });

    try {
        await ProductManagementRepository.UpdateConsume(formData.id, formData);
    } catch (error) {
        console.error("Failed to update bill expense:", error);
    }
};

// const update = async () => {
//     console.log(formData);
//     formData.consumeDetails = formData.consumeDetails.map((data) => {
//         if (data.consumeMaterial && data.consumeMaterial.id) {
//             return {
//                 quantity: data.quantity !== undefined ? data.quantity : null, // Ensuring quantity is set
//             };
//         } else {
//             // Handle the case where consumeMaterial or its id is not defined
//             console.error(
//                 "consumeMaterial or consumeMaterial.id is undefined",
//                 data
//             );
//             return data;
//         }
//     });

//     try {
//         await ProductManagementRepository.UpdateConsume(formData.id, formData);
//     } catch (error) {
//         console.error("Failed to update bill expense:", error);
//     }
// };

const saveData = async (id) => {
    await ProductManagementRepository.fetchMaterial(id);
};

const deleteItem = async (item) => {
    await ProductManagementRepository.deleteEarning(item.id);
};
formData.date = ProductManagementRepository.getTodaysDate();
ProductManagementRepository.GetWharehose();
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
    border-left: 4px solid #1175e7;
    background-color: #ecf1f4;
}

.discount {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
}
</style>
