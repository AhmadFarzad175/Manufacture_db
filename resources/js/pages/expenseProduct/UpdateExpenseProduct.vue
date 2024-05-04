<template>
    <v-dialog
        transition="dialog-top-transition"
        width="50rem"
        v-model="SettingRepository.updateDailog"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="px-3">
                <v-card-title class="px-6 py-4 d-flex justify-space-between">
                    <h2>Update</h2>

                    <v-btn variant="text" @click="isActive.value = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>

                <v-divider></v-divider>
                <v-spacer></v-spacer>
                <hr />

                <v-card-text>
                    <v-form ref="formRef">
                        <v-row>
                            <div class="w-4/5">
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="formData.name"
                                        :counter="10"
                                        label="   NAME  * "
                                        variant="outlined"
                                        density="compact"
                                        class="mb-4"
                                        :rules="[rules.required, rules.name]"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="formData.code"
                                        :counter="10"
                                        label="   CODE *"
                                        variant="outlined"
                                        density="compact"
                                    ></v-text-field>
                                </v-col>
                            </div>
                            <v-col cols="" sm="" class="w-1/5">
                                <div
                                    class="relative inline-block h-28 w-28 rounded-2xl border-dashed border-2 overflow-hidden"
                                >
                                    <v-file-input
                                        type="file"
                                        ref="inputRef"
                                        style="display: none"
                                        @change="onChangeImage"
                                    ></v-file-input>

                                    <img
                                        :src="imageSrc"
                                        class="h-full w-full object-cover"
                                        :style="{
                                            display: imageSrc
                                                ? 'block'
                                                : 'none',
                                        }"
                                    />
                                    <div
                                        class="absolute top-0 h-full w-full rounded bg-opacity-0 flex items-center justify-center border-2 border-gray-300"
                                    >
                                        <button
                                            v-if="!imageSrc"
                                            type="button"
                                            @click="OpenWindow(inputRef)"
                                            class="rounded-full hover:bg-white hover:bg-opacity-25 p-2 focus:outline-none transition duration-200"
                                        >
                                            <v-icon
                                                size="x-large"
                                                color="blue-grey-lighten-2"
                                                >mdi-camera</v-icon
                                            >
                                        </button>
                                        <button
                                            v-if="imageSrc"
                                            type="button"
                                            @click="CloseWindow()"
                                            class="rounded-full absolute -bottom-3 -right-4 text-gray bg-white hover:text-blue-500 p-1 shadow-xl transition duration-200"
                                        >
                                            <v-icon size="small"
                                                >mdi-close</v-icon
                                            >
                                        </button>
                                        <button
                                            v-if="imageSrc"
                                            type="button"
                                            @click="OpenWindow(inputRef)"
                                            class="rounded-full absolute -top-4 -right-4 text-gray hover:text-blue-500 bg-white shadow-lg p-1 transition duration-200"
                                        >
                                            <v-icon size="small"
                                                >mdi-pencil</v-icon
                                            >
                                        </button>
                                    </div>
                                </div>
                            </v-col>
                        </v-row>
                        <div class="d-flex w-100">
                            <div class="w-50">
                                <v-autocomplete
                                    type="category"
                                    v-model="formData.expenseCategory"
                                    :items="
                                        SettingRepository.productUnit
                                            .materialCategory
                                    "
                                    item-title="name"
                                    item-value="id"
                                    label="   Category *"
                                    variant="outlined"
                                    density="compact"
                                    class="pr-2"
                                ></v-autocomplete>
                            </div>
                            <div class="w-50">
                                <v-autocomplete
                                    v-model="formData.unitId"
                                    :items="SettingRepository.productUnit.unit"
                                    item-title="name"
                                    item-value="id"
                                    label="  UNIT *"
                                    variant="outlined"
                                    density="compact"
                                    class="pr-2"
                                ></v-autocomplete>
                            </div>
                        </div>

                        <div class="d-flex w-100">
                            <!-- <div class="w-50 h-100">
                                <div class="w-100 h-75 d-flex"> -->
                            <!-- <div class="w-100 switch rounded"> -->
                            <!-- <v-switch
                                =============================================
                                   @Update:modelValue="
                                        SettingRepository.GetProducts(
                                            SettingRepository.product.unit,
                                            formData.unitId
                                        )
                                    "
                                ============================================
                                                v-model="formData.status"
                                                :true-value="1"
                                                :false-value="0"
                                                style="height: 2.5rem"
                                                class="pr-4 pb-2"
                                                :color="
                                                    formData.status
                                                        ? 'primary'
                                                        : 'grey'
                                                "
                                                :label="
                                                    formData.status
                                                        ? ' فعال'
                                                        : ' غیر فعال'
                                                "
                                                hide-details
                                                density="compact"
                                                inset
                                            ></v-switch> -->
                            <!-- </div> -->
                            <!-- </div>
                            </div> -->
                            <div class="w-full d-flex">
                                <v-text-field
                                    type="email"
                                    v-model="formData.price"
                                    label="   COST*"
                                    variant="outlined"
                                    density="compact"
                                    class="pr-2 w-1/2"
                                >
                                    <!-- <span -->
                                    <!-- class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600" -->
                                    <!-- >kkkk -->
                                    <!-- {{ MoneyAccountRepository.symbol }} -->
                                    <!-- </span> -->
                                </v-text-field>
                                <v-text-field
                                    v-model="formData.stockAlert"
                                    :counter="10"
                                    label="   Stock Alert   * "
                                    variant="outlined"
                                    density="compact"
                                    class="w-1/2"
                                ></v-text-field>
                            </div>
                        </div>
                        <v-textarea
                            v-model="formData.details"
                            label="   Details   * "
                            variant="outlined"
                            density="compact"
                            class="w-full"
                        ></v-textarea>
                    </v-form>
                </v-card-text>
                <div class="d-flex flex-row mb-6 mx-6">
                    <v-btn color="primary" @click="updateProduct">
                        Submit</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useSettingRepository } from "@/store/SettingRepository";
