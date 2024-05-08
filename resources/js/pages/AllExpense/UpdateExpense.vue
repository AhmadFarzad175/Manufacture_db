<script setup>
import { useExpenseRepository } from "../../store/ExpenseRepository";
import { ref, reactive } from "vue";

let ExpensRepository = useExpenseRepository();
ExpensRepository.GetPersonCategory();

const formRef = ref(null);
const UpdateData = reactive({
    id: ExpensRepository.expense.id,
    reference: ExpensRepository.expense.reference,
    date: ExpensRepository.expense.date,
    amount: ExpensRepository.expense.amount,
    expenseCategoryId: ExpensRepository.expense.expenseCategory,
    addedBy: ExpensRepository.expense.addedBy.id,
    personId: ExpensRepository.expense.person,
});
// Date
// this the validtaion rules
const rules = {
    required: (value) => !!value || "Field is Required.",
    counter: (value) => value.length >= 3 || "Min 3 characters",
    phone: (value) => value.length >= 10 || "Min 10 numbers ",
    email: (value) => {
        if (!value) return true;

        const pattern =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(value) || "Invalid e-mail.";
    },
};
// functions
async function updateExpenses() {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            ExpensRepository.UpdateExpense(UpdateData.id, UpdateData);
        }
    });
}
</script>
<template>
    <v-dialog
        v-model="ExpensRepository.updateDailog"
        transition="dialog-top-transition"
        width="700px"
    >
        <template v-slot:default>
            <v-card class="px-3">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Create</h2>
                    <v-btn
                        variant="text"
                        @click="ExpensRepository.updateDailog = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="formRef">
                        <v-row no-gutters>
                            <div class="w-full d-flex">
                                <v-col cols="10" sm="6" class="pb-4">
                                    <v-text-field
                                        v-model="ExpensRepository.expense.date"
                                        variant="outlined"
                                        label="Date *"
                                        :rules="[rules.required]"
                                        density="compact"
                                        type="date"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="6" sm="6">
                                    <v-autocomplete
                                        v-model="UpdateData.expenseCategoryId"
                                        variant="outlined"
                                        :items="
                                            ExpensRepository.personCategory
                                                .expenseCategory
                                        "
                                        label="Category *"
                                        :rules="[rules.required]"
                                        density="compact"
                                        item-title="name"
                                        item-value="id"
                                        :return-object="false"
                                    ></v-autocomplete>
                                </v-col>
                            </div>
                            <div class="w-full d-flex">
                                <v-col cols="6" sm="6" class="pb-2 pl-1">
                                    <v-autocomplete
                                        v-model="UpdateData.personId"
                                        clearable
                                        variant="outlined"
                                        label="Person *"
                                        density="compact"
                                        :items="
                                            ExpensRepository.personCategory
                                                .expensePeople
                                        "
                                        item-title="name"
                                        item-value="id"
                                        :rules="[rules.required]"
                                        :return-object="false"
                                    ></v-autocomplete>
                                </v-col>
                                <v-col cols="6" sm="6">
                                    <v-text-field
                                        v-model="UpdateData.amount"
                                        variant="outlined"
                                        label="Phone"
                                        density="compact"
                                    ></v-text-field>
                                </v-col>
                            </div>
                            <v-textarea
                                v-model="UpdateData.details"
                                label="  Details * "
                                variant="outlined"
                                density="compact"
                            ></v-textarea>
                        </v-row>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="updateExpenses"
                        >Submit</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
