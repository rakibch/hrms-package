<script setup lang="ts">
import { Designation } from '@/App/Interfaces/designations';
import Checkbox from '@/Components/Checkbox.vue';
import DateInput from '@/Components/Others/DateInput.vue';
import TextInput from '@/Components/Others/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { Button, DatePicker, Label, ModalDialog } from '@softzino/st-uikit';
import { ProfessionalExperience } from '@/App/Interfaces/employees';
import { onMounted, watch } from "vue";
interface Props {
    designations: Designation[];
    isModalOpen: boolean;
    experience: ProfessionalExperience| null
}
const props = defineProps<Props>();
const emits = defineEmits<{
    (e: 'close'): void;
    (e: 'onSubmit', values: ProfessionalExperience): void;
}>();

const form = useForm<Partial<ProfessionalExperience>>({
    id: null,
    employee_id: null,
    institution_name: '',
    designation: '',
    start_date: '',
    end_date: '',
    is_running: false,
});

function closeForm() {
    form.reset();
    emits('close');
}
function handleFormSubmit() {
    emits('onSubmit', { ...form });
    closeForm();
}

function isRunningChanged() {
    if (form.is_running) {
        form.end_date = '';
    }
}
function formatDate(dateString: string | undefined): string | undefined {
    if (!dateString) return '';
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return '';
    return date.toISOString().split('T')[0]; // Returns "YYYY-MM-DD"
}

watch(
    () => props.experience,
    (newExperience) => {
        if (newExperience) {
            form.institution_name = newExperience.institution_name || '';
            form.designation = newExperience.designation || '';
            form.start_date = formatDate(newExperience.start_date) || '';
            form.end_date = formatDate(newExperience.end_date) || '';
            form.is_running = newExperience.is_running || false;
            form.id= newExperience.id || null;
            form.employee_id = newExperience.employee_id || null;
        } else {
            form.reset();
        }
    },
    { immediate: true }
);
onMounted(() => {
    console.log('Professional Experiences on mount:', props.experience);
});

</script>

<template>
    <div class="modal-dialog">
        <ModalDialog
            :isOpen="isModalOpen"
            :disableOutSideClick="true"
            :showIcon="false"
            dialogType="alert"
            layoutClasses="w-120"
            @modal-close="emits('close')"
        >
            <template #content>
                <div class="form-container px-1 text-left">
                    <h3
                        class="title-align d-flex justify-content-between align-items-center"
                    >
                        Add Professional Experience Information
                        <SvgIcon
                            :height="12"
                            :width="12"
                            name="red-cross"
                            class="icon-upload"
                            @click="closeForm"
                        />
                    </h3>
                    <p class="sub-title">
                        You are about to add professional experience
                        information.
                    </p>
                    <form @submit.prevent="handleFormSubmit" class="mt-5">
                        <TextInput
                            v-model="form.institution_name"
                            label="Institutions Name"
                            required
                            placeholder="Write Here"
                        />

                        <TextInput
                            v-model="form.designation"
                            label="Designation"
                            required
                            placeholder="Write Here"
                        />

                        <div class="mt-4 flex gap-4">
                            <!-- Start Date -->
                            <div class="w-1/2">
                                <Label
                                    text="Start Date"
                                    :required="false"
                                    class="input-label mb-1 block"
                                />
                                <input
                                    type="date"
                                    v-model="form.start_date"
                                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 bg-white"
                                />
                            </div>

                            <!-- End Date -->
                            <div class="w-1/2">
                                <div class="flex justify-between items-center mb-1">
                                    <Label
                                        text="End Date"
                                        :required="false"
                                        class="input-label"
                                    />
                                    <div class="flex items-center space-x-2">
                                        <Checkbox
                                            id="is_running"
                                            v-model="form.is_running"
                                            :checked="form.is_running"
                                            @change="isRunningChanged"
                                        />
                                        <Label
                                            text="Still running"
                                            for="is_running"
                                            class="cursor-pointer font-medium text-gray-700"
                                        />
                                    </div>
                                </div>
                                <input
                                    type="date"
                                    v-model="form.end_date"
                                    :disabled="form.is_running"
                                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 bg-white disabled:bg-gray-100"
                                />
                            </div>
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
                                :class="['base-button create-button']"
                                type="submit"
                            >
                                Add
                            </Button>
                        </div>
                    </form>
                </div>
            </template>
        </ModalDialog>
    </div>
</template>

<style scoped>
.form-container {
    min-width: 500px;
}

.title {
    font-style: normal;
    font-weight: 600;
    font-size: 18px;
    line-height: 28px;

    color: #1d2939;
}

.sub-title {
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 20px;

    color: #475467;
}

.input-label {
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 20px;

    color: #344054;
}

.input {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 8px 12px;
    gap: 8px;

    width: 100%;
    margin-top: 6px;

    background: #ffffff;
    border: 1px solid #d0d5dd;
    box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
    border-radius: 8px;
}

.form-action-button {
    box-sizing: border-box;

    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    padding: 10px 18px;
    gap: 8px;

    width: 81px;
    height: 44px;

    background: #ffffff;
    border: 1px solid #d0d5dd;
    box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
    border-radius: 8px;

    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;

    color: #344054;
}

.disabled {
    background: #e5e7eb;
    border: 1px solid #e5e7eb;

    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;

    color: #98a2b3;
}

.option-avatar {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0;

    width: 24px;
    height: 24px;

    border-radius: 200px;
}

.option-label {
    margin-left: 8px;
    font-style: normal;
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;

    color: #1d2939;
}
.title-align {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-style: normal;
    font-weight: 600;
    font-size: 18px;
    line-height: 28px;
    color: #1d2939;
}

.icon-upload {
    width: 24px;
    height: 24px;
    color: #333;
    margin-left: 8px;
}
</style>
