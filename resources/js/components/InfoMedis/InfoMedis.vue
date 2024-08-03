<template>
  <div class="container mx-auto p-8 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold mb-4">{{ information.title }}</h1>
    <div v-if="information.image" class="mb-4">
      <img :src="getImageUrl(information.image)" :alt="information.title" class="w-full h-auto rounded-lg">
    </div>
    <div class="prose prose-lg">
      <div v-html="information.body"></div>
    </div>
    <button @click="goBack" class="mt-6 text-blue-500 hover:text-blue-700">Back</button>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useStore } from 'vuex';
import axios from 'axios';

export default {
  setup() {
    const store = useStore();
    const router = useRouter();
    const route = useRoute();
    const information = ref({});
    const baseUrl = computed(() => store.getters.baseUrl);

    const fetchInformation = () => {
      axios.get(`${baseUrl.value}/api/post/${route.params.slug}`)
        .then(response => {
          information.value = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    };

    const goBack = () => {
      router.push({ name: 'informasi-medis' });
    };
    const getImageUrl = (path) => {
      return `${baseUrl.value}/storage/${path}`;
    };

    onMounted(() => {
      fetchInformation();
    });

    return {
      information,
        getImageUrl,
      goBack
    };
  }
};
</script>
