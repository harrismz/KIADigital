<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="flex w-full max-w-4xl shadow-md rounded-lg overflow-hidden">
            <div class="w-1/2 bg-gray-200 flex">
                <div>
                    <img :src="'/storage/images/ayah.png'" class="h-full" alt="Identitas Ayah">
                    <!-- <img :src="'/storage/images/ayah.png'" alt="Image" class="w-full h-full object-cover"> -->
                </div>
            </div>
            <div class="w-1/2 p-8 bg-white">
                <h2 class="text-2xl font-bold mb-6 text-center">IDENTITAS AYAH</h2>
                <form @submit.prevent="submitIdentitasAyah">

                    <div class="mb-4">
                        <label for="namaAyah" class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                        <input v-model="formIdentitasAyah.namaAyah" type="text" id="namaAyah"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>

                    <div class="mb-4">
                        <label for="nik" class="block text-sm font-medium text-gray-700">Nomor Induk
                            Kependudukan</label>
                        <input v-model="formIdentitasAyah.nik" type="text" id="nik"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>

                    <div class="mb-4">
                        <label for="tempatLahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input v-model="formIdentitasAyah.tempatLahir" type="text" id="tempatLahir"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="tanggalLahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input v-model="formIdentitasAyah.tanggalLahir" type="date" id="tanggalLahir"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Nomor Jaminan Kesehatan
                            Nasional</label>
                        <input v-model="formIdentitasAyah.phoneNumber" type="text" id="phoneNumber"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi</label>
                        <input v-model="formIdentitasAyah.tinggi" type="number" id="tinggi"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="golonganDarah" class="block text-sm font-medium text-gray-700">Golongan
                            Darah</label>
                        <select v-model="formIdentitasAyah.golonganDarah" id="golonganDarah"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                            <option value="" disabled>Pilih Golongan Darah</option>
                            <option v-for="bloodType in bloodTypeList" :key="bloodType.id"
                                :value="bloodType.blood_type_name">
                                {{ bloodType.blood_type_name }} ( {{ bloodType.reshus }} )
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input v-model="formIdentitasAyah.alamat" type="text" id="alamat"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                        <select v-model="formIdentitasAyah.kelurahan" id="kelurahan"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            @change="updateKecamatan" required>
                            <option value="" disabled>Pilih Kelurahan</option>
                            <option v-for="kelurahan in kelurahanList" :key="kelurahan.id" :value="kelurahan.id">
                                {{ kelurahan.kelurahan_name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700">kecamatan</label>
                        <select v-model="formIdentitasAyah.kecamatan" id="kecamatan"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                            <option value="" disabled>Pilih kecamatan</option>
                            <option v-for="kecamatan in kecamatanList" :key="kecamatan.id" :value="kecamatan.id">
                                {{ kecamatan.kecamatan_name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="religion" class="block text-sm font-medium text-gray-700">religion</label>
                        <select v-model="formIdentitasAyah.religion" id="religion"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                            <option value="" disabled>Pilih Agama</option>
                            <option v-for="religion in religionList" :key="religion.id" :value="religion.id">
                                {{ religion.religion_name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="pendidikan" class="block text-sm font-medium text-gray-700">Pendidikan</label>
                        <select v-model="formIdentitasAyah.pendidikan" id="pendidikan"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                            <option value="" disabled>Pilih Pendidikan</option>
                            <option v-for="education in educationList" :key="education.id" :value="education.id">
                                {{ education.education_name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                        <select v-model="formIdentitasAyah.pekerjaan" id="pekerjaan"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                            <option value="" disabled>Pilih Pekerjaan</option>
                            <option v-for="job in jobList" :key="job.id" :value="job.id">
                                {{ job.job_name }}
                            </option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Lanjut
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, computed, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import toastr from 'toastr';
import MyInput from './MyInput.vue';


toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "3000",
    "timeOut": "7000",
    "extendedTimeOut": "2000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

const store = useStore();
const router = useRouter();

const imgLogo = computed(() => store.getters.imgLogo);
const baseUrl = computed(() => store.getters.baseUrl);

const user_id = computed(() => router.params.id);
const nik = computed(() => router.params.nik);
const name = computed(() => router.params.name);
const email = computed(() => router.params.email);

const bloodTypeList = ref([]);
const kelurahanList = ref([]);
const kecamatanList = ref([]);
const educationList = ref([]);
const jobList = ref([]);
const religionList = ref([]);

const formIdentitasAyah = reactive({
    nik: '',
    noJkn: '',
    namaAyah: '',
    tanggalLahir: '',
    tempatLahir: '',
    phoneNumber: '',
    alamat: '',
    kelurahan: '',
    kecamatan: '',
    religion: '',
    pendidikan: '',
    golonganDarah: '',
    pekerjaan: '',
    tinggi: '',
    user_id: '',

});

const submitIdentitasAyah = async () => {
    try {
        toastr.success('Identitas Ayah Berhasil disimpan.');

        router.push({
            name: 'status-kehamilan',
            params: {}
        });
        // Handle the next step or redirect
    } catch (error) {
        console.error(error);
        // Handle the error
    }
}

const fetchKelurahan = async () => {

    console.log(router.params);
    try {
        const response = await axios.get(`${baseUrl.value}/api/kelurahan`);
        kelurahanList.value = response.data;
        console.log({ kelurahanList });
    } catch (error) {
        console.error('Error fetching kelurahan:', error);
    }
}

const fetchBloodTypes = async () => {
    try {
        const bloodTypeResponse = await axios.get(`${baseUrl.value}/api/blood-types`);
        bloodTypeList.value = bloodTypeResponse.data;
        console.log({ bloodTypeList });
    } catch (error) {
        console.error('Error fetching blood type:', error);
    }
};

const fetchEducations = async () => {
    try {
        const educationResponse = await axios.get(`${baseUrl.value}/api/pendidikan`);
        educationList.value = educationResponse.data;
        console.log({ educationList });
    } catch (error) {
        console.error('Error fetching education:', error);
    }
};

const fetchJobs = async () => {
    try {
        const jobResponse = await axios.get(`${baseUrl.value}/api/pekerjaan`);
        jobList.value = jobResponse.data;
        console.log({ jobList });
    } catch (error) {
        console.error('Error fetching job:', error);
    }
};

const fetchReligion = async () => {
    try {
        const religionResponse = await axios.get(`${baseUrl.value}/api/religion`);
        religionList.value = religionResponse.data;
        console.log({ religion });
    } catch (error) {
        console.error('Error fetching religion:', error);
    }
};

const updateKecamatan = async () => {
    try {
        const selectedKelurahan = await axios.get(`${baseUrl.value}/api/kecamatan/${formIdentitasAyah.kelurahan}`);
        kecamatanList.value = selectedKelurahan.data;
        console.log({ kecamatanList });
        router.push({
            name: 'my-profile',
            params: {}
        });
    } catch (error) {
        console.error('Error fetching kecamatan: ', error);
    }
};

onMounted(() => {
    fetchKelurahan();
    fetchBloodTypes();
    fetchEducations();
    fetchJobs();
    fetchReligion();
});
</script>
<style scoped>
/* Add your styles here */
</style>
