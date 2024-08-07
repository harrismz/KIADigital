<template>
    <div class="max-w-2xl mx-auto p-4 bg-white shadow rounded-lg">
        
        <h1 class="text-2xl font-bold mb-4">History Detail</h1>
        
        <div class="space-y-4">

        <div v-for="(value, key) in renderData" :key="key" class="flex justify-between ">
            <span class="">{{ key }}:</span>
            <span>{{ value }}</span>
        </div>

        <div v-if="data && data.usg_image" class="mt-4">
            <span class="font-semibold block mb-2">USG Image:</span>
            <img :src="`${baseUrl}/storage/${data.usg_image}`" alt="USG Image" class="w-full rounded-lg shadow" />
        </div>
        
    </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import helper from '../helper';
export default {
    
    data(){
        return {
            data:null
        }
    },

    computed: {
        ...mapGetters(['baseUrl']),

        renderData(){
            // return this.data except when the key is id
            if(this.data){
                const excludedKeys = ['id', 'created_at', 'prenancy_id','updated_at', 'staff_id', 'hospital_id'];
                return Object.fromEntries(
                    Object.entries(this.data).filter(([key]) => !excludedKeys.includes(key))
                );
            }
        },

        id(){
            return this.$route.params.id;
        },
        
        type(){
            return this.$route.params.type;
        },

        isMom() {
            return this.type == 'mom' ? true : false;
        }
    },

    methods: {
        fetchCheckupHistory(){
            let url = '';
            
            if(this.isMom){
                url = this.baseUrl + "/api/pregnancy-history/"+this.id;
            }else{
                url = this.baseUrl + "/api/child-dev-history/"+this.id;
            }
            // window.alert(url)
            axios.get(url, {
                // apa aja nih disini;
                params:{}
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                this.data = res.data
            }).catch(error => {
                console.log(error);
                helper.renderError(error);
            })
        }
    },

    mounted(){
        return this.fetchCheckupHistory();
    }
}
</script>

<style>

</style>