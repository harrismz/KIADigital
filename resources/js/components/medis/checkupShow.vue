<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-lg font-bold">Check Up : {{ data.type }}</h2>
                        <div class="separator"></div>
                        
                        <div class="p-4 bg-gray-200 rounded">
                            <div class="font-bold">
                                {{data[ name ]}}
                            </div>
                        </div>
                        
                        <div v-if="getUser" class="p-4 bg-gray-200 rounded mt-2">
                            <div class="font-bold">
                                {{ getUser.name }}
                            </div>
                        </div>

                        

                        <!-- pemeriksaan terakhir -->
                        <div class="p-4 bg-gray-100 rounded mt-2">
                            <div class="font-bold mb-4">
                                Pemeriksaan Terakhir
                            </div>

                            <div>
                                <table class="w-full text-left border-collapse">
                                    
                                    <tbody>
                                        <tr v-for="(val, key) in latest_checkup" :key="key">
                                            <td class="py-2 pr-2  font-medium text-xs leading-6 text-gray-500 whitespace-nowrap  border-t border-slate-100 dark:border-slate-400/10">
                                                {{ label( key) }}
                                            </td>
                                            <td class="py-2 pr-2  font-medium text-xs leading-6 text-gray-500 whitespace-nowrap  border-t border-slate-100 dark:border-slate-400/10">
                                                <div v-if="key == 'usg_image'">
                                                    <img :src="baseUrl + '/storage/'+val" :alt="key" class="block p-4 m-2 w-20 h-20">
                                                </div>
                                                <div v-else >
                                                    {{ val }}
                                                </div>
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                                
                                
                            </div>
                        </div>

                        <div class="p-4 rounded bg-gray-100">
                            <h2 class="font-bold mb-4">
                                Pemeriksaan
                            </h2>

                            <form @submit.prevent="submit">
                                <!-- <div class="col-span-full mb-2" v-for="(val, key) in inputs" :key="key" >
                                    <label :for="key" class="block text-sm font-medium leading-6 text-gray-900">{{key}}</label>
                                    <div class="mt-2">
                                    <input type="text" :placeholder="key" v-model="form[key]" :name="key" :id="key" :autocomplete="key" class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div> -->

                                <div v-if="isMom" class="p-6 w-full mb-2 mx-auto bg-white rounded-lg shadow-md">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="week">Weeks</label>
                                    <select v-model="form.week" name="week" id="week" class="p-2 border border-1 mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option v-for="week in weekOptions" :value="week" :key="week">
                                            Minggu {{ week }}
                                        </option>
                                    </select>
                                </div>

                                <my-input :isRequired="value.isRequired" :inputType="value.inputType ? value.inputType : 'text'" v-model="form[key]" :key="key" :inputKey="key" v-for="(value,key) in inputs"></my-input>
                                
                                <div v-if="isMom" class="p-6 w-full  mx-auto bg-white rounded-lg shadow-md">
                                    <span class="text-l font-semibold block mb-6">Kaki Bengkak :</span>
                                    
                                    <div class="space-y-4">
                                        <label class="flex items-center space-x-4">
                                            <input type="radio" value="1" v-model="form.swollen_foot" class="form-radio h-5 w-5 text-indigo-600">
                                            <span class="text-gray-700">Ya</span>
                                        </label>
                                        
                                        <label class="flex items-center space-x-4">
                                            <input type="radio" value="0" v-model="form.swollen_foot" class="form-radio h-5 w-5 text-indigo-600">
                                            <span class="text-gray-700">Tidak</span>
                                        </label>
                                    </div>
                                </div>

                                <button class="btn btn-primary mt-4">Submit</button>
                            </form>

                        </div>

                        <!-- imunisasi -->
                        <imunisasi v-if="type == 'child'" :child_id="data.id" />
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {mapGetters, mapActions} from 'vuex';
import toastr from 'toastr';
import Imunisasi from './Imunisasi.vue';
import MyInput from '../Ayah/MyInput.vue';
import helper from '../helper';

