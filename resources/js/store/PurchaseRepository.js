import { defineStore } from "pinia";
import { reactive, ref } from "vue";

// Import Axios
import { axios, setContentType } from "../axios";
// import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";
import CreatePurchase from "../pages/allPurchase/CreatePurchase.vue";
export let usePurchaseRepository = defineStore("PurchaseRepository", {
    state() {
        return {
            // ====purchase======\\
            purchaseSearch: ref(""),
            purchases: reactive([]),
            purchase: reactive([]),
            consumeAllData: reactive([]),
            consumeMaterial: reactive([]),

            searchFetch: reactive([]),
            // ======Produce=======\\\
            produces: reactive([]),
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

            purchaseSearch: "",
        };
    },
    actions: {
        getTodaysDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, "0");
            const day = String(today.getDate()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        },

        async GetWharehose() {
            const config = {
                url: "wHouses",
            };
            const response = await axios(config);
            this.consumeAllData = response.data.data;
            // console.log(this.consumeAllData, "man");
        },
        async SearchFetchData(id) {
            console.log(this.consumeSearch);

            this.loading = true;

            const response = await axios.get(
                `materials?wareHouse=${id}&search=${this.consumeSearch}`
            );
            //

            this.searchFetch = response.data.data;
            this.loading = false;
        },

        async fetchMaterial(id, isUpdate = false) {
            // this.error = null;
            try {
                const response = await axios.get(`materials/${id}`);

                console.log("name", response.data.data.name);
                if (isUpdate) {
                    delete response.data.data.id;
                }
                console.log(response.data.data, "fetchProduct");
                this.consumeMaterial.push(response.data.data);
                console.log(this.consumeMaterial, "data");
                // this.purchase.expenseProduct.push(response.data.data);

                console.log("Fetched product data:", response.data.data); // Console log the fetched data

                // this.searchFetch = [];
            } catch (err) {
                this.error = err.message;
            }
        },
        async FetchPurchasesData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/purchases?page=${page}&perPage=${itemsPerPage}&search=${this.purchaseSearch}`
            );
            this.purchases = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },

        async FetchPurchase(id) {
            // this.error = null;
            try {
                const response = await axios.get(`/purchases/${id}`);

                this.purchase = response.data.data;
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreatePurchase(formData) {
            console.log(formData);
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "/consumes",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            console.log(response.data, "this is data");
            this.router.push("/allConsume");
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            // this.createDailog = false;
            this.FetchConsumesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async UpdateConsume(id, data) {
            console.log(`Updating purchase expense with id: ${id}`, data);
            try {
                const config = {
                    method: "PUT",
                    url: `/consumes/${id}`,
                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);

                console.log("Update response:", response);

                this.router.push("/allConsume");

                this.FetchConsumesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error("Error updating purchase expense:", err);
                this.error = err;
            }
        },

        async DeleteConsume(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "consumes/" + id,
                };

                const response = await axios(config);

                this.purchase = response.data.data;
                this.FetchConsumesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // =========Produce===========================//
        async FetchProducesData({ page, itemsPerPage }) {
            this.loading = true;
            setContentType("application/json");

            const response = await axios.get(
                `/produces?page=${page}&perPage=${itemsPerPage}&search=${this.consumeSearch}`
            );
            this.produces = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async SearchFetchProduceData(id) {
            console.log(this.consumeSearch);

            this.loading = true;

            const response = await axios.get(
                `products?wareHouse=${id}&search=${this.consumeSearch}`
            );
            //

            this.searchFetch = response.data.data;
            this.loading = false;
        },
        async FetchProduece(id) {
            // this.error = null;
            try {
                const response = await axios.get(`/produces/${id}`);

                this.purchase = response.data.data;
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateProduce(formData) {
            console.log(formData);
            // Adding a custom header to the Axios request
            setContentType("application/json");

            const config = {
                method: "POST",
                url: "/produces",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            console.log(response.data, "this is data");
            this.router.push("/allProduce");
            // toast.success("Customer Succesfully Created", {
            //     autoClose: 1000,
            // });
            // this.createDailog = false;
            this.FetchProducesData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteProduce(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "produces/" + id,
                };

                const response = await axios(config);

                this.purchase = response.data.data;
                this.FetchProducesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async fetchProducts(id, isUpdate = false) {
            // this.error = null;
            try {
                const response = await axios.get(`products/${id}`);

                console.log("name", response.data.data.name);
                if (isUpdate) {
                    delete response.data.data.id;
                }
                console.log(response.data.data, "fetchProduct");
                this.consumeMaterial.push(response.data.data);
                console.log(this.consumeMaterial, "data");
                // this.purchase.expenseProduct.push(response.data.data);

                console.log("Fetched product data:", response.data.data); // Console log the fetched data

                // this.searchFetch = [];
            } catch (err) {
                this.error = err.message;
            }
        },
        async UpdateProduce(id, data) {
            console.log(`Updating purchase expense with id: ${id}`, data);
            try {
                const config = {
                    method: "PUT",
                    url: `/produces/${id}`,
                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);

                console.log("Update response:", response);

                this.router.push("/allProduce");

                this.FetchProducesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                console.error("Error updating purchase expense:", err);
                this.error = err;
            }
        },
    },
});
