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
import AllSupplier from "./pages/supplier/AllSupplier.vue";
import AllExpesePeople from "./pages/expensePeople/AllExpensePeople.vue";
import AllLoanPeople from "./pages/loanPeople/AllLoanPeople.vue";
import AllOwner from "./pages/owner/AllOwner.vue";
import AllUser from "./pages/user/AllUser.vue";
import AllExpenses from "./pages/AllExpense/AllExpenses.vue";
import AllBillableExpense from "./pages/billableExpense/AllBillableExpense.vue";
import CreateBillableExpense from "./pages/billableExpense/CreateBillableExpense.vue";
import UpdateBillableExpense from "./pages/billableExpense/UpdateBillableExpense.vue";
import AllConsume from "./pages/consume/AllConsume.vue";
import CreateConsume from "./pages/consume/CreateConsume.vue";
import UpdateConsume from "./pages/consume/UpdateConsume.vue";
// ========Produce==================
import AllProduce from "./pages/produce/AllProduce.vue";
import CreatProduce from "./pages/produce/CreateProduce.vue";
import UpdateProduce from "./pages/produce/UpdateProduce.vue";
// ==============All Purchase ============================\\
import 
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
        { path: "/allsupliers", component: AllSupplier },
        { path: "/allExpensePeople", component: AllExpesePeople },
        { path: "/loanPeople", component: AllLoanPeople },
        { path: "/allOwner", component: AllOwner },
        { path: "/allUser", component: AllUser },
        { path: "/allExpenses", component: AllExpenses },
        { path: "/allBillableExpense", component: AllBillableExpense },
        { path: "/ceateBillableExpense", component: CreateBillableExpense },

        {
            path: "/billableExpenses/:id",
            name: "UpdateBillableExpense",
            component: UpdateBillableExpense,
        },
        { path: "/allConsume", component: AllConsume },
        { path: "/createConsume", component: CreateConsume },
        {
            path: "/updateConsume/:id",
            name: "UpdateConsume",
            component: UpdateConsume,
        },
        // ========Produce ========================\\
        { path: "/allProduce", component: AllProduce },
        { path: "/createProduce", component: CreatProduce },
        {
            path: "/updateProdce/:id",
            name: "UpdateProduce",
            component: UpdateProduce,
        },
    ],
});

export default router;
