<template>
    <div class="mb-4">
        <label :for="inputKey" class="block text-sm font-medium text-gray-700">{{label(inputKey)}}</label>
        
        <input 
            :value="modelValue"
            :type="inputType" 
            :id="inputKey"
            @input="$emit('update:modelValue', $event.target.value)"
            class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            :required="isRequired" 
        />

        

    </div>
</template>

<script>
export default {
    methods: {
        label(snakeCaseString){
            return snakeCaseString
            .split('_')                  // Split the string by underscores
            .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Capitalize the first letter of each word
            .join(' '); 
        }
    },

    props : {
        inputKey: String,
        isRequired: Boolean,
        modelValue: String,
        inputType: {
            default: 'text',
            type: String
        }

    }
}
</script>

<style>

</style>