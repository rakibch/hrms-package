<script setup lang="ts">
import Dropdown from '@/Components/Others/Dropdown.vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { Button, Label, ModalDialog, RadioGroup } from '@softzino/st-uikit';
import { ref } from 'vue';

interface Filters {
  status: 'All' | 'Active' | 'Inactive';
  departments: number[];
}

interface Props {
  isModalOpen: boolean;
  departments: [];
}

const props = defineProps<Props>();

const emits = defineEmits<{
  (e: 'close'): void;
  (e: 'filter-apply', filters: Filters): void;
}>();

const filters = ref<Filters>({
  status: 'All',
  departments: [],
});

const statusOptions = ref(['All', 'Active', 'Inactive']);

const tempFilters = ref<Filters>({
  status: 'All',
  departments: [],
});

function applyFilter() {
  filters.value = { ...tempFilters.value };
  emits('filter-apply', filters.value);
}
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
        <div class="w-[500px] px-2 text-left">
          <div class="mb-5">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold text-gray-800">Filter</h3>

              <button @click="emits('close')">
                <XMarkIcon class="h-6 w-6 text-error-500" />
              </button>
            </div>
            <p class="text-left text-sm text-gray-600">
              You are about to filter
            </p>
          </div>
        </div>

        <div class="px-2">
          <div class="flex items-center justify-between">
            <Label text="Status" :required="false" class="input-label" />

            <div class="flex w-full justify-end">
              <RadioGroup
                v-for="statusOption in statusOptions"
                :key="statusOption"
                :name="statusOption"
                :label="statusOption"
                :value="statusOption"
                v-model="tempFilters.status"
                color="primary"
                size="md"
                class="border-gray-200"
              />
            </div>
          </div>
        </div>

        <hr class="my-4 px-2 text-athens-gray-100" />

        <div class="mt-2 px-2">
          <Dropdown
            label="Department"
            placeholder="Select"
            :options="departments"
            v-model="tempFilters.departments"
            clearable
          />
        </div>

        <div class="mt-5 flex justify-end gap-3">
          <Button class="base-button" type="button" @click="emits('close')">
            Close
          </Button>
          <Button
            :class="['base-button create-button']"
            type="submit"
            @click="applyFilter"
          >
            Apply
          </Button>
        </div>
      </template>
    </ModalDialog>
  </div>
</template>

<style scoped></style>
