<script setup lang="ts">
import { Department } from '@/App/Interfaces/departments';
import { Designation } from '@/App/Interfaces/designations';
import { Employee } from '@/App/Interfaces/employees';
import { getSeverityByStatus } from '@/App/Utils/helper';
import { formatIsoDateToReadable } from '@/App/Utils/timeAndDateFormatter';
import Chip from '@/Components/Others/Chip.vue';
import DataTable from '@/Components/Others/DataTable.vue';
import Popover from '@/Components/Others/Popover.vue';
import PageHeader from '@/Components/PageHeader.vue';
import EmployeeQuickView from '@/Components/Pages/Employee/Modal/EmployeeQuickView.vue';
import EmploymentListFilter from '@/Components/Pages/Employee/Modal/EmploymentListFilter.vue';
import StatusChange from '@/Components/Pages/Employee/Modal/StatusChange.vue';
import {
    EllipsisVerticalIcon,
    EyeIcon,
    PencilIcon,
} from '@heroicons/vue/16/solid';
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@softzino/st-uikit';
import { onMounted, ref } from 'vue';

interface Props {
    employee: Employee[];
    singleEmployee?: any;
    basicInformation?: any;
    designations: Designation[];
    departments: Department[];
}

interface Filters {
    department: number;
    designation: number;
    fromDate: string;
    toDate: string;
    status: [];
    profileStatus: [];
}

const filters = ref<Filters>({
    department: null,
    designation: null,
    fromDate: '',
    toDate: '',
    status: [], // Change from string to an array
    profileStatus: [],
});

const props = defineProps<Props>();
const breadCrumbs = [
    { name: 'Dashboard', routeName: 'dashboard' },
    { name: 'Employee Management', routeName: 'employee.index' },
];

const columns = [
    { label: 'Employee Name', key: 'name' },
    { label: 'Department', key: 'department_name' },
    { label: 'Designation', key: 'designation_name' },
    { label: 'Joined at', key: 'join_date', sortable: true },
    { label: 'Status', key: 'employment_status' },
    { label: 'Profile Status', key: 'profile_status' },
    { label: 'Created By', key: 'created_by' },
];

const isDetailsModalOpen = ref(false);
const changeStatusModalOpen = ref(false);
const isFilterModalOpen = ref(false);

const handleRowAction = async (payload: {
    index: number;
    rowData: Employee;
    action: 'view' | 'edit' | 'change-status' | 'employee-timeline';
}) => {
    if (payload.action === 'view') {
        localStorage.setItem('detailsFlag', 'true');
        router.visit(`employee/${payload.rowData.id}`, {
            preserveScroll: true,
        });
    } else if (payload.action === 'change-status') {
        localStorage.setItem('statusFlag', 'true');
        router.visit(`employee/${payload.rowData.id}`, {
            preserveScroll: true,
        });
    } else if (payload.action === 'employee-timeline') {
        router.visit(`employee/${payload.rowData.id}/employee-timeline`, {
            preserveScroll: true,
        });
    } else {
        isDetailsModalOpen.value = false;
        changeStatusModalOpen.value = false;
    }
};

function handleFilterButtonClick() {
    isFilterModalOpen.value = true;
}

const closeDetailsModal = () => {
    isDetailsModalOpen.value = false;
    router.visit(route('employee.index'));
};
const closeStatusChangeModal = () => {
    router.visit(route('employee.index'));
};

onMounted(() => {
    const storedFlag = localStorage.getItem('detailsFlag');
    const savedFlag = localStorage.getItem('statusFlag');
    if (storedFlag === 'true') {
        isDetailsModalOpen.value = true;
        localStorage.removeItem('detailsFlag');
    }
    if (savedFlag === 'true') {
        changeStatusModalOpen.value = true;
        localStorage.removeItem('statusFlag');
    }
});

