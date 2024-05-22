import { defineStore } from "pinia";
import { reactive, ref } from "vue";
// Import Axios
import { axios, setContentType } from "../axios";
import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";

export let usePurchaseRepository = defineStore("PurchaseRepository", {
    state() {
        return {
            visas: reactive([]),
            visaPartners: reactive([]),
            integratedDataForVisa: reactive([]),

            visa: reactive([]),
            visaPartner: reactive([]),

            // varible for visa report
            countVisa: ref(null),
            totalPrice: ref(null),
            grandTotalCost: ref(null),
            totalPaid: ref(null),
            totalDue: ref(null),
            netProfit: ref(null),
            countRefund: ref(null),

            router: useRouter(),
            dailog: false,
            isLoading: false,
            error: null,
            loading: true,
            itemsPerPage: 10,
            page: 1,
            selectedItems: [],
            selectAll: false,
            custmerEdiDailog: false,
            createDailog: false,
            updateDailog: false,
            showPaymentDailog: false,
            showRefundDailog: false,
            totaleRefundableDailog: false,
            custmerEdiDailog: false,
            showSelect: true,
            totalItems: 0,
            itemKey: "id",
            visaId: reactive([]),
            currency: reactive([]),
            symbol: ref(""),
            // search varible

            search: "",

            // customer search
            searchCustomer: "",
            customers: reactive([]),
            customerListArray: reactive([]),
            customerUpdateData: reactive([]),
        };
    },

    actions: {
        // Today Date
        getCurrentDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, "0");
            const day = today.getDate().toString().padStart(2, "0");
            return `${year}-${month}-${day}`;
        },
        getCurrencyAndSymbol(account, id) {
            this.currency = [];
            const array = account.filter((acc) => acc.id === id);
            console.log(array[0]);
            if (array[0].name === "CENTRAL") {
                this.currency.push(...array[0].currencies);
                console.log(array[0].currencies);
            } else {
                this.symbol = array[0].currency?.symbol;
                this.currency.push(array[0].currency);
                console.log(array[0].currency);
            }
            // console.log(this.currency);
            // console.log(array[0].currency?.symbol);
            // console.log(account, id);
        },
        getCurrencySymbol(account, id) {
            const array = account.filter((acc) => acc.id === id);
            const symbolFromAccount = array[0].symbol;
            this.symbol = symbolFromAccount;
            console.log(array[0].symbol);
            // console.log(account, id);
        },
        getPaymentCurrencySymbol(account, id) {
            const array = account.filter((acc) => acc.id === id);
            const symbolFromAccount = array[0].currency.symbol;
            this.symbol = symbolFromAccount;
            console.log(array[0].currency.symbol);
            // console.log(account, id);
        },
        updateCurrencySymbol(account, id) {
            const array = account.filter((acc) => acc.currency.id === id);
            const symbolFromAccount = array[0].currency.symbol;
            this.symbol = symbolFromAccount;
            console.log(array[0].currency.symbol);
            // console.log(account, id);
        },
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        },

        //    All purchase ================

        async FetchPurchasesData({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `visaCancel?page=${page}&perPage=${itemsPerPage}&search=${this.purchaseSearch}`
            );
            this.scrollToTop();
            this.purchases = response.data.data;
            console.log(this.purchases);
            this.totalItems = response.data.meta.total;
            console.log(this.totalItems);
            this.loading = false;
        },
        async fetchCanceledBooking(id) {
            setContentType("application/json");

            const response = await axios.get(`visaCancel/${id}`);

            this.canceledBooking = response.data.data; // Assign the fetched data directly to this.people
            console.log(this.canceledBooking);
            // Reset error in case it was previously set
        },
        async UpdateConceledVisa(id, data) {
            console.log(data);

            // Adding a custom header to the Axios request
            setContentType("application/json");
            const config = {
                method: "PUT",
                url: "visaStatus/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            toast.success("Visa Concel Succesfully Updated", {
                autoClose: 1000,
            });
            this.router.push("/canceledVisa");

            this.fetchVisaData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteCanceledBooking(id) {
            setContentType("application/json");
            const config = {
                method: "DELETE",
                url: "visaCancelDelete/" + id,
            };

            const response = await axios(config);

            this.purchases = response.data.data;
            toast.success("Booking Succesfully Deleted", {
                autoClose: 1000,
            });
            this.fetchCanceledBookings({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async RecoverBooking(id, data) {
            console.log(data);
            console.log(id);

            // Adding a custom header to the Axios request
            setContentType("application/json");
            const config = {
                method: "PUT",
                url: "visaCancelStatus/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            this.router.push("/visa");

            toast.success("Visa Succesfully Recover", {
                autoClose: 1000,
            });
            this.fetchVisaData({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },

        // Refund api

        async CreateRefund(formData) {
            // Adding a custom header to the Axios request
            setContentType("application/json");
            const config = {
                method: "POST",
                url: "visaRefunds",
                data: formData,
            };

            // Using Axios to make a GET request with async/await and custom headers
            const response = await axios(config);
            toast.success("Refund Succesfully Created", {
                autoClose: 1000,
            });

            this.symbol = null;
            this.dailog = false;
            this.visaId = [];
            this.fetchCanceledBookings({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async ShowRefund(id) {
            setContentType("application/json");
            const response = await axios.get(`showVisaRefundPayments/${id}`);

            this.refunds = response.data.data; // Assign the fetched data directly to this.people
            console.log(this.refunds);
        },
        async fetchRefund(id) {
            setContentType("application/json");

            const response = await axios.get(`visaRefunds/${id}`);

            this.refund = response.data.data; // Assign the fetched data directly to this.people
        },
        async UpdateRefund(id, data) {
            console.log(data);
            // Adding a custom header to the Axios request
            setContentType("application/json");
            const config = {
                method: "PUT",
                url: "visaRefunds/" + id,
                data: data,
            };

            // Using Axios to make a post request with async/await and custom headers
            const response = await axios(config);
            toast.success("Refund Succesfully Updated", {
                autoClose: 1000,
            });
            this.symbol = null;
            this.dailog = false;
            this.visaId = [];
            this.ShowRefund(data.visa);
            this.fetchCanceledBookings({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
        },
        async DeleteRefund(id, visa) {
            this.refunds = [];

            setContentType("application/json");
            const config = {
                method: "DELETE",
                url: "visaRefunds/" + id,
            };

            const response = await axios(config);
            this.payments = response.data.data;
            toast.success("Refund Succesfully Deleted", {
                autoClose: 1000,
            });
            this.fetchCanceledBookings({
                page: this.page,
                itemsPerPage: this.itemsPerPage,
            });
            this.ShowRefund(visa);
        },
    },
});
