<script setup>
import { useMoneyAccountRepository } from "../../store/MoneyAccountRepository ";

import { reactive, ref } from "vue";

let MoneyAccountRepository = useMoneyAccountRepository();

const formData = reactive({
    name: "",
    currency_id: "",
    price: "",
});

const rules = {
    required: (value) => !!value || "Required.",
    counter: (value) => value.length >= 1 || "Min 1 characters",
};

// Example currency options

const createAccount = async () => {
    MoneyAccountRepository.CreateAccounts(formData);
};
</script>
<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="MoneyAccountRepository.createDailog"
        width="600px"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="px-3">
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
                        <v-select
                            v-model="formData.currency_id"
                            :items="currencyOptions"
                            label="Currency*"
                            :rules="[rules.required]"
                            class="pb-4"
                        ></v-select>
                        <div class="d-flex align-center pb-4">
                            <v-text-field
                                v-model="formData.price"
                                variant="outlined"
                                label="Price*"
                                :rules="[rules.required, rules.counter]"
                            ></v-text-field
                            ><span class="mb-5 bg-slate-100 p-4 rounded-md">{{
                                formData.currency
                            }}</span>
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
