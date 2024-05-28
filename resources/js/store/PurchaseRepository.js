import { defineStore } from "pinia";
import { reactive, ref } from "vue";

// Import Axios
import { axios, setContentType } from "../axios";
// import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";
import CreatePurchase from "../pages/allPurchase/CreatePurchase.vue";
export let usePurchaseRepository = defineStore("PurchaseRepository", {
    state() {
        return {
            router: useRouter(),

            // =======Billable Expense============\\
            purchaseSearch: ref(""),
            purchases: reactive([]),
            purchase: reactive([]),

            billExpense: reactive([]),
            wharehouseSuplier: reactive([]),
            searchFetch: reactive([]),
            expenseProduct: reactive([]),
            symbol: ref(""),

            // ============Payment========\\\
            payments: reactive([]),

            isLoading: false,
            dailog: false,
            error: null,
            loading: false,
            createDailog: false,
            updateDailog: false,
            showRefundDailog: false,
            page: 1,
            itemsPerPage: 5,
            selectedItems: [],
            selectAll: false,
            showSelect: true,
            router: useRouter(),
            totalItems: 0,
            itemKey: "id",

            Search: "",

            clearSearch: "",
            currsymbol: reactive([]),
            currsymbolId: reactive([]),
        };
    },
    actions: {
        GetCurrency(currency, id) {
            console.log(currency, id, "this is curr");
            const currArr = currency.filter((curr) => curr.id == id);
            this.currsymbol = currArr[0].symbol;
            this.currsymbolId = currArr[0].id;
            console.log(this.currsymbolId);
        },

        async GetAccounts() {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(`/currency`);
            this.currency = response.data.data;
            console.log(response.data.data);
            this.loading = false;
        },
        getCurrentDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, "0");
            const day = today.getDate().toString().padStart(2, "0");
            return `${year}-${month}-${day}`;
        },
        GetPersonCategory(categorey, name) {
            const accArr = categorey.filter((acc) => acc.id == id);
            this.name = accArr[0].name;
            console.log(currArr[0].name);
        },

        async GetPersonCategory() {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(`/personCategory`);
            this.personCategory = response.data.data;
            console.log(response.data.data);
            this.loading = false;
        },

        // =================Bilable Expense====================//
        getTodaysDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, "0");
            const day = String(today.getDate()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        },

        // entigrating data for create Earnings
        async GetWharehouseSuplier() {
            const config = {
                url: "supplierWarehouse",
            };
            const response = await axios(config);
            this.wharehouseSuplier = response.data.data;
            // console.log(this.expenseAllData, "man");
        },
        async SearchFetchData() {
            console.log(this.purchaseSearch);
            this.loading = true;

            const response = await axios.get(
                `/materials?&search=${this.purchaseSearch}`
            );

            this.searchFetch = response.data.data;
            // console.log(this.SearchFetchData.data);
            // console.log(this.searchFetch, "mann");
            this.loading = false;
            // this.searchFetch = "";
        },
        async fetchMaterial(id, isUpdate = false) {
            // this.error = null;
            try {
                const response = await axios.get(`materials/${id}`);

                console.log("id", response.data.data.id);
                if (isUpdate) {
                    delete response.data.data.id;
                }
                console.log(response.data.data, "fetchProduct");
                this.expenseProduct.push(response.data.data);
                console.log(this.expenseProduct, "data");
                this.billExpense.expenseDetails.push(response.data.data);

                console.log("Fetched product data:", response.data.data); // Console log the fetched data

                // this.searchFetch = [];
            } catch (err) {
                // this.error = err.message;
            }
        },

        async FetchPurchasesData({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `purchases?page=${page}&perPage=${itemsPerPage}&search=${this.purchaseSearch}`
            );
            this.purchases = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async getPurchaseById(id) {
            try {
                const response = await axios.get(`/purchases/${id}`);
                return response.data;
            } catch (err) {
                console.error("Error fetching purchase data:", err);
                return null;
            }
        },
        async CreatePurchase(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "purchases",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.router.push("/allpurchase");

                this.FetchBillExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdatePurchase(id, data) {
            console.log(`Updating bill expense with id: ${id}`, data);
            try {
                const config = {
                    method: "PUT",
                    url: `/purchases/${id}`,
                    data: data,
                };

                const response = await axios(config);

                console.log("Update response:", response);

                router.push("/allpurchase");

                // Assuming FetchPurchasesData is defined elsewhere in the store
                FetchPurchasesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error("Error updating bill expense:", err);
            }
        },

        async DeletePurchase(id) {
            this.isLoading = true;
            this.Purchases = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "purchases/" + id,
                };

                const response = await axios(config);

                this.purchase = response.data.data;
                this.FetchBillExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
    },
});
