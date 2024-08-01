<template>
    <div class="flex h-screen">
        <div class="w-1/3 bg-gray-200 flex">
            <img :src="'/storage/images/alat ukur hamil.jpg'" alt="Logo" class="h-full">
        </div>
        <div class="w-2/3 flex flex-col items-center justify-center">
            <h1 class="text-3xl font-bold mb-2">STATUS KEHAMILAN</h1>
            <p class="text-gray-500 mb-8">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <button @click="goToCalendar"
                class="bg-white text-gray-800 font-bold py-2 px-4 border border-gray-400 rounded shadow mb-7 w-1/2">
                Input HPL
            </button>
            <button @click="goToChild"
                class="bg-white text-gray-800 font-bold py-2 px-4 border border-gray-400 rounded shadow w-1/2">
                Bayi Sudah Lahir
            </button>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        goToCalendar() {
            this.$router.push('/kalender-hpl');
        },
        goToChild() {
            this.$router.push('/child');
        }
    }
}
</script>
