<template>
    <CreateLoanPeople v-if="PeopleRepository.createDailog" />
    <UpdateLoanPeople v-if="PeopleRepository.updateDailog" />
    <toolbar title="People-" subtitle="Loan People" />

    <div class="w-full d-flex">
        <div class="w-full">
            <v-layout class="py-5">
                <v-row class="justify-space-between mt-6">
                    <v-col cols="12" sm="3">
                        <v-text-field
                            v-model="PeopleRepository.Search"
                            label="Search"
                            prepend-inner-icon="mdi-magnify"
                            variant="outlined"
                            name="search"
                            density="compact"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="2" class="d-flex mr-28 gap-2">
                        <v-btn color="blue" variant="outlined" size="large">
                            <v-icon>mdi-filter-outline</v-icon>
                            <span class="">FILTER</span>
                        </v-btn>
                        <v-btn
                            @click="createPopUp"
                            color="light-blue-darken-1"
                            size="large"
                        >
                            <span>Create</span>
                            <v-icon right large>mdi-plus</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-layout>

            <div class="overflow-x-auto pb-10">
                <v-app>
                    <v-main>
                        <v-row>
                            <v-col>
                                <v-data-table-server
                                    v-model:items-per-page="
                                        PeopleRepository.itemsPerPage
                                    "
                                    :headers="headers"
                                    :items-length="PeopleRepository.totalItems"
                                    :items="PeopleRepository.loanPeoples"
                                    :loading="PeopleRepository.loading"
                                    :search="PeopleRepository.loanPeoplesSearch"
                                    item-value="id"
                                    @update:options="
                                        PeopleRepository.FetchLoanPeoplesData
                                    "
                                    :item-key="PeopleRepository.loanPeoples"
                                    itemKey="id"
                                    hover
                                >
                                    <template
                                        v-slot:item.actions="{ item }"
                                        class="right"
                                    >
                                        <v-menu>
                                            <template
                                                v-slot:activator="{ props }"
                                            >
                                                <v-btn
                                                    icon="mdi-dots-vertical"
                                                    v-bind="props"
                                                    variant="text"
                                                ></v-btn>
                                            </template>

                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title
                                                        @click="
                                                            editItem(item.id)
                                                        "
                                                        class="cursor-pointer d-flex gap-3 justify-left pb-3"
                                                    >
                                                        <v-icon color="gray"
                                                            >mdi-square-edit-outline</v-icon
                                                        >
                                                        Edit
                                                    </v-list-item-title>

                                                    <v-list-item-title
                                                        class="cursor-pointer d-flex gap-3"
                                                        @click="
                                                            deleteItem(item.id)
                                                        "
                                                    >
                                                        <v-icon color="gray"
                                                            >mdi-delete-outline</v-icon
                                                        >
                                                        Delete
                                                    </v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </template>
                                </v-data-table-server>
                            </v-col>
                        </v-row>
                    </v-main>
                </v-app>
            </div>
        </div>
    </div>
</template>

<script setup>
import { usePeopleRepository } from "../../store/PeopleRepository";
import CreateLoanPeople from "./CreateLoanPeople.vue";
import UpdateLoanPeople from "./UpdateLoanPeople.vue";
import Toolbar from "../../Component/UI/Toolbar.vue";
import Search from "../../Component/UI/Search.vue";
import CreateButton from "../../Component/UI/CreateButton.vue";

let PeopleRepository = usePeopleRepository();

const headers = [
    { title: "NAME", key: "name", sortable: false },
    { title: "PHONE", key: "phone", sortable: false },
    {
        title: "EMAIL",
        key: "email",
        sortable: false,
        align: "center",
    },

    { title: "Action", key: "actions", sortable: false, align: "end" },
];

const createPopUp = () => {
    PeopleRepository.createDailog = true;
};
const deleteItem = (id) => {
    PeopleRepository.DeleteLoanPeople(id);
};
const editItem = (id) => {
    PeopleRepository.loanPeople = {};
    if (Object.keys(PeopleRepository.loanPeople).length === 0) {
        PeopleRepository.FetchLoanPeopleData(id)
            .then(() => {
                // Data has been fetched successfully, now set dialog to true
                PeopleRepository.updateDailog = true;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
                // Display  message
            });
    }
};
</script>
