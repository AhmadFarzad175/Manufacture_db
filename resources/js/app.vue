<template>
    <router-view></router-view>
    <v-layout class="rounded rounded-md">
        <v-navigation-drawer>
            <v-list>
                <v-list-item>
                    <navigation-drawer></navigation-drawer>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar:ev><toolbar></toolbar></v-app-bar:ev>

        <v-main
            class="d-flex align-center justify-center"
            style="min-height: 300px"
        >
            Main Content
        </v-main>
    </v-layout>
</template>
<script setup>
import NavigationDrawer from "./Component/UI/NavigationDrawer.vue";
import Toolbar from "./Component/UI/Toolbar.vue";
</script>
