<script setup lang="ts">
import { Department } from '@/App/Interfaces/departments';
import { Designation } from '@/App/Interfaces/designations';
import { formatIsoDateToReadable } from '@/App/Utils/timeAndDateFormatter';
import DataTable from '@/Components/Others/DataTable.vue';
import SwitchInput from '@/Components/Others/SwitchInput.vue';
import PageHeader from '@/Components/PageHeader.vue';
import DesignationDetails from '@Components/Pages/Designation/Details.vue';
import DesignationFilters from '@Components/Pages/Designation/Filters.vue';
import DesignationForm from '@Components/Pages/Designation/Form.vue';
import { Head, router } from '@inertiajs/vue3';
import { Button } from '@softzino/st-uikit';
import { vTooltip } from 'floating-vue';
import 'floating-vue/dist/style.css';
import { computed, onMounted, ref } from 'vue';

interface Filters {
  status: 'All' | 'Active' | 'Inactive';
  department: number;
}

interface Props {
  data: {
    designations: Designation[];
    departments: Department[];
    designation?: Designation;
  };
}

const props = defineProps<Props>();

const breadCrumbs = [
  { name: 'Dashboard', routeName: 'dashboard' },
  { name: 'Designation Management', routeName: 'designations.index' },
];

const columns = [
  { label: 'Designation Title', key: 'name' },
  { label: 'Department', key: 'departments' }, // Access nested name directly
  { label: 'Number of Employees', key: 'total_employees' },
  { label: 'Last Modified At', key: 'last_modified_at', sortable: true },
  { label: 'Supervisor', key: 'supervisor' }, // Access supervisor name
  { label: 'Created By', key: 'created_by' },
  { label: 'Status', key: 'status' },
];

const isFormModalOpen = ref(false);
const isDetailsModalOpen = ref(false);
const actionableDesignation = ref<null | Designation>(null);
const isFilterModalOpen = ref(false);
const filters = ref<Filters | null>(null);

const filteredDesignations = computed(() => {
  if (!filters.value) return props.data.designations;

  return props.data.designations.filter((des) => {
    const matchesStatus =
      !filters.value?.status ||
      filters.value?.status === 'All' ||
      des.status === filters.value?.status;

    const matchesDepartment =
      !filters.value?.departments ||
      des.departments.some((dept) => {
        return dept.id === filters.value?.departments;
      });

    return matchesStatus && matchesDepartment;
  });
});

const departmentsTransformed = computed(() =>
  props.data.departments.map((item) => ({
    value: item.id,
    label: item.name,
  })),
);

const handleRowAction = async (payload: {
  index: number;
  rowData: Designation;
  action: 'view' | 'edit';
}) => {
  if (payload.action === 'view') {
    router.visit(`designations/${payload.rowData.id}`, {
      preserveScroll: true,
    });
  } else {
    actionableDesignation.value = payload.rowData;
    isFormModalOpen.value = true;
  }
};

const closeActionModal = () => {
  actionableDesignation.value = null;
  isDetailsModalOpen.value = false;
  isFormModalOpen.value = false;
};

const closeDetailsModal = () => {
  isDetailsModalOpen.value = false;
  router.visit(route('designations.index'));
};

function changeStatus(id: number) {
  router.visit(`designations/${id}/toggle-status`, {
    preserveScroll: true,
    method: 'get',
  });
}

function handleFilterButtonClick() {
  isFilterModalOpen.value = true;
}

function applyFilters(filterValue: Filters) {
  filters.value = filterValue;
  isFilterModalOpen.value = false;
}

onMounted(() => {
  if (props.data.designation) {
    isDetailsModalOpen.value = true;
  }
});
</script>

<template>
  <div>
    <Head title="Designations" />

    <PageHeader
      title="Designation Management"
      subtitle="Manage your designation information here."
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
            @click="isFormModalOpen = true"
          >
            Create Designation
          </Button>
        </div>
      </template>
    </PageHeader>

    <div class="table-container mt-6">
      <DataTable
        :table-title="'Designation'"
        :columns="columns"
        :selection-mode="'multiple'"
        :values="filteredDesignations"
        :showExtraActions="false"
        @row-action="handleRowAction"
        @filter-click="handleFilterButtonClick"
      >
        <template #table-col-last_modified_at="{ rowData }">
          {{ formatIsoDateToReadable(rowData?.last_modified_at) }}
        </template>

        <template #table-col-departments="{ rowData }">
          <div class="my-3 flex w-full flex-wrap gap-2">
            <template v-for="item in rowData?.departments" :key="item">
              <div
                class="flex max-w-full items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-700"
              >
                {{ item.name }}
              </div>
            </template>
          </div>
        </template>

        <template #table-col-supervisor="{ rowData }">
          {{ rowData?.supervisor?.name }}
        </template>

        <template #table-col-status="{ rowData }">
          <div
            class="wrapper"
            v-tooltip="rowData.status === 'Active' ? 'Enabled' : 'Disabled'"
          >
            <SwitchInput
              :checked="rowData.status === 'Active'"
              @change="changeStatus(rowData.id)"
            />
          </div>
        </template>
      </DataTable>
    </div>

    <DesignationForm
      :designation="actionableDesignation"
      :departments="departmentsTransformed"
      :designations="data.designations"
      :is-modal-open="isFormModalOpen"
      @close="closeActionModal"
    />

    <DesignationDetails
      v-if="data.designation"
      :is-modal-open="isDetailsModalOpen"
      :designation="data.designation"
      @close="closeDetailsModal"
    />

    <DesignationFilters
      :is-modal-open="isFilterModalOpen"
      :departments="departmentsTransformed"
      @close="isFilterModalOpen = false"
      @filter-apply="applyFilters"
    />
  </div>
</template>
