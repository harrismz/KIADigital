<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h2>Data Ibu</h2>
                        <div class="separator"></div>
                        
                        {{ queryParam }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "checkupShow",
    data() {
        return {
            inputValue: ''
        };
    },
    computed: {
        formAction() {
            return '/admin/checkup/show'; // Ensure this matches the route path
        },
        
        queryParam() {
          return this.$route.query; // Access the query parameter
        }
    },
    mounted() {
        // Handle query parameters or perform actions when component is mounted
        console.log('Query Parameter:', this.queryParam);
    }

};
</script>
<script>
import axios from 'axios';
import {mapGetters} from 'vuex';
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
            'http://127.0.0.1:8000', 'getUser'
        ]),
        
        queryParam() {
            return this.$route.query; // Mengambil query parameter dari URL
        },

        name(){
            if(this.data) {
                return this.data.type === 'child' ? 'child_name' : 'name'; 
            }
        }
    },

    mounted() {
        let query = this.queryParam;
        let id = query.id;

        // URL untuk mengambil data dari API di 127.0.0.1:9000
        const url = `${this.baseUrl}/api/checkup/${id}`;
        console.log("Fetching data from:", url);

        axios.get(url, {
            params: {}
        }).then(res => res.data)
        .then(res => {
            console.log(res);
            if(res.success) {
                this.data = res.data;
            }
        }).catch(error => {
            console.error(error);
            toastr.error('Error fetching data: ' + error.message);
        });
    }
};
</script>




<style scoped>
/* Jika Anda memiliki styling khusus, tambahkan di sini */
</style>
