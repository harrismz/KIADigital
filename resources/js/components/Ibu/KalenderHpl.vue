<template>
    <div class="flex h-screen">
        <div class="w-1/2 bg-gray-200 flex">
            <img :src="'/storage/images/kalender hpl.jpg'" alt="Logo" class="h-full">
        </div>
        <div class="w-1/2 flex flex-col items-center justify-center">
            <h1 class="text-3xl font-bold mb-2">STATUS KEHAMILAN</h1>
            <p class="text-gray-500 mb-8 mx-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                industry.</p>
            DISINI INPUT HPL
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
