<script setup lang="ts">
import { watch } from 'vue';

interface Option {
    label: string;
    value: string | number | boolean;
}
interface Props {
    label: string;
    name: string;
    required?: boolean;
    error?: string;
    options: Option[] | string;
}

defineProps<Props>();
const emits = defineEmits<{
    (e: 'on-change', value: string | number | boolean | null): void;
}>();

const model = defineModel<string | number | boolean | null>();

const isArrayOptions = (options: Props['options']): options is Option[] =>
    Array.isArray(options);

watch(model, (value) => {
    emits('on-change', value);
});
</script>

<template>
    <div>
        <label class="label">
            {{ label }} <span class="required-star" v-if="required">*</span>
        </label>

        <div class="radio-group">
            <template v-if="isArrayOptions(options)">
                <label
                    v-for="(option, index) in options"
                    :key="`option-${index}-${option.value}`"
                    :for="`${name}-${option.value}`"
                    class="radio-label"
                >
                    <input
                        type="radio"
                        :id="`${name}-${option.value}`"
                        :name="name"
                        :value="option.value"
                        v-model="model"
                        :required="required"
                    />
                    <span class="option-label">{{ option.label }}</span>
                </label>
            </template>
            <template v-else>
                <span class="error-message">Invalid options provided.</span>
            </template>
        </div>

        <p v-if="error" class="error-text">{{ error }}</p>
    </div>
</template>

<style scoped>
.label {
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 20px;
    color: #344054;
}

.required-star {
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 20px;

    color: #f04438;
}

.radio-group {
    display: flex;
    gap: 2rem;
    align-items: center;
    margin-top: 8px;
}

.radio-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

input[type='radio'] {
    appearance: none;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    outline: none;
    cursor: pointer;
    position: relative;
    box-sizing: border-box;
    background: #ffffff;
    border: 1px solid #d0d5dd;
}

input[type='radio']:checked {
    background-color: white;
    border-color: #374151;
}

input[type='radio']:focus {
    background-color: white;
    border-color: #374151;
    outline: none !important;
}

input[type='radio']:checked::before {
    content: '';
    width: 6px;
    height: 6px;
    background-color: #4b5563;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.option-label {
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 20px;
    color: #344054;
}

.error-text {
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 20px;

    color: #b42318;
}
</style>
