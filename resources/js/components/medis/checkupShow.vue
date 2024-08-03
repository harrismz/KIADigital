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
                        <div class="p-4 bg-gray-50 rounded">
                            <div class="font-bold mb-4">
                                Pemeriksaan Terakhir
                            </div>

                            <div>
                                <ul>
                                    <li v-for="(val, key) in latest_checkup" :key="key">
                                        {{ key }} : {{ val }}
                                    </li>
                                </ul>
                                
                            </div>
                        </div>

                        <div class="p-4 rounded">
                            <h2 class="font-bold mb-4">
                                Pemeriksaan
                            </h2>

                            <form @submit.prevent="submit">
                                <div class="col-span-full mb-2" v-for="(val, key) in form" :key="key" >
                                    <label :for="key" class="block text-sm font-medium leading-6 text-gray-900">{{key}}</label>
                                    <div class="mt-2">
                                    <input type="text" v-model="form[key]" :name="key" :id="key" :autocomplete="key" class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <button class="btn btn-primary">Submit</button>
                            </form>

                        </div>
                        
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

export default {
    name: "checkupShow",

    data() {
        return {
            inputValue: '',
            data: {},
            except:{
                'id':true,
                'pregnancy_id':true,
                'staff_id':true,
                'hospital_id':true,
                'created_at':true,
                'updated_at':true,
                'child_id': true
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
        
        queryParam() {
          return this.$route.query; // Access the query parameter
        },

        latest_checkup(){
            if(this.data) {
                if(this.data.pregnancy) {
                    return this.data.pregnancy.latest_checkup;
                }

                if(this.data.latest_checkup) {
                    return this.data.latest_checkup
                }
            }

            return {}
        },

        name(){
            if(this.data) {
                return this.data.type == 'child' ? 'child_name' : 'name'; 
            }
        }
    },

    mounted() {
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
                this.populateForm(this.latest_checkup);
            }
        }).catch(error => {
            console.log(error);
            toastr.error(error)
        })
    },

    methods:{

        submit(){
            let form = this.form;
            console.log('submit', {form})
        },

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
    }

};
</script>

<style scoped>
/* Jika Anda memiliki styling khusus, tambahkan di sini */
</style>
