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
            data: {}
        };
    },
    computed: {
        ...mapGetters([
            'baseUrl', 'getUser'
        ]),
        
        queryParam() {
          return this.$route.query; // Access the query parameter
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
            }
        }).catch(error => {
            console.log(error);
            toastr.error(error)
        })
    }

};
</script>

<style scoped>
/* Jika Anda memiliki styling khusus, tambahkan di sini */
</style>
