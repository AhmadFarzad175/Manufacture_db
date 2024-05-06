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
    share: (value) => {
        const pattern = /^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
        return pattern.test(value) || "Please enter a valid percentage.";
    },
    asset: (value) => {
        const pattern = /^(?:\d*\.\d{1,2}|\d+)$/;
        return (
            pattern.test(value) ||
            "Please enter a valid numerical value with up to two decimal places."
        );
    },
    email: (value) => {
        const pattern = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
        return pattern.test(value) || "Invalid email address.";
    },
};
// functions
async function updateOwner() {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            const UpdateData = reactive({
                name: PeopleRepository.owner.name,
                phone: PeopleRepository.owner.phone,
                email: PeopleRepository.owner.email,
                share: PeopleRepository.owner.share,
                assets: PeopleRepository.owner.assets,
            });
            PeopleRepository.UpdateOwner(
                PeopleRepository.owner.id,
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
                                v-model="PeopleRepository.owner.name"
                                variant="outlined"
                                label="Name"
                                :rules="[rules.required, rules.name]"
                                class="pb-4 w-1/2"
                            ></v-text-field>
                            <v-text-field
                                v-model="PeopleRepository.owner.phone"
                                variant="outlined"
                                label="Phone"
                                :rules="[rules.required, rules.phone]"
                                class="pb-4 w-1/2"
                            ></v-text-field>
                        </div>
                        <div class="w-full d-flex gap-4">
                            <v-text-field
                                v-model="PeopleRepository.owner.email"
                                variant="outlined"
                                label="Email"
                                :rules="[rules.required, rules.email]"
                                class="pb-4 w-1/2"
                            ></v-text-field>
                            <v-text-field
                                v-model="PeopleRepository.owner.share"
                                variant="outlined"
                                label="Share *"
                                :rules="[rules.required, rules.share]"
                                class="pb-4 relative w-1/2"
                                ><span
                                    class="absulote absolute right-0 top-0 bg-slate-200 p-4 h-full"
                                    >%</span
                                ></v-text-field
                            >
                        </div>
                        <v-text-field
                            v-model="PeopleRepository.owner.assets"
                            variant="outlined"
                            label="Assets"
                            :rules="[rules.required, rules.asset]"
                            class="pb-4 relative"
                        >
                            <span
                                class="absolute right-0 top-0 bg-slate-200 p-4 h-full"
                                >USD</span
                            >
                        </v-text-field>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="updateOwner"
                        >Update</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