export default {
    name: "checkupShow",

    components: {
        Imunisasi,
        MyInput
    },

    data() {
        return {
            inputValue: '',

            data: {},

            except:{
                'id':true,
                'pregnancy_id':true, // dari apa ??
                'staff_id':true, //dari apa ?
                'hospital_id':true, // dari apa 
                'created_at':true,
                'updated_at':true,
                'child_id': true //from data.id
            },
            
            form:{
                // complaint : null,
                // blood_pressure : null,
                // weight : null,
                // gestational_age : null,
                // fundal_height : null,
                // fetus_position : null,
                // fetal_heart_rate : null,
                // swollen_foot : null,
                // lab_result : null,
                // action : null ,
                // advice_given : null,
                // usg_image : null,
                // weight_baby : null ,
                // staff_id : null,
                // hospital_id : null,
                // next_control : null,
            }
        };
    },

    computed: {
        ...mapGetters([
            'baseUrl', 'getUser'
        ]),

        inputs(){
            let m = {
                complaint : {
                    inputType: 'text'
                },
                blood_pressure : {
                    inputType: 'text'
                },
                weight : {
                    inputType: 'number'
                },
                gestational_age : {
                    inputType: 'number'
                },
                fundal_height : {
                    inputType: 'number'
                },
                fetus_position : {
                    inputType: 'text'
                },
                fetal_heart_rate : {
                    inputType: 'number'
                },
                // swollen_foot : {
                //     inputType: 'text' // ini kayaknya yes no
                // },
                lab_result : {
                    inputType: 'text'
                },
                action : {
                    inputType: 'text'
                } ,
                advice_given : {
                    inputType: 'text'
                },
                usg_image : {
                    inputType: 'file'
                },
                weight_baby : {
                    inputType: 'number'
                } ,
                // staff_id : {
                //     inputType: 'text'
                // },
                // hospital_id : {
                //     inputType: 'text'
                // },
                next_control : {
                    inputType: 'date'
                },
            }

            if (this.isMom ) {
                return m;
            }


            if(this.isChild){
                let c = {
                    "complaint": {
                        inputType: 'text'
                    },
                    "weight": {
                        inputType: 'number'
                    },
                    "height": {
                        inputType: 'number'
                    },
                    "head_circumference": {
                        inputType: 'text'
                    },
                    "immunisation_status": {
                        inputType: 'text'
                    },
                    "action": {
                        inputType: 'text'
                    },
                    "advice_given": {
                        inputType: 'text'
                    },
                };

                return c;
            }

        },

        weekOptions(){
            let res = []
            for (let i = 0; i < 40; i++) {
                res.push(i+1)
            }
            return res;
        },

        isMom(){
            return this.data.type == 'mother';
        },

        isChild(){
            return this.data.type == 'child';
        },

        additional(){
            if(this.data) {
                if(this.isMom) {

                    let staff_id = this.getUser ? this.getUser.id : null;
                    
                    return {
                        'pregnancy_id': this.data.pregnancy ? this.data.pregnancy.id : null , // dari apa ??
                        'staff_id': staff_id, //dari apa ?
                        // 'hospital_id': null, //  nanti kita perbaiki setealh user sama medical staff connected
                        'type': this.data.type,
                    }
                }

                if(this.isChild) {

                    return {
                        'child_id': this.data.id, //from data.id
                        'type': this.data.type
                    }

                }
            }

            return {}
        },
        
        queryParam() {
          return this.$route.query; // Access the query parameter
        },

        latest_checkup(){
            if(this.data) {
                let except = {
                    'id':null, 'child_id':null, 'created_at': null, 'updated_at':null
                }

                let res = {};
                if(this.data.pregnancy) {
                    res = this.data.pregnancy.latest_checkup;
                }

                if(this.data.latest_checkup) {
                    res = this.data.latest_checkup
                }

                let result ={}
                for (const key in res) {
                    if (Object.prototype.hasOwnProperty.call(res, key)) {
                        // const element = res[key];
                        if(! (key in except)) {
                            result[key] = res[key]
                        }
                    }
                }
                return result;
            }

            return {}
        },

        type(){
            if(this.data) {
                return this.data.type;
            }
        },

        name(){
            if(this.data) {
                return this.data.type == 'child' ? 'child_name' : 'name'; 
            }
        }
    },

    mounted() {
        this.fetchData();
    },

    methods:{

        fetchData(){
            // Handle query parameters or perform actions when component is mounted
            let query = this.queryParam;
            let id = query.id;

            // fetch guid
            const url = this.baseUrl +"/api/checkup/"+ id ;
            console.log("HI Im checkup show", {url})

            axios.get(url, {
                // apa aja nih disini;
                params:{}
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                if(res.success) {
                    this.data = res.data;
                    this.$store.commit('setPatient', res.data ); //set patient di store untuk diakses imunisasi
                    this.populateForm(this.latest_checkup);
                }
            }).catch(error => {
                console.log(error);
                toastr.error(error)
            })
        },

        submit() {
            // Create a new FormData object
            let formData = new FormData();

            // Append all form fields to the FormData object
            // let form = {...this.form, ...this.additional };
            for (let key in this.form) {
                if (this.form.hasOwnProperty(key)) {
                    formData.append(key, this.form[key]);
                }
            }

            // Append additional fields to the FormData object
            for (let key in this.additional) {
                if (this.additional.hasOwnProperty(key)) {
                    formData.append(key, this.additional[key]);
                }
            }

            // Append files (assuming `this.form` contains a `file` field)
            if (this.form.usg_image) {
                formData.append('usg_image', this.form.usg_image);
            }

            let url = this.baseUrl + `/api/checkup`;

            // Send the FormData object with axios
            axios.post(url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(res => res.data)
            .then(res => {
                console.log(res);
                toastr.success(res.message);
                this.clear();
                this.fetchData();
            })
            .catch(error => {
                console.log(error);
                // toastr.error(error);
                helper.renderError(error);
            });
        },


        // submit(){
        //     let form = {...this.form, ...this.additional };
        //     // console.log('submit', {form})
        //     let url = this.baseUrl + `/api/checkup`;

        //     axios.post(url, form ).then(res => res.data)
        //     .then(res => {
        //         console.log(res);
        //         toastr.success(res.message)
        //         this.clear();
        //         this.fetchData();
        //     }).catch(error => {
        //         console.log(error);
        //         toastr.error(error)
        //     });
        // },

        clear(){
            this.populateForm(this.latest_checkup);
        },

        // pake populateForm karena kita pake form ini untuk dua table yang berbeda
        populateForm(latestCheckup) {
            for (const key in latestCheckup ) {
                if (latestCheckup.hasOwnProperty(key)) {
                    if(this.except[key]) {
                        continue;
                    }
                    this.form[key] = null;
                }
            }
        },

        label(str) {
            return helper.label(str);
        }
    }

};
</script>

<style scoped>
/* Jika Anda memiliki styling khusus, tambahkan di sini */
</style>
