<template>
    <div class="card">
        <div class="card-body">
            <div class="bg-white p-4 shadow rounded mb-4">
                <h5 class="text-lg font-bold mb-2">{{ title }}</h5>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <p class="mb-4 md:col-span-3">{{ description }}</p>
                    <div class="flex justify-end md:col-span-1">
                    <img :src="img" alt="" class="w-24 h-24">
                    </div>
                </div>
                <a :href="link" class="text-blue-500">Selengkapnya ></a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        description: String,
        link: String,
        img: String,
    }
};
</script>
