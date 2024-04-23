import { createRouter, createWebHistory } from "vue-router";
import SystemSetting from "./pages/setting/SystemSettings/SystemSetting.vue";
import AllCurrencies from "./pages/currency/AllCurrencies.vue";
import MoneyAccount from "./pages/MoneyAccount/MoneyAccount.vue";
const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: "/systemsetting", component: SystemSetting },
        { path: "/allCurrencies", component: AllCurrencies },
        { path: "/moneyAccount", component: MoneyAccount },
    ],
});

export default router;
