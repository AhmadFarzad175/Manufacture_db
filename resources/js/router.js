import { createRouter, createWebHistory } from "vue-router";
import SystemSetting from "./pages/setting/SystemSettings/SystemSetting.vue";
import AllCurrencies from "./pages/currency/AllCurrencies.vue";
import MoneyAccount from "./pages/MoneyAccount/MoneyAccount.vue";
import Wharehouse from "./pages/Warehouse/wharehouse.vue";
import Porduct from "./pages/productSetup/Product.vue";
import productMenu from "./pages/productSetup/productMenu.vue";
import AllUnits from "./pages/unit/AllUnits.vue";
import AllProduct from "./pages/productCategory/AllProduct.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: "/systemsetting", component: SystemSetting },
        { path: "/allCurrencies", component: AllCurrencies },
        { path: "/moneyAccount", component: MoneyAccount },
        { path: "/wharehouse", component: Wharehouse },
        { path: "/product", component: Porduct },
        { path: "/productMenu", component: productMenu },
        { path: "/allUnits", component: AllUnits },
        { path: "/allCategory", component: AllProduct },
    ],
});

export default router;
