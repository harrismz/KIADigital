<template>
    <div class="p-4 bg-gray-100">
        <div class="font-bold mb-4">
            Imunisasi
        </div>

        <form @submit.prevent="submit" class="form">

            <div class="col-span-full mb-2">
                <label for="vaksin">Vaksin</label>
                <select v-model="form.vaccine_id" id="vaksin" name="vaksin" autocomplete="vaksin-name" class="block w-full rounded-md border-3 p-2 ">
                    <option v-for="(value, key) in vaksinOptions" :key="value.key" :value="value.value">{{value.key}}</option>
                </select>
            </div>
            
            <div class="col-span-full mb-4">
                <label for="tanggal">Tanggal Dilakukan Vaksin</label>
                <input v-model="form.date_vaccinated" type="date" name="date_vacinated" id="date_vacinated" class="block w-full rounded-md p-2 ">
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

export default {
    data(){
        return {
            vaksinOptions:[],

            form:{
                vaccine_id:null,
                date_vaccinated:null
            }
        }
    },

    props:['child_id'],

    computed: {

        ...mapGetters(['baseUrl', 'staff_id', 'hospital_id']),

        additional(){
            // still can't do this without user_id di medical_staff
            return {
                hospital_id: this.hospital_id,
                child_id: this.child_id,
                staff_id: this.staff_id
            }
        }
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
            }).catch(error => {
                console.log(error);
                toastr.error(error)
            })
        }
    },

    mounted(){
        this.fetchVaksinCombo();
    }
}
</script>

<style>

</style>