const applyFilters = (filterValue: Filters) => {
    filters.value = filterValue;
    router.get(route('employee.index'), filters.value, {
        preserveState: true,
        preserveScroll: true,
    });
    isFilterModalOpen.value = false;
};
const hidePopover = ref(false);
</script>
<template>
    <div>
        <Head title="Employee" />
        <PageHeader
            title="Employee Management"
            subtitle="Manage your employee information here."
            :bread-crumbs="breadCrumbs"
        >
            <template #rightSideContent>
                <div class="flex gap-3">
                    <Button class="base-button">
                        <SvgIcon name="upload-01" />
                        Import
                    </Button>
                    <Link
                        :href="route('employee.create')"
                        class="base-button create-button"
                    >
                        Create Employee
                    </Link>
                </div>
            </template>
        </PageHeader>

        <div class="table-container mt-6">
            <DataTable
                :table-title="'Employee'"
                :columns="columns"
                :selection-mode="'multiple'"
                :values="employee"
                :show-extra-actions="true"
                @row-action="handleRowAction"
                @filter-click="handleFilterButtonClick"
            >
                <template #table-col-name="{ rowData }">
                    <div class="flex items-center gap-2">
                        <img
                            class="option-avatar h-8 w-8 rounded-full"
                            :alt="rowData.name"
                            :src="rowData.profile_image ?? '/images/Avatar.png'"
                        />

                        <div>
                            <h3
                                class="text-[14px] font-medium leading-[20px] text-gray-800"
                            >
                                {{ rowData.name }}
                            </h3>
                            <p class="text-[12px] leading-[14px] text-gray-600">
                                {{ rowData.employee_no }}
                            </p>
                        </div>
                    </div>
                </template>
                <template #table-col-join_date="{ rowData }">
                    {{ formatIsoDateToReadable(rowData.join_date) }}
                </template>
                <template #table-col-employment_status="{ rowData }">
                    <Chip
                        :label="rowData.employment_status"
                        :severity="
                            getSeverityByStatus(rowData.employment_status)
                        "
                    />
                </template>
                <template #table-col-profile_status="{ rowData }">
                    <Chip
                        :label="rowData.profile_status"
                        :severity="
                            rowData.profile_status === 'Complete'
                                ? 'success'
                                : 'secondary'
                        "
                    />
                </template>
                <template #actions="{ row, index }">
                    <div>
                        <div class="flex items-center justify-center">
                            <Popover
                                :position="'bottom-right'"
                                :showArrow="false"
                                :hide-popover="hidePopover"
                            >
                                <button>
                                    <EllipsisVerticalIcon
                                        class="flex h-5 w-5 justify-start hover:text-primary-600"
                                    />
                                </button>

                                <template #content>
                                    <div class="w-[200px] px-0.5 py-1">
                                        <Button
                                            class="m-0 flex w-full items-center justify-start gap-2 bg-transparent py-2 pl-1 text-darkslategrey-800 hover:bg-gray-100"
                                            @click="
                                                            handleRowAction({
                                                                index,
                                                                rowData: row,
                                                                action: 'view',
                                                            })
                                                        "
                                        >
                                            <EyeIcon
                                                class="flex h-5 w-5 justify-start hover:text-primary-600"
                                            />
                                            <span> View </span>
                                        </Button>

                                        <Button
                                            class="m-0 flex w-full items-center justify-start gap-2 bg-transparent py-2 pl-1 text-darkslategrey-800 hover:bg-gray-100"
                                            @click="
                                                            handleRowAction({
                                                                index,
                                                                rowData: row,
                                                                action: 'edit',
                                                            })
                                                        "
                                        >
                                            <PencilIcon
                                                class="flex h-5 w-5 justify-start hover:text-primary-600"
                                            />
                                            <span> Edit </span>
                                        </Button>

                                        <Button
                                            v-if="row.profile_status === 'Complete'"
                                            class="m-0 flex w-full items-center justify-start gap-2 bg-transparent py-2 pl-1 text-darkslategrey-800 hover:bg-gray-100"
                                            @click="
                                                            handleRowAction({
                                                                index,
                                                                rowData: row,
                                                                action: 'change-status',
                                                            })
                                                        "
                                        >
                                            <SvgIcon name="status" height="16px" width="16px" />
                                            <span class="pl-1"> Change Status </span>
                                        </Button>

                                        <Button
                                            v-if="row.profile_status === 'Complete'"
                                            class="m-0 flex w-full items-center justify-start gap-2 bg-transparent py-2 pl-1 text-darkslategrey-800 hover:bg-gray-100"
                                            @click="
                                                            handleRowAction({
                                                                index,
                                                                rowData: row,
                                                                action: 'employee-timeline',
                                                            })
                                                        "
                                        >
                                            <SvgIcon
                                                name="timeline"
                                                height="16px"
                                                width="16px"
                                            />
                                            <span class="pl-1"> Employee Timeline </span>
                                        </Button>
                                    </div>
                                </template>
                            </Popover>
                        </div>
                    </div>
                </template>
            </DataTable>
        </div>
        <!--    This component we might keep for future development    -->
        <!--        <EmployeeInfoModal-->
        <!--            :show-modal="isDetailsModalOpen"-->
        <!--            @close="closeDetailsModal"-->
        <!--            :single-employee="props.singleEmployee"-->
        <!--            :basic-information="props.basicInformation"-->
        <!--            :official-information="props.officialInformation"-->
        <!--            :educational-information="props.educationalInformation"-->
        <!--            :professional-experience-information="-->
        <!--                props.professionalExperienceInformation-->
        <!--            "-->
        <!--            :work-location-information="props.workLocationInformation"-->
        <!--        />-->
        <EmployeeQuickView
            :show-modal="isDetailsModalOpen"
            :single-employee="props.singleEmployee"
            :basic-information="props.basicInformation"
            @close="closeDetailsModal"
        />
        <StatusChange
            @close="closeStatusChangeModal"
            :isModalOpen="changeStatusModalOpen"
            :single-employee="props.singleEmployee"
        />
        <EmploymentListFilter
            :is-modal-open="isFilterModalOpen"
            :designations="props.designations"
            :departments="props.departments"
            @close="isFilterModalOpen = false"
            @filter-apply="applyFilters"
        />
    </div>
</template>
