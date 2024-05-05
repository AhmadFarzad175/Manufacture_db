import { defineStore } from "pinia";
import { reactive, ref } from "vue";

// Import Axios
import { axios, setContentType } from "../axios";
// import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";
export let usePeopleRepository = defineStore("PeopleRepository", {
    state() {
        return {
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
    },
});
