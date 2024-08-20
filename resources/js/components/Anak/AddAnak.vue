<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="flex w-full max-w-4xl shadow-md rounded-lg overflow-hidden">
            <div class="w-1/2 bg-gray-200 flex">
                <div>
                    <img :src="'/storage/images/anak.jpg'" alt="Image" class="h-full">
                </div>
            </div>
            <div class="w-1/2 p-8 bg-white">
                <h2 class="text-2xl font-bold mb-6 text-center">IDENTITAS ANAK</h2>

                <form>
                    <div v-for="(value, key) in formDetail" :key="key">
                        <my-input-vue :inputType="formDetail[key].type" v-model="form[key]"
                            :inputKey="key"></my-input-vue>
                    </div>

                    <div>
                        <combo v-model="form.blood_type_id" :inputKey="blood_type_id.label" :key="blood_type_id.label"
                            :url="blood_type_id.url" :label="blood_type_id.label" />
                    </div>

                    <div class="w-full  mx-auto bg-white rounded-lg mb-4">
                        <span class="block mb-2">Jenis Kelamin :</span>

                        <div class="space-y-4">
                            <label class="flex items-center space-x-4">
                                <input type="radio" value="laki-laki" v-model="form.gender"
                                    class="form-radio h-5 w-5 text-indigo-600">
                                <span class="text-gray-700">Laki-laki</span>
                            </label>

                            <label class="flex items-center space-x-4">
                                <input type="radio" value="perempuan" v-model="form.gender"
                                    class="form-radio h-5 w-5 text-indigo-600">
                                <span class="text-gray-700">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <div class="p-4">
                        <button v-if="additional.id >= 1" type="button" @click="updateData"
                            class="btn btn-secondary text-white">Update</button>
                        <button v-else type="button" @click="submit" class="btn btn-primary text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</template>

<script>
import { mapGetters } from 'vuex';
import helper from '../helper';
import combo from '../utils/combo.vue';
import MyInputVue from '../utils/MyInput.vue';
import toastr from 'toastr';

export default {
    components: {
        MyInputVue, combo
    },

    data() {
        return {
            form: {
                child_name: null,
                date_of_birth: null,
                birth_place: null,
                child_of: null,
                akte_no: null,
                gender: null,
                blood_type_id: null
            },

            formDetail: {
                child_name: { type: 'text' },
                date_of_birth: { type: 'date' },
                birth_place: { type: 'text' },
                child_of: { type: 'number' },
                akte_no: { type: 'number' },
            },

            blood_type_id: {
                "label": "Golongan Darah",
                "url": "/api/combo/BloodType"
            },
        }
    },

    computed: {
        ...mapGetters([
            'baseUrl', 'mom', 'child'
        ]),

        additional() {
            return {
                mother_id: this.mom.id,
                father_id: this.mom.father ? this.mom.father.id : null,
                id: null
            }
        },
    },
    mounted() {
        this.processCheck()
    },
    methods: {
        async processCheck() {
            const childId = this.$route.params.id;
            if (!childId) return null;
            await axios.get(this.baseUrl + `/api/child/${childId}`)
                .then(res => res.data)
                .then(res => {
                    console.log("getDataAnak", res);
                    this.form = res.data;
                    this.additional.id = res.data.id;
                    console.log("additional->id", this.additional.id);
                    // this.submit()
                })
                .catch(error => {
                    console.log(error);
                    helper.renderError(error);
                })
        },
        submit() {
            const url = this.baseUrl + "/api/child";
            const form = {
                ...this.form, ...this.additional
            }
            axios.post(url, {
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
                    helper.renderError(error);
                })
        },
        updateData() {
            const url = `${this.baseUrl}/api/child/${this.additional.id}/update`;
            const form = {
                ...this.form, ...this.additional
            }
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
                    helper.renderError(error);
                })
        }
    }

}
</script>

<style></style>
