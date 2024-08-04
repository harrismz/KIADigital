<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Informasi</h1>
    <div class="mb-4">
      <input v-model="searchQuery" @input="searchInformations" type="text" placeholder="Search..." class="w-full p-2 border rounded-md" />
    </div>
    <div v-for="info in paginatedInformations" :key="info.id" class="bg-white shadow-md rounded-lg p-4 mb-4">
      <div class="flex">
        <img :src="getImageUrl(info.image)" alt="Thumbnail" class="w-20 h-20 object-cover rounded-lg mr-4">
        <div>
          <h2 class="text-xl font-semibold">{{ info.title }}</h2>
          <div v-html="info.excerpt"></div>
          <button @click="viewDetail(info.slug)" class="mt-2 text-blue-500 hover:text-blue-700">Read more</button>
        </div>
      </div>
    </div>
    <div class="flex justify-center mt-4">
      <button @click="previousPage" :disabled="currentPage === 1" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">Previous</button>
      <span class="px-4">{{ currentPage }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">Next</button>
    </div>
  </div>
</template>
<script>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import axios from 'axios';

export default {
  setup() {
    const store = useStore();
    const router = useRouter();
    const informations = ref([]);
    const searchQuery = ref('');
    const currentPage = ref(1);
    const itemsPerPage = 5;
    const totalItems = ref(0);
    const baseUrl = computed(() => store.getters.baseUrl);

    const fetchInformations = () => {
      const queryParams = new URLSearchParams({
        page: currentPage.value,
        search: searchQuery.value
      }).toString();

      axios.get(`${baseUrl.value}/api/post?${queryParams}`)
        .then(response => {
          informations.value = response.data.data;
          totalItems.value = response.data.total;
        })
        .catch(error => {
          console.error(error);
        });
    };

    const searchInformations = () => {
      currentPage.value = 1; // Reset to first page on new search
      fetchInformations();
    };

    const paginatedInformations = computed(() => {
      const start = (currentPage.value - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      return informations.value.slice(start, end);
    });

    const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));

    const nextPage = () => {
      if (currentPage.value < totalPages.value) {
        currentPage.value += 1;
        fetchInformations();
      }
    };

    const previousPage = () => {
      if (currentPage.value > 1) {
        currentPage.value -= 1;
        fetchInformations();
      }
    };

    const viewDetail = (slug) => {
      router.push({ name: 'informasi-medis-detail', params: { slug } });
    };

    const getImageUrl = (path) => {
      return `${baseUrl.value}/storage/${path}`;
    };

    onMounted(() => {
      fetchInformations();
    });

    return {
        informations,
        searchQuery,
        currentPage,
        totalPages,
        paginatedInformations,
        searchInformations,
        viewDetail,
        nextPage,
        previousPage,
        getImageUrl,
    };
  }
};
</script>
