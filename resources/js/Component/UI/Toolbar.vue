<template>
    <v-app-bar :elevation="0">
        <template v-slot:prepend>
            <v-btn icon="mdi-tune"></v-btn>
            <!-- <v-app-bar-nav-icon></v-app-bar-nav-icon> -->
        </template>

        <v-app-bar-title class="title"
            >{{ pageTitle }}
            <span class="text-[17px]">{{ pageSubtitle }}</span></v-app-bar-title
        >

        <template v-slot:append>
            <v-btn icon="mdi-web"></v-btn>

            <v-btn icon="mdi-crop-free"></v-btn>

            <v-btn icon="mdi-bell-ring-outline"></v-btn>
        </template>
    </v-app-bar>
</template>

<script setup>
import { ref, watchEffect, defineProps } from "vue";

const pageTitle = ref("");
const pageSubtitle = ref("");

const props = defineProps({
    title: String,
    subtitle: String,
});

watchEffect(() => {
    if (props.title) {
        pageTitle.value = props.title;
    }
    if (props.subtitle) {
        pageSubtitle.value = props.subtitle;
    }
});
</script>

<style scoped></style>
