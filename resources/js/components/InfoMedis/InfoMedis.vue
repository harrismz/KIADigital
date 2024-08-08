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
import axios from 'axios';
import { mapGetters } from 'vuex';

export default {
  name: 'InfoMedis',
  data() {
    return {
      information: {}
    };
  },
  computed: {
    ...mapGetters(['baseUrl']),
    slug() {
      return this.$route.params.slug;
    }
  },
  mounted() {
    this.fetchInformation();
  },
  methods: {
    fetchInformation() {
      axios.get(`${this.baseUrl}/api/post/${this.slug}`)
        .then(response => {
          this.information = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    goBack() {
      this.$router.push({ name: 'informasi-medis' });
    },
    getImageUrl(path) {
      return `${this.baseUrl}/storage/${path}`;
    }
  }
};
</script>