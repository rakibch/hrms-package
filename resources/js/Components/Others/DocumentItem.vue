<script setup lang="ts">
import { format } from 'date-fns';
import { computed, onUnmounted } from 'vue';

const props = defineProps<{
    label?: string;
    attachment: string | File;
    expiry_date?: string | Date;
    fileIcon?: string; // Custom file icons

    // Controls visibility of actions (default: false → buttons are visible)
    hideViewButton?: boolean;
    hideDownloadButton?: boolean;
    hideRemoveButton?: boolean;
}>();

const emits = defineEmits<{
    (e: 'remove'): void;
    (e: 'download'): void;
    (e: 'view', url: string): void;
}>();

// Compute preview URL
const previewUrl = computed(() => {
    if (props.attachment instanceof File) {
        return URL.createObjectURL(props.attachment);
    }
    return props.attachment;
});

// Extract file details
const formattedAttachment = computed(() => {
    const isFile = props.attachment instanceof File;

    // 1. get the “raw” name
    let rawName = isFile
        ? props.attachment.name
        : props.attachment;

    // 2. if it’s a URL/path, strip off everything up to the last slash
    if (!isFile) {
        const segments = rawName.split('/');
        rawName = segments[segments.length - 1] || rawName;
    }

    const fileSize = isFile
        ? (props.attachment.size / (1024 * 1024)).toFixed(2) + 'MB'
        : null;

    return {
        name: rawName,
        size: fileSize,
        preview: previewUrl.value,
    };
});


// Determine label (fallback to filename without extension)
const computedLabel = computed(() => {
    if (props.label) return props.label;
    return formattedAttachment.value.name.replace(/\.[^/.]+$/, ''); // Remove extension
});

// Format expiry date safely
const formattedExpiryDate = computed(() => {
    if (!props.expiry_date) return '';
    const date = new Date(props.expiry_date);
    return isNaN(date.getTime()) ? '' : format(date, 'PPP');
});

// View file action
const viewFile = () => {
    emits('view', formattedAttachment.value.preview);
};

// Cleanup preview URL to prevent memory leaks
onUnmounted(() => {
    if (props.attachment instanceof File) {
        URL.revokeObjectURL(previewUrl.value);
    }
});
</script>

<template>
    <div
        class="flex items-center justify-between rounded-lg border border-gray-300 bg-white px-4 py-2"
    >
        <div class="flex items-start gap-3">
            <!-- File Icon -->
            <div class="flex items-center justify-center">
                <SvgIcon
                    :width="40"
                    :height="40"
                    :name="fileIcon || 'file-icon'"
                />
            </div>
            <!-- File Details -->
            <div class="file-details flex flex-col">
                <span
                    class="max-w-xs truncate text-gray-600"
                    :title="computedLabel"
                >
                    {{ computedLabel }}
                </span>
                <span
                    v-if="formattedAttachment.size"
                    class="text-sm text-gray-500"
                >
                    {{ formattedAttachment.size }}
                </span>
                <span v-if="formattedExpiryDate" class="text-sm text-gray-400">
                    Expire On: {{ formattedExpiryDate }}
                </span>
            </div>
        </div>

        <!-- Actions -->
        <div class="file-actions flex gap-3">
            <button
                v-if="!hideViewButton"
                type="button"
                class="rounded-md border border-gray-200 p-2 text-red-500 hover:bg-gray-50 hover:text-red-700 focus:outline-none"
                @click="viewFile"
            >
                <SvgIcon name="eye" :height="16" :width="16" />
            </button>

            <button
                v-if="!hideRemoveButton"
                type="button"
                @click="emits('remove')"
                class="rounded-md border border-gray-200 p-2 text-red-500 hover:bg-gray-50 hover:text-red-700 focus:outline-none"
            >
                <SvgIcon name="trash" :height="16" :width="16" />
            </button>

            <button
                v-if="!hideDownloadButton"
                type="button"
                @click="emits('download')"
                class="rounded-md border border-gray-200 p-2 text-red-500 hover:text-red-700 focus:outline-none"
            >
                <SvgIcon name="download" :height="16" :width="16" />
            </button>
        </div>
    </div>
</template>
