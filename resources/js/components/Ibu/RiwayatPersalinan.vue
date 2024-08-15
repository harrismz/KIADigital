<template>
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-md shadow-md">
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <h1 class="text-2xl font-bold">Riwayat Persalinan</h1>
                    <div class="flex justify-end gap-x-3">
                        <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'"></img>
                        <img class="w-6 h-6" @click="editAnswer" :src="'storage/images/edit.png'"></img>
                    </div>
                </div>
            </div>
            <div v-if="loading" class="text-center">Loading...</div>
            <div v-else>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Tanggal Bersalin</p>
                    <p class="text-justify font-medium italic">21 Juni 2024</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Umur Kehamilan</p>
                    <p class="text-justify font-medium italic">38 Minggu</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Penolong Persalinan</p>
                    <p class="text-justify font-medium italic">Dr. xxx Sp.OG</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Cara Persalinan</p>
                    <p class="text-justify font-medium italic">Normal</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Keadaan Ibu</p>
                    <p class="text-justify font-medium italic">Sehat</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">KB Pasca Persalinan</p>
                    <p class="text-justify font-medium italic">Spiral</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Anak Ke</p>
                    <p class="text-justify font-medium italic">1</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Keterangan Tambahan</p>
                    <p class="text-justify font-medium italic">-</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

export default {
    name: 'RiwayatPersalinan',
    setup() {
        const childBirthData = ref({});
        const loading = ref(false);
        const router = useRouter();

        const fetchData = async () => {
            // Ganti URL ini dengan endpoint API yang sesuai
            const response = await fetch('/api/childbirth-history');
            childBirthData.value = await response.json();
            loading.value = false;
        };
        const editAnswer = () => {
            router.push({
                name: 'riwayat-persalinan-edit',
                params: {}
            });
        };
        const gotoHome = () => {
            router.push({
                name: 'dashboard',
                params: {}
            });
        };

        onMounted(fetchData);

        return {
            childBirthData,
            loading,
            gotoHome,
            editAnswer
        };
    },
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
