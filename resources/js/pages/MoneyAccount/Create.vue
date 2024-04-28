<script setup>
import { useMoneyAccountRepository } from "../../store/MoneyAccountRepository ";

import { reactive, ref } from "vue";
const formRef = ref(null);

let MoneyAccountRepository = useMoneyAccountRepository();
MoneyAccountRepository.GetAccounts();

const formData = reactive({
    id: "",
    name: "",
    currencies: "",
    price: "",
    // accounts: "",
});
const createAccount = async () => {
    const isValid = formRef.value.validate();
    if (isValid) {
        MoneyAccountRepository.CreateAccount(formData);
    }
};

const rules = {
    required: (value) => !!value || "Required.",
    counter: (value) => value.length >= 1 || "Min 1 characters",
};
</script>
<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="MoneyAccountRepository.createDailog"
        width="700px"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="px-3 w-full">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Create</h2>
                    <v-btn variant="text" @click="isActive.value = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="formRef">
                        <v-text-field
                            v-model="formData.name"
                            variant="outlined"
                            label="Bank*"
                            :rules="[rules.required]"
                            class="pb-4"
                            fullWidth
                        ></v-text-field>

                        <div class="d-flex align-center pb-4 gap-4">
                            <v-autocomplete
                                v-model="formData.currencies"
                                @update:modelValue="
                                    MoneyAccountRepository.GetCurrency(
                                        MoneyAccountRepository.currency
                                            .currencies,
                                        formData.currencies
                                    )
                                "
                                :items="
                                    MoneyAccountRepository.currency.currencies
                                "
                                label="Currency*"
                                :rules="[rules.required]"
                                :return-object="false"
                                variant="outlined"
                                item-title="symbol"
                                item-value="id"
                            ></v-autocomplete>
                            <v-text-field
                                v-model="formData.price"
                                variant="outlined"
                                label="Price*"
                                :rules="[rules.required, rules.counter]"
                                class="relative"
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
                    <v-btn color="light-blue-darken-1" @click="createAccount"
                        >Submit</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
