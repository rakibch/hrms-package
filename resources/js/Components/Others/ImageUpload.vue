<script setup lang="ts">
import { QuestionMarkCircleIcon } from '@heroicons/vue/24/outline';
import { Button } from '@softzino/st-uikit';
import { ref, watch } from 'vue';

const fileInput = ref<HTMLInputElement | null>(null);
const model = defineModel<string | File | null>({ default: null });
const photoUrl = ref<string | null>(null);

// Watch for changes in the model to update the preview
watch(
    () => model.value,
    (newValue) => {
        // 1️⃣ File wins
        if (newValue instanceof File) {
            photoUrl.value = URL.createObjectURL(newValue);
        }
        // 2️⃣ Only non‑empty strings
        else if (typeof newValue === 'string' && newValue.trim() !== '') {
            photoUrl.value = newValue;
        }
        // 3️⃣ Everything else → clear
        else {
            photoUrl.value = null;
        }
    },
    { immediate: true }
);

/**
 * Handles file selection and updates the model.
 */
const handleFileChange = (event: Event): void => {
    const target = event.target as HTMLInputElement;
    model.value = target.files?.[0] ?? null;
};

/**
 * Triggers the file input click event.
 */
const triggerFileInput = (): void => {
    fileInput.value?.click();
};
</script>

<template>
    <div>
        <div class="mb-4">
            <h3 class="section-label flex items-center gap-1 text-gray-900">
                Your photo
                <QuestionMarkCircleIcon class="h-4 w-4 text-gray-400" />
            </h3>
            <p class="section-text text-sm text-gray-600">
                This will be displayed on your profile.
            </p>
        </div>

        <div class="flex items-center gap-6">
            <div
                class="flex h-20 w-20 cursor-pointer items-center justify-center overflow-hidden rounded-full bg-gray-100"
                @click="triggerFileInput"
            >
                <img
                    v-if="photoUrl"
                    :src="photoUrl"
                    class="h-full w-full rounded-full object-cover"
                    alt="Profile photo preview"
                />
                <SvgIcon
                    v-else
                    name="user-01"
                    class="text-gray-600"
                    width="40px"
                    height="40px"
                />
            </div>

            <Button
                @click="triggerFileInput"
                type="button"
                class="base-button flex items-center gap-2"
            >
                <SvgIcon
                    name="upload-cloud-02"
                    class="text-gray-700"
                    width="20px"
                    height="20px"
                />
                Upload photo
            </Button>
        </div>

        <input
            ref="fileInput"
            id="photo-input"
            type="file"
            accept="image/*"
            @change="handleFileChange"
            hidden
        />
    </div>
</template>

<style scoped></style>
