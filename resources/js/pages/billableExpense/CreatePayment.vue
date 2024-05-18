<template>
    <v-dialog
        transition="dialog-top-transition"
        width="50rem"
        v-model="ExpenseRepository.createDailog"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="px-3">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Create Payment</h2>

                    <v-btn variant="text" @click="isActive.value = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>

                <v-divider></v-divider>
                <v-spacer></v-spacer>
                <hr />

                <v-card-text class="py-8">
                    <v-form ref="formRef">
                        <v-row>
                            <v-col class="d-flex w-full gap-4">
                                <v-text-field
                                    v-model="formData.date"
                                    variant="outlined"
                                    label="Date *"
                                    :rules="[rules.required]"
                                    density="compact"
                                    type="date"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <div class="d-flex w-100">
                            <div class="w-50">
                                <!-- <v-autocomplete
                                    type="category"
                                    v-model="formData.materialCategory"
                                    @create:modelValue="
                                        ExpenseRepository.GetProducts(
                                            ExpenseRepository.productUnit
                                                .materialCategory,
                                            formData.materialCategory
                                        )
                                    "
                                    :items="
                                        ExpenseRepository.productUnit
                                            .materialCategory
                                    "
                                    item-title="name"
                                    item-value="id"
                                    label="   Category *"
                                    variant="outlined"
                                    density="compact"
                                    class="pr-2"
                                    :rules="[rules.required, rules.email]"
                                ></v-autocomplete> -->
                            </div>
                            <div class="w-50">
                                <!-- <v-autocomplete
                                    type="unit"
                                    v-model="formData.unitId"
                                    @create:modelValue="
                                        ExpenseRepository.GetProducts(
                                            ExpenseRepository.productUnit.unit,
                                            formData.productUnit
                                        )
                                    "
                                    :items="ExpenseRepository.productUnit.unit"
                                    item-title="name"
                                    item-value="id"
                                    label="  UNIT *"
                                    variant="outlined"
                                    density="compact"
                                    class="pr-2"
                                    :rules="[rules.required, rules.email]"
                                ></v-autocomplete> -->
                            </div>
                        </div>

                        <div class="d-flex w-100 mt-2">
                            <div class="w-full d-flex">
                                <v-autocomplete
                                    v-model="formData.personId"
                                    @create:modelValue="
                                        ExpenseRepository.GetPersonCategory(
                                            ExpenseRepository.personCategory
                                                .expensePeople,
                                            formData.expensePeople
                                        )
                                    "
                                    :items="
                                        ExpenseRepository.personCategory
                                            .expensePeople
                                    "
                                    item-title="name"
                                    item-value="id"
                                    label="   Person *"
                                    variant="outlined"
                                    density="compact"
                                    class="pr-2 w-1/2"
                                    :rules="[rules.required]"
                                >
                                    <!-- <span -->
                                    <!-- class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600" -->
                                    <!-- >kkkk -->
                                    <!-- {{ MoneyAccountRepository.symbol }} -->
                                    <!-- </span> -->
                                </v-autocomplete>
                                <v-text-field
                                    v-model="formData.amount"
                                    :counter="10"
                                    label="  Amount * "
                                    variant="outlined"
                                    density="compact"
                                    class="w-1/2 relative"
                                >
                                    <span
                                        class="absolute right-0 top-0 bottom-0 pt-2 px-2 h-full bg-slate-200"
                                        >USD</span
                                    >
                                </v-text-field>
                            </div>
                        </div>
                        <v-textarea
                            v-model="formData.details"
                            label="  Details * "
                            variant="outlined"
                            density="compact"
                        ></v-textarea>
                    </v-form>
                </v-card-text>
                <div class="d-flex flex-row mb-6 mx-6">
                    <v-btn color="primary" @click="createPayment">
                        Submit</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useExpenseRepository } from "../../store/ExpenseRepository";
const ExpenseRepository = useExpenseRepository();
// ExpenseRepository.GetUnit();

ExpenseRepository.GetPersonCategory();

const formData = reactive({
    date: "",

    person: "",

    amount: "",
    details: "",
});
formData.date = ExpenseRepository.getCurrentDate();

const formRef = ref(null);
const rules = {
    required: (value) => !!value || "Field is required. ",
    name: (value) => /^[a-zA-Z\s]*$/.test(value) || "Invalid Name",
    // email: (value) =>
    //     /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || "Invalid Email",
    // //     password: (value) =>
    //         /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(value) ||
    //         "Password must be at least 8 characters long and contain at least one letter and one number",
};

const createPayment = async () => {
    const isValid = await formRef.value.validate();
    if (isValid) {
        ExpenseRepository.CreatePayment(formData);
    }
};
</script>
<style scoped></style>
