<template>
    <div class="search w-full py-8 ml-4">
        <v-card max-width="262" class="border">
            <v-text-field
                class="w-full"
                :loading="loading"
                append-inner-icon="mdi-magnify"
                label="Search"
                variant="solo"
                hide-details
                single-line
                @click:append-inner="onClick"
            ></v-text-field>
        </v-card>
    </div>
</template>
<script>
import { ref } from "vue";

export default {
    setup() {
        // Define reactive properties
        const loaded = ref(false);
        const loading = ref(false);

        // Define method
        const onClick = () => {
            loading.value = true;

            setTimeout(() => {
                loading.value = false;
                loaded.value = true;
            }, 2000);
        };

        // Return reactive properties and method
        return {
            loaded,
            loading,
            onClick,
        };
    },
};
</script>
