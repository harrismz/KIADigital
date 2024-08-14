<template>
    <div class="mb-4">
        <label :for="inputKey" class="block text-sm font-medium text-gray-700">{{label(inputKey)}}</label>
        
        <input 
            :value="modelValue"
            :type="inputType" 
            :id="inputKey"
            @input="$emit('update:modelValue', $event.target.value)"
            @change="onFileChange"
            :placeholder="label(inputKey)"
            class="mt-1 p-2 block bg-white w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            :required="wajib" 
        />

        

    </div>
</template>

<script>
import lang from '../../lang.json';
export default {
    methods: {
        label(snakeCaseString){
            
            if(lang[snakeCaseString]) {
                return lang[snakeCaseString];
            }

            return snakeCaseString
            .split('_')                  // Split the string by underscores
            .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Capitalize the first letter of each word
            .join(' '); 
        },

        onFileChange(event) {
            const input = event.target;
            if (input && input.type === 'file' && input.files.length > 0) {
                const file = input.files[0];
                this.$emit('update:modelValue', file); // Emit the file object to the parent component
            }
        },

    },

    props : {
        inputKey: String,
        isRequired: Boolean,
        modelValue: [String, File],
        inputType: {
            default: 'text',
            type: String
        }

    },

    computed: {
        wajib(){
            if(this.isRequired == null ) {
                return true;
            }

            return this.isRequired;
        }
    }
}
</script>

<style>

</style>