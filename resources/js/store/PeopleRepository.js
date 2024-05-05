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
        async FetchAcustomersData({ page, itemsPerPage }) {
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
                url: "/units",
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
        async DeleteUnit(id) {
            const config = {
                method: "DELETE",
                url: "/units/" + id,
            };

            const response = await axios(config);
            // toast.success("Customer Succesfully Deleted", {
            //     autoClose: 1000,
            // });
            this.FetchUnitsData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async FetchUnitData(id) {
            setContentType("application/json");
            const response = await axios.get(`/units/${id}`);

            this.unit = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateUnit(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "PUT",
                url: "/units/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            // toast.success("Customer Succesfully Updated", {
            //     autoClose: 1000,
            // });

            this.updateDailog = false;
            this.FetchUnitsData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
    },
});
