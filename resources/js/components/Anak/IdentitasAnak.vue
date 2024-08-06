<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="flex w-full max-w-4xl shadow-md rounded-lg overflow-hidden">
            <div class="w-1/2 bg-gray-200 flex">
                <div>
                    <img :src="'/storage/images/anak.jpg'" alt="Image" class="h-full">
                </div>
            </div>
            <div class="w-1/2 p-8 bg-white">
                <h2 class="text-2xl font-bold mb-6 text-center">IDENTITAS ANAK</h2>
                <form @submit.prevent="submitIdentitas">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                        <input v-model="formIdentitasAnak.name" type="text" id="name"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="nik" class="block text-sm font-medium text-gray-700">Nomor Akte Kelahiran</label>
                        <input v-model="formIdentitasAnak.nik" type="text" id="nik"
                            class="mt-1 p-2  block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>

                    <div class="mb-4">
                        <label for="tempatLahir" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <input v-model="formIdentitasAnak.birth_place" type="text" id="tempatLahir"
                            class="mt-1 p-2  block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>

                    <div class="mb-4">
                        <label for="tempatLahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input v-model="formIdentitasAnak.birth_place" type="text" id="tempatLahir"
                            class="mt-1 p-2  block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="tanggalLahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input v-model="formIdentitasAnak.date_of_birth" type="date" id="tanggalLahir"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>

                    <div class="mb-4">
                        <label for="tempatLahir" class="block text-sm font-medium text-gray-700">Tinggi Saat
                            Lahir</label>
                        <input v-model="formIdentitasAnak.height" type="number" id="tempatLahir"
                            class="mt-1 p-2  block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="berat" class="block text-sm font-medium text-gray-700">Berat Saat Lahir</label>
                        <input v-model="formIdentitasAnak.berat" type="number" id="berat"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
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

const formIdentitasAnak = reactive({
    nik: '',
    no_jkn: '',
    name: '',
    date_of_birth: '',
    birth_place: '',
    phone_number: '',
    address: '',
    // kelurahan: '',
    kecamatan_id: '',
    religion_id: '',
    education_id: '',
    blood_type_id: '',
    job_id: '',
    height: '',
    user_id: '',

});

const submitIdentitasIbu = async () => {
    try {
        // bang lanjutin save
        const user = store.getters.getUser;

        let form = { ...formIdentitasAnak, ...{ user_id: user.id } };

        console.log("submit identitas ", { form })

        const response = await axios.post(`${baseUrl.value}/api/identitas-ibu`, form);

        if (response && response.data) {
            console.log("creating", response.data);
            console.log("User data:", response.data.user);
        }

        toastr.success('Identitas Ibu Berhasil disimpan.');

        router.push({
            name: 'identitas-ayah',
            params: {}
        });
        // Handle the next step or redirect
    } catch (error) {
        let message = error;

        if (error.response) {
            if (error.data) {
                message = error.data.message;
            }
        }
        console.error(message);
        toastr.error(message)
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
        // const selectedKelurahan = await axios.get(`${baseUrl.value}/api/kecamatan/${formIdentitasAnak.kelurahan}`);
        const selectedKelurahan = await axios.get(`${baseUrl.value}/api/kecamatan`);
        kecamatanList.value = selectedKelurahan.data;
        console.log({ kecamatanList });
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
    updateKecamatan();
});
</script>
<style scoped>
/* Add your styles here */
</style>
