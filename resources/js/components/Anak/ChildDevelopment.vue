<template>
  <div class="container mx-auto p-8 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold mb-6 text-center">
      {{ childDevelopment.child?.child_name || 'Child Name Not Available' }}
    </h1>

    <div class="space-y-4">
      <!-- Display Age -->
      <div class="flex items-center">
        <span class="font-semibold w-1/3">Age:</span>
        <span>
          {{ childDevelopment.age?.years || 'N/A' }} years,
          {{ childDevelopment.age?.weeks || 'N/A' }} weeks
        </span>
      </div>

      <!-- Other Child Development Details -->
      <div class="flex items-center">
        <span class="font-semibold w-1/3">Created Date:</span>
        <span>{{ formatDate(childDevelopment.created_at) || 'Date Not Available' }}</span>
      </div>

      <div class="flex items-center">
        <span class="font-semibold w-1/3">Immunization Status:</span>
        <span>{{ childDevelopment.immunisation_status || 'Status Not Available' }}</span>
      </div>

      <div class="flex items-center">
        <span class="font-semibold w-1/3">Advice Given:</span>
        <span>{{ childDevelopment.advice_given || 'Advice Not Available' }}</span>
      </div>

      <div class="flex items-center">
        <span class="font-semibold w-1/3">Complaint:</span>
        <span>{{ childDevelopment.complaint || 'Complaint Not Available' }}</span>
      </div>

      <div class="flex items-center">
        <span class="font-semibold w-1/3">Head Circumference:</span>
        <span>{{ childDevelopment.head_circumference || 'Head Circumference Not Available' }}</span>
      </div>

      <div class="flex items-center">
        <span class="font-semibold w-1/3">Height:</span>
        <span>{{ childDevelopment.height || 'Height Not Available' }}</span>
      </div>

      <div class="flex items-center">
        <span class="font-semibold w-1/3">Weight:</span>
        <span>{{ childDevelopment.weight || 'Weight Not Available' }}</span>
      </div>
    </div>

    <div class="text-center mt-8">
      <button @click="goBack" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
        Back
      </button>
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
      childDevelopment: {}
    };
  },
  computed: {
    ...mapGetters(['baseUrl']),
    id() {
      return this.$route.params.id;
    }
  },
  mounted() {
    this.fetchInformation();
  },
  methods: {
    async fetchInformation() {

        const url = `${this.baseUrl}/api/child-development-detail/${this.id}`;
        console.log('Fetching child development information:', url);

        axios.get(url)
        .then(response => {
          this.childDevelopment = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    goBack() {
      this.$router.push({ name: 'child-development-list' });
    },
    formatDate(date) {
      if (!date) return null;
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(date).toLocaleDateString(undefined, options);
    }
  }
};
</script>
