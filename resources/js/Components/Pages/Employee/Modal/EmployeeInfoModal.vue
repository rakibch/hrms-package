<script setup lang="ts">
import { defineEmits, defineProps, ref } from 'vue';

const props = defineProps<{
    showModal: boolean;
    singleEmployee: any;
    basicInformation: any;
    officialInformation: any;
    educationalInformation: any;
    professionalExperienceInformation: any;
    workLocationInformation: any;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const emitClose = () => {
    emit('close');
};

const isAccordionOpen = ref({
    leaveInformation: false,
    basicInformation: false,
    officialInformation: false,
    educationalInformation: false,
    professionalExpInformation: false,
    workLocationInformation: false,
});

function toggleAccordion(section: string) {
    isAccordionOpen.value = {
        ...isAccordionOpen.value,
        [section]: !isAccordionOpen.value[section],
    };
}

const formatDate = (dateString: any) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>
<template>
    <Transition name="fade">
        <div
            v-if="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        >
            <div
                class="relative max-h-[90vh] w-full max-w-3xl overflow-auto rounded-lg bg-white shadow-lg sm:w-2/4"
            >
                <div
                    class="relative flex h-[140px] flex-col justify-center rounded-t-lg bg-gray-800 p-4 text-white"
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
                        src="https://plus.unsplash.com/premium_photo-1668902223894-053948883caa?q=80&w=2960&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
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
                <div class="mt-2 flex justify-center space-x-3">
                    <div
                        class="rounded-md border px-2 py-1 text-sm text-gray-700"
                    >
                        {{ props.singleEmployee.employeeNo }}
                    </div>
                    <div
                        class="rounded-md border px-2 py-1 text-sm text-gray-700"
                    >
                        {{ props.singleEmployee.department }}
                    </div>
                    <div
                        class="rounded-md border px-2 py-1 text-sm text-gray-700"
                    >
                        {{ props.singleEmployee.designation }}
                    </div>
                    <div
                        class="rounded-md border px-2 py-1 text-sm text-gray-700"
                    >
                        {{ props.singleEmployee.jobType }}
                    </div>
                </div>
                <div class="ml-5 mr-5 mt-6 flex justify-center">
                    <button
                        class="w-full rounded-md border-2 border-transparent bg-primary-600 px-6 py-3 font-semibold text-white transition duration-200 hover:border-gray-100 hover:bg-transparent hover:text-black"
                    >
                        Edit Information
                    </button>
                </div>

                <div
                    class="ml-5 mr-5 mt-6 cursor-pointer rounded-lg border border-error-200 bg-error-25 px-6 py-3"
                >
                    <div
                        @click="toggleAccordion('leaveInformation')"
                        class="flex items-center justify-between"
                    >
                        <div class="text-lg font-semibold text-gray-800">
                            Leave Information
                        </div>
                        <div class="flex items-center">
                            <SvgIcon
                                :name="
                                    isAccordionOpen.leaveInformation
                                        ? 'circle-minus'
                                        : 'circle-plus'
                                "
                                width="20px"
                                height="20px"
                            />
                        </div>
                    </div>
                    <div
                        v-show="isAccordionOpen.leaveInformation"
                        class="ml-5 mr-5 mt-3 px-6 py-3"
                    >
                        <p><strong>Name:</strong> John Smith</p>
                        <p><strong>Email:</strong> john.smith@example.com</p>
                        <p><strong>Leave Balance:</strong> 20 days</p>
                        <!-- Add more information as needed -->
                    </div>
                </div>

                <div
                    class="ml-5 mr-5 mt-2 cursor-pointer border-b-2 border-gray-100 px-6 py-3"
                >
                    <div
                        @click="toggleAccordion('basicInformation')"
                        class="flex items-center justify-between"
                    >
                        <div class="text-lg font-semibold text-gray-800">
                            Basic Information
                        </div>
                        <div class="flex items-center">
                            <SvgIcon
                                :name="
                                    isAccordionOpen.basicInformation
                                        ? 'circle-minus'
                                        : 'circle-plus'
                                "
                                width="20px"
                                height="20px"
                            />
                        </div>
                    </div>
                </div>
                <div
                    v-show="isAccordionOpen.basicInformation"
                    class="ml-5 mr-5 mt-3 border-b-2 border-gray-100 px-6 py-3"
                >
                    <p class="font-semibold">Personal Info:</p>
                    <div class="mt-2 grid grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Date of Birth:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                formatDate(props.basicInformation.dob)
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">Gender:</span>
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.gender
                            }}</span>
                        </div>

                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">Religion:</span>
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.religion
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Blood Group:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.bloodGroup
                            }}</span>
                        </div>
                    </div>

                    <p class="mt-2 font-semibold">Contact Info:</p>
                    <div class="mt-2 grid grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Personal Phone Number:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.personalContactNo
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Personal Email Address:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.personalEmail
                            }}</span>
                        </div>
                    </div>

                    <p class="mt-2 font-semibold">Present Address:</p>
                    <div class="mt-2 grid grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">Country:</span>
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.presentCountry
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">City:</span>
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.presentCity
                            }}</span>
                        </div>

                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Street Address:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.presentStreetAddress
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >State/Province:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.presentState
                            }}</span>
                        </div>

                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">Postcode:</span>
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.presentPostalCode
                            }}</span>
                        </div>
                    </div>

                    <p class="mt-2 font-semibold">Family Information's:</p>
                    <div class="mt-2 grid grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Father's Name:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.fatherName
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Mother's Name:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.motherName
                            }}</span>
                        </div>

                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Marital Status:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.maritalStatus
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Spouse Name:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.spouseName
                            }}</span>
                        </div>
                    </div>

                    <p class="mt-2 font-semibold">
                        Emergency Contact Information's:
                    </p>
                    <div class="mt-2 grid grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Emergency Contact Person:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.emContactName
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Emergency Contact No:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.emContactPhone
                            }}</span>
                        </div>

                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">Relation:</span>
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.emContactRelationship
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">Country:</span>
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.emContactCountry
                            }}</span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">City:</span>
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.emContactCity
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Street Address:</span
                            >
                            <span class="text-sm text-gray-800"
                                >{{ props.basicInformation.emContactStreet }}
                            </span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >State/Province:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.emContactState
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Post Code:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.basicInformation.emContactPostalCode
                            }}</span>
                        </div>
                    </div>
                </div>

                <div
                    class="ml-5 mr-5 mt-2 cursor-pointer border-b-2 border-gray-100 px-6 py-3"
                >
                    <div
                        @click="toggleAccordion('officialInformation')"
                        class="flex items-center justify-between"
                    >
                        <div class="text-lg font-semibold text-gray-800">
                            Official Information
                        </div>
                        <div class="flex items-center">
                            <SvgIcon
                                :name="
                                    isAccordionOpen.officialInformation
                                        ? 'circle-minus'
                                        : 'circle-plus'
                                "
                                width="20px"
                                height="20px"
                            />
                        </div>
                    </div>
                </div>
                <div
                    v-show="isAccordionOpen.officialInformation"
                    class="ml-5 mr-5 mt-3 border-b-2 border-gray-100 px-6 py-3"
                >
                    <p class="font-semibold">Official Info:</p>
                    <div class="mt-2 grid grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Department:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.officialInformation.officialDepartment
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Designation:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.officialInformation.officialDesignation
                            }}</span>
                        </div>

                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Employee Type:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.officialInformation.officialEmploymentType
                            }}</span>
                        </div>
                    </div>
                    <p class="mt-2 font-semibold">Contact Info:</p>
                    <div class="mt-2 grid grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Phone Number(Official):</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.officialInformation.officialContactNo
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Phone Number(Official):</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.officialInformation.officialEmail
                            }}</span>
                        </div>
                    </div>
                </div>

                <div
                    class="ml-5 mr-5 mt-2 cursor-pointer border-b-2 border-gray-100 px-6 py-3"
                >
                    <div
                        @click="toggleAccordion('educationalInformation')"
                        class="flex items-center justify-between"
                    >
                        <div class="text-lg font-semibold text-gray-800">
                            Educational Information
                        </div>
                        <div class="flex items-center">
                            <SvgIcon
                                :name="
                                    isAccordionOpen.educationalInformation
                                        ? 'circle-minus'
                                        : 'circle-plus'
                                "
                                width="20px"
                                height="20px"
                            />
                        </div>
                    </div>
                </div>
                <div
                    v-show="isAccordionOpen.educationalInformation"
                    class="ml-5 mr-5 mt-3 border-b-2 border-gray-100 px-6 py-3"
                >
                    <div v-if="props.educationalInformation.length > 0">
                        <div
                            v-for="(
                                eduItem, index
                            ) in props.educationalInformation"
                            :key="index"
                            class="grid grid-cols-2 gap-4"
                            :class="{
                                'mb-3 border-b border-gray-200 pb-3':
                                    index !==
                                    props.educationalInformation.length - 1,
                            }"
                        >
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-800">{{
                                    eduItem.institution_name
                                }}</span>
                                <span class="text-sm text-gray-600">{{
                                    eduItem.degree
                                }}</span>
                            </div>
                            <div class="flex flex-col">
                                <p
                                    class="inline-flex items-center text-sm text-gray-500"
                                >
                                    <span class="pl-1 text-gray-800"
                                        >Start:
                                        {{ formatDate(eduItem.start_date) }} -
                                        End:
                                        {{ formatDate(eduItem.end_date) }}</span
                                    >
                                </p>
                            </div>
                        </div>
                    </div>
                    <div v-else></div>
                </div>

                <div
                    class="ml-5 mr-5 mt-2 cursor-pointer border-b-2 border-gray-100 px-6 py-3"
                >
                    <div
                        @click="toggleAccordion('professionalExpInformation')"
                        class="flex items-center justify-between"
                    >
                        <div class="text-lg font-semibold text-gray-800">
                            Professional Experience Information
                        </div>
                        <div class="flex items-center">
                            <SvgIcon
                                :name="
                                    isAccordionOpen.professionalExpInformation
                                        ? 'circle-minus'
                                        : 'circle-plus'
                                "
                                width="20px"
                                height="20px"
                            />
                        </div>
                    </div>
                </div>
                <div
                    v-show="isAccordionOpen.professionalExpInformation"
                    class="ml-5 mr-5 mt-3 border-b-2 border-gray-100 px-6 py-3"
                >
                    <div
                        v-if="
                            props.professionalExperienceInformation.length > 0
                        "
                    >
                        <div
                            v-for="(
                                pExpItem, index
                            ) in props.professionalExperienceInformation"
                            :key="index"
                            class="grid grid-cols-2 gap-4"
                            :class="{
                                'mb-3 border-b border-gray-200 pb-3':
                                    index !==
                                    props.professionalExperienceInformation
                                        .length -
                                        1,
                            }"
                        >
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-800">{{
                                    pExpItem.institution_name
                                }}</span>
                                <span class="text-sm text-gray-600">{{
                                    pExpItem.designation
                                }}</span>
                            </div>
                            <div class="flex flex-col">
                                <p
                                    class="inline-flex items-center text-sm text-gray-500"
                                >
                                    <span class="pl-1 text-gray-800"
                                        >Start:
                                        {{ formatDate(pExpItem.start_date) }} -
                                        End:
                                        {{
                                            formatDate(pExpItem.end_date)
                                        }}</span
                                    >
                                </p>
                            </div>
                        </div>
                    </div>
                    <div v-else></div>
                </div>

                <div
                    class="ml-5 mr-5 mt-2 flex items-center justify-between border-b-2 border-gray-100 px-6 py-3"
                >
                    <div class="text-lg font-semibold text-gray-800">
                        Certification Experience
                    </div>
                    <div class="flex items-center">
                        <SvgIcon
                            name="circle-plus"
                            width="20px"
                            height="20px"
                        />
                    </div>
                </div>
                <div
                    class="ml-5 mr-5 mt-2 cursor-pointer border-b-2 border-gray-100 px-6 py-3"
                >
                    <div
                        @click="toggleAccordion('workLocationInformation')"
                        class="flex items-center justify-between"
                    >
                        <div class="text-lg font-semibold text-gray-800">
                            Location
                        </div>
                        <div class="flex items-center">
                            <SvgIcon
                                :name="
                                    isAccordionOpen.workLocationInformation
                                        ? 'circle-minus'
                                        : 'circle-plus'
                                "
                                width="20px"
                                height="20px"
                            />
                        </div>
                    </div>
                </div>
                <div
                    v-show="isAccordionOpen.workLocationInformation"
                    class="ml-5 mr-5 mt-3 border-b-2 border-gray-100 px-6 py-3"
                >
                    <div class="flex justify-between items-center">
                        <p class="font-semibold">Working Location:</p>
                        <div class="flex items-center gap-2 cursor-pointer">
                            <SvgIcon name="map" width="15px" height="15px"/>
                            <p class="font-semibold text-gray-700">View Map</p>
                        </div>
                    </div>
                    <div class="mt-2 grid grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">Country:</span>
                            <span class="text-sm text-gray-800">{{
                                props.workLocationInformation.wLocationCountry
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">City:</span>
                            <span class="text-sm text-gray-800">{{
                                props.workLocationInformation.wLocationCity
                            }}</span>
                        </div>

                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >Street Address:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.workLocationInformation.wLocationStreet
                            }}</span>
                        </div>

                        <!-- Right Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600"
                                >State/Province:</span
                            >
                            <span class="text-sm text-gray-800">{{
                                props.workLocationInformation.wLocationState
                            }}</span>
                        </div>

                        <!-- Left Column -->
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">PostCode:</span>
                            <span class="text-sm text-gray-800">{{
                                props.workLocationInformation.wLocationPostalCode
                            }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>
