<script setup>
import { usePeopleRepository } from "../../store/PeopleRepository";

import { reactive, ref } from "vue";
let PeopleRepository = usePeopleRepository();

const formRef = ref(null);
const formData = reactive({
    name: "",
    phone: "",
    email: "",
});

const createSupplier = async () => {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            PeopleRepository.CreateSupplier(formData);
        }
    });
};

const rules = {
    required: (value) => !!value || "Field is Required.",
    counter: (value) => value.length >= 3 || "Min 3 characters",
    phone: (value) => {
        if (value == "") {
            return;
        }
        return value.length >= 10 || "Min 10 numbers ";
    },
    email: (value) => {
        if (value == "") {
            return;
        }
        const pattern =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(value) || "Invalid e-mail.";
    },
};
</script>
<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="PeopleRepository.createDailog"
        width="600px"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="px-3 py-2">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Create</h2>

                    <v-btn variant="text" @click="isActive.value = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="formRef">
                        <v-row no-gutters class="justify-space-between">
                            <v-col cols="12" sm="12">
                                <v-text-field
                                    v-model="formData.name"
                                    variant="outlined"
                                    label="Expense People *"
                                    density="compact"
                                    :rules="[rules.required, rules.counter]"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" class="pr-2">
                                <v-text-field
                                    v-model="formData.phone"
                                    variant="outlined"
                                    label="Phone *"
                                    density="compact"
                                    :rules="[rules.phone]"
                                ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12">
                                <v-text-field
                                    v-model="formData.email"
                                    variant="outlined"
                                    label="Email *"
                                    suffix="@gmail.com"
                                    density="compact"
                                    :rules="[rules.email]"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="createSupplier"
                        >Submit</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
