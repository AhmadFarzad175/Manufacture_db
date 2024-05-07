import { defineStore } from "pinia";
import { reactive, ref } from "vue";

// Import Axios
import { axios, setContentType } from "../axios";
// import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";

export let usePeopleRepository = defineStore("PeopleRepository", {
    state() {
        return {
            // Customers//
            customers: reactive([]),
            customer: reactive([]),
            // ===Supplier====\\
            suppliers: reactive([]),
            supplier: reactive([]),
            // ====Expense People ========\\
            expensePeople: reactive([]),
            expensePeoples: reactive([]),
            // =====LoanPeople========\\

            loanPeoples: reactive([]),
            loanPeople: reactive([]),
            // ====Owner=====\\
            owners: reactive([]),
            owner: reactive([]),

            // ====User===\\
            user: reactive([]),
            users: reactive([]),

            isLoading: false,
            error: null,
            loading: false,
            createDailog: ref(false),
            updateDailog: ref(false),
            page: 1,
            itemsPerPage: 5,
            selectedItems: [],
            selectAll: false,
            showSelect: true,
            router: useRouter(),
            totalItems: 0,
            itemKey: "id",
            supplierSearch: "",
            loanPeopleSearch: "",
            expensePeopleSearch: "",
            ownerSearch: "",
            userSearch: "",

            Search: "",
        };
    },
    actions: {
        // ===============Customer===============================\\
        async FetchCustomersData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/customers?page=${page}&perPage=${itemsPerPage}&search=${this.Search}`
            );
            this.customers = response.data.data;
            console.log(response.data.data);
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async CreateCustomer(formData) {
            console.log(formData);
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "/customers",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            this.createDailog = false;
            this.FetchUnitsData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteCustomer(id) {
            const config = {
                method: "DELETE",
                url: "/customers/" + id,
            };

            const response = await axios(config);
            // toast.success("Customer Succesfully Deleted", {
            //     autoClose: 1000,
            // });
            this.FetchCustomersData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async FetchCustomerData(id) {
            setContentType("application/json");
            const response = await axios.get(`/customers/${id}`);

            this.customer = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateCustomer(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "PUT",
                url: "/customers/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Updated", {
            //     autoClose: 1000,
            // });

            this.updateDailog = false;
            this.FetchCustomersData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        //  ==============================Supplier==========================================\\

        async FetchSuppliersData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/suppliers?page=${page}&perPage=${itemsPerPage}&search=${this.supplierSearch}`
            );
            this.suppliers = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async CreateSupplier(formData) {
            console.log(formData);
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "/suppliers/",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            this.createDailog = false;
            this.FetchSuppliersData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteSupplier(id) {
            const config = {
                method: "DELETE",
                url: "/suppliers/" + id,
            };

            const response = await axios(config);
            // toast.success("Customer Succesfully Deleted", {
            //     autoClose: 1000,
            // });
            this.FetchSuppliersData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async FetchSupplierData(id) {
            setContentType("application/json");
            const response = await axios.get(`/suppliers/${id}`);

            this.supplier = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateSupplier(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "PUT",
                url: "/suppliers/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Updated", {
            //     autoClose: 1000,
            // });

            this.updateDailog = false;
            this.FetchSuppliersData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        // ===============Expense People ======================================

        async FetchExpensePeoplesData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/expensePeoples?page=${page}&perPage=${itemsPerPage}&search=${this.expensePeopleSearch}`
            );
            this.expensePeoples = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async CreateExpensePeople(formData) {
            console.log(formData);
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "expensePeoples",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            this.createDailog = false;
            this.FetchExpensePeoplesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteExpensePeople(id) {
            const config = {
                method: "DELETE",
                url: "/expensePeoples/" + id,
            };

            const response = await axios(config);
            // toast.success("Customer Succesfully Deleted", {
            //     autoClose: 1000,
            // });
            this.FetchExpensePeoplesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async FetchExpensePeopleData(id) {
            setContentType("application/json");
            const response = await axios.get(`/expensePeoples/${id}`);

            this.expensePeople = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateExpensePeople(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "PUT",
                url: "/expensePeoples/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Updated", {
            //     autoClose: 1000,
            // });

            this.updateDailog = false;
            this.FetchExpensePeoplesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },

        // ======LoanPeople ==================\\
        async FetchLoanPeoplesData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/loanPeoples?page=${page}&perPage=${itemsPerPage}&search=${this.expensePeopleSearch}`
            );
            this.loanPeoples = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async CreateLoanPeople(formData) {
            console.log(formData);
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "/loanPeoples/",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            this.createDailog = false;
            this.FetchLoanPeoplesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteLoanPeople(id) {
            const config = {
                method: "DELETE",
                url: "/loanPeoples/" + id,
            };

            const response = await axios(config);
            // toast.success("Customer Succesfully Deleted", {
            //     autoClose: 1000,
            // });
            this.FetchLoanPeoplesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async FetchLoanPeopleData(id) {
            setContentType("application/json");
            const response = await axios.get(`/loanPeoples/${id}`);

            this.loanPeople = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateLoanPeople(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "PUT",
                url: "/loanPeoples/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Updated", {
            //     autoClose: 1000,
            // });

            this.updateDailog = false;
            this.FetchLoanPeoplesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },

        // =============Owner==================\\

        async FetchOwnersData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/owners?page=${page}&perPage=${itemsPerPage}&search=${this.ownerSearch}`
            );
            this.owners = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async CreateOwner(formData) {
            console.log(formData);
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "/owners/",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            this.createDailog = false;
            this.FetchOwnersData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteOwner(id) {
            const config = {
                method: "DELETE",
                url: "/owners/" + id,
            };

            const response = await axios(config);
            // toast.success("Customer Succesfully Deleted", {
            //     autoClose: 1000,
            // });
            this.FetchOwnersData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async FetchOwnerData(id) {
            setContentType("application/json");
            const response = await axios.get(`/owners/${id}`);

            this.owner = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateOwner(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "PUT",
                url: "/owners/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Updated", {
            //     autoClose: 1000,
            // });

            this.updateDailog = false;
            this.FetchOwnersData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },

        // =======User=========\\
        async FetchUsersData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("multipart/form-data");

            const response = await axios.get(
                `/users?page=${page}&perPage=${itemsPerPage}&search=${this.ownerSearch}`
            );
            this.users = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async CreateUser(formData) {
            console.log(formData);
            // Adding a custom header to the Axios request
            setContentType("multipart/form-data");

            const config = {
                method: "POST",
                url: "/users",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            this.createDailog = false;
            this.FetchUsersData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteUser(id) {
            const config = {
                method: "DELETE",
                url: "/users/" + id,
            };

            const response = await axios(config);
            // toast.success("Customer Succesfully Deleted", {
            //     autoClose: 1000,
            // });
            this.FetchUsersData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async FetchUserData(id) {
            setContentType("multipart/form-data");
            const response = await axios.get(`/users/${id}`);

            this.user = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateUser(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("multipart/form-data");

            const config = {
                method: "POST",
                url: "/users/update/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Updated", {
            //     autoClose: 1000,
            // });

            this.updateDailog = false;
            this.FetchOwnersData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        // async UpdateUserStatus(id, data) {
        //     console.log(data);
        //     // Adding a custom header to the Axios request
        //     setContentType("application/json");
        //     const config = {
        //         method: "PUT",
        //         url: "/users/switch/" + id,
        //         data: data,
        //     };

        //     // Using Axios to make a post request with async/await and custom headers
        //     const response = await axios(config);
        //     // toast.success(" Status Succesfully Updated", {
        //     //     autoClose: 1000,
        //     // });
        // },
    },
});
