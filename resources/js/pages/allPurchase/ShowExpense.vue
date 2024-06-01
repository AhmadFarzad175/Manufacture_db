<script setup>
import { usePurchaseRepository } from "@/store/PurchaseRepository";

// import UpdateRefund from "./UpdateRefund.vue";
let PurchaseRepository = usePurchaseRepository();

const editPayment = (id) => {
    PurchaseRepository.expense = {};
    if (Object.keys(PurchaseRepository.expense).length === 0) {
        PurchaseRepository.fetchExpense(id)
            .then(() => {
                // Data has been fetched successfully, now set dialog to true
                PurchaseRepository.dailog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};
const deleteRefund = async (expense) => {
    await PurchaseRepository.DeleteRefund(expense.id, expense.bookingId);
};
</script>

<template>
    <UpdateRefund v-if="PurchaseRepository.dailog" />
    <v-dialog
        v-model="PurchaseRepository.ShowExpenseDailog"
        transition="dialog-top-transition"
        width="60vw"
    >
        <template v-slot:default>
            <v-card class="px-3">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Expenses</h2>
                    <v-btn
                        variant="text"
                        @click="PurchaseRepository.ShowExpenseDailog = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>
                <v-divider
                    :thickness="1"
                    class="border-opacity-100"
                    color="success"
                ></v-divider>
                <v-card-text class="">
                    <div class="mb-6">
                        <table
                            class="w-full text-sm border border-l-blue-400-500 rounded-lg"
                        >
                            <thead
                                class="text-xs border border-black bg-gray-200"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-5">Date</th>

                                    <th scope="col" class="px-6 py-3">
                                        REFERENCE
                                    </th>

                                    <th scope="col" class="px-6 py-3">
                                        ADDED BY
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        AMOUNT
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="border bg-white"
                                    v-for="expense in PurchaseRepository.expenses"
                                    :key="expense.id"
                                >
                                    <td class="px-6 py-3">
                                        {{ expense.date }}
                                    </td>
                                    <td class="px-6 py-3">
                                        {{ expense.reference }}
                                    </td>
                                    <td class="px-6 py-3">
                                        {{ expense.addedBy }}
                                    </td>

                                    <td class="px-6 py-3">
                                        {{ expense.amount }}
                                    </td>

                                    <td
                                        class="flex gap-3 justify-center items-center px-2"
                                    >
                                        <v-icon color="black" size="x-large"
                                            >mdi-pencil</v-icon
                                        >
                                        <v-icon
                                            color="red"
                                            size="x-large"
                                            @click="deleteRefund(expense)"
                                            >mdi-delete</v-icon
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </v-card-text>
            </v-card>
        </template>
    </v-dialog>
</template>
