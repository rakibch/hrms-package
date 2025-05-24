<script setup lang="ts">
import { Select } from '@softzino/st-uikit';
import { computed, watch } from 'vue';

const model = defineModel<string | number>({ default: '' });

const props = defineProps<{
    id?: string;
    label?: string;
    options: { label: string; value: string | number }[];
    placeholder?: string;
    error?: string;
    disabled?: boolean;
    required?: boolean;
    clearable?: boolean;
}>();

const emits = defineEmits<{ (e: 'onChange', value: string | number): void }>();

const computedId = computed(
    () =>
        props.id || `dropdown-input-${Math.random().toString(36).slice(2, 11)}`,
);

watch(
    () => model.value,
    (value) => {
        emits('onChange', value);
    },
);
</script>

<template>
    <div class="flex h-full flex-col">
        <label
            v-if="label"
            :for="computedId"
            class="text-sm font-medium text-gray-700"
        >
            {{ label }} <span v-if="required" class="text-red-500">*</span>
        </label>

        <Select
            :id="computedId"
            v-model="model"
            :options="options"
            :placeholder="placeholder"
            :required="required"
            :clearable="clearable"
            :disabled="disabled"
            class="shadow-xs mt-1.5 max-h-[40px] flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-gray-300 focus:ring-4 focus:ring-purple-100"
            :class="[
                {
                    'border-error-300 focus:border-error-300 focus:ring-error-100':
                        error,
                    'cursor-not-allowed bg-gray-100': disabled,
                },
            ]"
        />

        <p class="min-h-[5px] text-sm text-error-700">
            <span v-show="error">{{ error }}</span>
        </p>
    </div>
</template>

<style scoped></style>
