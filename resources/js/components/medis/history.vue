<template>
    <div class="bg-white p-4 shadow-md rounded mb-4">


        <h5 class="text-lg font-bold mb-2">Checkup History</h5>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <p class="mb-4 md:col-span-3 text-gray-500"> Your Checkup Data History</p>
            <div class="flex justify-end gap-x-3 items-center">
                <a href="/dashboard">
                    <img class="w-6 h-6" :src="'storage/images/home.png'">
                </a>
            </div>
        </div>


        <div class="bg-white rounded-lg p-4 mb-4" v-for="(val,key) in data" :key="val.id">
            <div class="flex">
                <!-- <img :src="getImage(val.usg_image)" alt="Thumbnail" class="w-20 h-20 object-cover rounded-lg mr-4"> -->
                <div>
                    <h2 class="text-xl font-semibold flex">
                        {{ getName(val) }} <img :src="isMom(val) ? getImage('images/mom.png'): getImage('images/child.png')" class="w-10 h-10" alt="">
                    </h2>
                    <div class="fs-7 text-sm text-gray-500 mb-4"> <i class="fa fa-clock"></i> 2024-07-30 </div>
                    <div>Complain : {{val.complaint}}</div>
                    <div>Action : {{val.action}}</div>
                    <button @click="viewDetail(val.type, val.id)" class="mt-2 text-blue-500 hover:text-blue-700">Read
                        more</button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import helper from '../helper';

export default {
    data(){
        return {
            data:[]
        }
    },

    computed: {
        ...mapGetters(['baseUrl']),

        patient(){

        }
    },

    methods:{
        fetchData(){
            const id = this.$store.state.user.id;
            const url = this.baseUrl + "/api/checkup?id=" + id;

            axios.get(url, {
                // apa aja nih disini;
                headers: {
                    'Accept': 'application/json', // Expect a JSON response
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                this.data = res.data;
            }).catch(error => {
                console.log(error);
                helper.renderError(error);
            })
        },

        isMom(d){
            if(d.pregnancy) {
                return true;
            }

            return false;
        },

        getName(d) {
            let name = '-'

            if(d.child) {
                name = d.child.child_name;
            }

            if(!d.pregnancy){
                return name;
            }

            if(!d.pregnancy.mother) {
                return name;
            }

            return d.pregnancy.mother.name;
        },

        getImage(img) {
            return this.baseUrl + "/storage/" + img;
        },

        viewDetail(type, id){
            this.$router.push(`/history/${type}/${id}`)
        },


    },

    mounted(){
        this.fetchData();
    }
}
</script>

<style>

</style>