<script setup lang="ts">
import { EducationalInformation } from '@/App/Interfaces/employees';
import { degrees } from '@/App/Utils/const';
import Checkbox from '@/Components/Checkbox.vue';
import DateInput from '@/Components/Others/DateInput.vue';
import Dropdown from '@/Components/Others/Dropdown.vue';
import TextInput from '@/Components/Others/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { Button, DatePicker, Label, ModalDialog } from '@softzino/st-uikit';
import { computed,watch } from 'vue';

interface Props {
    isModalOpen: boolean;
    education?: EducationalInformation | null;
}

const props = defineProps<Props>();

const emits = defineEmits<{
    (e: 'close'): void;
    (e: 'onSubmit', values: EducationalInformation): void;
}>();

const form = useForm<Partial<EducationalInformation>>({
    institution_name: '',
    degree: '',
    field_of_study: '',
    start_date: '',
    end_date: '',
    is_running: false,
    id: null,
    employee_id: null,
});

const degreeOptions = computed(() => {
    return degrees.map((degree) => ({ label: degree, value: degree }));
});

function handleFormSubmit() {
    emits('onSubmit', { ...form });
    closeForm();
}

function closeForm() {
    form.reset();
    emits('close');
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
    () => props.education,
    (newVal) => {
        if (newVal) {
            form.institution_name = newVal.institution_name;
            form.degree = newVal.degree;
            form.field_of_study = newVal.field_of_study;
            form.start_date = formatDate(newVal.start_date);
            form.end_date = formatDate(newVal.end_date);
            form.is_running = newVal.is_running;
            form.id= newVal.id || null;
            form.employee_id = newVal.employee_id || null;

        } else {
            form.reset();
        }
    },
    { immediate: true }
);

</script>

<template>
    <div class="modal-dialog">
        <ModalDialog
            :isOpen="isModalOpen"
            :disableOutSideClick="true"
            :showIcon="false"
            dialogType="alert"
            layoutClasses="w-120"
            @modal-close="closeForm"
        >
            <template #content>
                <div class="form-container px-1 text-left">
                    <h3
                        class="title-align d-flex justify-content-between align-items-center"
                    >
                        Add Educational Information
                        <SvgIcon
                            :height="12"
                            :width="12"
                            name="red-cross"
                            class="icon-upload"
                            @click="closeForm"
                        />
                    </h3>
                    <p class="sub-title">
                        You are about to add educational information
                    </p>
                    <form @submit.prevent="handleFormSubmit" class="mt-5">
                        <TextInput
                            :maxlength="100"
                            v-model="form.institution_name"
                            label="University/College Name"
                            required
                            placeholder="Write Here"
                        />

                        <TextInput
                            :maxlength="100"
                            v-model="form.field_of_study"
                            label="Subject"
                            required
                            placeholder="Write Here"
                            class="mt-4"
                        />

                        <Dropdown
                            label="Name of Degrees"
                            :options="degreeOptions"
                            v-model="form.degree"
                            placeholder="Select"
                            class="mt-4"
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
