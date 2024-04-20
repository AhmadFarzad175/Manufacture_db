<template>
    <v-layout class="rounded rounded-md">
        <v-navigation-drawer class="nav">
            <v-list>
                <v-list-item>
                    <navigation-drawer></navigation-drawer
                ></v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar:ev></v-app-bar:ev>

        <v-main
            class="d-flex align-center justify-center flex-col"
            style="min-height: 300px"
        >
            <router-view></router-view>
        </v-main>
    </v-layout>
</template>
<style scoped>
.nav {
    background-color: #f2f3f6;
}
</style>
<script setup>
import NavigationDrawer from "./Component/UI/NavigationDrawer.vue";

import Toolbar from "./Component/UI/Toolbar.vue";
</script>
