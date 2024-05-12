import { defineStore } from "pinia";
import { reactive, ref } from "vue";

// Import Axios
import { axios, setContentType } from "../axios";
// import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";
export let useExpenseRepository = defineStore("ExpensRepository", {
    state() {
        return {
            expense: reactive([]),
            expenses: reactive([]),
            personCategory: reactive([]),

            // =======Billable Expense============\\
            billableExpense: reactive([]),
            billableExpenses: reactive([]),
            product: reactive([]),
            expenseAllData: reactive([]),

            isLoading: false,
            error: null,
            loading: false,
            createDailog: false,
            updateDailog: false,
            page: 1,
            itemsPerPage: 7,
            selectedItems: [],
            selectAll: false,
            showSelect: true,
            router: useRouter(),
            totalItems: 0,
            itemKey: "id",

            Search: "",
            expenseSearch: "",
            searchFetch: "",
            clearSearch: "",
        };
    },
    actions: {
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
        GetCurrency(currency, id) {
            const currArr = currency.filter((curr) => curr.id == id);
            this.symbol = currArr[0].symbol;
            console.log(currArr[0].symbol);
        },
        async GetPersonCategory() {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(`/personCategory`);
            this.personCategory = response.data.data;
            console.log(response.data.data);
            this.loading = false;
        },
        async FetchExpensesData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/expenses?page=${page}&perPage=${itemsPerPage}&search=${this.Search}`
            );
            this.expenses = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async CreateExpense(formData) {
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "/expenses",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            this.createDailog = false;
            this.FetchExpensesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteExpense(id) {
            const config = {
                method: "DELETE",
                url: "/expenses/" + id,
            };

            const response = await axios(config);
            // toast.success("Customer Succesfully Deleted", {
            //     autoClose: 1000,
            // });
            this.FetchExpensesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async FetchExpenseData(id) {
            setContentType("application/json");
            const response = await axios.get(`/expenses/${id}`);

            this.expense = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateExpense(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "PUT",
                url: "/expenses/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Updated", {
            //     autoClose: 1000,
            // });

            this.updateDailog = false;
            this.FetchExpensesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },

        // =================Bilable Expense====================//

        async SearchFetchData() {
            console.log(this.expenseSearch);
            this.loading = true;

            const response = await axios.get(
                ` billableExpenses?&search=${this.expenseSearch}`
            );
            this.searchFetch = response.data.data;
            this.loading = false;
            // this.searchFetch = "";
        },
        async fetchProduct(id, isUpdate = false) {
            // this.error = null;
            try {
                const response = await axios.get(`expense_products/${id}`);

                // console.log("id", response.data.data.id);
                if (isUpdate) {
                    delete response.data.data.id;
                }
                console.log(response.data.data, "fetchProduct");
                this.expenseProduct.push(response.data.data);
                this.billExpense.expenseDetails.push(response.data.data);

                this.searchFetch = [];
            } catch (err) {
                // this.error = err.message;
            }
        },

        async FetchBillableExpensesData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/billableExpenses?page=${page}&perPage=${itemsPerPage}&search=${this.Search}`
            );
            this.billableExpenses = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async ExpenseAllData() {
            const config = {
                url: "expense_all_data",
            };
            const response = await axios(config);
            this.expenseAllData = response.data.data;
        },
        async CreateBillableExpense(formData) {
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "/expenses",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            this.createDailog = false;
            this.FetchExpensesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async productAllData() {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/billableExpenses?search=${this.Search}`
            );
            this.product = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
    },
});
