<script setup lang="ts">
import { Designation } from '@/App/Interfaces/designations';
import { ProfessionalExperience } from '@/App/Interfaces/employees';
import ProfessionalExperienceInfoModal from '@/Components/Pages/Employee/Modal/ProfessionalExperienceInfoModal.vue';
import { ref,onMounted } from 'vue';

const props = defineProps<{
    designations: Designation[];
}>();

const professionalExperiences = defineModel<ProfessionalExperience[]>({
    default: [],
});

const isFormModalOpen = ref(false);

const selectedExperience = ref<ProfessionalExperience | null>(null);
const editingIndex = ref<number | null>(null);
const actionableDesignation = ref<null | Designation>(null);

const openModal = (experience?: ProfessionalExperience, index?: number) => {
    if (experience && typeof index === 'number') {
        selectedExperience.value = { ...experience }; // clone for editing
        editingIndex.value = index;
    } else {
        selectedExperience.value = null;
        editingIndex.value = null;
    }
    isFormModalOpen.value = true;
};
const closeActionModal = () => {
    selectedExperience.value = null;
    editingIndex.value = null;
    actionableDesignation.value = null;
    isFormModalOpen.value = false;
};

const addProfessionalExperience = (experience: ProfessionalExperience) => {
    if (editingIndex.value !== null) {
        professionalExperiences.value.splice(editingIndex.value, 1, experience);
    } else {
        professionalExperiences.value.push({
            ...experience,
            isNew: true,
        });
    }
    closeActionModal();
};


const deleteProfExp = (index: number) => {
    if (professionalExperiences.value[index].isNew) {
        professionalExperiences.value.splice(index, 1); // hard delete
    } else {
        const item = {
            ...professionalExperiences.value[index],
            _delete: true
        };
        professionalExperiences.value.splice(index, 1, item); // soft delete
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
            <span>Professional Experience Information</span>
            <span
                class="cursor-pointer font-semibold text-gray-800"
                @click="openModal"
                >+ Add New</span
            >
        </div>

        <div>
            <div v-if="professionalExperiences.length">
                <ul  v-for="(item, index) in professionalExperiences"
                     :key="index">
                    <li v-if="!item._delete" class="mt-4 flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <!-- Left Side -->
                        <div>
                            <strong class="block text-gray-500">
                                {{ item.institution_name }}
                            </strong>
                            <p class="text-sm text-gray-600">
                                {{ item.designation }}
                            </p>
                            <p
                                class="inline-flex items-center text-sm text-gray-500"
                            >
                                <SvgIcon name="date" :width="15" />
                                <span class="pl-2">
                                    {{ formatDate(item.start_date) }} -
                                    {{
                                        item.is_running
                                            ? 'Present'
                                            : formatDate(item.end_date)
                                    }}
                                </span>
                            </p>
                            <p>
                                <b class="cursor-pointer text-sm text-gray-600" @click="openModal(item, index)">
                                    Edit
                                </b>
                            </p>
                        </div>
                        <!-- Right Side -->
                        <div>
                            <button
                                @click="deleteProfExp(index)"
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
                    No Professional Experience Information
                </p>
                <p class="pt-[2px] text-gray-600">
                    No information added yet. To add information click on new
                    add new button
                </p>
            </div>
        </div>
    </div>
    <ProfessionalExperienceInfoModal
        :designations="props.designations"
        :is-modal-open="isFormModalOpen"
        :experience="selectedExperience"
        @close="closeActionModal"
        @onSubmit="addProfessionalExperience"
    />

</template>

<style scoped></style>
