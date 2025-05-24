<script setup lang="ts">
import { defineProps } from 'vue';
const props = defineProps(['officialInformation']);

const capitalizeWords = (sentence: string): string => {
    return sentence.replace(/\b\w/g, (char) => char.toUpperCase());
};
</script>
<template>
    <!-- Job Type Info -->
    <div class="mx-48 rounded-xl border border-gray-300 bg-white p-4">
        <div class="mb-2 text-start font-semibold text-gray-800">Job Type</div>
        <hr class="mb-4" />

        <div class="mb-4 flex justify-between">
            <div class="w-1/2">
                <p class="text-sm text-gray-600">Job Type</p>
                <p class="text-sm text-gray-800 font-medium">
                    {{ capitalizeWords(props.officialInformation.official_job_type) || '-' }}
                </p>
            </div>
        </div>
    </div>
    <!-- Employment Info -->
    <div class="mx-48 rounded-xl border border-gray-300 bg-white p-4 mt-6">
        <div class="mb-2 text-start font-semibold text-gray-800">Employment Information</div>
        <hr class="mb-4" />

        <div class="mb-4 flex justify-between">
            <div class="w-1/2">
                <p class="text-sm text-gray-600">Department</p>
                <p class="text-sm text-gray-800 font-medium">
                    {{ props.officialInformation.official_department || '-' }}
                </p>
            </div>
            <div class="w-1/2 text-left">
                <p class="text-sm text-gray-600">Designation</p>
                <p class="text-sm text-gray-800 font-medium">
                    {{ props.officialInformation.official_designation || '-' }}
                </p>
            </div>
        </div>
        <div class="mb-4 flex justify-between">
            <div class="w-1/2">
                <p class="text-sm text-gray-600">Employment Type</p>
                <p class="text-sm text-gray-800 font-medium">
                    {{ capitalizeWords(props.officialInformation.official_employment_type) || '-' }}
                </p>
            </div>
        </div>
    </div>
    <!-- Official Contact Info -->
    <div class="mx-48 rounded-xl border border-gray-300 bg-white p-4 mt-6">
        <div class="mb-2 text-start font-semibold text-gray-800">Official Contact</div>
        <hr class="mb-4" />

        <div class="mb-4 flex justify-between">
            <div class="w-1/2">
                <p class="text-sm text-gray-600">Phone Number(Official)</p>
                <p class="text-sm text-gray-800 font-medium">
                    {{ props.officialInformation.official_contact_no || '-' }}
                </p>
            </div>
            <div class="w-1/2 text-left">
                <p class="text-sm text-gray-600">Email(Official)</p>
                <p class="text-sm text-gray-800 font-medium">
                    {{ props.officialInformation.official_email || '-' }}
                </p>
            </div>
        </div>
    </div>
</template>
<style></style>
