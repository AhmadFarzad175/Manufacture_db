<script setup>
import { usePeopleRepository } from "@/store/PeopleRepository";

import { reactive, ref } from "vue";
let PeopleRepository = usePeopleRepository();

const visiblePassword = ref(false);
const formRef = ref(null);
const formData = reactive({
    name: "",
    phone: "",
    email: "",
    password: "",

    status: true,
    image: "",
});
// Image Upload Code ----------------------------------------------------------------------------
let imageSrc = ref(null);
const inputRef = ref(null);
const onChangeImage = (e) => {
    imageSrc.value = URL.createObjectURL(e.target.files[0]);
    formData.image = e.target.files[0];
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

// ---------------------------------------------
const createUser = async () => {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            PeopleRepository.CreateUser(formData);
        }
    });
};

const rules = {
    required: (value) => !!value || "Field is Required.",
    counter: (value) => value.length >= 3 || "Min 3 characters",
    phone: (value) => {
        if (value == null || value == "") {
            return;
        }
        return value.length >= 10 || "Min 10 numbers ";
    },
    email: (value) => {
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
        width="60vw"
    >
        <template v-slot:default="{ isActive }">
            <v-card class="py-2">
                <v-card-title class="px-6 d-flex justify-space-between">
                    <h2>Create User</h2>

                    <v-btn variant="text" @click="isActive.value = false"
                        ><v-icon> mdi-close </v-icon></v-btn
                    >
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-form ref="formRef">
                        <!-- Customer Details  ------------------------------------------------------------>

                        <div class="grid grid-col-1 pb-3">
                            <div class="px-2 py-2">
                                <v-row no-gutters>
                                    <v-col cols="12" sm="9" md="9">
                                        <v-text-field
                                            v-model="formData.name"
                                            variant="outlined"
                                            label="Name *"
                                            density="compact"
                                            :rules="[rules.required]"
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="formData.phone"
                                            variant="outlined"
                                            label="Phone *"
                                            density="compact"
                                            :rules="[
                                                rules.required,
                                                rules.phone,
                                            ]"
                                        ></v-text-field>
                                    </v-col>
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
                                                        ? {
                                                              display: 'none',
                                                          }
                                                        : {
                                                              display: 'block',
                                                          }
                                                "
                                            />
                                            <div
                                                class="absolute top-0 h-full w-full rounded-lg bg-opacity-0 flex items-center justify-center border-2 shadow-lg"
                                            >
                                                <button
                                                    v-if="!imageSrc"
                                                    type="button"
                                                    @click="
                                                        OpenWindow(inputRef)
                                                    "
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
                                                    class="rounded-full absolute -bottom-1 -right-1 bg-none text-gray text-white hover:text-blue-500 p-1 shadow-xl transition duration-200"
                                                >
                                                    <v-icon size="small"
                                                        >mdi-close</v-icon
                                                    >
                                                </button>
                                                <button
                                                    v-if="imageSrc"
                                                    type="button"
                                                    @click="
                                                        OpenWindow(inputRef)
                                                    "
                                                    class="rounded-full absolute -top-1 -right-1 text-gray text-white hover:text-blue-500 shodaw-lg p-1 transition duration-200"
                                                >
                                                    <v-icon size="small"
                                                        >mdi-pencil</v-icon
                                                    >
                                                </button>
                                            </div>
                                        </div>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6">
                                        <v-text-field
                                            v-model="formData.email"
                                            variant="outlined"
                                            label="Email *"
                                            suffix="@gmail.com"
                                            density="compact"
                                            :rules="[
                                                rules.required,
                                                rules.email,
                                            ]"
                                        ></v-text-field>
                                        <!-- <v-autocomplete
                                            v-model="formData.rolePermision"
                                            clearable
                                            variant="outlined"
                                            label="Role Permision *"
                                            density="compact"
                                            item-title="name"
                                            item-value="id"
                                            :return-object="false"
                                            :rules="[rules.required]"
                                        ></v-autocomplete> -->
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6" class="pl-2">
                                        <v-text-field
                                            v-model="formData.password"
                                            :append-inner-icon="
                                                visiblePassword
                                                    ? 'mdi-eye-off'
                                                    : 'mdi-eye'
                                            "
                                            :type="
                                                visiblePassword
                                                    ? 'text'
                                                    : 'password'
                                            "
                                            density="compact"
                                            label="Password  *"
                                            variant="outlined"
                                            @click:append-inner="
                                                visiblePassword =
                                                    !visiblePassword
                                            "
                                            :rules="[rules.required]"
                                        ></v-text-field>
                                        <v-layout
                                            class="d-flex justify-space-between border border-black rounded items-center"
                                        >
                                            <p class="px-2">Status</p>
                                            <span class="px-2">
                                                <v-switch
                                                    v-model="formData.status"
                                                    hide-details
                                                    density="compact"
                                                    :true-value="1"
                                                    :false-value="0"
                                                    :model-value="
                                                        formData.status
                                                    "
                                                    color="blue"
                                                ></v-switch>
                                            </span>
                                        </v-layout>
                                    </v-col>
                                </v-row>
                            </div>
                            <v-col cols="3" sm="3">
                                <v-btn
                                    color="light-blue-darken-1"
                                    @click="createUser"
                                    >Submit</v-btn
                                >
                            </v-col>
                        </div>
                    </v-form>
                </v-card-text>
            </v-card>
        </template>
    </v-dialog>
</template>
