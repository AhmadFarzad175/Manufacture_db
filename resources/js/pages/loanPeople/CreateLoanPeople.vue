<script setup>
import { usePeopleRepository } from "../../store/PeopleRepository";
import { reactive, ref } from "vue";
let PeopleRepository = usePeopleRepository();
const formRef = ref(null);
const formData = reactive({
    id: "",
    name: "",
    phone: "",
    email: "",
});

const createExpensePeople = async () => {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            PeopleRepository.CreateExpensePeople(formData);
        }
    });
};

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
</script>
<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="PeopleRepository.createDailog"
        width="700px"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="px-3">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Create</h2>

                    <v-btn variant="text" @click="isActive.value = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="formRef" class="w-full gap-4">
                        <div class="d-flex gap-4 w-full">
                            <v-text-field
                                v-model="formData.name"
                                variant="outlined"
                                label=" Name *"
                                :rules="[rules.required, rules.name]"
                                class="pb-4"
                            ></v-text-field>
                            <v-text-field
                                v-model="formData.phone"
                                variant="outlined"
                                label="phone *"
                                :rules="[rules.required, rules.phone]"
                                class="pb-4"
                            ></v-text-field>
                        </div>
                        <div class="w-full">
                            <v-text-field
                                v-model="formData.email"
                                variant="outlined"
                                label="Email *"
                                :rules="[rules.required, rules.email]"
                                class="pb-4"
                            ></v-text-field>
                        </div>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn
                        color="light-blue-darken-1"
                        @click="createExpensePeople"
                        >Submit</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
