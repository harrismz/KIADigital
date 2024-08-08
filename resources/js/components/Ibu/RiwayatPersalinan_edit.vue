<template>
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-md shadow-md">
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <h1 class="text-2xl font-bold">Riwayat Persalinan</h1>
                    <div class="flex justify-end gap-x-3">
                        <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'"></img>
                    </div>
                </div>
            </div>
            <h1 class="text-2xl font-semibold">Identitas Anak</h1>
            <div v-if="loading" class="text-center">Loading...</div>
            <div v-else>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">1. Tanggal Bersalin</p>
                    <input type="date" class="w-full p-2 border-gray-300 rounded-lg shadow-sm" rows="3"
                        placeholder="Tanggal Bersalin.."></input>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">2. Umur Kehamilan</p>
                    <input type="text" class="w-full p-2 border-gray-300 rounded-lg shadow-sm" rows="3"
                        placeholder="Umur Kehamilan"></input>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">3. Penolong Persalinan</p>
                    <input type="text" class="w-full p-2 border-gray-300 rounded-lg shadow-sm" rows="3"
                        placeholder="Penolong Persalinan"></input>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">4. Cara Persalinan</p>
                    <input type="text" class="w-full p-2 border-gray-300 rounded-lg shadow-sm" rows="3"
                        placeholder="Cara Persalinan"></input>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">5. Keadaan Ibu</p>
                    <input type="text" class="w-full p-2 border-gray-300 rounded-lg shadow-sm" rows="3"
                        placeholder="Keadaan Ibu"></input>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">6. KB Pasca Persalinan</p>
                    <input type="text" class="w-full p-2 border-gray-300 rounded-lg shadow-sm" rows="3"
                        placeholder=""></input>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">7. Anak Ke</p>
                    <input type="number" class="w-full p-2 border-gray-300 rounded-lg shadow-sm" rows="3"
                        placeholder=""></input>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">8. Keterangan Tambahan</p>
                    <textarea type="text" class="w-full p-2 border-gray-300 rounded-lg shadow-sm" rows="3"
                        placeholder="Keterangan Tambahan"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

export default {
    name: 'RiwayatPersalinanEdit',
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

        const gotoHome = () => {
            router.push({
                name: 'home',
                params: {}
            });
        };

        onMounted(fetchData);

        return {
            childBirthData,
            loading,
            gotoHome
        };
    },
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
