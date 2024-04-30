<script setup>
import { useSettingRepository } from "../../store/SettingRepository";
import { reactive, ref } from "vue";
let SettingRepository = useSettingRepository();
const formRef = ref(null);

// this the validtaion rules
const rules = {
    required: (value) => !!value || " Required.",
    counter: (value) => value.length >= 1 || "Min 1 characters",
};
// functions
async function updateExpenseCategory() {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            // SettingRepository.UpdateCurrency(
            // SettingRepository.currency.id,
            // SettingRepository.currency
            // );
            const UpdateData = reactive({
                name: SettingRepository.expenseCategory.name,
                details: SettingRepository.expenseCategory.details,
            });
            SettingRepository.UpdateExpenseCategory(
                SettingRepository.expenseCategory.id,
                // SettingRepository.currency.name,
                // SettingRepository.currency.rate,
                // SettingRepository.currency.symbl,
                UpdateData
            );
        }
    });
}
</script>
<template>
    <v-dialog
        v-model="SettingRepository.updateDailog"
        transition="dialog-top-transition"
        width="700px"
    >
        <template v-slot:default>
            <v-card class="px-3">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Update</h2>
                    <v-btn
                        variant="text"
                        @click="SettingRepository.updateDailog = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="formRef" class="d-flex gap-4">
                        <div class="w-full">
                            <v-text-field
                                v-model="SettingRepository.expenseCategory.name"
                                variant="outlined"
                                label="Name"
                                :rules="[rules.required, rules.name]"
                                class="pb-4"
                            ></v-text-field>
                            <v-textarea
                                v-model="
                                    SettingRepository.expenseCategory.details
                                "
                                variant="outlined"
                                label="Details"
                                class="pb-4"
                            ></v-textarea>
                        </div>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn
                        color="light-blue-darken-1"
                        @click="updateExpenseCategory"
                        >Update</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
