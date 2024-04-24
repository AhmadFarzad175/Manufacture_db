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
async function updateAccount() {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            // MoneyAccountRepository.UpdateCurrency(
            // MoneyAccountRepository.currency.id,
            // MoneyAccountRepository.currency
            // );
            const UpdateData = reactive({
                name: MoneyAccountRepository.account.name,
                currency: MoneyAccountRepository.account.currency,
                price: MoneyAccountRepository.account.currency,
            });
            MoneyAccountRepository.UpdateAccount(
                MoneyAccountRepository.account.id,
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
        width="700px"
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
                    <v-form ref="formRef" class="d-flex gap-4 flex-col">
                        <div class="w-full">
                            <v-text-field
                                v-model="MoneyAccountRepository.currency.name"
                                variant="outlined"
                                label="Name*"
                                :rules="[rules.required, rules.counter]"
                                class="pb-4"
                            ></v-text-field>
                        </div>
                        <div class="gap-6 w-full d-flex">
                            <v-autocomplete
                                class="w-1/2"
                                v-model="
                                    MoneyAccountRepository.currency.currency
                                "
                                label="Currency*"
                                :rules="[rules.required]"
                                :return-object="false"
                                variant="outlined"
                                item-title="symbol"
                                item-value="id"
                            ></v-autocomplete>

                            <v-text-field
                                v-model="MoneyAccountRepository.currency.price"
                                variant="outlined"
                                label="Price*"
                                :rules="[rules.required, rules.counter]"
                                class="relative w-1/2"
                            >
                                <span
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600"
                                >
                                    {{ MoneyAccountRepository.symbol }}
                                </span>
                            </v-text-field>
                        </div>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="updateAccount"
                        >Update</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
