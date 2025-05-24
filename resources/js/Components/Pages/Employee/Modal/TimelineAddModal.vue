<script setup lang="ts">
import { showToast } from '@/App/Utils';
import TextAreaField from '@/Components/Others/TextAreaField.vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { router, usePage } from '@inertiajs/vue3';
import { Button, Label, ModalDialog,Select } from "@softzino/st-uikit";
import { employmentEvent } from "@/App/Utils/const";
import { ref } from 'vue';

interface Filters {
    status: string;
    remarks: string;
}

interface Props {
    isModalOpen: boolean;
    singleEmployee: any;
}

const props = defineProps<Props>();

const emits = defineEmits<{
    (e: 'close'): void;
}>();

const filters = ref<Filters>({
    status: '',
    remarks: '',
});

const statusOptions = ref(employmentEvent);
const isConfirmModalOpen = ref(false);

function applyFilter() {
    isConfirmModalOpen.value = true;
}
const page = usePage();
const confirmApplyFilter = () => {
    const url = route('employee.update.status', {
        employee: props.singleEmployee.id,
    });

    router.post(
        url,
        {
            status: filters.value.status,
            remarks: filters.value.remarks,
        },
        {
            onSuccess: () => {
                const successMessage = page.props.flash?.success;
                if (successMessage) {
                    showToast('success', successMessage, 3000, 'top-right');
                }
                isConfirmModalOpen.value = false;
            },
            onError: () => {
                if (page.props?.errors) {
                    showToast(
                        'error',
                        'Something went wrong!',
                        3000,
                        'top-right',
                    );
                }
            },
        },
    );
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
                    <div class="mb-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">
                                Add Employment Event
                            </h3>

                            <button @click="emits('close')">
                                <XMarkIcon class="h-6 w-6 text-error-500" />
                            </button>
                        </div>
                        <p class="text-left text-sm text-gray-600">
                            You are about to add employment event for employee.
                        </p>
                        <!-- Profile Section -->
                        <div class="mt-3 flex items-center space-x-4">
                            <img
                                class="option-avatar h-10 w-10 rounded-full"
                                src="https://img.freepik.com/free-vector/smiling-young-man-illustration_1308-173524.jpg?t=st=1739854185~exp=1739857785~hmac=a3427d7d7e6b2808a3ca49f42de0c742b8ae92eecfd3ea06674656c2433bac79&w=900"
                            />
                            <!-- Employee Name & Designation -->
                            <div class="flex flex-col">
                                <span
                                    class="text-md font-semibold text-gray-700"
                                >
                                    {{ props.singleEmployee.fullName }}
                                </span>
                                <span class="text-sm text-gray-600">
                                    {{ props.singleEmployee.designation }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4 text-athens-gray-100" />
                <div class="flex flex-col ml-1 mr-1">
                    <Label
                        text="Change Status"
                        :required="true"
                        class="input-label text-left"
                    />
                    <Select
                        :required="true"
                        :options="statusOptions"
                        placeholder="Select"
                        v-model="filters.status"
                        clearable
                        class="input mt-1.5"
                    />
                    <Label
                        text="Remarks"
                        :required="false"
                        class="input-label text-left mt-2"
                    />
                    <TextAreaField
                        id="description"
                        placeholder="Write a remarks for this employee..."
                        :rows="7"
                        :cols="50"
                        :required="true"
                        v-model="filters.remarks"
                    />
                </div>
                <div class="mt-5 flex justify-end gap-3">
                    <Button
                        class="base-button"
                        type="button"
                        @click="emits('close')"
                    >
                        Close
                    </Button>
                    <Button
                        :class="['base-button create-button']"
                        type="submit"
                        @click="applyFilter"
                    >
                        Change
                    </Button>
                </div>
            </template>
        </ModalDialog>

        <!-- Confirmation Modal -->
        <ModalDialog
            :isOpen="isConfirmModalOpen"
            :disableOutSideClick="true"
            :showIcon="false"
            dialogType="alert"
            layoutClasses="w-96"
            @modal-close="isConfirmModalOpen = false"
        >
            <template #content>
                <div class="relative text-left">
                    <!-- Close Button (X Icon) -->
                    <button
                        @click="isConfirmModalOpen = false"
                        class="absolute right-0 top-0"
                    >
                        <XMarkIcon class="h-6 w-6 text-error-500" />
                    </button>

                    <!-- Modal Title -->
                    <h3 class="text-lg font-semibold text-gray-800">
                        Change Employment Status
                    </h3>

                    <!-- Modal Description -->
                    <p class="mt-3 text-sm text-gray-600">
                        You are about to change employment status. Are you sure
                        to <br />change employment status? You can change the
                        status again.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="mt-5 flex justify-end gap-3">
                    <!-- Cancel Button -->
                    <Button
                        class="text-md rounded-md border border-[#FDA29B] bg-white px-5 py-3 font-medium text-[#B42318] hover:bg-[#FECDCA]"
                        @click="isConfirmModalOpen = false"
                    >
                        Cancel
                    </Button>
                    <!-- Confirm Button -->
                    <Button
                        class="text-md rounded-md border border-success-200 bg-success-50 px-5 py-3 font-medium text-success-700 hover:bg-success-700 hover:text-white"
                        type="submit"
                        @click="confirmApplyFilter"
                    >
                        Confirm
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
