<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="flex w-full max-w-4xl shadow-md rounded-lg overflow-hidden">
            <div class="w-1/2 bg-gray-200 flex">
                <div>
                    <img :src="'/storage/images/ibu.jpg'" alt="Image" class="h-full">
                </div>
            </div>
            <div class="w-1/2 p-8 bg-white">
                <h2 class="text-2xl font-bold mb-6 text-center">IDENTITAS IBU</h2>
                <form @submit.prevent="submitIdentitasIbu">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                        <input v-model="formIdentitasIbu.name" type="text" id="name"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required disabled />
                    </div>
                    <div class="mb-4">
                        <label for="nik" class="block text-sm font-medium text-gray-700">Nomor Induk
                            Kependudukan</label>
                        <input v-model="formIdentitasIbu.nik" type="text" id="nik"
                            class="mt-1 p-2  block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required disabled/>
                    </div>

                    <div class="mb-4">
                        <label for="tempatLahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input v-model="formIdentitasIbu.birth_place" type="text" id="tempatLahir"
                            class="mt-1 p-2  block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="tanggalLahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input v-model="formIdentitasIbu.date_of_birth" type="date" id="tanggalLahir"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Nomor Whatsapp</label>
                        <input v-model="formIdentitasIbu.phone_number" type="text" id="phoneNumber"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Nomor Jaminan Kesehatan
                            Nasional</label>
                        <input v-model="formIdentitasIbu.no_jkn" type="text" id="noJkn"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi</label>
                        <input v-model="formIdentitasIbu.height" type="number" id="tinggi"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="golonganDarah" class="block text-sm font-medium text-gray-700">Golongan
                            Darah</label>
                        <select v-model="formIdentitasIbu.blood_type_id" id="golonganDarah"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                            <option value="" disabled>Pilih Golongan Darah</option>
                            <option v-for="bloodType in bloodTypeList" :key="bloodType.id"
                                :value="bloodType.id">
                                {{ bloodType.blood_type_name }} ( {{ bloodType.reshus }} )
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input v-model="formIdentitasIbu.address" type="text" id="alamat"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <!-- <div class="mb-4">
                        <label for="kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                        <select v-model="formIdentitasIbu.kelurahan" id="kelurahan"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            @change="updateKecamatan" required>
                            <option value="" disabled>Pilih Kelurahan</option>
                            <option v-for="kelurahan in kelurahanList" :key="kelurahan.id" :value="kelurahan.id">
                                {{ kelurahan.kelurahan_name }}
                            </option>
                        </select>
                    </div> -->
                    <div class="mb-4">
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <select v-model="formIdentitasIbu.kecamatan_id" id="kecamatan"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                            <option value="" disabled>Pilih kecamatan</option>
                            <option v-for="kecamatan in kecamatanList" :key="kecamatan.id" :value="kecamatan.id">
                                {{ kecamatan.kecamatan_name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                        <select v-model="formIdentitasIbu.religion_id" id="religion"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                            <option value="" disabled>Pilih Agama</option>
                            <option v-for="religion in religionList" :key="religion.id" :value="religion.id">
                                {{ religion.religion_name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="pendidikan" class="block text-sm font-medium text-gray-700">Pendidikan</label>
                        <select v-model="formIdentitasIbu.education_id" id="pendidikan"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                            <option value="" disabled>Pilih Pendidikan</option>
                            <option v-for="education in educationList" :key="education.id" :value="education.id">
                                {{ education.education_name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                        <select v-model="formIdentitasIbu.job_id" id="pekerjaan"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
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

const formIdentitasIbu = reactive({
    nik: store.state.user.nik? `${store.state.user.nik}`:'',
    no_jkn: '',
    name: store.state.user.name ? store.state.user.name : '',
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

        let form = {...formIdentitasIbu, ...{user_id: user.id }};

        console.log("submit identitas ",{form})

        const response = await axios.post(`${baseUrl.value}/api/identitas-ibu`, form );

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

        console.log(error)

        if(error.response) {
            if(error.response.data) {
                message = error.response.data.message;
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
        // const selectedKelurahan = await axios.get(`${baseUrl.value}/api/kecamatan/${formIdentitasIbu.kelurahan}`);
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
