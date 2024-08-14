<template>
    <div>
        <div class="my-4">
            <label for="kecamatan" class="block text-sm font-medium text-gray-700">{{ renderLabel(label)}}</label>
            <select  
                id="kecamatan"
                class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required 
                :value="modelValue"
                @change="handleChange"
            >

                <option value="" disabled>Pilih {{renderLabel( label)}}</option>

                <option v-for="val in options" :key="val.value" :value="val.value">
                    {{ val.key }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import helper from '../helper';

export default {
    props:{
        inputKey:String,
        label:String,
        url:String,
        modelValue:[String, Number]
        
    },

    data(){
        return {
            options:[]
        }
    },

    methods: {
        fetchOptoins(){
            const url = this.url;
                        
            axios.get(url, {
                // apa aja nih disini;
                params:{}
            }).then(res => res.data)
            .then(res => {
                console.log(res);
                let data = res.data;
                this.options = data;
            }).catch(error => {
                console.log(error);
                toastr.error(error);
            })
        },

        handleChange($event){
            const intValue = parseInt($event.target.value, 10);
            this.$emit('update:modelValue', intValue )
        },

        renderLabel(label) {
            return helper.label(label);
        }
    },

    mounted(){
        this.fetchOptoins();
    }
}
</script>

<style lang="scss" scoped>

</style>