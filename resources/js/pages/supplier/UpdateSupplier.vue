<script setup>
import { usePeopleRepository } from "../../store/PeopleRepository";
import { reactive, ref } from "vue";
let PeopleRepository = usePeopleRepository();
const formRef = ref(null);

// this the validtaion rules
const rules = {
    required: (value) => !!value || "Required.",
    counter: (value) => value.length >= 1 || "Min 1 characters",
    phone: (value) => {
        const pattern = /^(\+\d{1,3}[- ]?)?\d{10}$/;
        return pattern.test(value) || "Invalid phone number.";
    },
    email: (value) => {
        const pattern = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
        return pattern.test(value) || "Invalid email address.";
    },
};
// functions
async function updateCustomer() {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            const UpdateData = reactive({
                name: PeopleRepository.customer.name,
                phone: PeopleRepository.customer.phone,
                email: PeopleRepository.customer.email,
            });
            PeopleRepository.UpdateCustomer(
                PeopleRepository.customer.id,
                // PeopleRepository.currency.name,
                // PeopleRepository.currency.rate,
                // PeopleRepository.currency.symbl,
                UpdateData
            );
        }
    });
}
</script>
<template>
    <v-dialog
        v-model="PeopleRepository.updateDailog"
        transition="dialog-top-transition"
        width="700px"
    >
        <template v-slot:default>
            <v-card class="px-3">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Update</h2>
                    <v-btn
                        variant="text"
                        @click="PeopleRepository.updateDailog = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="formRef">
                        <div class="w-full d-flex gap-4">
                            <v-text-field
                                v-model="PeopleRepository.customer.name"
                                variant="outlined"
                                label="Name"
                                :rules="[rules.required, rules.name]"
                                class="pb-4 w-1/2"
                            ></v-text-field>
                            <v-text-field
                                v-model="PeopleRepository.customer.phone"
                                variant="outlined"
                                label="Phone"
                                :rules="[rules.required, rules.phone]"
                                class="pb-4 w-1/2"
                            ></v-text-field>
                        </div>
                        <v-text-field
                            v-model="PeopleRepository.customer.email"
                            variant="outlined"
                            label="Email"
                            :rules="[rules.required, rules.email]"
                            class="pb-4 w-full"
                        ></v-text-field>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="updateCustomer"
                        >Update</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
