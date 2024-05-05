import { createRouter, createWebHistory } from "vue-router";
import SystemSetting from "./pages/setting/SystemSettings/SystemSetting.vue";
import AllCurrencies from "./pages/currency/AllCurrencies.vue";
import MoneyAccount from "./pages/MoneyAccount/MoneyAccount.vue";
import Wharehouse from "./pages/Warehouse/wharehouse.vue";
import Porduct from "./pages/productSetup/Product.vue";
import productMenu from "./pages/productSetup/productMenu.vue";
import AllUnits from "./pages/unit/AllUnits.vue";
import AllProduct from "./pages/productCategory/AllProduct.vue";
import AllExpense from "./pages/expenseCategory/AllExpense.vue";
import AllTransfer from "./pages/transfer/AllTransfer.vue";
import AllExpenseProduct from "./pages/expenseProduct/AllExpenseProduct.vue";
import AllCustomers from "./pages/customer/AllCustomers.vue";

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
        { path: "/allExpense", component: AllExpense },
        { path: "/allTransfer", component: AllTransfer },
        { path: "/allExpenseProduct", component: AllExpenseProduct },
        { path: "/allCustomers", component: AllCustomers },
    ],
});

export default router;
