<script setup>
import { ref, computed, defineProps, defineEmits } from 'vue';
import Label from '@/Components/Others/Label.vue';

const props = defineProps({
    id: String,
    label: String,
    modelValue: String,
    error: String,
    required: Boolean,
    placeholder: String,
});

const emit = defineEmits(['update:modelValue', 'on-change']);

const showModal = ref(false);
const step = ref('date');
const selectedYear = ref(new Date().getFullYear());
const selectedMonth = ref(new Date().getMonth());
const selectedDay = ref(new Date().getDate());
const startYear = ref(selectedYear.value - (selectedYear.value % 10));

const openModal = () => {
    showModal.value = true;
    step.value = 'date';
};
const closeModal = () => (showModal.value = false);

const selectToday = () => {
    const today = new Date();
    selectedYear.value = today.getFullYear();
    selectedMonth.value = today.getMonth();
    selectedDay.value = today.getDate();
    applyDate();
};

const selectYear = (year) => {
    selectedYear.value = year;
    step.value = 'month';
};

const selectMonth = (month) => {
    selectedMonth.value = month;
    step.value = 'date';
};

const selectDate = (day) => {
    selectedDay.value = day;
    applyDate();
};

const applyDate = () => {
    if (selectedYear.value !== null && selectedMonth.value !== null && selectedDay.value !== null) {
        const formattedDate = `${selectedYear.value}-${String(selectedMonth.value + 1).padStart(2, '0')}-${String(selectedDay.value).padStart(2, '0')}`;
        emit('update:modelValue', formattedDate);
        emit('on-change');
    }
    closeModal();
};

const nextMonth = () => {
    if (selectedMonth.value === 11) {
        selectedMonth.value = 0;
        selectedYear.value++;
    } else {
        selectedMonth.value++;
    }
};

const prevMonth = () => {
    if (selectedMonth.value === 0) {
        selectedMonth.value = 11;
        selectedYear.value--;
    } else {
        selectedMonth.value--;
    }
};

const nextYearRange = () => {
    startYear.value += 10;
};

const prevYearRange = () => {
    startYear.value -= 10;
};

const yearRange = computed(() => {
    return Array.from({ length: 10 }, (_, i) => startYear.value + i);
});

const months = computed(() => [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
]);

const daysInMonth = computed(() => {
    return Array.from({ length: new Date(selectedYear.value, selectedMonth.value + 1, 0).getDate() }, (_, i) => i + 1);
});

// const displayDate = computed(() => {
// return props.modelValue ? `${selectedYear.value}-${String(selectedMonth.value + 1).padStart(2, '0')}-${String(selectedDay.value).padStart(2, '0')}` : 'Select Date';
// });
const displayDate = computed(() => {
    return props.modelValue ? `${selectedYear.value}-${String(selectedMonth.value + 1).padStart(2, '0')}-${String(selectedDay.value).padStart(2, '0')}` : 'Select Date';
});

</script>

<template>
    <div class="relative">
        <Label v-if="label" :for="id" :text="label" :required="required" class="input-label mb-1" />

        <button @click="openModal" class="border p-2 rounded-md w-full flex justify-between items-center text-sm text-gray-400 border-gray-300 focus:border-gray-300 focus:ring-purple-100">
            <span>{{ displayDate }}</span>
        </button>

        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-5 rounded-lg shadow-lg w-96">
                <div class="flex justify-between items-center mb-4">
                    <button @click="prevMonth" class="text-gray-500">&lt;</button>
                    <span @click="step = 'year'" class="text-lg font-semibold cursor-pointer">{{ months[selectedMonth]
                        }} {{ selectedYear }}</span>
                    <button @click="nextMonth" class="text-gray-500">&gt;</button>
                </div>

                <div class="flex gap-2 mb-2">
                    <input type="text" :value="displayDate" class="border border-gray-300 p-2 rounded-md w-2/3"
                           readonly>
                    <button @click="selectToday" class="bg-gray-500 text-white px-4 py-2 rounded-md w-1/3">Today
                    </button>
                </div>

                <div v-if="step === 'year'" class="text-center">
                    <div class="flex justify-between mb-2">
                        <button @click="prevYearRange" class="text-gray-500">&lt;</button>
                        <span class="font-semibold">{{ startYear }} - {{ startYear + 9 }}</span>
                        <button @click="nextYearRange" class="text-gray-500">&gt;</button>
                    </div>
                    <div class="grid grid-cols-5 gap-2">
                        <div v-for="year in yearRange" :key="year" @click="selectYear(year)"
                             class="p-2 cursor-pointer text-center hover:bg-gray-200">{{ year }}
                        </div>
                    </div>
                </div>

                <div v-if="step === 'month'" class="grid grid-cols-3 gap-2 text-center">
                    <div v-for="(month, index) in months" :key="index" @click="selectMonth(index)"
                         class="p-2 cursor-pointer text-center hover:bg-gray-200">{{ month }}
                    </div>
                </div>

                <div v-if="step === 'date'" class="grid grid-cols-7 gap-1 text-center">
                    <div v-for="date in daysInMonth" :key="date" @click="selectDate(date)"
                         class="p-2 cursor-pointer rounded-full text-center border hover:bg-gray-200">{{ date }}
                    </div>
                </div>

                <div class="flex justify-between mt-4">
                    <button @click="closeModal" class="border border-gray-300 text-gray-500 px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button @click="applyDate" class="bg-gray-500 text-white px-4 py-2 rounded-md">Apply</button>
                </div>
            </div>
        </div>

        <div v-if="error" class="text-sm text-red-500 mt-1">{{ error }}</div>
    </div>
</template>

<style scoped>
button {
    cursor: pointer;
}
</style>
