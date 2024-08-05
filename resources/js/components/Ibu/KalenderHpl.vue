<template>
    <div class="flex">
        
        <div class="w-1/2 bg-gray-200 flex">
            <img :src="'/storage/images/kalender hpl.jpg'" alt="Logo" class="h-full">
        </div>

        <div class="mt-4 w-1/2 flex flex-col items-center justify-center">
            <h1 class="text-3xl font-bold mb-2">STATUS KEHAMILAN</h1>
            <p class="text-gray-500 mb-4 mx-2">Silahkan Input Data Kehamilan</p>
            
            <div class=" bg-gray-300 w-3/4 p-4 rounded">
                <form action=""></form>
                <form action="" @submit.prevent="submit">
                    
                    <div class="p-6 max-w-lg mx-auto bg-white rounded-lg shadow-md">
                        <span class="text-l font-semibold block mb-6">Input Tanggal Hari Haid Terakhir :</span>
                        
                        <my-input :isRequired="true" :inputType="'date'" v-model="form.first_day_of_last_period" :inputKey="'first_day_of_last_period'" />
                        
                    </div>
                

                    <!-- input radio -->
                    <div class="p-6 max-w-lg mx-auto bg-white rounded-lg shadow-md">
                        <span class="text-l font-semibold block mb-6">Kekurangan Energi Kronis (KEK) :</span>
                        
                        <div class="space-y-4">
                        <label class="flex items-center space-x-4">
                            <input type="radio" value="1" v-model="form.kek" class="form-radio h-5 w-5 text-indigo-600">
                            <span class="text-gray-700">Ya</span>
                        </label>
                        
                        <label class="flex items-center space-x-4">
                            <input type="radio" value="0" v-model="form.kek" class="form-radio h-5 w-5 text-indigo-600">
                            <span class="text-gray-700">Tidak</span>
                        </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Combo from '../Ayah/combo.vue';
import MyInput from '../Ayah/MyInput.vue';
import {mapGetters} from 'vuex';
import toastr from 'toastr';
import helper from '../helper';

export default {

    components: {
        MyInput, Combo
    },

    computed: {
        ...mapGetters(['baseUrl', 'getUser'])
    },

    data(){
        return {
            form: {
                // "id": null,
                // "mother_id": null,
                "first_day_of_last_period": null,
                "estimate_date_of_delivery": null,
                "upper_arm_circumference": null,
                "kek": null,
                "contraception_id": null,
                "pregnancy_number": null,
                "number_of_deliveries": null,
                "number_of_miscarriages": null,
                "number_of_living_children": null,
                "number_of_deceased_children": null,
                "number_of_premature_children": null,
                "interval_of_last_delivery": null,
                "tetanus_immunization": null,
                "last_delivery_helper": null,
                "last_delivery_method": null,
            },

            inputs: {
                "first_day_of_last_period": {
                    inputType:'date'
                },
                
                "estimate_date_of_delivery": {
                    inputType:'date'
                },

                "upper_arm_circumference": {
                    inputType:'number'
                },

                "pregnancy_number": {inputType: 'number'},
                "number_of_deliveries": {inputType: 'number'},
                "number_of_miscarriages": {inputType: 'number'},
                "number_of_living_children": {inputType: 'number'},
                "number_of_deceased_children": {inputType: 'number'},
                "number_of_premature_children": {inputType: 'number'},
                "interval_of_last_delivery": {inputType: 'number'},

                "tetanus_immunization": {inputType: 'text'},
                "last_delivery_helper": {inputType: 'text'},
                "last_delivery_method": {inputType: 'text'},
            },

            combos: {
                "contraception_id": {
                    label: 'Contraception',
                    url: '/api/combo/contraception'
                },
            }
        };
    },
    
    methods: {

        submit(){
            let user = this.getUser;

            let form = {...this.form, ... {
                mother_id: user.id
            }}


            const url = this.baseUrl + "/api/pregnancy";
                        
            axios.post(url, form ).then(res => res.data)
            .then(res => {
                let msg = res.message;
                toastr.success(msg);

                this.$router.push('/'); //ini ke profile kah ?
            }).catch(error => {
                // console.log(error);
                // toastr.error(error)
                helper.renderError(error);
            })

            console.log({form})
        },

        goToCalendar() {
            this.$router.push('/kalender-hpl');
        },
        goToChild() {
            this.$router.push('/child');
        }
    }
}
</script>
