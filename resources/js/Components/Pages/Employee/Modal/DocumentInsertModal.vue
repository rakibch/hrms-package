<script setup lang="ts">
import { watch, computed } from 'vue';
import { Document } from '@/App/Interfaces/employees';
import DateInput from '@/Components/Others/DateInput.vue';
import Dropdown from '@/Components/Others/Dropdown.vue';
import FileInput from '@/Components/Others/FileInput.vue';
import { useForm } from '@inertiajs/vue3';
import { Button, ModalDialog } from '@softzino/st-uikit';

const props = defineProps<{ isModalOpen: boolean; document?: Document }>();
const emits = defineEmits<{
    (e: 'close'): void;
    (e: 'onSubmit', values: Document): void;
}>();

// Initialize form (will be filled via watch)
const form = useForm<Document>({
    type: '',
    expiry_date: '',
    files: [] as (File | string)[],
});

// Watch for document prop changes and fill/reset the form
watch(
    () => props.document,
    (doc) => {
        if (doc) {
            form.type = doc.type;
            form.expiry_date = doc.expiry_date || '';
            form.files = Array.isArray(doc.files) ? [...doc.files] : [];
        } else {
            form.reset();
        }
    },
    { immediate: true }
);

const documentTypeOptions = [
    { label: 'National Id', value: 'National Id', hasExpireDate: false },
    { label: 'Passport', value: 'Passport', hasExpireDate: true },
    { label: 'Driving License', value: 'Driving License', hasExpireDate: true },
    { label: 'Birth Certificate', value: 'Birth Certificate', hasExpireDate: false },
    { label: 'Other', value: 'Other', hasExpireDate: true },
];

const selectedDocumentType = computed(() =>
    documentTypeOptions.find((opt) => opt.value === form.type)
);

const handleFormSubmit = () => {
    emits('onSubmit', form.data());
    closeForm();
};

const closeForm = () => {
    emits('close');
};
</script>

<template>
    <ModalDialog
        :isOpen="props.isModalOpen"
        :disableOutSideClick="true"
        :showIcon="false"
        dialogType="alert"
        layoutClasses="w-120"
        @modal-close="closeForm"
    >
        <template #content>
            <div class="form-container px-1 text-left">
                <h3 class="flex items-center justify-between">
          <span class="text-lg font-semibold text-gray-800">
            {{ props.document ? 'Edit Document' : 'Add Other Document' }}
          </span>
                    <button
                        class="rounded-md p-2 hover:bg-error-50"
                        @click="closeForm"
                    >
                        <SvgIcon name="red-cross" class="text-error-500" width="10" height="10" />
                    </button>
                </h3>
                <p class="text-sm text-gray-600">
                    {{ props.document ? 'Update the document details.' : 'You are about to add another document.' }}
                </p>
                <form @submit.prevent="handleFormSubmit" class="mt-5">
                    <Dropdown
                        label="Select Document Type"
                        placeholder="Select"
                        required
                        :options="documentTypeOptions"
                        v-model="form.type"
                    />
                    <FileInput
                        class="mt-4"
                        v-model="form.files"
                        accept="image/svg+xml,image/png,image/jpeg,application/pdf"
                        :multiple="true"
                    />

                    <div class="mt-2">
                    <label class="" for="expiry_date">Expiry Date</label>
                    <input
                        type="date" name="" id="expiry_date"
                        class="block w-full px-4 py-2 border
                        border-gray-300
                        rounded-md shadow-sm focus:ring-2
                        focus:ring-blue-500
                        focus:border-blue-500
                        text-gray-700 bg-white"
                        v-model="form.expiry_date">
                    </div>
                    <div class="mt-5 flex justify-end gap-3">
                        <Button
                            class="base-button"
                            type="button"
                            @click="closeForm"
                        >
                            Close
                        </Button>
                        <Button
                            :disabled="
                                !form.type ||
                                !form.files?.length ||
                                (selectedDocumentType?.hasExpireDate &&
                                    !form.expiry_date)
                            "
                            class="base-button create-button"
                            type="submit"
                        >
                            Add
                        </Button>
                    </div>

                </form>
            </div>
        </template>
    </ModalDialog>
</template>

<style scoped>
.form-container { min-width: 500px; }
</style>
