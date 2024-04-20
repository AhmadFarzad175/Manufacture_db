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
        async FetchCurrensiesData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `units?page=${page}&perPage=${itemsPerPage}&search=${this.Search}`
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
                url: "units",
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
                url: "units/" + id,
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
            const response = await axios.get(`units/${id}`);

            this.currency = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateCurrency(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "PUT",
                url: "units/" + id,
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
    },
});
