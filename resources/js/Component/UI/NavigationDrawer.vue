<template>
    <img src="../../assets/logo black (1) 4.png" alt="" class="mx-auto" />
    <div class="side w-full">
        <!-- <v-card class="mx-auto card" width="300"> -->

        <v-list-item
            class="hover:bg-sky-700"
            prepend-icon="mdi-account-multiple-outline"
            :append-icon="null"
            title="Expense"
            value="expense"
        ></v-list-item>

        <v-list-item
            prepend-icon="mdi-cash-marker"
            :append-icon="null"
            title="HRM"
            value="hrm"
        ></v-list-item>
        <v-list-item
            prepend-icon="mdi-card-account-details-outline"
            :append-icon="null"
            title="Finance"
            value="finance"
        ></v-list-item>
        <v-list-item
            prepend-icon="mdi-transmission-tower"
            :append-icon="null"
            title="People"
            value="people"
        ></v-list-item>
        <v-list-item
            prepend-icon="mdi-finance"
            :append-icon="null"
            title="Reports"
            value="reports"
        ></v-list-item>
        <v-list v-model:opened="open">
            <v-list-group class="side" value="expense">
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        prepend-icon="mdi-cog-outline"
                        :append-icon="null"
                        title="Settings"
                        value="settings"
                    ></v-list-item>
                </template>
                <div>
                    <v-list-group value="System setings" class="w-full">
                        <template v-slot:activator="{ props }">
                            <router-link to="/systemsetting">
                                <v-list-item
                                    v-bind="props"
                                    :append-icon="null"
                                    title="System setings"
                                    class="-ml-12 w-full"
                                >
                                </v-list-item>
                            </router-link>
                        </template>
                    </v-list-group>
                    <v-list-group value="currency">
                        <template v-slot:activator="{ props }">
                            <router-link to="/allCurrencies">
                                <v-list-item
                                    :append-icon="null"
                                    v-bind="props"
                                    title="Currency"
                                ></v-list-item>
                            </router-link>
                        </template>
                    </v-list-group>
                    <v-list-group value="Moneyaccount">
                        <template v-slot:activator="{ props }">
                            <router-link to="/moneyAccount">
                                <v-list-item
                                    :append-icon="null"
                                    v-bind="props"
                                    title="Money Acount"
                                ></v-list-item>
                            </router-link>
                        </template>
                    </v-list-group>
                    <v-list-group value="Warehouse">
                        <template v-slot:activator="{ props }">
                            <router-link to="/wharehouse">
                                <v-list-item
                                    :append-icon="null"
                                    v-bind="props"
                                    title="Warehouse"
                                ></v-list-item>
                            </router-link>
                        </template>
                    </v-list-group>
                    <v-list-group value="Role Permission">
                        <template v-slot:activator="{ props }">
                            <v-list-item
                                :append-icon="null"
                                v-bind="props"
                                title="Role Permission"
                            ></v-list-item>
                        </template>
                    </v-list-group>
                    <v-list-group value="Adjustment">
                        <template v-slot:activator="{ props }">
                            <v-list-item
                                :append-icon="null"
                                v-bind="props"
                                title="Adjustment"
                            ></v-list-item>
                        </template>
                    </v-list-group>
                    <v-list-group value="Transfer">
                        <template v-slot:activator="{ props }">
                            <v-list-item
                                :append-icon="null"
                                v-bind="props"
                                title="Transfer"
                            ></v-list-item>
                        </template>
                    </v-list-group>
                    <v-list-group value="Product Setup">
                        <template v-slot:activator="{ props }">
                            <v-list-item
                                :append-icon="null"
                                v-bind="props"
                                title="Product Setup"
                            ></v-list-item>
                        </template>
                    </v-list-group>
                </div>
            </v-list-group>
        </v-list>
        <!-- </v-card> -->
    </div>

    <img src="../../assets/Frame 860.png" alt=" image" class="positio" />
</template>
<style>
.side {
    background-color: #f2f3f6;
    margin-top: 0;
}
</style>

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
