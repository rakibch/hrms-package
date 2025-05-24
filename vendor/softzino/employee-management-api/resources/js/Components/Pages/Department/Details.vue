<script setup lang="ts">
import { Department } from '@/App/Interfaces/departments';
import EmployeeCard from '@/Components/Others/EmployeeCard.vue';
import PanelTabs from '@/Components/Others/PanelTabs.vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { ModalDialog } from '@softzino/st-uikit';
import { ref } from 'vue';

const props = defineProps<{
    department: Department;
    isModalOpen: boolean;
}>();

const emits = defineEmits<{
    (e: 'close'): void;
}>();

const tabList = ref([
    {
        value: 'designations',
        title: 'Designations',
        badge: props.department?.designations?.length,
    },
    {
        value: 'employees',
        title: 'Employees',
        badge: props.department?.employees?.length,
    },
]);

const activeTab = ref('designations');
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
                <div class="w-[500px] text-left mr-3">
                    <div class="mb-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">
                                Department Details
                            </h3>

                            <button @click="emits('close')">
                                <XMarkIcon class="h-6 w-6 text-error-500" />
                            </button>
                        </div>
                        <p class="text-left text-sm text-gray-600">
                            Check out the department details.
                        </p>
                    </div>

                    <div class="flex justify-between text-gray-800">
                        <p class="">Department Name</p>
                        <p class="font-medium">
                            {{ department.name }}
                        </p>
                    </div>

                    <hr class="my-4 text-athens-gray-100" />

                    <div>
                        <p class="text-sm font-normal leading-5 text-gray-600">
                            Head of the department
                        </p>

                        <EmployeeCard
                            :employee="{
                                ...department.department_head,
                                avatar: '/images/sample-image.jpeg',
                            }"
                        />
                    </div>

                    <hr class="my-4 text-athens-gray-100" />

                    <div>
                        <PanelTabs :items="tabList" v-model="activeTab" />

                        <div v-show="activeTab === 'designations'">
                            <div
                                class="flex justify-between pt-4 font-inter text-xs font-medium leading-5 text-gray-800"
                            >
                                <p>Designation</p>
                                <p>Number of Employee</p>
                            </div>

                            <div
                                v-for="designation in department.designations"
                                :key="designation.id"
                                class="flex justify-between py-2 font-inter text-xs font-medium leading-5 text-gray-700"
                            >
                                <p>{{ designation.name }}</p>
                                <p>{{ designation.employee_count }}</p>
                            </div>
                        </div>

                        <div v-show="activeTab === 'employees'">
                            <div
                                class="flex justify-between pt-4 font-inter text-xs font-medium leading-5 text-gray-800"
                            >
                                <p>Employee Name</p>
                                <p>Designation</p>
                            </div>

                            <EmployeeCard
                                v-for="employee in department.employees"
                                :key="employee.id"
                                :employee="{
                                    ...employee,
                                    avatar: '/images/sample-image.jpeg',
                                }"
                            />
                        </div>
                    </div>
                </div>
            </template>
        </ModalDialog>
    </div>
</template>

<style>
.modal-dialog {
    .bg-opacity-75 {
        opacity: 0;
    }
}
</style>
