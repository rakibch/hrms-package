<script lang="ts">
import { defineComponent, PropType, ref, watch } from 'vue';

interface UploadedFile {
    file: File;
    preview: string;
    isImage: boolean;
    size: number;
    name: string;
}

export default defineComponent({
    name: 'UploadFile',
    props: {
        files: {
            type: Array as PropType<UploadedFile[]>,
            required: true,
        },
    },
    emits: ['update:files'],
    setup(props, { emit }) {
        const uploadedFiles = ref<UploadedFile[]>([...props.files]);
        const fileInput = ref<HTMLInputElement | null>(null);

        const handleFileUpload = async (event: Event): Promise<void> => {
            const input = event.target as HTMLInputElement;
            const files = input.files;

            if (!files) return;

            const newFiles: UploadedFile[] = [];

            for (const file of files) {
                const isValid = await validateFile(file);
                if (isValid) {
                    const isImage = file.type.startsWith('image');
                    const preview = isImage
                        ? await getImagePreview(file)
                        : 'https://via.placeholder.com/100?text=File'; // Placeholder for non-images

                    newFiles.push({ file, preview, isImage, size: file.size ,name: file.name});
                } else {
                    alert(
                        "Invalid file. Ensure it's SVG, PNG, JPG, GIF, PDF, or Word document and within 800x400px (for images).",
                    );
                }
            }

            uploadedFiles.value.push(...newFiles);
            emit('update:files', uploadedFiles.value);

            if (input) input.value = '';
        };

        const triggerFileInput = (): void => {
            fileInput.value?.click();
        };

        const validateFile = (file: File): Promise<boolean> => {
            const validTypes = [
                'image/svg+xml',
                'image/png',
                'image/jpeg',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ];
            const maxWidth = 1200;
            const maxHeight = 800;

            if (!validTypes.includes(file.type)) return Promise.resolve(false);

            if (file.type.startsWith('image')) {
                return new Promise((resolve) => {
                    const img = new Image();
                    img.onload = () => {
                        resolve(
                            img.width <= maxWidth && img.height <= maxHeight,
                        );
                    };
                    img.src = URL.createObjectURL(file);
                });
            }

            return Promise.resolve(true);
        };

        const getImagePreview = (file: File): Promise<string> => {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    resolve(e.target?.result as string);
                };
                reader.readAsDataURL(file);
            });
        };

        const deleteFile = (index: number): void => {
            uploadedFiles.value.splice(index, 1);
            emit('update:files', uploadedFiles.value);
        };

        const openFile = (preview: string): void => {
            window.open(preview, '_blank');
        };

        watch(
            () => props.files,
            (newFiles) => {
                uploadedFiles.value = [...newFiles];
            },
        );

        return {
            uploadedFiles,
            fileInput,
            handleFileUpload,
            triggerFileInput,
            deleteFile,
        };
    },
});
</script>

<template>
    <div class="upload-file">
        <!-- Uploaded Files Section -->
        <div
            v-if="uploadedFiles.length"
            class="uploaded-files mb-4 flex flex-col gap-4"
        >
            <div
                v-for="(file, index) in uploadedFiles"
                :key="index"
                class="file-item flex items-center justify-between rounded-lg border border-gray-300 p-4"
            >
                <div class="file-preview flex items-center gap-4">
                    <img
                        v-if="file.isImage"
                        :src="file.preview"
                        alt="Uploaded File"
                        class="h-20 w-20 rounded-lg border border-gray-200 object-cover"
                    />
                    <div v-else class="flex items-center justify-center">
<!--                        <span class="text-sm text-gray-500">File</span>-->
                        <SvgIcon :width="50" :height="50" name="pdf-icon" />
                    </div>
                    <div class="file-details flex flex-col">
                        <span class="max-w-xs truncate font-bold text-gray-800">
                            {{ file.file.name }}
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ (file.file.size / (1024 * 1024)).toFixed(2) }} MB
                        </span>
                    </div>
                </div>

                <div class="file-actions flex gap-4">
                    <button
                        @click="deleteFile(index)"
                        class="text-red-500 hover:text-red-700 focus:outline-none"
                    >
                        <div class="rounded-md border border-red-200 p-2">
                            <SvgIcon name="trash" />
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- File Upload Section -->
        <div
            class="file-upload cursor-pointer rounded-xl border border-gray-300 p-8 text-center"
            @click="triggerFileInput"
        >
            <input
                ref="fileInput"
                type="file"
                accept=".svg,.png,.jpg,.gif,.pdf,.doc,.docx"
                class="hidden"
                @change="handleFileUpload"
            />
            <div class="upload-content flex flex-col items-center gap-4">
                <div class="rounded-md border border-gray-200 p-2">
                    <SvgIcon name="upload-02" />
                </div>
                <p class="text-sm text-gray-600">
                    <b>Click to upload</b> or drag and drop SVG, PNG, <br />JPG,
                    GIF, GIF, PDF, DOC, or DOCX (max: 800x400px for images)
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.upload-file {
    max-width: 600px;
    margin: 0 auto;
}
</style>
