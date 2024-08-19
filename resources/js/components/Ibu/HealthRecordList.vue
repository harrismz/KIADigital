<template>
    <div class="container mx-auto p-4">
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-4">
                <h1 class="text-2xl font-bold">Catatan Kesehatan Ibu</h1>
                <div class="flex justify-end gap-x-3">
                    <img class="w-6 h-6 cursor-pointer" @click="gotoHome" :src="`${baseUrl}/storage/images/home.png`"
                        alt="Home">
                </div>
            </div>
        </div>
        <div class="mb-4">
            <input v-model="searchQuery" @input="searchPregnancyHistories" type="text" placeholder="Search..."
                class="w-full p-2 border rounded-md" />
        </div>
        <div v-for="healthRecord in paginatedPregnancyHistories" :key="healthRecord.id"
            class="bg-white shadow-md rounded-lg p-4 mb-4">
            <div class="flex">
                <div>
                    <h2 class="text-xl font-semibold">{{ healthRecord.complaint }}</h2>
                    <p v-if="healthRecord.medical_staff" class="text-sm italic">
                        by: {{ healthRecord.medical_staff?.staff_name
                        }}</p>
                    <p class="text-sm italic">{{ formatDate(healthRecord.created_at) }}</p>
                    <button @click="viewDetail(healthRecord.id)" class="mt-3 text-blue-500 hover:text-blue-700">Detail
                        more</button>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-4">
            <button @click="previousPage" :disabled="currentPage === 1"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">Previous</button>
            <span class="px-4">{{ currentPage }}</span>
            <button @click="nextPage" :disabled="currentPage === totalPages"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">Next</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';
export default {
    name: 'HealthRecordList',
    data() {
        return {
            pregnancyHistories: [],
            searchQuery: '',
            currentPage: 1,
            itemsPerPage: 5,
            totalItems: 0,
        };
    },
    computed: {
        ...mapGetters(['baseUrl']),
        paginatedPregnancyHistories() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.pregnancyHistories.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.totalItems / this.itemsPerPage);
        },
    },
    methods: {
        async fetchPregnancyHistories() {
            try {
                // console.log(`${this.baseUrl}/api/pregnancy-history`);

                axios.get(`${this.baseUrl}/api/pregnancy-history`, {
                    headers: {
                        'Accept': 'application/json', // Expect a JSON response
                        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                    }
                })
                    .then(response => response.data)
                    .then(response => {
                        console.log({ response });
                        this.pregnancyHistories = response.data;
                        this.totalItems = response.total;
                    })
                    .catch(error => {
                        console.error('Error fetching pregnancy history:', error);
                    });

            } catch (error) {
                console.error('Error fetching pregnancy histories:', error);
            }
        },
        searchPregnancyHistories() {
        // this.currentPage = 1; // Reset to first page on new search
            const queryParams = new URLSearchParams({
                page: this.currentPage,
                search: this.searchQuery
            }).toString();

            try {
                axios.get(`${this.baseUrl}/api/pregnancy-history-search?${queryParams}`, {
                    headers: {
                        'Accept': 'application/json', // Expect a JSON response
                        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                    }
                })
                    .then(response => response.data)
                    .then(response => {
                        console.log({ response });
                        this.pregnancyHistories = response.data;
                        this.totalItems = response.total;
                    })
                    .catch(error => {
                        console.error('Error fetching pregnancy history:', error);
                    });

            } catch (error) {
                console.error('Error fetching pregnancy histories:', error);
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage += 1;
                this.fetchPregnancyHistories();
            }
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage -= 1;
                this.fetchPregnancyHistories();
            }
        },
        viewDetail(id) {
            this.$router.push({ name: 'health-records', params: { id } });
        },
        getImageUrl(path) {
            return `${this.baseUrl}/storage/${path}`;
        },
        formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(date).toLocaleDateString(undefined, options);
        },
        gotoHome() {
            this.$router.push({ name: 'dashboard' });
        },

    },
    created() {
        this.fetchPregnancyHistories();
    }
};
</script>
<style scoped></style>
