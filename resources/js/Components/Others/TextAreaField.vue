<script setup lang="ts">
import { defineEmits, defineProps } from 'vue';

defineProps<{
    id?: string;
    label?: string;
    placeholder?: string;
    error?: string;
    disabled?: boolean;
    required?: boolean;
    rows?: number;
    cols?: number;
}>();

// this is an emit
const emit = defineEmits<{
    (e: 'onBlur'): void;
    (e: 'onFocus'): void;
}>();

const model = defineModel<string>({ default: '' });
</script>

<template>
    <div class="flex h-full flex-col">
        <label :for="id" v-if="label" class="text-sm font-medium text-gray-700">
            {{ label }} <span v-if="required" class="text-red-500">*</span>
        </label>
        <textarea
            :id="id"
            v-model="model"
            :placeholder="placeholder || ''"
            :disabled="disabled"
            :rows="rows"
            :cols="cols"
            class="shadow-xs mt-1.5 flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-gray-300 focus:ring-4 focus:ring-pink-100 focus:ring-offset-0"
            :class="[
                {
                    'border-error-300 focus:border-error-300 focus:ring-error-100':
                        error,
                    'cursor-not-allowed bg-gray-100': disabled,
                },
            ]"
            @blur="emit('onBlur')"
            @focus="emit('onFocus')"
        ></textarea>

        <p class="h-[5px] text-sm text-error-700">
            <span v-show="error">{{ error }}</span>
        </p>
    </div>
</template>

<style scoped>
</style>

