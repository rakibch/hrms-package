<script setup lang="ts">
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { Button, Label, ModalDialog, Select,DatePicker } from "@softzino/st-uikit";
import { defineProps, defineEmits, onMounted, ref } from "vue";
import { Department } from "@/App/Interfaces/departments";
import { Designation } from "@/App/Interfaces/designations";
import { Checkbox } from "@softzino/st-uikit";
import { jobStatus } from "@/App/Utils/const";
import { profileStatus } from "@/App/Utils/const";

interface Props {
    isModalOpen: boolean;
    designations: Designation[];
    departments: Department[];
}

const props = defineProps<Props>();
const jobStatusOptions = ref(jobStatus);
const profileStatusOptions = ref(profileStatus);
interface Filters {
    department: number;
    designation: number;
    fromDate: string;
    toDate: string;
    status: [];
    profileStatus:[];
}

const filters = ref<Filters>({
    department: null,
    designation: null,
    fromDate: '',
    toDate: '',
    status: [], // Change from string to an array
    profileStatus:[],
});

const emits = defineEmits<{
    (e: 'close'): void;
    (e: 'filter-apply', filters: Filters): void;
}>();

const toggleStatus = (value: string) => {
    if (filters.value.status.includes(value)) {
        filters.value.status = filters.value.status.filter((item) => item !== value);
    } else {
        filters.value.status.push(value);
    }
};

const toggleProfileStatus = (value: string) => {
    if (filters.value.profileStatus.includes(value)) {
        filters.value.profileStatus = filters.value.profileStatus.filter((item) => item !== value);
    } else {
        filters.value.profileStatus.push(value);
    }
};

const applyFilters = () => {
    emits('filter-apply', filters.value);
    // Reset filters after emitting
    filters.value = {
        department: null,
        designation: null,
        fromDate: '',
        toDate: '',
        status: [],
        profileStatus: [],
    };
};
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
                <div class="w-[500px] text-left">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Filter
                        </h3>
                        <button @click="emits('close')">
                            <XMarkIcon class="h-6 w-6 text-error-500" />
                        </button>
                    </div>
                    <p class="text-left text-sm text-gray-600">
                        You are about to filter
                    </p>
                </div>

                <div class="mt-2 w-[500px]">
                    <Label text="Department"  class="text-sm-start flex"/>
                    <div class="mt-2">
                        <Select :options="props.departments.map(dept => ({value: dept.id,label: dept.name}))"
                            v-model="filters.department"
                            placeholder="Select"
                            clearable
                        />
                        <div class="h-[5px]"></div>
                    </div>
                </div>
                <hr class="my-4 text-athens-gray-100" />

                <div class="mt-2 w-[500px]">
                    <Label text="Designation"  class="text-sm-start flex"/>
                    <div class="mt-2">
                        <Select :options="props.designations.map(dept => ({value: dept.id,label: dept.name}))"
                            v-model="filters.designation"
                            placeholder="Select"
                            clearable
                        />
                        <div class="h-[5px]"></div>
                    </div>
                </div>
                <hr class="my-4 text-athens-gray-100" />

                <div class="mt-2 grid grid-cols-3 gap-4 w-[500px]">
                    <div>
                        <Label text="Date Range" class="text-sm font-semibold text-start" />
                    </div>
                    <div class="relative">
                        <Label text="From" class="text-sm font-medium text-start" />
                        <DatePicker v-model="filters.fromDate" placeholder="Select Date" class="w-full mt-2 dp_menu" />
                    </div>
                    <div class="relative">
                        <Label text="To" class="text-sm font-medium text-start" />
                        <DatePicker v-model="filters.toDate" placeholder="Select Date" class="w-full mt-2" />
                    </div>
                </div>
                <hr class="my-4 text-athens-gray-100" />

                <div class="mt-2 flex items-center gap-4 w-[500px]">
                    <!-- Label on the left -->
                    <Label text="Job Status" class="text-sm font-medium text-start min-w-[120px]" />

                    <!-- Checkboxes inlined on the right -->
                    <div class="flex flex-wrap gap-2 ml-8">
                        <div v-for="(status) in jobStatusOptions" :key="status.value" class="flex items-center space-x-1"
                            :class="{'bg-success-50 border border-success-200 p-1 rounded-md': status.value == 'active',
                            'bg-error-50 border border-error-200 p-1 rounded-md': status.value=='terminated',
                            'bg-gray-50 border border-gray-200 p-1 rounded-md': status.value=='inactive',
                            'bg-blue-50 border border-blue-200 p-1 rounded-md': status.value=='resigned'
                            }">
                            <Checkbox
                                :id="'status-' + status.value"
                                :value="status.value"
                                :checked="filters.status.includes(status.value)"
                                @change="toggleStatus(status.value)"
                                class="mr-1"
                            />
                            <Label
                                :for="'status-' + status.value"
                                :text="status.label"
                                class="cursor-pointer font-medium text-gray-700 pl-0 ml-0"
                            />
                        </div>
                    </div>
                </div>
                <hr class="my-4 text-athens-gray-100" />

                <div class="mt-2 flex items-center gap-4 w-[500px]">
                    <Label text="Profile Status" class="text-sm font-medium text-start min-w-[120px]" />

                    <div class="flex flex-wrap gap-2 ml-8">
                        <div v-for="(status) in profileStatusOptions" :key="status.value" class="flex items-center space-x-1"
                             :class="{'bg-success-50 border border-success-200 p-1 rounded-md': status.value == 'complete',
                            'bg-gray-50 border border-gray-200 p-1 rounded-md': status.value=='draft',
                            }">
                            <Checkbox
                                :id="'status-' + status.value"
                                :value="status.value"
                                :checked="filters.status.includes(status.value)"
                                @change="toggleProfileStatus(status.value)"
                                class="mr-1"
                            />
                            <Label
                                :for="'status-' + status.value"
                                :text="status.label"
                                class="cursor-pointer font-medium text-gray-700 pl-0 ml-0"
                            />
                        </div>
                    </div>
                </div>
                <hr class="my-4 text-athens-gray-100" />

                <div class="mt-5 flex justify-end gap-3">
                    <Button class="base-button" type="button" @click="emits('close')">
                        Close
                    </Button>
                    <Button class="base-button create-button" type="button" @click="applyFilters">
                        Apply
                    </Button>
                </div>
            </template>
        </ModalDialog>
    </div>
</template>
<style>
.items-start{
    .text-center{
        text-align: left;
    }
}
</style>


