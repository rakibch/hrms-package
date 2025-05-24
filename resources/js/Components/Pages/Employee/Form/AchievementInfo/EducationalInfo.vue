<script setup lang="ts">
import { EducationalInformation } from '@/App/Interfaces/employees';
import EducationInfoModal from '@/Components/Pages/Employee/Modal/EducationInfoModal.vue';
import { onMounted, ref } from "vue";

const educationList = defineModel<EducationalInformation[]>({
    default: [],
});

const isFormModalOpen = ref(false);

const selectedEducation = ref<EducationalInformation | null>(null);
const editingIndex = ref<number | null>(null);

const openModal = (education?: EducationalInformation, index?: number) => {
    if (education && typeof index === 'number') {
        selectedEducation.value = { ...education }; // shallow clone
        editingIndex.value = index;
    } else {
        selectedEducation.value = null;
        editingIndex.value = null;
    }
    isFormModalOpen.value = true;
};
const closeActionModal = () => {
    isFormModalOpen.value = false;
    selectedEducation.value = null;
    editingIndex.value = null;
};
const addEducation = (education: EducationalInformation) => {
    if (editingIndex.value !== null) {
        educationList.value.splice(editingIndex.value, 1, education);
    } else {
        educationList.value.push({
            ...education,
            isNew: true,
        });
    }
    closeActionModal();
};

const deleteEducation = (index: number) => {
    if (educationList.value[index].isNew) {
        educationList.value.splice(index, 1); // hard delete
    } else {
        const item = {
            ...educationList.value[index],
            _delete: true
        };
        educationList.value.splice(index, 1, item); // soft delete
    }
};

const formatDate = (date: string | Date | null): string => {
    if (!date) return '';
    const options: Intl.DateTimeFormatOptions = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };
    return new Date(date).toLocaleDateString('en-US', options);
};
</script>

<template>
    <div class="w-full rounded-xl border border-gray-200 p-4">
        <div
            class="mb-4 flex items-center justify-between border-b border-gray-200 pb-4 font-semibold text-gray-800"
        >
            <span>Educational Information</span>
            <span
                class="cursor-pointer font-semibold text-gray-800"
                @click="openModal"
            >
                + Add New
            </span>
        </div>
        <div>
            <div v-if="educationList.length">
                <ul  v-for="(education, index) in educationList"
                     :key="index">
                    <li v-if="!education._delete" class="mt-4 flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 p-4">
                        <!-- Left Side -->
                        <div>
                            <strong class="block text-gray-500">
                                {{ education.institution_name }}
                            </strong>
                            <p class="text-sm text-gray-600">
                                {{ education.degree }} -
                                {{ education.field_of_study }}
                            </p>
                            <p
                                class="inline-flex items-center text-sm text-gray-500"
                            >
                                <SvgIcon name="date" :width="15" />
                                <span class="pl-2">
                                    {{ formatDate(education.start_date) }} -
                                    {{
                                        education.is_running
                                            ? 'Present'
                                            : formatDate(education.end_date)
                                    }}
                                </span>
                            </p>
                            <p>
                                <b class="cursor-pointer text-sm text-gray-600"  @click="openModal(education, index)">
                                    Edit
                                </b>
                            </p>
                        </div>
                        <!-- Right Side -->
                        <div>
                            <button
                                @click="deleteEducation(index)"
                                class="text-red-500 hover:text-red-700"
                            >
                                <SvgIcon name="trash" />
                            </button>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col items-center justify-center" v-else>
                <div class="rounded-md border border-gray-200 p-2">
                    <SvgIcon name="info-files" />
                </div>
                <p class="pt-4 font-semibold text-gray-800">
                    No Educational Information
                </p>
                <p class="pt-[2px] text-gray-600">
                    No information added yet. To add information click on new
                    add new button
                </p>
            </div>
        </div>
    </div>

    <EducationInfoModal
        :is-modal-open="isFormModalOpen"
        @onSubmit="addEducation"
        :education="selectedEducation"
        @close="closeActionModal"
    />
</template>

<style scoped></style>
