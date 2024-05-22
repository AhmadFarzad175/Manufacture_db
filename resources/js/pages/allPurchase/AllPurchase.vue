<script setup>
import toolbar from "../../Component/UI/Toolbar.vue";
import { usePurchaseRepository } from "@/store/PurchaseRepository";

let PurchaseRepository = usePurchaseRepository();

const headers = [
    { title: "DATE", key: "date", sortable: false, align: "center" },
    { title: "REFERENCE", key: "reference", sortable: false, align: "center" },
    {
        title: "SUPPLIER",
        key: "supplier.name",
        sortable: false,
        align: "center",
    },
    {
        title: "ADDED BY",
        key: "addedBy.name",
        sortable: false,
        align: "center",
    },
    {
        title: "WAREHOUSE",
        key: "refundable",
        sortable: false,
        align: "center",
    },
    { title: "STATUS", key: "IsCanceled", sortable: false },
    { title: "GRAND TOTAL", key: "IsCanceled", sortable: false },
    { title: "PAID", key: "paid", sortable: false, align: "center" },
    { title: "DUE", key: "due", sortable: false, align: "center" },
    { title: "PAYMENT STATUS", key: "due", sortable: false, align: "center" },

    { title: "Action", key: "actions", sortable: false, align: "end" },
];
// CRUD function in the Booking

const deleteItem = async (item) => {
    await PurchaseRepository.DeleteCanceledBooking(item.cvId);
};
const createRefund = (item) => {
    PurchaseRepository.dailog = true;
    PurchaseRepository.visaId.push({ id: item.visaId });
};
const showRefunds = async (item) => {
    PurchaseRepository.showRefundDailog = true;
    await PurchaseRepository.ShowRefund(item.visaId);
};
const recoverBooking = async (item) => {
    let data = { IsCanceled: false };
    await PurchaseRepository.RecoverBooking(item.id, data);
};
</script>
<template>
    <CreateRefund v-if="PurchaseRepository.dailog" />
    <ShowRefunds v-if="PurchaseRepository.showRefundDailog" />
    <div class="relative sm:rounded-lg pt-24 pr-8">
        <toolbar title="Purchase-" subtitle="All" />
        <v-layout class="py-5 flex justify-between">
            <div class="w-[20%]">
                <v-text-field
                    v-model="PurchaseRepository.purchaseSearch"
                    label="Search"
                    prepend-inner-icon="mdi-magnify"
                    variant="outlined"
                    name="search"
                    density="compact"
                ></v-text-field>
            </div>
            <div class="flex gap-2 justify-end">
                <v-btn
                    color="green"
                    variant="outlined"
                    size="large"
                    @click="PurchaseRepository.ExportCanceledVisa"
                >
                    <span class="pl-2">EXPORT</span>
                </v-btn>
                <v-btn color="blue" variant="outlined" size="large">
                    <v-icon>mdi-filter-outline</v-icon>
                    <span class="pl-2">FILTER</span>
                </v-btn>
            </div>
        </v-layout>
        <div class="overflow-x-hidden pb-10">
            <v-app>
                <v-main>
                    <v-row>
                        <v-col>
                            <v-data-table-server
                                v-model:items-per-page="
                                    PurchaseRepository.itemsPerPage
                                "
                                :headers="headers"
                                :items-length="PurchaseRepository.totalItems"
                                :items="PurchaseRepository.purchases"
                                :loading="PurchaseRepository.loading"
                                :search="PurchaseRepository.purchaseSearch"
                                item-value="id"
                                @update:options="
                                    PurchaseRepository.FetchPurchasesData
                                "
                                :item-key="PurchaseRepository.purchases"
                                itemKey="id"
                                hover
                            >
                                <template v-slot:item.refundable="{ item }">
                                    <v-layout
                                        class="flex justify-center text-center gap-1"
                                    >
                                        <!-- Display the.symbol -->
                                        <div>{{ item.refundable }}</div>
                                        <span>{{ item.symbol }}</span>
                                    </v-layout>
                                </template>
                                <template v-slot:item.paid="{ item }">
                                    <v-layout
                                        class="flex justify-center text-center gap-1"
                                    >
                                        <!-- Display the.symbol -->
                                        <div>{{ item.paid }}</div>
                                        <span>{{ item.symbol }}</span>
                                    </v-layout>
                                </template>
                                <template v-slot:item.price="{ item }">
                                    <v-layout
                                        class="flex justify-center text-center gap-1"
                                    >
                                        <!-- Display the.symbol -->
                                        <div>{{ item.price }}</div>
                                        <span>{{ item.symbol }}</span>
                                    </v-layout>
                                </template>
                                <template v-slot:item.due="{ item }">
                                    <v-layout
                                        class="flex justify-center text-red-700 text-center gap-1"
                                    >
                                        <!-- Display the.symbol -->
                                        <div>{{ item.due }}</div>
                                        <span>{{ item.symbol }}</span>
                                    </v-layout>
                                </template>

                                <template v-slot:item.IsCanceled="{ item }">
                                    <v-layout>
                                        <v-chip variant="flat" color="red">
                                            {{
                                                item.IsCanceled === 1
                                                    ? "CANCELED"
                                                    : ""
                                            }}
                                        </v-chip>
                                    </v-layout>
                                </template>

                                <template
                                    v-slot:item.actions="{ item }"
                                    class="right"
                                >
                                    <v-menu>
                                        <template v-slot:activator="{ props }">
                                            <v-btn
                                                icon="mdi-dots-vertical"
                                                v-bind="props"
                                                variant="text"
                                            ></v-btn>
                                        </template>

                                        <v-list class="w-[190px]">
                                            <v-list-item>
                                                <v-list-item-title>
                                                    <v-icon color="red"
                                                        >mdi-close</v-icon
                                                    >
                                                    Recover
                                                </v-list-item-title>

                                                <v-list-item-title
                                                    class="cursor-pointer flex justify-start items-center gap-3 pb-3"
                                                    @click="createRefund(item)"
                                                >
                                                    <v-icon
                                                        >mdi-currency-usd</v-icon
                                                    >
                                                    Create Refund
                                                </v-list-item-title>
                                                <v-list-item-title
                                                    class="cursor-pointer flex justify-start items-center gap-3 pb-3"
                                                    @click="showRefunds(item)"
                                                >
                                                    <v-icon>mdi-domain</v-icon>
                                                    Show Refund
                                                </v-list-item-title>

                                                <v-list-item-title
                                                    v-if="
                                                        AuthRepository.permissions &&
                                                        AuthRepository.permissions.includes(
                                                            'deleteCancelTicket'
                                                        )
                                                    "
                                                    class="cursor-pointer flex justify-start items-center gap-3 pb-3"
                                                    @click="deleteItem(item)"
                                                >
                                                    <v-icon
                                                        >mdi-delete-circle</v-icon
                                                    >
                                                    Delete
                                                </v-list-item-title>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>
                                </template>
                            </v-data-table-server>
                        </v-col>
                    </v-row>
                </v-main>
            </v-app>
        </div>
    </div>
</template>
