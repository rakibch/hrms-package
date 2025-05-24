<script setup lang="ts">
import { MagnifyingGlassIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { defineEmits, defineModel, ref } from 'vue';

const isInputVisible = ref(false);

const model = defineModel<string>({ default: '' });

const emits = defineEmits<{
    (e: 'toggle', isVisible: boolean): void;
    (e: 'input', value: string): void;
    (e: 'close'): void;
}>();

function toggleInput() {
    isInputVisible.value = !isInputVisible.value;

    emits('toggle', isInputVisible.value);

    if (!isInputVisible.value) {
        model.value = '';
        emits('close');
    }
}
</script>

<template>
    <div class="search-container">
        <button
            v-if="!isInputVisible"
            @click="toggleInput"
            class="icon-button"
            aria-label="Search"
        >
            <MagnifyingGlassIcon class="h-6 w-6 text-gray-500" />
        </button>

        <div v-if="isInputVisible" class="search-input-container">
            <input
                autofocus
                type="text"
                v-model="model"
                @input="emits('input', model)"
                class="search-input"
                placeholder="Search..."
            />
            <button @click="toggleInput" class="icon-button" aria-label="Close">
                <XMarkIcon class="h-6 w-6 text-gray-500" />
            </button>
        </div>
    </div>
</template>

<style scoped lang="scss">
.search-container {
    display: flex;
    align-items: center;
    position: relative;
    height: 100%;

    .icon-button {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;

        &:hover {
            color: #475467;
        }
    }

    .search-input-container {
        display: flex;
        align-items: center;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 0 8px;
        background-color: white;
        height: 100%;

        .search-input {
            border: none;
            outline: none;
            padding: 6px;
            font-size: 14px;
            flex-grow: 1;
            border-radius: 8px;
            box-shadow: none;

            &::placeholder {
                color: #9ca3af;
            }
        }
    }
}
</style>
