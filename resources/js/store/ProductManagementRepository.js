import { defineStore } from "pinia";
import { reactive, ref } from "vue";

// Import Axios
import { axios, setContentType } from "../axios";
// import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";
export let useProductManagementRepository = defineStore(
    "ProductManagementRepository",
    {
        state() {
            return {
                // ====consume======\\
                consumeSearch: ref(""),
                consumes: reactive([]),
                consume: reactive([]),
                expenseAllData: reactive([]),
                searchFetch: reactive([]),
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

                consumeSearch: "",
            };
        },
        actions: {
            async FetchConsumesData({ page, itemsPerPage }) {
                this.loading = true;
                setContentType("application/json");

                const response = await axios.get(
                    `/consumes?page=${page}&perPage=${itemsPerPage}&search=${this.consumeSearch}`
                );
                this.consumes = response.data.data;
                this.totalItems = response.data.meta.total;
                this.loading = false;
            },
        },
    }
);
