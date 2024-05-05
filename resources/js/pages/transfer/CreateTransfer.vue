<script setup>
import { useSettingRepository } from "../../store/SettingRepository";
import { reactive, ref } from "vue";
let SettingRepository = useSettingRepository();
const formRef = ref(null);
const formData = reactive({
    id: "",
    name: "",
    shortName: "",
});

const createUnit = async () => {
    formRef.value.validate().then((validate) => {
        if (validate.valid) {
            SettingRepository.CreateUnit(formData);
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
        width="70rem"
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
                    <v-form class="w-full">
                        <div class="w-full d-flex gap-4">
                            <v-autocomplete
                                type="Date"
                                v-model="formData.name"
                                variant="outlined"
                                label=" DATE*"
                                :rules="[rules.required, rules.counter]"
                                class="pb-4"
                            ></v-autocomplete>

                            <v-autocomplete
                                v-model="formData.shortName"
                                variant="outlined"
                                label="From Warehouse *"
                                :rules="[rules.required, rules.name]"
                                class="pb-4"
                            ></v-autocomplete>
                            <v-autocomplete
                                v-model="formData.shortName"
                                variant="outlined"
                                label="To Warehouse *"
                                :rules="[rules.required, rules.name]"
                                class="pb-4"
                            ></v-autocomplete>
                        </div>
                        <v-col cols="full" class="w-50" sm="12" md="12">
                            <v-text-field
                                v-model="SettingRepository.earningSearch"
                                @keyup.enter="SettingRepository.SearchFetchData"
                                @input="SettingRepository.SearchFetchData"
                                @click:clear="clearSearch"
                                variant="outlined"
                                label="محصولات"
                                density="compact"
                                append-inner-icon="mdi-magnify"
                                clearable
                                class="border-none"
                            ></v-text-field>
                            <div
                                class="rounded shadow-lg px-5 mb-12 w-[83vw]"
                                v-if="SettingRepository.searchFetch.length > 0"
                            >
                                <div>
                                    <div
                                        v-for="index in SettingRepository.searchFetch"
                                        :key="index"
                                    >
                                        <p
                                            @click="
                                                SettingRepository.fetchProduct(
                                                    index.id
                                                )
                                            "
                                            class="cursor-pointer pb-2.5 hover:bg-red"
                                        >
                                            {{ index.name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </v-col>
                    </v-form>
                </v-card-text>
                <div class="justify-start pl-6 pb-6">
                    <v-btn color="light-blue-darken-1" @click="createUnit"
                        >Submit</v-btn
                    >
                </div>
            </v-card>
        </template>
    </v-dialog>
</template>
