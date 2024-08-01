<template>
    <LoginLayout>
        <div class="min-h-screen flex items-center justify-center bg-gray-100">
            <div class="flex w-full max-w-4xl shadow-md rounded-lg overflow-hidden">
                <div class="w-1/2 bg-gray-200 flex items-center justify-center">
                    <div>
                        <!-- <img src="http://localhost:8000/storage/users/July2024/5EBVXVtkaXZtpxHTUFxL.png" alt="Logo"
                        class="w-32 h-32 mb-4"> -->
                        <img src="/storage/images/buku_kia.png" alt="Image"
                            class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="w-1/2 p-8 bg-white">
                    <h2 class="text-2xl font-bold mb-6 text-center">LOGIN</h2>
                    <p class="mb-6 text-center">Pastikan anda sudah memiliki akun.</p>
                    <form @submit.prevent="login">
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
                        <div class="flex justify-between items-center mb-4">
                            <a href="#" class="text-sm text-indigo-600 hover:underline">Forgot Password?</a>
                        </div>
                        <button type="submit"
                            class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Login
                        </button>
                    </form>
                    <div class="mt-6 text-center">
                        <p>Belum punya akun? <a href="/registration" class="text-indigo-600 hover:underline">Buat akun
                                sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </LoginLayout>
</template>

<script>
import axios from 'axios';
import LoginLayout from '../layouts/LoginLayout.vue';
import toastr from 'toastr';

export default {
    components: {
        LoginLayout
    },
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            error: ''
        };
    },
    methods: {
        async login() {
        try {
            
            const response = await axios.post('/api/login', {
                email: this.form.email,
                password: this.form.password
            });
            
            let data = response.data;

            localStorage.setItem('auth_token', data.access_token);

            this.$router.push('/dashboard');

        } catch (error) {
            console.log(error)
            let res = error.response;
            let data = res.data;
            let msg = data.message;
            toastr.error(msg)
        }
        }
    }
};
</script>

<style scoped>
/* Add your styles here */
</style>
