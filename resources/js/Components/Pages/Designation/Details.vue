<script setup lang="ts">
import { Designation } from '@/App/Interfaces/designations';
import EmployeeCard from '@/Components/Others/EmployeeCard.vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { ModalDialog } from '@softzino/st-uikit';

defineProps<{
  designation: Designation;
  isModalOpen: boolean;
}>();

const emits = defineEmits<{
  (e: 'close'): void;
}>();
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
        <div class="mr-3 w-[500px] text-left">
          <div class="mb-5">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold text-gray-800">
                Designation Details
              </h3>

              <button @click="emits('close')">
                <XMarkIcon class="h-6 w-6 text-error-500" />
              </button>
            </div>
            <p class="text-left text-sm text-gray-600">
              Check out the designation details.
            </p>
          </div>

          <div class="flex justify-between text-gray-800">
            <p class="">Designation Name</p>
            <p class="font-medium">
              {{ designation.name }}
            </p>
          </div>

          <hr class="my-4 text-athens-gray-100" />

          <div class="text-gray-800">
            <div class="text-sm font-normal text-gray-600">Departments</div>
            <div class="my-3 flex w-full flex-wrap gap-2">
              <template v-for="item in designation.departments" :key="item">
                <div
                  class="flex max-w-full items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-700"
                >
                  {{ item.name }}
                </div>
              </template>
            </div>
          </div>

          <hr class="my-4 text-athens-gray-100" />

          <div class="flex justify-between text-gray-800">
            <p class="text-sm font-normal text-gray-600">Total Employee</p>
            <p class="font-medium">
              {{ designation.total_employees }}
            </p>
          </div>

          <hr class="my-4 text-athens-gray-100" />

          <div>
            <p class="text-sm font-normal leading-5 text-gray-600">
              Reporting Designation
            </p>

            <p class="text-sm font-medium leading-5 text-gray-800">
              {{ designation?.supervisor?.name }}
            </p>
          </div>

          <hr class="my-4 text-athens-gray-100" />

          <div
            class="flex justify-between pt-4 font-inter text-xs font-medium leading-5 text-gray-800"
          >
            <p>Employee Name</p>
            <p>Designation</p>
          </div>

          <EmployeeCard
            v-for="employee in designation.employees"
            :key="employee.id"
            :employee="{
              ...employee,
              avatar: '/images/sample-image.jpeg',
            }"
          />
        </div>
      </template>
    </ModalDialog>
  </div>
</template>

<style scoped></style>
