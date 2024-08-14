<template>
    <div class="max-w-2xl mx-auto p-4 bg-white shadow rounded-lg">
        
        <h1 class="text-2xl font-bold mb-4">History Detail</h1>
        
        <div class="space-y-4">

        <div class="p-4 bg-gray-800 flex">
            <div class="flex justify-center items-center ">

                <h2 class="font-l rounded text-white font-bold">Name : {{name}}</h2>
                <img class="w-10 " :src="getImage" alt="">
            </div>
        </div>

        <div v-for="(value, key) in renderData" :key="key" class="flex justify-between font-l text-gray-600">
            <span class="">{{ ucfirst( key) }}:</span>
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

        getImage(){
            let img = '/mom.png';
            if(!this.isMom) {
                img = '/child.png';
            }

            return this.baseUrl + `/storage/images/` + img;
        },

        name(){
            let name = '-'

            if(this.data) {
                if( this.data.child ) {
                    return this.data.child.child_name;
                }

                
                if(this.data.pregnancy) {
                    
                    if(this.data.pregnancy.mother){
                        return this.data.pregnancy.mother.name;
                    }
                }
                
            }

            return name;
        },

        renderData(){
            // return this.data except when the key is id
            if(this.data){
                const excludedKeys = ['id','child_id','child', 'pregnancy', 'created_at', 'prenancy_id','updated_at', 'staff_id', 'hospital_id'];
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
        ucfirst(string) {
            return helper.label(string);
            // return string.charAt(0).toUpperCase() + string.slice(1);
        },

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