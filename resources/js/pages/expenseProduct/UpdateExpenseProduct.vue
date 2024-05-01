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
                            <div class="w-3/5">
                                <v-col cols="10">
                                    <v-text-field
                                        v-model="
                                            SettingRepository.expenseProduct
                                                .name
                                        "
                                        :counter="10"
                                        label="   NAME  * "
                                        variant="outlined"
                                        density="compact"
                                        class="mb-4"
                                        :rules="[rules.required, rules.name]"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="
                                            SettingRepository.expenseProduct
                                                .code
                                        "
                                        :counter="10"
                                        label="   CODE *"
                                        variant="outlined"
                                        density="compact"
                                    ></v-text-field>
                                </v-col>
                            </div>
                            <v-col cols="3" sm="3">
                                <div
                                    class="relative inline-block h-28 w-40 ml-5 rounded-lg object-cover"
                                >
                                    <v-file-input
                                        type="file"
                                        ref="inputRef"
                                        style="display: none"
                                        @change="onChangeImage"
                                    ></v-file-input>

                                    <img
                                        :src="imageSrc"
                                        class="h-28 w-40 object-cover"
                                        :style="
                                            imageSrc === null
                                                ? { display: 'none' }
                                                : { display: 'block' }
                                        "
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
                                            class="rounded-full absolute -top-4 -right-4 text-gray hover:text-blue-500 bg-white shodaw-lg p-1 transition duration-200"
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
                                    v-model="
                                        SettingRepository.expenseProduct
                                            .materialCategory
                                    "
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
                                    v-model="
                                        SettingRepository.expenseProduct.unit
                                    "
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
                                    v-model="
                                        SettingRepository.expenseProduct.price
                                    "
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
                                    v-model="
                                        SettingRepository.expenseProduct
                                            .stockAlert
                                    "
                                    :counter="10"
                                    label="   Stock Alert   * "
                                    variant="outlined"
                                    density="compact"
                                    class="w-1/2"
                                ></v-text-field>
                            </div>
                        </div>
                        <v-textarea
                            v-model="SettingRepository.expenseProduct.details"
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
    materialCategory: SettingRepository.expenseProduct.materialCategory,
    unitId: SettingRepository.expenseProduct.unitId,
    price: SettingRepository.expenseProduct.price,
    stockAlert: SettingRepository.expenseProduct.stockAlert,
    details: SettingRepository.expenseProduct.details,
});
let imageSrc = ref(SettingRepository.expenseProduct.image);

let image_url = SettingRepository.expenseProduct.image_url;
const inputRef = ref(null);
const onChangeImage = (e) => {
    imageSrc.value = URL.createObjectURL(e.target.files[0]);
    UpdateData.image = e.target.files[0];
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
            SettingRepository.UpdateExpenseProduc(formData.id, formData);
        }
    });
};
</script>
<style scoped>
span {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

.switch {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    border: 1px solid #000;
}
.file-input-button {
    display: block;
    width: 7.6rem;
    height: 7.6rem;
    border: 2px dashed #ccc;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    position: relative;
}

.file-input-button img {
    width: 100%;
    height: 100%;
    object-fit: cover;

    /* Make the image cover the entire area */
}

.file-input-button::before {
    content: ""; /* Hide the "Choose File" text */
    display: block;
    text-align: center;
    font-size: 16px;
    color: #666;
}

.file-input-button:hover {
    background-color: #f0f0f0; /* Change the background color on hover */
}

.hidden {
    display: none;
}
</style>
