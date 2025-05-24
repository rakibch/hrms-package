<script setup lang="ts">
import { IconEye, IconEyeOff } from '@tabler/icons-vue';
import { defineEmits, defineProps, ref } from 'vue';

defineProps<{
    id?: string;
    label?: string;
    placeholder?: string;
    type?: string;
    error?: string;
    disabled?: boolean;
    required?: boolean;
    maxlength?: number;
    minlength?: number;
}>();

const emit = defineEmits<{
    (e: 'onBlur'): void;
    (e: 'onFocus'): void;
}>();

const model = defineModel<string>({ default: '' });
const showPassword = ref(false);
</script>

<template>
    <div>
        <label :for="id" v-if="label" class="text-sm font-medium text-gray-700">
            {{ label }} <span v-if="required" class="text-red-500">*</span>
        </label>

        <div class="relative mt-1.5 max-h-[40px] flex-1">
            <input
                :id="id"
                :type="
                    type === 'password' && !showPassword ? 'password' : 'text'
                "
                v-model="model"
                :placeholder="placeholder || ''"
                :disabled="disabled"
                :required="required"
                class="shadow-xs w-full rounded-lg border px-3 py-2 pr-10 text-sm focus:ring-4"
                :class="[
                    {
                        'border-gray-300 focus:border-gray-300 focus:ring-purple-100':
                            !error,
                        'border-error-300 focus:border-error-300 focus:ring-error-100':
                            error,
                        'cursor-not-allowed bg-gray-100': disabled,
                    },
                ]"
                @blur="emit('onBlur')"
                @focus="emit('onFocus')"
            />

            <!-- Toggle Password Visibility -->
            <button
                v-if="type === 'password'"
                type="button"
                class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700"
                @click="showPassword = !showPassword"
            >
                <IconEye v-if="!showPassword" class="h-5 w-5" />
                <IconEyeOff v-else class="h-5 w-5" />
            </button>
        </div>

        <p class="min-h-[5px] text-sm text-error-700">
            <span v-show="error">{{ error }}</span>
        </p>
    </div>
</template>
