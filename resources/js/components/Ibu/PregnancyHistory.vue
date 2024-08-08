<template>
  <div class="max-w-lg mx-auto p-6 bg-gray-100 border rounded-lg">
    <div class="flex justify-between items-center mb-4">
      <div class="text-gray-800 font-bold text-lg">Catatan Kesehatan Ibu</div>
      <div class="text-gray-500 text-sm">LOGO</div>
    </div>
    
    <div class="mt-4">
      <div class="text-gray-800 font-semibold mb-2">Hasil USG :</div>
      <img src="path_to_your_image.png" alt="USG Image" class="w-full h-auto border" />
    </div>
    
    <div class="mt-4 text-gray-700">
      <p class="font-semibold">Pemeriksaan Laboratorium :</p>
      <p>Hemoglobin x gr/dL, golongan darah & Rhesus O, gula darah sewaktu mg/dL, H R, S R, Hepatitis B R.</p>
      <p class="mt-2"><span class="font-semibold">Keluhan dan gejala lainnya :</span> -</p>
      <p><span class="font-semibold">Solusi Keluhan :</span> -</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      pregnancyData: {}
    };
  },

  computed: {
    week() {
      return this.$router.query.weeks; //weeks = router 
    }
  },
  async created() {
    const id = this.$route.params.id;
    try {
      const response = await axios.get('/api/pregnancy-history');
      this.pregnancyData = response.data;
    } catch (error) {
      console.error("Error fetching pregnancy data:", error);
    }
  }
};
</script>

<style scoped>
/* Add your styles here */
</style>