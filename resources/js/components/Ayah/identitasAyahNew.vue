<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="flex w-full max-w-4xl shadow-md rounded-lg overflow-hidden">
            <div class="w-1/2 bg-gray-200 flex">
                <div>
                    <img :src="'/storage/images/ayah.png'" class="h-full" alt="Identitas Ayah">
                    <!-- <img :src="'/storage/images/ayah.png'" alt="Image" class="w-full h-full object-cover"> -->
                </div>
            </div>
            <div class="w-1/2 p-8 bg-white">
                <h2 class="text-2xl font-bold mb-6 text-center">IDENTITAS AYAH</h2>
                <form @submit.prevent="submit">

                    <my-input :isRequired="value.isRequired" :inputType="value.inputType ? value.inputType : 'text'" v-model="form[key]" :key="key" :inputKey="key" v-for="(value,key) in inputs"></my-input>
                    
                    <div class="mb-4">
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" v-model="form.date_of_birth" class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <combo v-model="form[key]" :inputKey="key" :key="val.label" :url="val.url" :label="val.label" v-for="(val, key) in combos"  />

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import toastr from 'toastr';
import MyInput from './MyInput.vue';
import Combo from './combo.vue';
import {mapGetters} from 'vuex';

export default {
    
    components: {
        MyInput, Combo
    },

    computed:{
        ...mapGetters(['baseUrl', 'getUser'])
    },

    data() {
        return {
            form: {
                "nik": null,
                "no_jkn": null,
                "name": null,
                "date_of_birth": null,
                "birth_place": null,
                "phone_number": null,
                "address": null,
                "kecamatan_id": null,
                "religion_id": null,
                "education_id": null,
                "blood_type_id": null,
                "job_id": null,
                // "created_at": null,
                // "updated_at": null,
                "user_id": null
            },

            inputs: {
                "nik": {
                    isRequired:true
                },
                "no_jkn": {
                    inputType: 'number',
                    isRequired: true,
                },
                "name": {
                    isRequired:true
                },
                "birth_place": {
                    isRequired:true
                },
                "phone_number": {
                    isRequired:true
                },
            },

            combos: {
                "kecamatan_id": {
                    "label": "Kecamatan",
                    "url": "/api/combo/kecamatan"
                },
                "religion_id": {
                    "label": "Religion Id",
                    "url": "/api/combo/religion"
                },
                "education_id": {
                    "label": "Education Id",
                    "url": "/api/combo/education"
                },
                "blood_type_id": {
                    "label": "Blood Type Id",
                    "url": "/api/combo/BloodType"
                },
                "job_id": {
                    "label": "Job Id",
                    "url": "/api/combo/job"
                }
            }
        }
    },

    methods: {
        submit(){
            let form = {
                ...this.form,
                ...{
                    user_id: this.getUser.id || null
                }
            }

            const url = this.baseUrl + "/api/identitas-ayah";
            console.log('store to ayah', form)
            axios.post(url, form ).then(res => res.data)
            .then(res => {
                console.log(res);
                let data = res.data;
                let message = res.message;
                toastr.success(message)

                this.$router.push({
                    name: 'status-kehamilan',
                    params: {}
                });

            }).catch(error => {
                console.log(error);
                const errorMessage = error.response?.data?.message || error.message || 'An unknown error occurred';
                toastr.error(errorMessage);
            })
        }
    }
}
</script>

<style>

</style>