<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="flex w-full max-w-4xl shadow-md rounded-lg overflow-hidden">
            <div class="w-1/3 bg-gray-200 flex items-center justify-center">
                <div>
                    <img :src="imgLogo" alt="Image" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="w-2/3 p-8 bg-white">
                <h2 class="text-2xl font-bold mb-6 text-center">DAFTAR AKUN</h2>
                <p class="mb-6 text-center">Buat akun untuk dapat mengakses semua fitur KIA</p>
                <form @submit.prevent="register">
                    <div class="mb-4">
                        <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                        <input v-model="form.nik" type="number" id="nik"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input v-model="form.name" type="text" id="name"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input v-model="form.email" type="email" id="email"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input v-model="form.password" type="password" id="password"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required />
                    </div>
                    <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Daftar Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, computed, onMounted } from 'vue';
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

const form = reactive({
    nik: '',
    name: '',
    email: '',
    password: ''
});

const register = async () => {
    // console.log({ baseUrl: baseUrl.value });
    try {
        const response = await axios.post(`${baseUrl.value}/api/register`, form);

        if (response && response.data) {
            console.log("creating", response.data);

            let data = response.data;
            // set token to localStorage
            localStorage.setItem('auth_token', data.access_token);
            // save to store
            store.commit('setToken', data.access_token );

            console.log("User data:", response.data.user);
        }

        toastr.success('Akun berhasil dibuat!');

        router.push({
            name: 'identitas-ibu',
            params: {
                id: response.data.user.id.toString(),
                nik: response.data.user.nik.toString(),
                name: response.data.user.name.toString(),
                email: response.data.user.email.toString(),
            }
        })

    } catch (error) {
        console.error({ erorr: error });

        if (error.response && error.response.data) {
            const errors = error.response.data;
            for (const key in errors) {
                if (errors.hasOwnProperty(key)) {
                    errors[key].forEach(message => {
                        toastr.error(message);
                    });
                }
            }
        }
    }
};

onMounted(() => {
    store.dispatch('fetchBaseUrl');
    store.dispatch('fetchUser');
    store.dispatch('fetchLogo');
});
</script>

<style scoped>
/* Add your styles here */
</style>
