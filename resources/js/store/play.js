import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { axios, contentType } from "../axios";
import { useRouter } from "vue-router";

export let useExpenseRepository = defineStore("ExpenseRepository", {
    state() {
        return {
            //  all the variable are in camelCase and except fetch all data all of them don't have sin there
            router: useRouter(),

            search: ref(""),
            serverItems: ref([]),
            loadingTable: ref(true),
            loading: ref(false),
            totalItems: ref(0),
            selectedItems: ref([]),
            itemsPerPage: ref(5),
            ExpenseSearch: ref(""),
            Expenses: reactive([]),
            Expense: reactive([]),
            createDialog: ref(false),
            updateDialog: ref(false),
            // CREATE ALL EXPENSE
            categories: reactive([]),
            people: reactive([]),
            currency: reactive([]),
            getCurrencySymbol: reactive(""),
            // payment sent's
            paymentSents: reactive([]),
            paymentSent: reactive([]),
            paymentSentsSearch: ref(""),
            createPaymentsDialog: ref(false),
            UpdatePaymentsDialog: ref(false),
            manyAccounts: ref(""),
            //  payments  received
            paymentsReceive: reactive([]),
            paymentReceive: reactive([]),
            paymentsReceiveSearch: ref(""),
            createPaymentReceiveDialog: ref(false),
            UpdatePaymentReceiveDialog: ref(false),
            // Expense Categories
            expenseCategory: reactive([]),
            expenseCategories: reactive([]),
            expenseCatSearch: ref(""),
            createExpenseCatDialog: ref(""),
            updateExpenseCatDialog: ref(""),
            // expense people
            expensePeople: reactive([]),
            expensePeoples: reactive([]),
            expensePeopleSearch: ref(""),
            createDialog: ref(false),
            updateDialog: ref(false),
            // expenseProduct
            expenseProductSearch: ref(""),
            expenseProducts: reactive([]),
            expenseProduct: reactive([]),
            // Supplier
            supplierSearch: ref(""),
            suppliers: reactive([]),
            supplier: reactive([]),
            // bill expense
            billExpenseSearch: ref(""),
            billExpenses: reactive([]),
            billExpense: reactive([]),
            expenseAllData: reactive([]),
            searchFetch: reactive([]),
            expenseProduct: reactive([]),
            symbol: ref(""),

            //
        };
    },
    actions: {
        getTodaysDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, "0");
            const day = String(today.getDate()).padStart(2, "0");
            return ${year}-${month}-${day};
        },
        GetCurrency(account, id) {
            console.log(account, id, "this is what i need ");
            const array = account.filter((acc) => acc.id == id);

            this.getCurrencySymbol = array[0].currencySymbol;
            console.log(array[0].currencySymbol, "the currency symbol");
            console.log(this.getCurrencySymbol);
        },
        // kk
        async fetchExpensesData({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                expenses?page=${page}&perPage=${itemsPerPage}&search=${this.ExpenseSearch}
            );
            this.Expenses = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchExpense(id) {
            // this.error = null;
            try {
                const response = await axios.get(expenses/${id});

                this.Expense = response.data.data;
                console.log(this.Expense);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdateExpense(id, data) {
            try {
                const config = {
                    method: "PUT",
                    url: "expenses/" + id,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.updateDialog = false;
                this.fetchExpensesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async CreateExpense(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "expenses",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchExpensesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteExpense(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "expenses/" + id,
                };

                const response = await axios(config);

                // this.Expenses = response.data.data;
                this.fetchExpensesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        //   this is data fro ALL EXPENSE FETCH
        async Categories() {
            const config = {
                url: "expense_categories",
            };
            const response = await axios(config);
            this.categories = response.data.data;
        },

        async People() {
            const config = {
                url: "peoples",
            };
            const response = await axios(config);
            this.people = response.data.data;
            // console.log(this.people);
        },

        async ManyAccounts() {
            const config = {
                url: "accounts",
            };
            const response = await axios(config);
            this.manyAccounts = response.data.data;
            // console.log(this.people);
        },
        async Currency() {
            const config = {
                url: "currencies",
            };
            const response = await axios(config);
            this.currency = response.data.data;
            // console.log(this.people);
        },

        //  payment sent data
        async fetchPaymentSents({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                payment_sents?page=${page}&perPage=${itemsPerPage}&search=${this.paymentSentsSearch}
            );
            this.paymentSents = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },

        async fetchPaymentSent(id) {
            // this.error = null;
            try {
                const response = await axios.get(payment_sents/${id});

                this.paymentSent = response.data.data;
                console.log(this.paymentSent);
            } catch (err) {
                // this.error = err.message;
            }
        },

        async CreatePaymentSent(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "payment_sents",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createPaymentsDialog = false;
                this.fetchPaymentSents({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },

        async UpdatePaymentSent(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: "payment_sents/" + id,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.UpdatePaymentsDialog = false;
                this.fetchPaymentSents({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },

        async DeleteExpense(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "payment_sents/" + id,
                };

                const response = await axios(config);

                this.paymentSents = response.data.data;
                this.fetchPaymentSents({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },

        // payments Receive data
        async fetchPaymentsReceive({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                payment_receiveds?page=${page}&perPage=${itemsPerPage}&search=${this.paymentsReceiveSearch}
            );
            this.paymentsReceive = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },

        async fetchPaymentReceive(id) {
            // this.error = null;
            try {
                const response = await axios.get(payment_receiveds/${id});

                this.paymentReceive = response.data.data;
                console.log(this.paymentReceive);
            } catch (err) {
                // this.error = err.message;
            }
        },

        async CreatePaymentReceive(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "payment_receiveds",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createPaymentReceiveDialog = false;
                this.fetchPaymentsReceive({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },

        async UpdatePaymentReceive(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: "payment_receiveds/" + id,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.UpdatePaymentReceiveDialog = false;
                this.fetchPaymentsReceive({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },

        async deletePaymentsReceive(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "payment_receiveds/" + id,
                };

                const response = await axios(config);

                this.paymentReceive = response.data.data;
                this.fetchPaymentsReceive({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // expense category data
        async FetchExpenseCats({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                expense_categories?page=${page}&perPage=${itemsPerPage}&search=${this.expenseCatSearch}
            );
            this.expenseCategories = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },

        async FetchExpenseCat(id) {
            // this.error = null;
            try {
                const response = await axios.get(expense_categories/${id});

                this.expenseCategory = response.data.data;
                console.log(this.expenseCategory);
            } catch (err) {
                // this.error = err.message;
            }
        },

        async CreateExpenseCat(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "expense_categories",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createExpenseCatDialog = false;
                this.FetchExpenseCats({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },

        async UpdateExpenseCat(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: "expense_categories/" + id,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.updateExpenseCatDialog = false;
                this.FetchExpenseCats({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },

        async DeleteExpenseCat(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "expense_categories/" + id,
                };

                const response = await axios(config);

                this.expenseCategory = response.data.data;
                this.FetchExpenseCats({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // the people data

        async FetchExpensePeoples({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                peoples?page=${page}&perPage=${itemsPerPage}&search=${this.expensePeopleSearch}
            );
            this.expensePeoples = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },

        async FetchExpensePeople(id) {
            // this.error = null;
            try {
                const response = await axios.get(peoples/${id});

                this.expensePeople = response.data.data;
                console.log(this.expensePeople);
            } catch (err) {
                // this.error = err.message;
            }
        },

        async CreateExpensePeople(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "peoples",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchExpensePeoples({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },

        async UpdateExpensePeople(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: peoples/${id},

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.updateDialog = false;
                this.FetchExpensePeoples({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },

        async DeleteExpensePeople(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "peoples/" + id,
                };

                const response = await axios(config);

                this.expensePeople = response.data.data;
                this.FetchExpensePeoples({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },

        // expense_products
        async FetchExpenseProducts({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                expense_products?page=${page}&perPage=${itemsPerPage}&search=${this.expenseProductSearch}
            );
            this.expenseProducts = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchExpenseProduct(id) {
            // this.error = null;
            try {
                const response = await axios.get(expense_products/${id});

                this.expenseProduct = response.data.data;
                console.log(this.expenseProduct);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateExpenseProduct(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "expense_products",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchExpenseProducts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateExpenseProduct(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: expense_products/${id},

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.updateDialog = false;
                this.FetchExpenseProducts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async DeleteExpenseProduct(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "expense_products/" + id,
                };

                const response = await axios(config);

                this.expenseProduct = response.data.data;
                this.FetchExpenseProducts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // supplier
        async FetchSuppliers({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                suppliers?page=${page}&perPage=${itemsPerPage}&search=${this.supplierSearch}
            );
            this.suppliers = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchSupplier(id) {
            // this.error = null;
            try {
                const response = await axios.get(suppliers/${id});

                this.supplier = response.data.data;
                console.log(this.expensePeople);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateSupplier(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "suppliers",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchSuppliers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateSupplier(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: suppliers/${id},

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.updateDialog = false;
                this.FetchSuppliers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async DeleteSupplier(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "suppliers/" + id,
                };

                const response = await axios(config);

                this.supplier = response.data.data;
                this.FetchSuppliers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // bill expense
        getTodaysDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, "0");
            const day = String(today.getDate()).padStart(2, "0");
            return ${year}-${month}-${day};
        },
        // GetCurrency(expenseAllData, id) {
        //     const currArr = expenseAllData.filter((curr) => curr.id == id);
        //     this.symbol = currArr[0].symbol;
        //     console.log(currArr[0].symbol);
        // },

        // entigrating data for create Earnings
        async ExpenseAllData() {
            const config = {
                url: "expense_all_data",
            };
            const response = await axios(config);
            this.expenseAllData = response.data.data;
        },
        async SearchFetchData() {
            console.log(this.billExpenseSearch);
            this.loading = true;

            const response = await axios.get(
                expense_products?&search=${this.billExpenseSearch}
            );
            this.searchFetch = response.data.data;
            this.loading = false;
            // this.searchFetch = "";
        },
        async fetchProduct(id, isUpdate = false) {
            // this.error = null;
            try {
                const response = await axios.get(expense_products/${id});

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
        async FetchBillExpenses({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                bill_expenses?page=${page}&perPage=${itemsPerPage}&search=${this.billExpenseSearch}
            );
            this.billExpenses = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchBillExpense(id) {
            // this.error = null;
            try {
                const response = await axios.get(bill_expenses/${id});

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
                    url: "bill_expenses",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.router.push("/billExpense");

                this.FetchBillExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateBillExpense(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: bill_expenses/${id},

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);

                this.router.push("/billExpense");

                this.FetchBillExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
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
                    url: "bill_expenses/" + id,
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
    },
});