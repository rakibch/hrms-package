<script setup lang="ts">
import { DatePicker, Label } from '@softzino/st-uikit';
import { computed } from 'vue';

// Define the model with support for both Date and string values
const model = defineModel<Date | Date[] | null | string>();

const props = defineProps<{
    id?: string;
    label?: string;
    required?: boolean;
    error?: string;
    placeholder?: string;
    disabled?: boolean;
    selectionMode?: 'single' | 'range';
    multiple?: boolean;
    minDate?: Date | null;
    maxDate?: Date | null;
    alignRight?: boolean;
}>();

const emit = defineEmits<{
    (e: 'apply', startDate: Date | null, endDate: Date | null): void;
    (e: 'reset', startDate: null, endDate: null): void;
    (e: 'on-change'): void;
}>();

// Generate a unique ID if none is provided
const computedId = computed(
    () => props.id || `date-input-${Math.random().toString(36).slice(2, 11)}`,
);

// Convert string model values to Date objects before passing to DatePicker
const internalModel = computed({
    get: () => {
        if (typeof model.value === 'string') {
            const parsedDate = new Date(model.value);
            return isNaN(parsedDate.getTime()) ? null : parsedDate;
        }
        return model.value;
    },
    set: (newValue) => {
        if (newValue instanceof Date) {
            model.value = newValue.toISOString().split('T')[0]; // Convert back to YYYY-MM-DD string
        } else {
            model.value = newValue;
        }
        emit('on-change');
    },
});

function reset() {
    internalModel.value = null;
    emit('reset', null, null);
}
</script>

<template>
    <div>
        <Label
            v-if="label"
            :for="computedId"
            :text="label"
            :required="required"
            class="input-label"
        />

        <DatePicker
            :id="computedId"
            v-model="internalModel"
            :required="required"
            :placeholder="placeholder"
            :disabled="disabled"
            :selectionMode="selectionMode || 'single'"
            :multiple="multiple || false"
            :minDate="minDate ?? null"
            :maxDate="maxDate ?? null"
            :alignRight="alignRight || false"
            :invalid="!!error"
            @apply="
                (start: Date | null, end: Date | null) =>
                    emit('apply', start, end)
            "
            @reset="reset"
            class="input mt-1.5 max-h-[40px] bg-white focus:border-gray-300 focus:ring-4 focus:ring-purple-100"
            :class="[
                {
                    'border-error-300 focus:border-error-300 focus:ring-error-100':
                        error,
                    'cursor-not-allowed bg-gray-100': disabled,
                },
            ]"
        />

        <div v-if="error" class="min-h-[5px] text-sm text-red-500">
            {{ error }}
        </div>
    </div>
</template>

<style scoped></style>
