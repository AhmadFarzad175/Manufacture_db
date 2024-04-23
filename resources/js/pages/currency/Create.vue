<script setup>
import { useSettingRepository } from "../../store/SettingRepository";
import { reactive, ref } from "vue";
let SettingRepository = useSettingRepository();
const formRef = ref(null);
const formData = reactive({
    name: "",
    code: "",
    symbol: "",
    rate: "",
});

const createCurrency = async () => {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            SettingRepository.CreateCurrency(formData);
        }
    });
};

const rules = {
    required: (value) => !!value || "Required.",
    counter: (value) => value.length >= 1 || "Min 1 characters",
};
</script>
<template>
    <v-dialog
        transition="dialog-top-transition"
        v-model="SettingRepository.createDailog"
        width="600px"
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
                    <v-form ref="formRef" class="d-flex gap-4">
                        <div class="w-1/2">
                            <v-text-field
                                v-model="formData.code"
                                variant="outlined"
                                label="Currency Code*"
                                :rules="[rules.required, rules.counter]"
                                class="pb-4"
                            ></v-text-field>
                            <v-text-field
                                v-model="formData.name"
                                variant="outlined"
                                label="Currency Name *"
                                :rules="[rules.required, rules.counter]"
                                class="pb-4"
                            ></v-text-field>
                        </div>
                        <div class="w-1/2">
                            <v-text-field
                                v-model="formData.symbol"
                                variant="outlined"
                                label="Symbol*"
                                :rules="[rules.required, rules.counter]"
                                class="pb-4"
                            ></v-text-field>
                            <v-text-field
                                v-model="formData.rate"
                                variant="outlined"
                                label="Rate*"
                                :rules="[rules.required, rules.counter]"
                                class="pb-4"
                            ></v-text-field>
                        </div>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="createCurrency"
                        >Submit</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
