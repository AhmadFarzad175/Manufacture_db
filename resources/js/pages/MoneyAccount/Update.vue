<script setup>
import { useMoneyAccountRepository } from "../../store/MoneyAccountRepository ";
import { reactive, ref } from "vue";
let MoneyAccountRepository = useMoneyAccountRepository();
const formRef = ref(null);

// this the validtaion rules
const rules = {
    required: (value) => !!value || " Required.",
    counter: (value) => value.length >= 1 || "Min 1 characters",
};
// functions
async function updateCurrency() {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            // MoneyAccountRepository.UpdateCurrency(
            // MoneyAccountRepository.currency.id,
            // MoneyAccountRepository.currency
            // );
            const UpdateData = reactive({
                name: MoneyAccountRepository.currency.name,
                code: MoneyAccountRepository.currency.code,
                rate: MoneyAccountRepository.currency.rate,
                symbol: MoneyAccountRepository.currency.symbol,
            });
            MoneyAccountRepository.UpdateCurrency(
                MoneyAccountRepository.currency.id,
                // MoneyAccountRepository.currency.name,
                // MoneyAccountRepository.currency.rate,
                // MoneyAccountRepository.currency.symbl,
                UpdateData
            );
        }
    });
}
</script>
<template>
    <v-dialog
        v-model="MoneyAccountRepository.updateDailog"
        transition="dialog-top-transition"
        width="600px"
    >
        <template v-slot:default>
            <v-card class="px-3">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Update</h2>
                    <v-btn
                        variant="text"
                        @click="MoneyAccountRepository.updateDailog = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="formRef" class="d-flex gap-4">
                        <div class="w-1/2">
                            <v-text-field
                                v-model="MoneyAccountRepository.currency.code"
                                variant="outlined"
                                label="CODE"
                                :rules="[rules.required, rules.counter]"
                                class="pb-4"
                            ></v-text-field>
                            <v-text-field
                                v-model="MoneyAccountRepository.currency.symbol"
                                variant="outlined"
                                label="SYMBOL"
                                :rules="[rules.required, rules.counter]"
                                class="pb-4"
                            ></v-text-field>
                        </div>
                        <div class="w-1/2">
                            <v-text-field
                                v-model="MoneyAccountRepository.currency.name"
                                variant="outlined"
                                label="Name"
                                :rules="[rules.required, rules.counter]"
                                class="pb-4"
                            ></v-text-field>
                            <v-text-field
                                v-model="MoneyAccountRepository.currency.rate"
                                variant="outlined"
                                label="Rate"
                                class="pb-4"
                            ></v-text-field>
                        </div>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="updateCurrency"
                        >Update</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
