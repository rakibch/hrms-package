<script setup lang="ts">
import { Department } from '@/App/Interfaces/departments';
import { Employee } from '@/App/Interfaces/employees';
import DataTable from '@/Components/Others/DataTable.vue';
import SwitchInput from '@/Components/Others/SwitchInput.vue';
import PageHeader from '@/Components/PageHeader.vue';
import DepartmentDetails from '@/Components/Pages/Department/Details.vue';
import DepartmentFilters from '@/Components/Pages/Department/Filters.vue';
import DepartmentForm from '@/Components/Pages/Department/Form.vue';
import { formatIsoDateToReadable } from '@App/Utils/timeAndDateFormatter';
import { Head, router } from '@inertiajs/vue3';
import { Button } from '@softzino/st-uikit';
import { vTooltip } from 'floating-vue';
import 'floating-vue/dist/style.css';
import { computed, onMounted, ref } from 'vue';

interface Props {
    departments: Department[];
    employees: Employee[];
    department: any;
}

interface Filters {
    status: 'All' | 'Active' | 'Inactive';
}

const props = defineProps<Props>();

const breadCrumbs = [
    { name: 'Dashboard', routeName: 'dashboard' },
    { name: 'Department Management', routeName: 'departments.index' },
];

const columns = [
    { label: 'Department Title', key: 'name' },
    { label: 'Number of Designation', key: 'designations_count' },
    { label: 'Number of Employees', key: 'employees_count' },
    { label: 'Last Modified at', key: 'updated_at', sortable: true },
    { label: 'Department Head', key: 'department_head' },
    { label: 'Created By', key: 'created_by' },
    { label: 'Status', key: 'status' },
];

const isFormModalOpen = ref(false);
const isDetailsModalOpen = ref(false);
const isFilterModalOpen = ref(false);
const filters = ref<Filters | null>(null);
const actionableDepartment = ref<null | Department>(null);

const filteredDepartments = computed(() => {
    if (!filters.value) return props.departments;

    return props.departments.filter((department) => {
        return (
            department.status === filters.value?.status ||
            filters.value?.status === 'All'
        );
    });
});

const openModal = () => (isFormModalOpen.value = true);

const handleRowAction = async (payload: {
    index: number;
    rowData: Department;
    action: 'view' | 'edit';
}) => {
    if (payload.action === 'view') {
        router.visit(`departments/${payload.rowData.id}`, {
            preserveScroll: true,
        });
    } else {
        actionableDepartment.value = payload.rowData;
        isFormModalOpen.value = true;
    }
};

const closeActionModal = () => {
    actionableDepartment.value = null;
    isFormModalOpen.value = false;
};

const closeDetailsModal = () => {
    isDetailsModalOpen.value = false;
    router.visit(route('departments.index'));
};

function handleFilterButtonClick() {
    isFilterModalOpen.value = true;
}

function changeStatus(id: number) {
    route('departments.toggle-status', id);
    router.visit(`departments/${id}/toggle-status`, {
        preserveScroll: true,
        method: 'patch',
    });
}

function applyFilters(filterValue: Filters) {
    filters.value = filterValue;
    isFilterModalOpen.value = false;
}

onMounted(() => {
    if (props.department) {
        isDetailsModalOpen.value = true;
    }
});
</script>

<template>
    <div>
        <Head title="Departments" />

        <PageHeader
            title="Department Management"
            subtitle="Manage your department information here."
            :bread-crumbs="breadCrumbs"
        >
            <template #rightSideContent>
                <div class="flex gap-3">
                    <Button class="base-button">
                        <SvgIcon name="upload-01" />
                        Import
                    </Button>
                    <Button
                        class="base-button create-button"
                        @click="openModal"
                    >
                        Create Department
                    </Button>
                </div>
            </template>
        </PageHeader>

        <div class="table-container mt-6">
            <DataTable
                :table-title="'Departments'"
                :columns="columns"
                :selection-mode="'multiple'"
                :values="filteredDepartments"
                :total-value="total"
                @row-action="handleRowAction"
                @filter-click="handleFilterButtonClick"
            >
                <template #table-col-updated_at="{ rowData }">
                    {{ formatIsoDateToReadable(rowData?.updated_at) }}
                </template>
                <template #table-col-department_head="{ rowData }">
                    {{ rowData?.department_head?.name }}
                </template>
                <template #table-col-status="{ rowData }">
                    <div
                        class="wrapper"
                        v-tooltip="
                            rowData.status === 'Active' ? 'Enabled' : 'Disabled'
                        "
                    >
                        <SwitchInput
                            :checked="rowData.status === 'Active'"
                            @change="changeStatus(rowData.id)"
                        />
                    </div>
                </template>
            </DataTable>
        </div>

        <DepartmentForm
            :department="actionableDepartment"
            :employees="employees"
            :is-modal-open="isFormModalOpen"
            @close="closeActionModal"
        />

        <DepartmentDetails
            v-if="department"
            :is-modal-open="isDetailsModalOpen"
            :department="department"
            @close="closeDetailsModal"
        />

        <DepartmentFilters
            :is-modal-open="isFilterModalOpen"
            @filter-apply="applyFilters"
            @close="isFilterModalOpen = false"
        />
    </div>
</template>
