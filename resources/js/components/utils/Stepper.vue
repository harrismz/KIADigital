<template>
    <div class="overflow-x-auto mb-3">
        <div class="flex space-x-2">
            <div v-for="(week, index) in weeks" :key="index"
                @click="!week.disabled && goToWeek(index)"
                :class="[
                    'px-4 py-2 rounded-lg cursor-pointer',
                    currentWeek === index
                        ? 'bg-blue-500 text-white'
                        : week.disabled
                        ? 'bg-gray-200 text-gray-400 cursor-not-allowed pointer-events-none'
                        : 'bg-gray-200',
                ]">
                Minggu <span class="font-bold">Ke - {{ week.number }}</span>
            </div>
        </div>
    </div>
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
    }
};
</script>
