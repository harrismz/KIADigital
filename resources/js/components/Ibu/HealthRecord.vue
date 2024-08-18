<template>
    <div class="p-8 bg-gray-100 font-sans">
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-4">
                <h1 class="text-2xl font-bold">Catatan Kesehatan Ibu</h1>
                <div class="flex justify-end">
                    <img class="w-6 h-6" @click="gotoHome" :src="`${baseUrl}/storage/images/home.png`"></img>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-md">
            <ul class="list-disc list-inside space-y-2" v-for="(val, key) in data" :key="key">
                <li v-if="label(key) != 'Foto USG'" class="mb-2">{{ label(key) }} : {{ val }}</li>
                <div v-if="key == 'usg_image'" class="flex justify-center mb-4">
                    <img :src="baseUrl + '/storage/' + val" :alt="key" alt="Hasil USG" class="rounded shadow-md" />
                </div>
            </ul>
        </div>


    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import helper from '../helper';

export default {
    name: "HealthRecord",
    data() {
        return {
            inputValue: '',
            data: {},
            except: {
                'id': true,
                'pregnancy_id': true, // dari apa ??
                'staff_id': true, //dari apa ?
                'hospital_id': true, // dari apa
                'created_at': true,
                'updated_at': true,
                'child_id': true,
                'pregnancy': true //from data.id
            },
        };
    },
    computed: {
        ...mapGetters(['baseUrl', 'mom']),

    },
    mounted() {
        this.getHealthRecord()
    },
    methods: {
        async getHealthRecord() {
            const id = this.id();

            try {

                await axios.get(`${this.baseUrl}/api/pregnancy-history/${id}`, {
                    headers: {
                        'Accept': 'application/json', // Expect a JSON response
                        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                    }
                })
                    .then(response => response.data)
                    .then(response => {

                        if (response.success) {

                            let result = {}
                            let res = response.data;
                            for (const key in res) {
                                if (Object.prototype.hasOwnProperty.call(res, key)) {
                                    // const element = res[key];
                                    if (!(key in this.except)) {
                                        result[key] = res[key]
                                    }
                                }
                            }
                            console.log({ result });
                            this.data = result;

                        }

                    })
                    .catch(error => {
                        console.error('Error fetching pregnancy history:', error);
                    });

            } catch (error) {
                console.error('Error fetching pregnancy histories:', error);
            }
            // console.log({ Preg: this.pregnancies })
        },
        id() {
            return this.$route.params.id;
        },
        label(str) {
            return helper.label(str);
        },
        gotoHome() {
            this.$router.push({
                name: 'health-records-list',
                params: {},
            });
        },
    },
};
</script>

<style scoped>
/* Jika Anda memiliki styling khusus, tambahkan di sini */
</style>
