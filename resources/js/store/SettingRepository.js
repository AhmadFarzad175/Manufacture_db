import { defineStore } from "pinia";
import { reactive, ref } from "vue";

// Import Axios
import { axios, setContentType } from "../axios";
// import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";
export let useSettingRepository = defineStore("SettingRepository", {
    state() {
        return {
            currencies: reactive([]),
            currency: reactive([]),
            wharehouse: reactive([]),
            wharehouses: reactive([]),

            isLoading: false,
            error: null,
            loading: false,
            createDailog: false,
            updateDailog: false,
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
        async FetchCurrensiesData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/currencies?page=${page}&perPage=${itemsPerPage}&search=${this.Search}`
            );
            this.currencies = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async CreateCurrency(formData) {
            console.log(formData);
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "/currencies",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            this.createDailog = false;
            this.FetchCurrensiesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteCurrency(id) {
            const config = {
                method: "DELETE",
                url: "/currencies/" + id,
            };

            const response = await axios(config);
            // toast.success("Customer Succesfully Deleted", {
            //     autoClose: 1000,
            // });
            this.FetchCurrensiesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async FetchCurrencyData(id) {
            setContentType("application/json");
            const response = await axios.get(`/currencies/${id}`);

            this.currency = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateCurrency(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "PUT",
                url: "/currencies/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Updated", {
            //     autoClose: 1000,
            // });

            this.updateDailog = false;
            this.FetchCurrensiesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },

        // WhareHouse
        async FetchWharehousesData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/warehouses?page=${page}&perPage=${itemsPerPage}&search=${this.Search}`
            );
            this.wharehouses = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async CreateWharehouse(formData) {
            console.log(formData);
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "/warehouses",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            this.createDailog = false;
            this.FetchWharehousesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteWharehouse(id) {
            const config = {
                method: "DELETE",
                url: "/warehouses/" + id,
            };

            const response = await axios(config);
            // toast.success("Customer Succesfully Deleted", {
            //     autoClose: 1000,
            // });
            this.FetchWharehousesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async FetchWharehouseData(id) {
            setContentType("application/json");
            const response = await axios.get(`/warehouses/${id}`);

            this.wharehouse = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateWharehouse(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "PUT",
                url: "/warehouses/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Updated", {
            //     autoClose: 1000,
            // });

            this.updateDailog = false;
            this.FetchWharehousesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
    },
});
