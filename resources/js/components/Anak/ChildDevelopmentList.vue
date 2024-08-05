<template>
    <div class="container mx-auto p-4">
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-4">
                <h1 class="text-2xl font-bold">Catatan Pertumbuhan Anak</h1>
                <div class="flex justify-end gap-x-3">
                    <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'">
                </div>
            </div>
        </div>
        <div class="mb-4">
            <input v-model="searchQuery" @input="searchChildDevelopments" type="text" placeholder="Search..."
                class="w-full p-2 border rounded-md" />
        </div>
        <div v-for="childDev in paginatedChildDevelopments" :key="childDev.id" class="bg-white shadow-md rounded-lg p-4 mb-4">
            <div class="flex">
                <img :src="getImageUrl(childDev.image)" alt="Thumbnail" class="w-20 h-20 object-cover rounded-lg mr-4">
                <div>
                    <h2 class="text-xl font-semibold">{{ childDev.child?.child_name }}</h2>
                    <div v-html="childDev.created_at"></div>
                    <button @click="viewDetail(childDev.id)" class="mt-2 text-blue-500 hover:text-blue-700">Detail
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
  name: 'ChildDevelopment',
  data() {
    return {
      childDevelopment: [],
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 5,
      totalItems: 0,
    };
  },
  computed: {
    ...mapGetters(['baseUrl']),
    queryParams() {
      return new URLSearchParams({
        page: this.currentPage,
        search: this.searchQuery
      }).toString();
    },
    paginatedChildDevelopments() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.childDevelopment.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.totalItems / this.itemsPerPage);
    }
  },
  mounted() {
    this.fetchChildDevelopments();
  },
  methods: {
    fetchChildDevelopments() {
      axios.get(`${this.baseUrl}/api/child-development-history?${this.queryParams}`)
        .then(response => {
          this.childDevelopment = response.data.data;
          this.totalItems = response.data.total;
        })
        .catch(error => {
          console.error(error);
        });
    },
    searchChildDevelopments() {
      this.currentPage = 1; // Reset to first page on new search
      this.fetchChildDevelopments();
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage += 1;
        this.fetchChildDevelopments();
      }
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage -= 1;
        this.fetchChildDevelopments();
      }
    },
    viewDetail(id) {
      this.$router.push({ name: 'child-development', params: { id } });
    },
    getImageUrl(path) {
      return `${this.baseUrl}/storage/${path}`;
    },
    gotoHome() {
      this.$router.push({ name: 'home' });
    }
  }
};
</script>