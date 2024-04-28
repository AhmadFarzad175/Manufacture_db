<template>
    <div class="mt-1 border-2 border-t-1 rounded-2xl p-0 w-1/5">
        <!-- <v-card class="mx-auto card" width="300"> -->

        <v-list v-model:opened="open">
            <v-list-group>
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        :append-icon="null"
                        rounded="shaped"
                        title="Raw Material"
                        value="Raw Material"
                        class="hover:bg-green-500"
                    ></v-list-item>
                </template>
            </v-list-group>
        </v-list>
        <v-list v-model:opened="open">
            <v-list-group>
                <template v-slot:activator="{ props }">
                    <v-list-item
                        class="hover:bg-green-500"
                        rounded="shaped"
                        v-bind="props"
                        :append-icon="null"
                        title="Settings"
                        value="settings"
                    ></v-list-item>
                </template>
            </v-list-group>
        </v-list>
        <v-list v-model:opened="open">
            <v-list-group>
                <template v-slot:activator="{ props }">
                    <v-list-item
                        class="hover:bg-green-500"
                        rounded="shaped"
                        v-bind="props"
                        :append-icon="null"
                        title="Settings"
                        value="settings"
                    ></v-list-item>
                </template>
            </v-list-group>
        </v-list>
        <v-list v-model:opened="open">
            <v-list-group>
                <template v-slot:activator="{ props }">
                    <v-list-item
                        class="hover:bg-green-500"
                        rounded="shaped"
                        v-bind="props"
                        :append-icon="null"
                        title="Settings"
                        value="settings"
                    ></v-list-item>
                </template>
            </v-list-group>
        </v-list>
        <!-- </v-card> -->
    </div>
</template>
<script>
export default {
    data: () => ({
        open: ["Settings"],
    }),
    // setup() {
    //     return {
    //         open: ["Settings"],
    //     };
    // },
};
</script>
