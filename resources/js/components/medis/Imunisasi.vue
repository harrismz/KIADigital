<template>
    <div class="p-4 bg-gray-100">
         <div class="mb-6">
            <div class="grid grid-cols-2 gap-4">
                <h1 class="text-2xl font-bold">Imunisasi</h1>
                <div class="flex justify-end gap-x-3">
                    <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'">
                </div>
            </div>
        </div>

        <div class="p-4 bg-white mb-8">
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Jenis Vaksin</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Rumah Sakit</th>
                    <th>Pemberi Vaksin</th>
                </thead>
                <tbody>
                    <tr v-for="(im, key) in renderImunisasi" :key="im.id">
                        <td class="fs-sm text-gray-500">
                            {{ key+1 }}
                        </td>
                        <td class="text-gray-500">
                            {{ im.vaccinename }}
                        </td>
                        <td class="fs-sm text-gray-500">
                            {{ im.date_vaccinated }}
                        </td>
                        <td class="fs-sm text-gray-500">
                            {{ im.hospitalname }}
                        </td>
                        <td class="fs-sm text-gray-500">
                            {{ im.staffname }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <form v-if="isMedic" @submit.prevent="submit" class="form">

            <div class="col-span-full mb-2">
                <label for="vaksin">Vaksin</label>
                <select v-model="form.vaccine_id" id="vaksin" name="vaksin" autocomplete="vaksin-name" class="block w-full bg-white rounded-md border-3 p-2 ">
                    <option v-for="(value, key) in vaksinOptions" :key="value.key" :value="value.value">{{value.key}}</option>
                </select>
            </div>

            <div class="col-span-full mb-4">
                <label for="tanggal">Tanggal Dilakukan Vaksin</label>
                <input v-model="form.date_vaccinated" type="date" name="date_vacinated" id="date_vacinated" class="block bg-white w-full rounded-md p-2 ">
            </div>

            <div>
                <button class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
import toastr from 'toastr';
import helper from '../helper';

export default {
    data(){
        return {
            vaksinOptions:[],

            form:{
                vaccine_id:null,
                date_vaccinated:null
            },

            imunisasi:null,
        }
    },

    props:['child_id'],

    computed: {

        ...mapGetters(['baseUrl', 'staff_id', 'hospital_id', 'getUser', 'isMedic', 'patient']),

        renderImunisasi(){
            if(!this.imunisasi) {
                return [];
            }

            let res = [];
            for (let i = 0; i < this.imunisasi.length; i++) {
                const imunisasi = this.imunisasi[i];
                let childname = imunisasi.child ? imunisasi.child.child_name : '-';
                let staffname = imunisasi.staff ? imunisasi.staff.staff_name : '-';
                let vaccinename = imunisasi.vaccine ? imunisasi.vaccine.vaccine_name : '-';
                let hospitalname = imunisasi.hospital ? imunisasi.hospital.hospital_name : '-';
                let date_vaccinated = imunisasi.date_vaccinated;
                let id = imunisasi.id;
                let data = {
                    id, childname, staffname, vaccinename, hospitalname, date_vaccinated
                }

                res.push(data)
            }
            return res;
        },

        additional(){
            // still can't do this without user_id di medical_staff
            return {
                hospital_id: this.hospital_id,
                child_id: this.child_id,
                staff_id: this.staff_id
            }
        },


    },

    methods: {
        fetchVaksinCombo() {
            const url = this.baseUrl + "/api/vaksin/combo";

            axios.get(url, {
                // apa aja nih disini;
                params:{}
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                this.vaksinOptions = res.data;
            }).catch(error => {
                console.log(error);
            });
        },

        fetchVaksin() {
            // console.log({patient: this.patient})
            let id = this.patient.id; //

            const url = this.baseUrl + "/api/imunisasi/"+ id;

            axios.get(url, {
                // apa aja nih disini;
                params:{}
            }).then(res => res.data)
            .then(res => {
                console.log({res});
                this.imunisasi = res.data;
            }).catch(error => {
                // console.log(error);
                helper.renderError(error);
            });
        },


        submit(){
            let form = {
                ...this.form, ...this.additional
            }

            // console.log("data form submit ",{form})
            const url = this.baseUrl + "/api/imunisasi";

            axios.post(url, form )
            .then(res => res.data)
            .then(res => {
                console.log(res);
                toastr.success(res.message || "data saved!")

                this.fetchVaksin();
            }).catch(error => {
                console.log(error);
                toastr.error(error)
            })
        },

        gotoHome() {
            this.$router.push({ name: 'dashboard' });
        }
    },

    mounted(){
        this.fetchVaksinCombo();

        this.fetchVaksin();
    }
}
</script>

<style scoped></style>
