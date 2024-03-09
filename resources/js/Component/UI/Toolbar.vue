<template>
    <v-app-bar :elevation="0">
        <template v-slot:prepend>
            <v-btn icon="mdi-tune"></v-btn>
            <!-- <v-app-bar-nav-icon></v-app-bar-nav-icon> -->
        </template>

        <v-app-bar-title></v-app-bar-title>

        <template v-slot:append>
            <v-btn icon="mdi-heart"></v-btn>

            <v-btn icon="mdi-magnify"></v-btn>

            <v-btn icon="mdi-bell-ring-outline"></v-btn>
        </template>
    </v-app-bar>
</template>
<script>
export default {
    name: "toolbar",
};
</script>
