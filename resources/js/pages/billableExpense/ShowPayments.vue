<script setup>
import { useExpenseRepository } from "@/store/ExpenseRepository";

import UpdateRefund from "./UpdateRefund.vue";
let ExpenseRepository = useExpenseRepository();

const editPayment = (id) => {
    ExpenseRepository.refund = {};
    if (Object.keys(ExpenseRepository.refund).length === 0) {
        ExpenseRepository.fetchRefund(id)
            .then(() => {
                // Data has been fetched successfully, now set dialog to true
                ExpenseRepository.dailog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
};
const deleteRefund = async (refund) => {
    await ExpenseRepository.DeleteRefund(refund.id, refund.visa);
};
</script>

<template>
    <UpdateRefund v-if="ExpenseRepository.dailog" />
    <v-dialog
        v-model="ExpenseRepository.showRefundDailog"
        transition="dialog-top-transition"
        width="60vw"
    >
        <template v-slot:default>
            <v-card class="px-3">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Refunds</h2>
                    <v-btn
                        variant="text"
                        @click="ExpenseRepository.showRefundDailog = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <div class="overflow-x-auto rounded-lg mb-6">
                        <table
                            class="w-full text-sm text-center text-gray-500 dark:text-gray-400 border border-gary-500 rounded-lg"
                        >
                            <thead
                                class="text-xs border border-dashed border-gary-200 text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-5">Date</th>
                                    <th scope="col" class="px-6 py-3">
                                        ADDED BY
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        REPERENCE
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        AMOUNT
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        PAID BY
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white border border-dashed border-gary-200 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="refund in ExpenseRepository.refunds"
                                    :key="refund.id"
                                >
                                    <td class="px-6 py-3">
                                        {{ refund.date }}
                                    </td>
                                    <td class="px-6 py-3">
                                        {{ refund.user?.name }}
                                    </td>
                                    <td class="px-6 py-3">
                                        {{ refund.reference }}
                                    </td>
                                    <td class="px-6 py-3">
                                        {{ refund.amount }}
                                    </td>
                                    <td class="px-6 py-3">
                                        {{ refund.moneyAccount.name }}
                                    </td>

                                    <td
                                        class="flex gap-3 justify-center items-center px-2"
                                    >
                                        <v-icon
                                            color="blue"
                                            size="x-large"
                                            @click="editPayment(refund.id)"
                                            >mdi-pencil-circle</v-icon
                                        >
                                        <v-icon
                                            color="red"
                                            size="x-large"
                                            @click="deleteRefund(refund)"
                                            >mdi-delete-circle</v-icon
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
