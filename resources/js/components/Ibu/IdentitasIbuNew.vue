<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="flex w-full max-w-4xl shadow-md rounded-lg overflow-hidden">
            <div class="w-1/2 bg-gray-200 flex">
                <div>
                    <img :src="'/storage/images/ibu.jpg'" alt="Image" class="h-full">
                </div>
            </div>
            <div class="w-1/2 p-8 bg-white">
                <h2 class="text-2xl font-bold mb-6 text-center">IDENTITAS IBU</h2>
                <form>

                    <my-input :isRequired="value.isRequired" :inputType="value.inputType ? value.inputType : 'text'"
                        v-model="form[key]" :key="key" :inputKey="key" v-for="(value, key) in inputs"></my-input>

                    <div class="mb-4">
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" v-model="form.date_of_birth"
                            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <combo v-model="form[key]" :inputKey="key" :key="val.label" :url="val.url" :label="val.label"
                        v-for="(val, key) in combos" />
                    <div class="p-4">
                        <button v-if="additional.id >= 1" type="button" @click="updateData"
                            class="btn btn-secondary text-white">Update</button>
                        <button v-else type="button" @click="submit" class="btn btn-primary text-white">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import toastr from 'toastr';
import MyInput from '../utils/MyInput.vue';
import Combo from '../utils/combo.vue';
import { mapGetters } from 'vuex';

export default {

    components: {
        MyInput, Combo
    },

    computed: {
        ...mapGetters(['baseUrl', 'getUser', 'mom']),
        additional() {
            return {
                id: null
            }
        }
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
                "height": null,
                "user_id": null
            },

            inputs: {
                "nik": {
                    isRequired: true
                },
                "no_jkn": {
                    inputType: 'number',
                    isRequired: true,
                },
                "name": {
                    isRequired: true
                },
                "birth_place": {
                    isRequired: true
                },
                "phone_number": {
                    isRequired: true
                },
                "height": {
                    inputType: 'number',
                    isRequired: true,
                },
            },

            combos: {
                "kecamatan_id": {
                    "label": "Kecamatan",
                    "url": "/api/combo/kecamatan"
                },
                "religion_id": {
                    "label": "Agama",
                    "url": "/api/combo/religion"
                },
                "education_id": {
                    "label": "Pendidikan",
                    "url": "/api/combo/education"
                },
                "blood_type_id": {
                    "label": "Golongan Darah",
                    "url": "/api/combo/BloodType"
                },
                "job_id": {
                    "label": "Pekerjaan",
                    "url": "/api/combo/job"
                }
            }
        }
    },
    mounted() {
        this.processCheck()
    },
    methods: {
        async processCheck() {
            const motherId = this.$route.params.id;
            if (!motherId) return null;
            await axios.get(this.baseUrl + `/api/mother/${motherId}`)
                .then(res => res.data)
                .then(res => {
                    console.log("getDataIbu", res);
                    this.form = res;
                    this.additional.id = res.id;
                    console.log("additional->id", this.additional.id);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        fetchDad() {
            const url = this.baseUrl + "/api/mother/" + this.id;
            axios.get(url).then(res => res.data)
                .then(res => {
                    console.log(res);
                    this.form = res.data;
                }).catch(error => {
                    console.log(error);
                    const errorMessage = error.response?.data?.message || error.message || 'An unknown error occurred';
                    toastr.error(errorMessage);
                })
        },
        submit() {
            let form = {
                ...this.form,
                ...{
                    user_id: this.getUser.id || null,
                    mother_id: this.mom.id //this.getUser.id || null, //yg nambah data ayah si ibu
                }
            }

            const url = this.baseUrl + "/api/mother";
            console.log('store to ibu', form)
            axios.post(url, form).then(res => res.data)
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
        },
        updateData() {
            const url = `${this.baseUrl}/api/mother/${this.additional.id}/update`;
            const form = {
                ...this.form, ...this.additional
            }
            console.log('update to mother', form)
            axios.put(url, {
                ...form
            }).then(res => res.data)
                .then(res => {
                    console.log(res);
                    toastr.success(res.message);

                    setTimeout(() => {
                        this.$router.push('/dashboard')
                    }, 1000);
                }).catch(error => {
                    console.log(error);
                })
        }
    }
}
</script>

<style></style>
