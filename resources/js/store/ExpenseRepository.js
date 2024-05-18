import { defineStore } from "pinia";
import { reactive, ref } from "vue";

// Import Axios
import { axios, setContentType } from "../axios";
// import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";
export let useExpenseRepository = defineStore("ExpenseRepository", {
    state() {
        return {
            router: useRouter(),
            currency: reactive([]),

            expense: reactive([]),
            expenses: reactive([]),
            personCategory: reactive([]),

            // =======Billable Expense============\\
            billExpenseSearch: ref(""),
            billExpenses: reactive([]),
            billExpense: reactive([]),
            expenseAllData: reactive([]),
            searchFetch: reactive([]),
            expenseProduct: reactive([]),
            symbol: ref(""),

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

            searchFetch: "",
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
        getTodaysDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, "0");
            const day = String(today.getDate()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        },
        // GetCurrency(expenseAllData, id) {
        //     const currArr = expenseAllData.filter((curr) => curr.id == id);
        //     this.symbol = currArr[0].symbol;
        //     console.log(currArr[0].symbol);
        // },

        // entigrating data for create Earnings
        async ExpenseAllData() {
            const config = {
                url: "personExpenseProduct",
            };
            const response = await axios(config);
            this.expenseAllData = response.data.data;
            // console.log(this.expenseAllData, "man");
        },
        async SearchFetchData() {
            console.log(this.billExpenseSearch);
            this.loading = true;

            const response = await axios.get(
                `/expenseProducts?&search=${this.billExpenseSearch}`
            );

            this.searchFetch = response.data.data;
            // console.log(this.SearchFetchData.data);
            // console.log(this.searchFetch, "mann");
            this.loading = false;
            // this.searchFetch = "";
        },
        async fetchProduct(id, isUpdate = false) {
            // this.error = null;
            try {
                const response = await axios.get(`expenseProducts/${id}`);

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

        async FetchBillExpenses({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `billableExpenses?page=${page}&perPage=${itemsPerPage}&search=${this.billExpenseSearch}`
            );
            this.billExpenses = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchBillExpense(id) {
            // this.error = null;
            try {
                const response = await axios.get(`billableExpenses/${id}`);

                this.billExpense = response.data.data;
                this.expenseProduct = response.data.data.expenseDetails;

                this.expenseProduct = this.expenseProduct.map((data) => {
                    return { ...data, name: data.expenseProduct.name };
                });

                console.log(this.expenseProduct, "fetchBillExpense");
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateBillExpense(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "billableExpenses",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.router.push("/allBillableExpense");

                this.FetchBillExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateBillExpense(id, data) {
            console.log(`Updating bill expense with id: ${id}`, data);
            try {
                const config = {
                    method: "PUT",
                    url: `/billableExpenses/${id}`,
                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);

                console.log("Update response:", response);

                this.router.push("/allBillableExpense");

                this.FetchBillExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error("Error updating bill expense:", err);
                this.error = err;
            }
        },

        async DeleteBillExpense(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "billableExpenses/" + id,
                };

                const response = await axios(config);

                this.supplier = response.data.data;
                this.FetchBillExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async CreatePayment(formData) {
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "/billablePayments/",
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
    },
});
