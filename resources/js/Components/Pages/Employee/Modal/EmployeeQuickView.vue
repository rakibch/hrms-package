<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Button } from '@softzino/st-uikit';
import { defineEmits, defineProps } from 'vue';
import { route } from 'ziggy-js'

const props = defineProps<{
    showModal: boolean;
    singleEmployee: any;
    basicInformation: any;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const emitClose = () => {
    emit('close');
};

const formatDate = (dateString: any) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const capitalizeWords = (sentence: string): string => {
    return sentence.replace(/\b\w/g, (char) => char.toUpperCase());
};
const viewMoreEmployeeInfo = () => {
    router.visit(`/employee/${props.singleEmployee.id}/view-information`);
};
</script>
<template>
    <Transition name="fade">
        <div
            v-if="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        >
            <div
                class="relative max-h-[90vh] w-full overflow-auto rounded-lg bg-white shadow-lg sm:w-2/4 sm:max-w-lg"
            >
                <div
                    class="relative flex h-[140px] flex-col justify-start rounded-t-lg bg-gray-800 p-4 text-white"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold">
                                Employee Details
                            </h2>
                            <p class="text-md opacity-80">
                                Check out the employee details
                            </p>
                        </div>
                        <button
                            @click="emitClose"
                            class="text-md text-white hover:text-gray-300"
                        >
                            ✕
                        </button>
                    </div>
                    <img
                        :src="singleEmployee.profile_image"
                        alt="Employee"
                        class="absolute left-1/2 top-[100%] h-[96px] w-[96px] -translate-x-1/2 -translate-y-1/2 transform rounded-full border-2 border-white bg-white"
                    />
                </div>
                <p
                    class="pt-16 text-center text-xl font-semibold text-gray-800"
                >
                    {{ props.singleEmployee.fullName }}
                </p>
                <p class="text-center text-base text-gray-500">
                    Joined at: {{ formatDate(props.singleEmployee.joinDate) }}
                </p>
                <div class="mt-2 flex justify-center space-x-1">
                    <div
                        class="rounded-md border px-2 py-1 text-xs text-gray-700"
                    >
                        {{ props.singleEmployee.employeeNo }}
                    </div>
                    <div
                        class="rounded-md border px-2 py-1 text-xs text-gray-700"
                    >
                        {{ props.singleEmployee.department }}
                    </div>
                    <div
                        class="rounded-md border px-2 py-1 text-xs text-gray-700"
                    >
                        {{ props.singleEmployee.designation }}
                    </div>
                    <div
                        class="rounded-md border px-2 py-1 text-xs text-gray-700"
                    >
                        {{ capitalizeWords(props.singleEmployee.jobType) }}
                    </div>
                    <div
                        class="rounded-md border px-2 py-1 text-xs text-gray-700"
                    >
                        {{
                            capitalizeWords(props.singleEmployee.employmentType)
                        }}
                    </div>
                </div>
                <div class="mt-10 px-6 pb-6">
                    <div class="flex justify-between py-1">
                        <span class="text-sm text-gray-600"
                            >Personal Phone Number</span
                        >
                        <span class="text-sm text-gray-800">{{
                            props.basicInformation.personalContactNo
                        }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-sm text-gray-600">Date of Birth</span>
                        <span class="text-sm text-gray-800">{{
                            formatDate(props.basicInformation.dob)
                        }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-sm text-gray-600">Blood Group</span>
                        <span class="text-sm text-gray-800">{{
                            props.basicInformation.bloodGroup
                        }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-sm text-gray-600"
                            >Marital Status</span
                        >
                        <span class="text-sm text-gray-800">{{
                            capitalizeWords(
                                props.basicInformation.maritalStatus,
                            )
                        }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-sm text-gray-600">Religion</span>
                        <span class="text-sm text-gray-800">{{
                            capitalizeWords(props.basicInformation.religion)
                        }}</span>
                    </div>
                    <hr class="mt-2 py-3" />
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600"
                            >Present Address</span
                        >
                        <div class="flex cursor-pointer items-center gap-2">
                            <SvgIcon name="map" width="15px" height="15px" />
                            <p class="font-semibold text-[#4285F5]">View Map</p>
                        </div>
                    </div>
                    <div class="col flex py-3">
                        <span class="text-sm text-gray-800">
                            {{
                                [
                                    basicInformation.presentStreetAddress,
                                    basicInformation.presentState,
                                    basicInformation.presentCity,
                                    basicInformation.presentPostalCode,
                                    basicInformation.presentCountry,
                                ]
                                    .filter(Boolean)
                                    .join(', ')
                            }}
                        </span>
                    </div>

                    <hr class="mt-2 py-3" />
                    <div class="flex justify-end gap-3">
                        <Link
                            class="base-button"
                            :href="route('employee.edit', singleEmployee.id)"
                        >
                            Edit Information
                        </Link>
                        <Button
                            :class="['base-button create-button']"
                            type="submit"
                            @click="viewMoreEmployeeInfo"
                        >
                            View More
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>
