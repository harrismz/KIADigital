<template>
    <div class="max-w-3xl mx-auto p-8">
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <div v-for="(step, index) in steps" :key="index" class="flex items-center">
                    <div :class="{
                        'bg-indigo-600 text-white': index <= currentStep,
                        'bg-gray-200 text-gray-500': index > currentStep
                    }" class="flex items-center justify-center w-8 h-8 rounded-full">
                        {{ index + 1 }}
                    </div>
                    <div v-if="index < steps.length - 1" :class="{
                        'bg-indigo-600': index < currentStep,
                        'bg-gray-200': index >= currentStep
                    }" class="flex-1 h-1"></div>
                </div>
            </div>
            <h2 class="text-2xl font-semibold">{{ steps[currentStep] }}</h2>
        </div>
        <div v-if="currentStep === 0">
            <form @submit.prevent="nextStep">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" v-model="form.name" id="name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required />
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" v-model="form.email" id="email"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required />
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Next</button>
            </form>
        </div>
        <div v-else-if="currentStep === 1">
            <form @submit.prevent="nextStep">
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" v-model="form.address" id="address"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required />
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" v-model="form.phone" id="phone"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required />
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Next</button>
                <button @click="prevStep" type="button"
                    class="mt-2 w-full py-2 px-4 bg-gray-600 text-white rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Previous</button>
            </form>
        </div>
        <div v-else-if="currentStep === 2">
            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" v-model="form.password" id="password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required />
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input type="password" v-model="form.password_confirmation" id="password_confirmation"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required />
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                <button @click="prevStep" type="button"
                    class="mt-2 w-full py-2 px-4 bg-gray-600 text-white rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Previous</button>
            </form>
        </div>
        <div v-else>
            <h2 class="text-2xl font-semibold text-center">Registration Complete!</h2>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            currentStep: 0,
            steps: ['Personal Info', 'Contact Info', 'Set Password'],
            form: {
                name: '',
                email: '',
                address: '',
                phone: '',
                password: '',
                password_confirmation: '',
            },
        };
    },
    methods: {
        nextStep() {
            if (this.currentStep < this.steps.length - 1) {
                this.currentStep++;
            }
        },
        prevStep() {
            if (this.currentStep > 0) {
                this.currentStep--;
            }
        },
        async submitForm() {
            try {
                const response = await fetch('/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(this.form),
                });

                const data = await response.json();
                
                console.log({data});

                // set token to localStorage
                localStorage.setItem('auth_token', data.access_token);
                
                // save to store
                this.$store.commit('setToken', data.access_token );

                if (data.success) {
                    this.currentStep++;
                } else {
                    alert('Registration failed: ' + data.message);
                }
            } catch (error) {
                console.error('Error during registration:', error);
            }
        },
    },
};
</script>

<style scoped>
/* Customize your stepper styling here if needed */
</style>
