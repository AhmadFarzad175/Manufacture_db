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
                expenseProduct: reactive([]),
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
            getTodaysDate() {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, "0");
                const day = String(today.getDate()).padStart(2, "0");
                return `${year}-${month}-${day}`;
            },

            // entigrating data for create Earnings
            async ExpenseAllData() {
                const config = {
                    url: "wHouses",
                };
                const response = await axios(config);
                this.expenseAllData = response.data.data;
                // console.log(this.expenseAllData, "man");
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

            async fetchProduct(id, isUpdate = false) {
                // this.error = null;
                try {
                    const response = await axios.get(
                        `materials?wareHouse/${id}`
                    );

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

            async FetchConsume(id) {
                // this.error = null;
                try {
                    const response = await axios.get(`consumes/${id}`);

                    this.consume = response.data.data;
                } catch (err) {
                    // this.error = err.message;
                }
            },
            async CreateConsume(formData) {
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
            async UpdateBillExpense(id, data) {
                console.log(`Updating bill expense with id: ${id}`, data);
                try {
                    const config = {
                        method: "PUT",
                        url: `/consumes/${id}`,
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
                        url: "consumes/" + id,
                    };

                    const response = await axios(config);

                    this.consume = response.data.data;
                    this.FetchConsumesData({
                        page: this.page,
                        itemsPerPage: this.itemsPerPage,
                    });
                } catch (err) {
                    this.error = err;
                }
            },
        },
    }
);
