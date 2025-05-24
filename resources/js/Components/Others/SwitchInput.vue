<script lang="ts" setup>
import { defineEmits, defineProps, ref, watch } from 'vue';

const props = defineProps<{
    checked: boolean;
}>();

const emits = defineEmits<{
    (e: 'change', value: boolean): void;
}>();

const model = ref<boolean>(props.checked);

watch(
    () => props.checked,
    (value) => {
        model.value = value;
    },
);

const handleChange = () => {
    emits('change', model.value);
};
</script>

<template>
    <div class="switch">
        <label class="switch-label">
            <input type="checkbox" :checked="model" @change="handleChange" />
            <span class="slider"></span>
        </label>
    </div>
</template>

<style scoped>
.switch {
    display: inline-block;
}

.switch-label {
    position: relative;
    display: inline-block;
    width: 36px;
    height: 20px;
}

.switch-label input {
    opacity: 0;
    width: 0;
    height: 0;
}

.switch-label .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #f2f4f7;
    transition: 0.4s;
    border-radius: 34px;
}

.switch-label input:checked + .slider {
    background-color: #4b5563;
}

.switch-label .slider:before {
    position: absolute;
    content: '';
    height: 16px;
    width: 16px;
    border-radius: 50%;
    left: 4px;
    bottom: 2px;
    background-color: white;
    transition: 0.1s;
}

.switch-label input:checked + .slider:before {
    transform: translateX(15px);
}
</style>
