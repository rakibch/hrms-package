<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button, ModalDialog } from '@softzino/st-uikit';
import { watch } from 'vue';
import { Certification } from "@/App/Interfaces/employees";
import TextInput from '@/Components/Others/TextInput.vue';

interface Props {
    isModalOpen: boolean;
    certification: Certification| null
}
const props = defineProps<Props>();

const emits = defineEmits<{
    (e: 'close'): void;
    (e: 'onSubmit', values: Certification): void;
}>();

const form = useForm<Partial<Certification>>({
    course_name: '',
    issuing_organization: '',
    start_date: '',
    completion_date: '',
    certificate_urls: '',
    id: null,
    employee_id: null,
});

function handleSubmit() {
    emits('onSubmit', { ...form });
    closeModal();
}

function closeModal() {
    form.reset();
    emits('close');
}

function formatDate(dateString: string | undefined): string | undefined {
    if (!dateString) return '';
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return '';
    return date.toISOString().split('T')[0]; // Returns "YYYY-MM-DD"
}

watch(
    () => props.certification,
    (newVal) => {
        if (newVal) {
            // Optionally prefill the form with certification data
            form.course_name = newVal.course_name;
            form.issuing_organization = newVal.issuing_organization;
            form.start_date = formatDate(newVal.start_date);
            form.completion_date = formatDate(newVal.completion_date);
            form.certificate_urls = newVal.certificate_urls;
            form.id= newVal.id || null;
            form.employee_id = newVal.employee_id || null;
        } else {
            form.reset();
        }
    },
    { immediate: true } // runs on initial mount too
);
</script>

<template>
    <ModalDialog
        :isOpen="isModalOpen"
        :disableOutSideClick="true"
        :showIcon="false"
        dialogType="alert"
        layoutClasses="w-120"
        @modal-close="closeModal"
    >
        <template #content>
            <div class="form-container px-1">
                <h3 class="title">
                    Add Certification Information
                    <SvgIcon
                        :height="12"
                        :width="12"
                        name="red-cross"
                        class="close-icon"
                        @click="closeModal"
                    />
                </h3>
                <p class="sub-title">
                    You are about to add certification information.
                </p>

                <form @submit.prevent="handleSubmit" class="mt-5">
                    <TextInput
                        v-model="form.course_name"
                        label="Course Name"
                        required
                        placeholder="Write Here"
                    />
                    <TextInput
                        class="mt-4"
                        v-model="form.issuing_organization"
                        label="Issuing Organization"
                        placeholder="Write Here"
                    />

                    <div class="mt-4 flex items-center space-x-6">
                        <input
                            type="date"
                            v-model="form.start_date"
                            class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 bg-white"
                        />
                        <input
                            type="date"
                            v-model="form.completion_date"
                            class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 bg-white"
                        />
                    </div>

                    <TextInput
                        v-model="form.certificate_urls"
                        class="mt-4"
                        placeholder="www.behance.net/example"
                    />

                    <div class="mt-5 flex justify-end gap-3">
                        <Button
                            class="base-button"
                            type="button"
                            @click="closeModal"
                            >Close</Button
                        >
                        <Button
                            class="base-button create-button"
                            type="submit"
                            >Add</Button
                        >
                    </div>
                </form>
            </div>
        </template>
    </ModalDialog>
</template>

<style scoped>
.form-container {
    min-width: 500px;
}

.title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
    font-size: 18px;
    color: #1d2939;
}

.sub-title {
    font-size: 14px;
    color: #475467;
}

.close-icon {
    width: 24px;
    height: 24px;
    color: #333;
    cursor: pointer;
}
</style>
