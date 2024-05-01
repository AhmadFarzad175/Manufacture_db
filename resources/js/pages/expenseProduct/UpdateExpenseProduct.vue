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
                            <v-col cols="10">
                                <v-text-field
                                    v-model="SettingRepository.product.name"
                                    :counter="10"
                                    label="   NAME  * "
                                    variant="outlined"
                                    density="compact"
                                    class="mb-4"
                                    :rules="[rules.required, rules.name]"
                                ></v-text-field>
                                <v-text-field
                                    v-model="SettingRepository.product.code"
                                    :counter="10"
                                    label="   CODE *"
                                    variant="outlined"
                                    density="compact"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2" class="pb-10">
                                <button
                                    @click="triggerFileInput"
                                    class="file-input-button"
                                >
                                    <img
                                        v-if="!formData.image"
                                        src=""
                                        alt="Placeholder Image"
                                        class="w-full h-full font object-cover"
                                    />
                                    <img
                                        :src="
                                            SettingRepository.product.image_url
                                        "
                                        alt="Selected Image"
                                        class="w-full h-full object-cover"
                                    />
                                </button>

                                <input
                                    type="file"
                                    ref="fileInput"
                                    accept="image/*"
                                    @change="handleFileChange"
                                    class="hidden"
                                />
                            </v-col>
                        </v-row>
                        <div class="d-flex w-100">
                            <div class="w-50">
                                <v-autocomplete
                                    type="category"
                                    v-model="
                                        SettingRepository.product
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
                                    v-model="SettingRepository.product.unit"
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
                                    v-model="SettingRepository.product.cost"
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
                                        SettingRepository.product.stockAlert
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
                            v-model="SettingRepository.product.details"
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

const formData = reactive({
    id: SettingRepository.product.id,
    image: SettingRepository.product.image,
    name: SettingRepository.product.name,
    code: SettingRepository.product.code,
    materialCategory: SettingRepository.product.materialCategory,
    unitId: SettingRepository.product.unitId,
    cost: SettingRepository.product.cost,
    stockAlert: SettingRepository.product.stockAlert,
    details: SettingRepository.product.details,
});

let image_url = SettingRepository.product.image_url;
// SettingRepository.UpdateProduct(
//     SettingRepository.product.id
//     // SettingRepository.currency.name,
//     // SettingRepository.currency.rate,
//     // SettingRepository.currency.symbl,
//     // UpdateData
// );
SettingRepository.GetUnit();

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        formData.image_url = URL.createObjectURL(file);
        formData.image = file;
    }
};
const triggerFileInput = () => {
    const fileInput = document.querySelector('input[type="file"]');
    fileInput.click();
};
const rules = {
    required: (value) => !!value || "Field is required. ",
    name: (value) => /^[a-zA-Z\s]*$/.test(value) || "Invalid Name",
    // email: (value) =>
    //     /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || "Invalid Email",
    // //     password: (value) =>
    //         /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(value) ||
    //         "Password must be at least 8 characters long and contain at least one letter and one number",
};

async function updateProduct() {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            SettingRepository.UpdateProduct(id);
        }
    });
}
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
