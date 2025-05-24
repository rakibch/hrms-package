<script setup lang="ts">
import { computed, ref, onMounted, watch } from 'vue';
import DocumentItem from '@/Components/Others/DocumentItem.vue';
import SvgIcon from '@/Plugins/svg-icon';

interface Props {
    accept?: string;
    maxSize?: number;    // KB
    multiple?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    accept: '*',          // accepts everything by default
    maxSize: 2048,        // default 2 MB
    multiple: false,
});

// v-model binding (an array of File | string URLs)
const model = defineModel<Array<File | string>>();

// local refs
const fileInput = ref<HTMLInputElement|null>(null);
const dragOver = ref(false);
const uploadedFiles = ref<Array<File|string>>([]);

// 1) Initialize from model on mount
onMounted(() => {
    if (Array.isArray(model.value)) {
        uploadedFiles.value = [...model.value];
    }
});

// 2) Keep in sync if parent writes to the model externally
watch(model, (newVal) => {
    if (Array.isArray(newVal)) {
        uploadedFiles.value = [...newVal];
    } else {
        uploadedFiles.value = [];
    }
});

// Human‐readable accept string
const formattedAccept = computed(() => {
    const mimeMap: Record<string,string> = {
        'image/svg+xml': 'SVG',
        'image/png':      'PNG',
        'image/jpeg':     'JPG',
        'image/gif':      'GIF',
        'application/pdf':'PDF',
    };
    const list = props.accept.split(',').map(t => t.trim());
    const names = list.map(t => mimeMap[t] || t.toUpperCase());
    return names.length > 1
        ? `${names.slice(0,-1).join(', ')} or ${names.slice(-1)}`
        : names[0];
});

// Helpers
const triggerFileInput = () => fileInput.value?.click();

const handleFileUpload = (e: Event) => {
    const input = e.target as HTMLInputElement;
    if (input.files) processFiles(Array.from(input.files));
};

const processFiles = (files: File[]) => {
    const valid: File[] = [];
    const allowed = props.accept === '*'
        ? null
        : props.accept.split(',').map(t => t.trim());

    for (const file of files) {
        // type check
        if (allowed && !allowed.some(a => file.type.includes(a))) {
            alert(`Invalid file type: ${file.name}`);
            continue;
        }
        // size check
        if (file.size/1024 > props.maxSize!) {
            alert(`File too large: ${file.name} (max ${props.maxSize} KB)`);
            continue;
        }
        valid.push(file);
    }

    if (props.multiple) {
        uploadedFiles.value.push(...valid);
    } else {
        uploadedFiles.value = valid;
    }
    model.value = [...uploadedFiles.value];
};

const removeFile = (idx: number) => {
    uploadedFiles.value.splice(idx, 1);
    model.value = [...uploadedFiles.value];
};

const handleDragOver = (e: DragEvent) => {
    e.preventDefault();
    dragOver.value = true;
};
const handleDragLeave = () => {
    dragOver.value = false;
};
const handleDrop = (e: DragEvent) => {
    e.preventDefault();
    dragOver.value = false;
    if (e.dataTransfer?.files) processFiles(Array.from(e.dataTransfer.files));
};

const viewFile = (attachment: File|string) => {
    if (typeof attachment === 'string') {
        window.open(attachment, '_blank');
    } else {
        const url = URL.createObjectURL(attachment);
        window.open(url, '_blank');
    }
};
</script>

<template>
    <div>
        <!-- debugging: {{ uploadedFiles }}  model: {{ model }} -->

        <div
            class="file-upload cursor-pointer rounded-xl border border-gray-300 p-8 text-center
             hover:border-transparent hover:outline hover:outline-2 hover:outline-gray-500"
            :class="{ 'border-blue-500 bg-blue-50': dragOver }"
            @click="triggerFileInput"
            @dragover="handleDragOver"
            @dragleave="handleDragLeave"
            @drop="handleDrop"
        >
            <input
                ref="fileInput"
                type="file"
                class="hidden"
                :accept="accept"
                :multiple="multiple"
                @change="handleFileUpload"
            />
            <div class="upload-content flex flex-col items-center gap-4">
                <div class="rounded-md border border-gray-200 p-2">
                    <SvgIcon name="upload-02" />
                </div>
                <p class="text-sm text-gray-600">
                    <b>Click to upload</b> or drag and drop<br />
                    {{ formattedAccept }} (max. {{ maxSize }} KB)
                </p>
            </div>
        </div>

        <div v-if="uploadedFiles.length" class="mt-4">
            <p class="font-semibold text-gray-700">Uploaded Files:</p>
            <DocumentItem
                v-for="(att, i) in uploadedFiles"
                :key="i"
                :attachment="att"
                hide-download-button
                @remove="removeFile(i)"
                @view="() => viewFile(att)"
                class="mt-2"
            />
        </div>
    </div>
</template>

<style scoped>
.file-upload {
    transition:
        border-color 0.2s,
        background-color 0.2s;
}
</style>
