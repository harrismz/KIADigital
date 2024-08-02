<template>
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-md shadow-md">
            <div class="grid grid-cols-2 gap-4">
                <h1 class="text-2xl font-bold">Dairy Ibu Hamil - Week 3</h1>
                <h2 class="text-xl font-semibold mb-4">Identitas Anak {{ chidBirthData.namaAnak }}</h2>
                <div class="flex justify-end">
                    <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'"></img>
                </div>
            </div>
            <!-- <h1 class="text-2xl font-bold mb-6">Riwayat Persalinan</h1> -->
            <div v-if="loading" class="text-center">Loading...</div>
            <div v-else>
                <div class="mb-4">
                    <label class="block text-gray-700">Tanggal Bersalin</label>
                    <div class="p-2 border rounded">{{ childBirthData.deliveryDate }}</div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Umur Kehamilan</label>
                    <div class="p-2 border rounded">{{ childBirthData.gestationalAge }}</div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Penolong Persalinan</label>
                    <div class="p-2 border rounded">{{ childBirthData.birthAttendant }}</div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Cara Persalinan</label>
                    <div class="p-2 border rounded">{{ childBirthData.deliveryMethod }}</div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Keadaan Ibu</label>
                    <div class="p-2 border rounded">{{ childBirthData.motherCondition }}</div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">KB Pasca Persalinan</label>
                    <div class="p-2 border rounded">{{ childBirthData.postpartumContraception }}</div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Anak Ke</label>
                    <div class="p-2 border rounded">{{ childBirthData.childOrder }}</div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Keterangan Tambahan</label>
                    <div class="p-2 border rounded">{{ childBirthData.additionalNotes }}</div>
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
        const loading = ref(true);
        const router = useRouter();

        const fetchData = async () => {
            // Ganti URL ini dengan endpoint API yang sesuai
            const response = await fetch('/api/childbirth-history');
            childBirthData.value = await response.json();
            loading.value = false;
        };

        const gotoHome = () => {
            router.push({
                name: 'profile',
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
