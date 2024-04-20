<template>
    <v-container class="border rounded-lg">
        <toolbar :title="title" :subtitle="subtitle" />
        <div class="border-b-2 mb-2 py-2">
            <h1 class="text-lg">System settings</h1>
        </div>

        <v-form @submit.prevent="submitForm">
            <div class="flex w-full justify-between gap-4 mt-8">
                <div class="w-4/5">
                    <v-text-field
                        label="Company Name*"
                        variant="outlined"
                        density="compact"
                        class="name mt-6"
                        v-model="formData.companyName"
                        required
                    ></v-text-field>

                    <v-text-field
                        class="mt-6"
                        variant="outlined"
                        density="compact"
                        label="Phone Number*"
                        v-model="formData.phoneNumber"
                        required
                    ></v-text-field>
                </div>
                <div class="file-upload-container w-1/5 mb-6 h-40">
                    <label for="fileInput" class="file-upload-label">
                        <v-icon class="mt-16" v-if="!imageUrl"
                            >mdi-camera</v-icon
                        >
                        <img
                            v-else
                            :src="imageUrl"
                            alt="Uploaded Image"
                            class="uploaded-image w-full h-full"
                        />
                        <input
                            type="file"
                            id="fileInput"
                            accept="image/*"
                            @change="handleFileUpload"
                            style="display: none"
                        />
                        <v-icon
                            v-if="imageUrl"
                            class="pen-icon"
                            @click="clearImage"
                            >mdi-pencil</v-icon
                        >
                    </label>
                </div>
            </div>
            <div class="flex flex-row gap-4 mt-2">
                <v-text-field
                    variant="outlined"
                    density="compact"
                    v-model="formData.email"
                    label="Email*"
                    required
                ></v-text-field>
                <v-text-field
                    variant="outlined"
                    density="compact"
                    v-model="formData.address"
                    label="Address*"
                    required
                ></v-text-field>
            </div>

            <v-btn type="submit" color="primary" class="my-8">Submit</v-btn>
        </v-form>
    </v-container>
</template>

<script>
import Toolbar from "../../../Component/UI/Toolbar.vue";
export default {
    components: {
        Toolbar,
    },
    data() {
        return {
            title: "Setting- ",
            subtitle: "System Settngs",
            formData: {
                companyName: "",
                email: "",
                phoneNumber: "",
                address: "",
            },
            imageUrl: null,
            formErrors: {
                companyName: false,
                email: false,
                phoneNumber: false,
                address: false,
                image: false,
            },
        };
    },
    methods: {
        submitForm() {
            this.validateForm();
            if (this.isFormValid()) {
                // Handle form submission logic here
                console.log("Form submitted with data:", this.formData);
            }
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                this.imageUrl = reader.result;
                this.formErrors.image = false;
            };
        },
        clearImage() {
            this.imageUrl = null;
        },
        validateForm() {
            for (const key in this.formData) {
                if (!this.formData[key]) {
                    this.formErrors[key] = true;
                } else {
                    this.formErrors[key] = false;
                }
            }
            if (!this.imageUrl) {
                this.formErrors.image = true;
            }
        },
        isFormValid() {
            return Object.values(this.formErrors).every((error) => !error);
        },
    },
};
</script>

<style scoped>
.file-upload-container {
    position: relative;
}

.file-upload-label {
    display: block;
    background-color: white;
    box-shadow: 0px 7px 9px -3px rgba(0, 0, 0, 0.75);

    border: 1px solid #cec8c8;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    position: relative;
    width: 90%;
    height: 90%;
    margin-top: 1em;
}

.uploaded-image {
    max-width: 100%;
    max-height: 100%;
}

.pen-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}

.image-preview {
    margin-top: 20px;
}

.image-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.error-message {
    color: red;
    margin-top: 8px;
}
</style>