let SettingRepository = useSettingRepository();
const formRef = ref(null);

const formData = reactive({
    id: SettingRepository.expenseProduct.id,
    image: "",

    name: SettingRepository.expenseProduct.name,
    code: SettingRepository.expenseProduct.code,
    expenseCategory: SettingRepository.expenseProduct.expenseCategory,
    unitId: SettingRepository.expenseProduct.unitId,
    price: SettingRepository.expenseProduct.price,
    stockAlert: SettingRepository.expenseProduct.stockAlert,
    details: "",
});
let imageSrc = ref(SettingRepository.expenseProduct.image);

const inputRef = ref(null);
const onChangeImage = (e) => {
    const file = e.target.files[0]; // Get the selected file
    formData.image = file; // Set the file in formData
    imageSrc.value = URL.createObjectURL(file);
};
const OpenWindow = (action) => {
    if (action) {
        ref(action).value.click();
    }
};
const CloseWindow = () => {
    imageSrc.value = null;
    formData.image = null;
};

// SettingRepository.UpdateProduct(
//     SettingRepository.product.id
//     // SettingRepository.currency.name,
//     // SettingRepository.currency.rate,
//     // SettingRepository.currency.symbl,
//     // UpdateData
// );
SettingRepository.GetUnit();

const rules = {
    required: (value) => !!value || "Field is required. ",
    name: (value) => /^[a-zA-Z\s]*$/.test(value) || "Invalid Name",
    // email: (value) =>
    //     /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || "Invalid Email",
    // //     password: (value) =>
    //         /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(value) ||
    //         "Password must be at least 8 characters long and contain at least one letter and one number",
};

const updateProduct = async () => {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            SettingRepository.UpdateExpenseProduct(formData.id, formData);
        }
    });
};
</script>
