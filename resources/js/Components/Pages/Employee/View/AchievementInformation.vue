<script setup lang="ts">
import { defineProps } from 'vue';
const props = defineProps(['educationalInformation','certificationInformation','professionalExperienceInformation']);
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
    <!--    Educational Information  -->
    <div class="mx-48 rounded-xl border border-gray-300 bg-white p-4">
        <div class="mb-2 text-start font-semibold text-gray-800">Educational Information</div>
        <hr class="mb-4" />
        <!-- Education Section -->
        <div class="relative">
            <!-- Vertical Line -->
            <div class="absolute left-5 top-8 w-[2px] bg-gray-100 h-full"></div>
            <div class="flex items-start mb-3 relative" v-for="(item,index) in props.educationalInformation" :key="index">
                <!-- Study Icon -->
                <div class="w-10 h-10 flex items-center justify-center bg-primary-100 rounded-full z-10">
                    <SvgIcon name="date" height="20px" />
                </div>

                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-700 mt-3">{{ item.institution_name }}</p>
                    <div class="mt-2 rounded-lg bg-primary-100 p-3 w-[500px]">
                        <div class="mb-2">
                            <p class="text-sm text-gray-700">Name of Degree:</p>
                            <span class="text-sm font-medium text-primary-800">{{ item.degree }}</span>
                        </div>
                        <div class="mb-2">
                            <p class="text-sm text-gray-700">Subject:</p>
                            <span class="text-sm font-medium text-primary-800">{{ item.field_of_study }}</span>
                        </div>
                        <div class="mb-2">
                            <p class="text-sm text-gray-700">Duration:</p>
                            <span class="text-sm font-medium text-primary-800">
                                {{ formatDate(item.start_date) }} -
                                {{ item.is_running ? 'Continue' : formatDate(item.end_date) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    Professional Experience  Information  -->
    <div class="mx-48 rounded-xl border border-gray-300 bg-white p-4 mt-6">
        <div class="mb-2 text-start font-semibold text-gray-800">Professional Experience</div>
        <hr class="mb-4" />
        <!-- Education Section -->
        <div class="relative">
            <!-- Vertical Line -->
            <div class="absolute left-5 top-8 w-[2px] bg-gray-100 h-full"></div>
            <div class="flex items-start mb-3 relative" v-for="(item,index) in professionalExperienceInformation" :key="index">
                <!-- Study Icon -->
                <div class="w-10 h-10 flex items-center justify-center bg-primary-100 rounded-full z-10">
                    <SvgIcon name="date" height="20px" />
                </div>

                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-700 mt-3">{{ item.institution_name }}</p>
                    <div class="mt-2 rounded-lg bg-primary-100 p-3 w-[500px]">
                        <div class="mb-2">
                            <p class="text-sm text-gray-700">Designation:</p>
                            <span class="text-sm font-medium text-primary-800">{{ item.designation }}</span>
                        </div>
                        <div class="mb-2">
                            <p class="text-sm text-gray-700">Duration:</p>
                            <span class="text-sm font-medium text-primary-800">{{ item.start_date }}-{{ item.end_date }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    Certification  Information  -->
    <div class="mx-48 rounded-xl border border-gray-300 bg-white p-4 mt-6">
        <div class="mb-2 text-start font-semibold text-gray-800">Certification</div>
        <hr class="mb-4" />
        <!-- Education Section -->
        <div class="relative">
            <!-- Vertical Line -->
            <div class="absolute left-5 top-8 w-[2px] bg-gray-100 h-full"></div>
            <div class="flex items-start mb-3 relative" v-for="(item,index) in certificationInformation" :key="index">
                <!-- Study Icon -->
                <div class="w-10 h-10 flex items-center justify-center bg-primary-100 rounded-full z-10">
                    <SvgIcon name="date" height="20px" />
                </div>

                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-700 mt-3">{{ item.issuing_organization }}</p>
                    <div class="mt-2 rounded-lg bg-primary-100 p-3 w-[500px]">
                        <div class="mb-2">
                            <p class="text-sm text-gray-700">Course Name:</p>
                            <span class="text-sm font-medium text-primary-800">{{ item.course_name }}</span>
                        </div>
                        <div class="mb-2">
                            <p class="text-sm text-gray-700">Duration:</p>
                            <span class="text-sm font-medium text-primary-800">{{ formatDate(item.start_date) }} - {{ formatDate(item.completion_date) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style></style>
