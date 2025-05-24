<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    label: string;
    removable?: boolean;
    severity?:
        | 'secondary'
        | 'info'
        | 'success'
        | 'warn'
        | 'danger'
        | 'contrast'
        | null;
}

const props = withDefaults(defineProps<Props>(), {
    removable: false,
    severity: 'secondary',
});

const emit = defineEmits<{
    (e: 'remove'): void;
}>();

const severityStyles = {
    secondary: 'bg-gray-50 border-gray-200 text-gray-700',
    info: 'bg-blue-50 border-blue-200 text-blue-700',
    success: 'bg-success-50 border-success-200 text-success-700',
    warn: 'bg-yellow-50 border-yellow-200 text-yellow-700',
    danger: 'bg-error-50 border-error-200 text-error-700',
    contrast: 'bg-black text-white border-black',
    default: 'bg-gray-50 border-gray-200 text-gray-700',
};

const chipClasses = computed(() => {
    return (
        severityStyles[props.severity || 'default'] +
        ' px-2 py-1 border box-border'
    );
});

const closeButtonClasses = computed(() => {
    return props.severity === 'contrast'
        ? 'bg-white text-black hover:bg-gray-200'
        : 'bg-gray-300 text-gray-600 hover:bg-gray-400';
});

// Methods
const handleRemove = () => {
    emit('remove');
};
</script>

<template>
    <div
        class="chip inline-flex items-center rounded-md text-sm font-medium"
        :class="chipClasses"
    >
        <span class="mr-2">{{ label }}</span>
        <button
            v-if="removable"
            class="flex h-4 w-4 items-center justify-center rounded-full"
            :class="closeButtonClasses"
            @click="handleRemove"
            aria-label="Remove"
        >
            <span class="text-xs">&times;</span>
        </button>
    </div>
</template>

<style scoped>
.chip {
    padding: 2px 6px;
    flex-direction: row;
    align-items: center;
    height: 22px;
    width: fit-content;
}
</style>
