<template>
    <div class="p-8 bg-gray-100 min-h-screen">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-md shadow-md">
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <h1 class="text-2xl font-bold">Riwayat Persalinan</h1>
                    <div class="flex justify-end gap-x-3">
                        <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'"></img>
                    </div>
                </div>
            </div>
            <h1 class="text-2xl font-semibold">Identitas Anak</h1>
            <div v-if="loading" class="text-center">Loading...</div>
            <div v-else>
                
                <form  @submit.prevent="submit">
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <my-input v-for="(value, key) in pregnancyInputs" :key="key"  :isRequired="value.isRequired" :inputType="value.inputType"
                        v-model="form[key]"  :inputKey="key" ></my-input>

                        <div>
                            <label for="kek">Kekurangan Energi Kronis</label>
                            <div class="flex gap-10">
                                <span>
                                    <input type="radio" value="1" name="kek" id="kek" v-model="form.kek">
                                    Ya
                                </span>
                                <span>
                                    <input type="radio" value="0" name="kek" id="kek" v-model="form.kek">
                                    Tidak
                                </span>
                            </div>
                        </div>
                    </div>

                    

                    <button type="submit" class="btn btn-primary text-white">Submit</button>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { mapGetters } from 'vuex';
import helper from '../helper';
import MyInput from '../utils/MyInput.vue';
import toastr from 'toastr';

export default {
    
    name: 'RiwayatPersalinanEdit',

    components: {
        MyInput
    },
    
    setup() {
        const childBirthData = ref({});
        const loading = ref(false);
        const router = useRouter();

        const fetchData = async () => {
            // Ganti URL ini dengan endpoint API yang sesuai
            const response = await fetch('/api/childbirth-history');
            childBirthData.value = await response.json();
            loading.value = false;
        };

        const gotoHome = () => {
            router.push({
                name: 'home',
                params: {}
            });
        };

        onMounted(fetchData);

        return {
            childBirthData,
            loading,
            gotoHome
        };
    },

    data(){
        return {
            pregnancy:null,
            form:{}
        }
    },

    computed:{
        ...mapGetters(['baseUrl', 'mom']),

        PregnancyId(){
            return this.$route.query.id;
        },

        pregnancyInputs(){
            return {
                "first_day_of_last_period": {
                    isRequired: true,
                    inputType: 'date',
                },

                "upper_arm_circumference": {
                    inputType: 'number',
                    isRequired: true,
                },

                "pregnancy_number": {
                    isRequired: true,
                    inputType: 'number' 
                },

                "number_of_deliveries": {
                    isRequired: true,
                    inputType: 'number' 
                },

                "number_of_miscarriages": {
                    isRequired: true,
                    inputType: 'number' 
                },

                "number_of_living_children": {
                    isRequired: true,
                    inputType: 'number' 
                },

                "number_of_deceased_children": {
                    isRequired: true,
                    inputType: 'number' 
                },

                "number_of_premature_children": {
                    isRequired: true,
                    inputType: 'number' 
                },

                "interval_of_last_delivery": {
                    isRequired: true,
                    inputType: 'number' 
                },
                
                "tetanus_immunization": {
                    isRequired: true,
                    inputType: 'number' 
                },
                
                "last_delivery_helper": {
                    isRequired: true,
                    inputType: 'text' 
                },
                
                "last_delivery_method": {
                    isRequired: true,
                    inputType: 'text' 
                },
            }
        },

        additional(){
            return {
                mother_id: this.pregnancy.mother_id,
            }
        },

    },

    methods: {
        fetchPregnancyId(){
            const url = this.baseUrl + "/api/pregnancy/show/"+ this.PregnancyId ;
            console.log({url})
                        
            axios.get(url, {
                // apa aja nih disini;
                params:{}
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                this.form = {...res.data};
                this.pregnancy = res.data;
            }).catch(error => {
                console.log(error);
                helper.renderError(error);
            })
        },

        submit(){
            const url = this.baseUrl + "/api/pregnancy/"+ this.pregnancy.id;
                        
            axios.put(url, {
                ...this.form, ...this.additional
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                toastr.success(res.message);

                setTimeout(() => {

                    this.$router.push('/')
                }, 1000);
            }).catch(error => {
                console.log(error);
                helper.renderError(error);
            })
        }
    },

    mounted(){
        this.fetchPregnancyId();
    }

};
</script>

<style scoped>
/* Custom styles if needed */
</style>
