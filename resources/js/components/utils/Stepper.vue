<template>
    <div class="overflow-x-auto mb-3">
        <div class="flex space-x-2">
            <div v-for="(week, index) in weeks" :key="index" @click="goToWeek(index)"
                :class="['px-4 py-2 rounded-lg cursor-pointer', currentWeek === index ? 'bg-blue-500 text-white' : 'bg-gray-200']">
                Minggu <span class="font-bold">Ke - {{ week }}</span>
            </div>
        </div>
    </div>
    <!-- <div class="flex justify-between mb-4 gap-x-2">
        <div v-for="(step, index) in steps" :key="index"
            :class="['py-2 px-4 rounded cursor-pointer', { 'bg-blue-500 text-white': currentStep === index, 'bg-gray-200': currentStep !== index }]"
            @click="goToStep(index)">
            Minggu Ke - {{ step }}
        </div>
    </div> -->
    <!-- <div class="p-4">
        <div class="flex items-center">
            <button @click="prevStep" :disabled="currentStep === 0" class="p-2 bg-gray-300 rounded-l">Prev</button>
            <div class="flex overflow-hidden w-full relative">
                <div class="flex transition-transform duration-300"
                    :style="{ transform: `translateX(-${currentStep * 100}%)` }">
                    <div v-for="(step, index) in steps" :key="index" class="flex-none w-full p-4">
                        <slot :step="step"></slot>
                    </div>
                </div>
            </div>
            <button @click="nextStep" :disabled="currentStep === steps.length - 1"
                class="p-2 bg-gray-300 rounded-r">Next</button>
        </div>
        <div class="flex justify-center mt-4">
            <div v-for="(step, index) in steps" :key="index" @click="currentStep = index"
                class="w-4 h-4 rounded-full mx-1 cursor-pointer"
                :class="index === currentStep ? 'bg-blue-500' : 'bg-gray-300'"></div>
        </div>
    </div> -->
</template>

<script>
export default {
    name: 'Stepper',
    props: {
        weeks: Array,
        currentWeek: Number
    },
    methods: {
        goToWeek(index) {
            this.$emit('update:currentWeek', index);
            console.log({ stepper: this.currentWeek })
            console.log({ index })
        },
        // nextStep() {
        //     if (this.currentWeek < this.weeks.length - 1) {
        //         this.currentWeek += 1;
        //     }
        // },
        // prevStep() {
        //     if (this.currentWeek > 0) {
        //         this.currentWeek -= 1;
        //     }
        // }
    }
};
</script>
