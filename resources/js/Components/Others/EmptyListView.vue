<script setup lang="ts">
import { withDefaults } from 'vue';

interface Props {
    icon?: string;
    title?: string;
    description?: string;
}

const props = withDefaults(defineProps<Props>(), {
    icon: 'info-files',
    title: 'No data available',
    description: 'No information added yet.',
});
</script>

<template>
    <div class="flex flex-col items-center justify-center p-4 text-center">
        <div class="rounded-md border border-gray-200 p-2">
            <SvgIcon :name="icon" />
        </div>
        <p class="pt-4 font-semibold text-gray-800">
            {{ title }}
        </p>
        <p class="pt-[2px] text-gray-600">
            {{ description }}
        </p>
        <slot />
    </div>
</template>

<style scoped></style>
