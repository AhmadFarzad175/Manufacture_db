import { defineStore } from "pinia";
import { reactive, ref } from "vue";

// Import Axios
import { axios, setContentType } from "../axios";
// import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";
export let useMoneyAccountRepository = defineStore("MoneyAccountRepository", {
    state() {
        return {
            accounts: reactive([]),
            account: reactive([]),
            currency: reactive([]),
            symbol: ref(""),

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

            Search: "",
        };
    },
    actions: {
        GetCurrency(currency, id) {
            const currArr = currency.filter((curr) => curr.id == id);
            this.symbol = currArr[0].symbol;
            console.log(currArr[0].symbol);
        },

        async FetchAccountsData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/accounts?page=${page}&perPage=${itemsPerPage}&search=${this.Search}`
            );
            this.accounts = response.data.data;
            console.log(response.data.data);
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },

        async GetAccounts() {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(`/currency`);
            this.currency = response.data.data;
            console.log(response.data.data);
            this.loading = false;
        },
        async CreateAccount(formData) {
            console.log(formData);

            try {
                // Assuming setContentType and axios are defined somewhere
                setContentType("application/json");

                const config = {
                    method: "POST",
                    url: "/accounts",
                    data: formData,
                };

                const response = await axios(config);
                console.log("Account created successfully:", response.data);

                // Close dialog after successful creation
                this.createDailog = false;

                // Fetch updated account data
                this.FetchAccountsData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (error) {
                console.error("Error creating account:", error);
                // Handle error here (e.g., show error message to the user)
            }
        },
        async DeleteAccount(id) {
            const config = {
                method: "DELETE",
                url: "/accounts/" + id,
            };

            const response = await axios(config);
            // toast.success("Customer Succesfully Deleted", {
            //     autoClose: 1000,
            // });
            this.FetchAccountsData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async FetchAccountData(id) {
            setContentType("application/json");
            const response = await axios.get(`/accounts/${id}`);

            this.account = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateAccount(id, data) {
            console.log(response.data.data);

            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "PUT",
                url: "/accounts/" + id,
                data: data,
            };
            console.log(response.data.data);
            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Updated", {
            //     autoClose: 1000,
            // });

            this.updateDailog = false;
            this.FetchAccountsData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
    },
});
