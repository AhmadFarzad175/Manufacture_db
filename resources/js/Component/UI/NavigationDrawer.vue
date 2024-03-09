<template>
    <img src="../../assets/logo black (1) 4.png" alt="" />
    <v-card class="mx-auto" width="300">
        <v-list v-model:opened="open">
            <v-list-group>
                <template v-slot:activator="{ props }">
                    <v-list-item
                        class="hover:bg-sky-700"
                        prepend-icon="mdi-cash"
                        title="Expense"
                        value="expense"
                    ></v-list-item>
                    <v-list-item
                        prepend-icon="mdi-cog-outline"
                        title="HRM"
                        value="hrm"
                    ></v-list-item>
                    <v-list-item
                        prepend-icon="mdi-cog-outline"
                        title="Finance"
                        value="finance"
                    ></v-list-item>
                    <v-list-item
                        prepend-icon="mdi-cog-outline"
                        title="People"
                        value="people"
                    ></v-list-item>
                    <v-list-item
                        prepend-icon="mdi-cog-outline"
                        title="Reports"
                        value="reports"
                    ></v-list-item>
                    <v-list-item
                        v-bind="props"
                        prepend-icon="mdi-cog-outline"
                        title="Settings"
                        value="settings"
                    ></v-list-item>
                </template>

                <v-list-group value="System setings">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            title="System setings"
                        ></v-list-item>
                    </template>
                </v-list-group>
                <v-list-group value="currency">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            title="Currency"
                        ></v-list-item>
                    </template>
                </v-list-group>
                <v-list-group value="Moneyaccount">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            title="Mpney Acount"
                        ></v-list-item>
                    </template>
                </v-list-group>
                <v-list-group value="Role Permission">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            title="Role Permission"
                        ></v-list-item>
                    </template>
                </v-list-group>
                <v-list-group value="Adjustment">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            title="Adjustment"
                        ></v-list-item>
                    </template>
                </v-list-group>
                <v-list-group value="Transfer">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            title="Transfer"
                        ></v-list-item>
                    </template>
                </v-list-group>
                <v-list-group value="Product Setup">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            title="Product Setup"
                        ></v-list-item>
                    </template>
                </v-list-group>
            </v-list-group>
        </v-list>
    </v-card>

    <img src="../../assets/Frame 860.png" alt="" />
</template>
<style></style>

<!-- <script>
// export default {
//     name: "NavigationDrawer",
//     // Your component logic goes here
// };
</script> -->
<script>
export default {
    data: () => ({
        open: ["Users"],
    }),
};
</script>
