<script setup>
import { usePurchaseRepository } from "../../store/PurchaseRepository";

import { ref, reactive } from "vue";

let PurchaseRepository = usePurchaseRepository();

const formRef = ref(null);
const formData = reactive({
    purchase: PurchaseRepository.purchaseId[0]?.id,
    amount: "",
    moneyAccount: "",
    details: "",
    date: "",
});
// Date
formData.date = PurchaseRepository.getCurrentDate();
// this the validtaion rules
const rules = {
    required: (value) => !!value || "field is Required.",
    counter: (value) => value.length >= 3 || "Min 3 characters",
};
// functions
async function createExpense() {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            PurchaseRepository.CreateRefund(formData);
            console.log(formData);
        }
        PurchaseRepository.purchaseId = [];
    });
}
</script>
<template>
    <v-dialog
        v-model="PurchaseRepository.dailog"
        transition="dialog-top-transition"
        width="800px"
    >
        <template v-slot:default>
            <v-card class="px-3">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>{{ "Create" }}</h2>
                    <v-btn
                        variant="text"
                        @click="PurchaseRepository.dailog = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="formRef">
                        <v-row no-gutters>
                            <v-col cols="6" sm="6" class="pb-1">
                                <v-text-field
                                    v-model="formData.date"
                                    variant="outlined"
                                    :rules="[rules.required]"
                                    density="compact"
                                    class="w-full"
                                    type="date"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6" sm="6" class="pb-2 pl-2">
                                <v-autocomplete
                                    v-model="formData.moneyAccount"
                                    clearable
                                    variant="outlined"
                                    :label="'Company*'"
                                    density="compact"
                                    item-title="name"
                                    item-value="id"
                                    :rules="[rules.required]"
                                    :return-object="false"
                                ></v-autocomplete>
                            </v-col>
                            <v-col cols="12" sm="12" class="pb-2">
                                <div class="d-flex gap-2">
                                    <v-autocomplete
                                        v-model="formData.moneyAccount"
                                        clearable
                                        variant="outlined"
                                        :label="'Account*'"
                                        density="compact"
                                        item-title="name"
                                        class="w-1/2"
                                        item-value="id"
                                        :rules="[rules.required]"
                                        :return-object="false"
                                    ></v-autocomplete>
                                    <v-text-field
                                        v-model="formData.moneyAccount"
                                        clearable
                                        variant="outlined"
                                        :label="'Amount*'"
                                        density="compact"
                                        class="w-1/2"
                                        item-title="name"
                                        item-value="id"
                                        :rules="[rules.required]"
                                        :return-object="false"
                                    ></v-text-field>
                                </div>
                            </v-col>

                            <v-col cols="12" sm="12" class="pa-0 pb-2">
                                <v-textarea
                                    clearable
                                    v-model="formData.details"
                                    variant="outlined"
                                    density="compact"
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="createExpense">{{
                        "Submit"
                    }}</v-btn>
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
