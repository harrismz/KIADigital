<template>
    <div class="container mt-5">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-grey">Check Up</h2>
                        <form class="flex items-end space-x-2" action="/checkup/show" method="GET">
                            <div class="flex-grow">
                                <input type="text" placeholder="input medical id : ID XXXXXX XXXX XXXXX" name="id" id="id" class="w-full block border border-gray-300 rounded-md py-2 pl-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm sm:leading-6">
                            </div>
                            <button class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HealthRecord",

};
</script>

<style scoped>
/* Jika Anda memiliki styling khusus, tambahkan di sini */
</style>
