<template>
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-md shadow-md">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <i class="fas fa-bell text-gray-600 text-xl"></i>
                    <i class="fas fa-user-circle text-gray-600 text-2xl ml-4"></i>
                </div>
            </div>
            <h1 class="text-2xl font-bold mb-6">Riwayat Persalinan</h1>
            <h2 class="text-xl font-semibold mb-4">Identitas Anak</h2>
            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <label for="deliveryDate" class="block text-gray-700">Tanggal Bersalin</label>
                    <input type="date" id="deliveryDate" v-model="form.deliveryDate"
                        class="w-full p-2 border rounded" />
                </div>
                <div class="mb-4">
                    <label for="gestationalAge" class="block text-gray-700">Umur Kehamilan</label>
                    <input type="text" id="gestationalAge" v-model="form.gestationalAge"
                        class="w-full p-2 border rounded" />
                </div>
                <div class="mb-4">
                    <label for="birthAttendant" class="block text-gray-700">Penolong Persalinan</label>
                    <input type="text" id="birthAttendant" v-model="form.birthAttendant"
                        class="w-full p-2 border rounded" />
                </div>
                <div class="mb-4">
                    <label for="deliveryMethod" class="block text-gray-700">Cara Persalinan</label>
                    <input type="text" id="deliveryMethod" v-model="form.deliveryMethod"
                        class="w-full p-2 border rounded" />
                </div>
                <div class="mb-4">
                    <label for="motherCondition" class="block text-gray-700">Keadaan Ibu</label>
                    <input type="text" id="motherCondition" v-model="form.motherCondition"
                        class="w-full p-2 border rounded" />
                </div>
                <div class="mb-4">
                    <label for="postpartumContraception" class="block text-gray-700">KB Pasca Persalinan</label>
                    <input type="text" id="postpartumContraception" v-model="form.postpartumContraception"
                        class="w-full p-2 border rounded" />
                </div>
                <div class="mb-4">
                    <label for="childOrder" class="block text-gray-700">Anak Ke</label>
                    <input type="text" id="childOrder" v-model="form.childOrder" class="w-full p-2 border rounded" />
                </div>
                <div class="mb-4">
                    <label for="additionalNotes" class="block text-gray-700">Keterangan Tambahan</label>
                    <textarea id="additionalNotes" v-model="form.additionalNotes"
                        class="w-full p-2 border rounded"></textarea>
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded">
                    Submit
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';


export default {
    name: 'RiwayatPersalinan',
    setup() {
        const router = useRouter();

        const form = ref({
            deliveryDate: '',
            gestationalAge: '',
            birthAttendant: '',
            deliveryMethod: '',
            motherCondition: '',
            postpartumContraception: '',
            childOrder: '',
            additionalNotes: '',
        });

        const handleSubmit = () => {
            console.log(form.value);
            // Implement submit logic here
            toastr.sucess("Riwayat Berhasil disimpan.")
            router.push({
                name: 
            })

        };


        return {
            form,
            handleSubmit,
        };
    },
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
