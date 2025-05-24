<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { defineProps,ref,onMounted} from "vue";
import TimelineAddModal from "@/Components/Pages/Employee/Modal/TimelineAddModal.vue";
import { route } from 'ziggy-js';

const props = defineProps<{
    singleEmployee: any;
    timelineRecords: any;
}>();

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

const activeTab = ref("Basic Information");
const changeTimelineModalOpen = ref(false);
const openTimeLineModal = () => {
   changeTimelineModalOpen.value=true;
};

const closeTimeLineModal = () =>{
    changeTimelineModalOpen.value=false;
}

</script>
<template>
    <div>
        <Head title="View Information" />
        <div class="relative">
            <div class="relative bg-gray-800 p-8 flex items-center" style="height: 250px">
                <!-- Profile Image -->
                <div class="absolute top-[100%] transform -translate-y-1/2 translate-x-[-50%]" style="margin-left: 80px;">
                    <img
                        src="https://plus.unsplash.com/premium_photo-1668902223894-053948883caa?q=80&w=2960&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Employee"
                        class="h-[160px] w-[160px] rounded-full border-2 border-white bg-white"
                    />
                </div>

                <div class="text-white flex-1">
                    <p class="text-sm">Employee Management > Employees > Employee Details</p>
                    <p class="font-bold text-xl mt-2">Employee Timeline</p>
                    <p class="text-base">Automatically added every event that happens during the job of an employee</p>
                    <p class="text-xl font-semibold mt-24 ml-44">
                        {{ props.singleEmployee.full_name }}
                    </p>
                </div>
                <div class="mt-40">
                    <Link
                        class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-800 shadow"
                        :href="route('employee.edit', singleEmployee.id)"
                    >
                        Edit Information
                    </Link>
                </div>
            </div>

            <!-- White Section -->
            <div class="bg-white shadow left-4 h-52">
                <p class="text-sm pt-5 ml-52">Joined at: {{ formatDate(props.singleEmployee.join_date) }}</p>
                    <div class="flex justify-start space-x-3 pt-1 ml-52">
                    <div class="rounded-md border px-2 py-1 text-xs text-gray-700">
                        {{ props.singleEmployee.employee_no }}
                    </div>
                    <div class="rounded-md border px-2 py-1 text-xs text-gray-700">
                        {{ props.singleEmployee.department }}
                    </div>
                    <div class="rounded-md border px-2 py-1 text-xs text-gray-700">
                        {{ props.singleEmployee.designation }}
                    </div>
                    <div class="rounded-md border px-2 py-1 text-xs text-gray-700">
                        {{ capitalizeWords(props.singleEmployee.job_type) }}
                    </div>
                    <div class="rounded-md border px-2 py-1 text-xs text-gray-700">
                        {{ capitalizeWords(props.singleEmployee.employment_type) }}
                    </div>
                </div>
            </div>

            <!-- Timeline Section -->
            <div class="p-6">
                <div class="bg-white">
                    <div class="flex flex-col py-3">
                        <div class="flex items-center" style="margin-left: 165px;" @click="openTimeLineModal">
                            <SvgIcon name="plus-circle-gray" width="55px" height="55px" />
                            <p class="text-lg font-semibold text-gray-700 ml-5">Add Employment Event</p>
                        </div>
                        <p class="text-sm text-gray-500 ml-60">
                            Employee timeline refers to an employee's full experience with an organization. From the first
                            <br />
                            contact as a possible recruit to the last day of employment.
                        </p>
                    </div>

                    <div v-for="(item,index) in props.timelineRecords" :key="index">
                        <!-- Timeline List -->
                        <div v-if="item.event=='Join'" class="mt-6 relative ml-4">
                            <!-- Vertical Gray Line -->
                            <div class="absolute left-44 top-0 bottom-0 w-0.5 bg-primary-100"></div>
                            <!-- Timeline Entry 1 -->
                            <div class="flex items-center relative">
                                <!-- Date on Left Side -->
                                <p class="text-gray-700 text-sm font-medium w-32 text-right">{{ item.date }}</p>

                                <!-- SVG Circle in Middle -->
                                <div class="h-12 w-12 bg-primary-100 flex items-center justify-center rounded-full mx-6 z-10 border border-primary-200">
                                    <SvgIcon name="date" width="24px" height="24px" />
                                </div>

                                <!-- Event Text on Right Side -->
                                <div class="bg-gray-50 text-gray-700 px-2 py-1 rounded-md text-sm font-semibold border border-primary-300">
                                    {{ item.event }}
                                </div>
                            </div>

                            <!-- Subtext -->
                            <p class="text-gray-600 text-sm mt-1 ml-56 mb-10 font-semibold">{{ item.description }}</p>
                            <span class="ml-56 mt-1 text-blue-500 text-sm font-semibold"></span>
                        </div>

                        <!-- Timeline List 2-->
                        <div class="relative ml-4" v-if="item.event=='Position Updated'">
                            <!-- Vertical Gray Line -->
                            <div class="absolute left-44 top-0 bottom-0 w-0.5 bg-primary-100"></div>
                            <!-- Timeline Entry 1 -->
                            <div class="flex items-center relative">
                                <!-- Date on Left Side -->
                                <p class="text-gray-700 text-sm font-medium w-32 text-right">{{ item.date }}</p>

                                <!-- SVG Circle in Middle -->
                                <div class="h-12 w-12 bg-primary-100 flex items-center justify-center rounded-full mx-6 z-10 border border-primary-200">
                                    <SvgIcon name="date" width="24px" height="24px" />
                                </div>

                                <!-- Event Text on Right Side -->
                                <div class="bg-blue-50 text-blue-700 px-2 py-1 rounded-md text-sm font-semibold border border-blue-200">
                                    {{ item.event }}
                                </div>
                            </div>

                            <!-- Subtext -->
                            <p class="text-gray-600 text-sm mt-1 ml-56 mb-10 font-semibold">{{ item.description }}</p>
                            <span class="ml-56 mt-1 text-blue-500 text-sm font-semibold mb-10"></span>
                        </div>

                        <!-- Timeline List 3-->
                        <div class="relative ml-4" v-if="item.event=='Promotion'">
                            <!-- Vertical Gray Line -->
                            <div class="absolute left-44 top-0 bottom-0 w-0.5 bg-primary-100"></div>
                            <!-- Timeline Entry 1 -->
                            <div class="flex items-center relative ">
                                <!-- Date on Left Side -->
                                <p class="text-gray-700 text-sm font-medium w-32 text-right">{{ item.date }}</p>

                                <!-- SVG Circle in Middle -->
                                <div class="h-12 w-12 bg-primary-100 flex items-center justify-center rounded-full mx-6 z-10 border border-primary-200">
                                    <SvgIcon name="date" width="24px" height="24px" />
                                </div>

                                <!-- Event Text on Right Side -->
                                <div class="bg-orange-50 text-orange-700 px-2 py-1 rounded-md text-sm font-semibold border border-orange-200">
                                    {{ item.event }}
                                </div>
                            </div>

                            <!-- Subtext -->
                            <p class="text-gray-600 text-sm mt-1 ml-56 mb-10 font-semibold">{{ item.description }}</p>
                            <span class="ml-56 mt-1 text-blue-500 text-sm font-semibold mb-10"></span>
                        </div>

                        <!-- Timeline List 4-->
                        <div class="relative ml-4" v-if="item.event=='Goabroad'">
                            <!-- Vertical Gray Line -->
                            <div class="absolute left-44 top-0 bottom-0 w-0.5 bg-primary-100"></div>
                            <!-- Timeline Entry 1 -->
                            <div class="flex items-center relative ">
                                <!-- Date on Left Side -->
                                <p class="text-gray-700 text-sm font-medium w-32 text-right">{{ item.date }}</p>

                                <!-- SVG Circle in Middle -->
                                <div class="h-12 w-12 bg-primary-100 flex items-center justify-center rounded-full mx-6 z-10 border border-primary-200">
                                    <SvgIcon name="date" width="24px" height="24px" />
                                </div>

                                <!-- Event Text on Right Side -->
                                <div class="bg-primary-50 text-gray-700 px-2 py-1 rounded-md text-sm font-semibold border border-primary-200">
                                    {{ item.event }}
                                </div>
                            </div>

                            <!-- Subtext -->
                            <p class="text-gray-600 text-sm mt-1 ml-56 mb-10 font-semibold"></p>
                            <span class="ml-56 mt-1 text-blue-500 text-sm font-semibold mb-10"></span>
                        </div>

                        <!-- Timeline List 5-->
                        <div class="relative ml-4" v-if="item.event=='Deceased'">
                            <!-- Vertical Gray Line -->
                            <div class="absolute left-44 top-0 bottom-0 w-0.5 bg-primary-100"></div>
                            <!-- Timeline Entry 1 -->
                            <div class="flex items-center relative ">
                                <!-- Date on Left Side -->
                                <p class="text-gray-700 text-sm font-medium w-32 text-right">{{ item.date }}</p>

                                <!-- SVG Circle in Middle -->
                                <div class="h-12 w-12 bg-primary-100 flex items-center justify-center rounded-full mx-6 z-10 border border-primary-200">
                                    <SvgIcon name="date" width="24px" height="24px" />
                                </div>

                                <!-- Event Text on Right Side -->
                                <div class="bg-error-50 text-orange-700 px-2 py-1 rounded-md text-sm font-semibold border border-error-200">
                                    {{ item.event }}
                                </div>
                            </div>

                            <!-- Subtext -->
                            <p class="text-gray-600 text-sm mt-1 ml-56 mb-10 font-semibold"></p>
                            <span class="ml-56 mt-1 text-blue-500 text-sm font-semibold mb-10"></span>
                        </div>

                        <!-- Timeline List 5-->
                        <div class="relative ml-4" v-if="item.event=='Terminated'">
                            <!-- Vertical Gray Line -->
                            <div class="absolute left-44 top-0 bottom-0 w-0.5 bg-primary-100"></div>
                            <!-- Timeline Entry 1 -->
                            <div class="flex items-center relative ">
                                <!-- Date on Left Side -->
                                <p class="text-gray-700 text-sm font-medium w-32 text-right">{{ item.date }}</p>

                                <!-- SVG Circle in Middle -->
                                <div class="h-12 w-12 bg-primary-100 flex items-center justify-center rounded-full mx-6 z-10 border border-primary-200">
                                    <SvgIcon name="date" width="24px" height="24px" />
                                </div>

                                <!-- Event Text on Right Side -->
                                <div class="bg-error-50 text-orange-700 px-2 py-1 rounded-md text-sm font-semibold border border-error-200">
                                    {{ item.event }}
                                </div>
                            </div>

                            <!-- Subtext -->
                            <p class="text-gray-600 text-sm mt-1 ml-56 mb-10 font-semibold"></p>
                            <span class="ml-56 mt-1 text-blue-500 text-sm font-semibold mb-10"></span>
                        </div>

                        <!-- Timeline List 5-->
                        <div class="relative ml-4" v-if="item.event=='Resigned'">
                            <!-- Vertical Gray Line -->
                            <div class="absolute left-44 top-0 bottom-0 w-0.5 bg-primary-100"></div>
                            <!-- Timeline Entry 1 -->
                            <div class="flex items-center relative ">
                                <!-- Date on Left Side -->
                                <p class="text-gray-700 text-sm font-medium w-32 text-right">{{ item.date }}</p>

                                <!-- SVG Circle in Middle -->
                                <div class="h-12 w-12 bg-primary-100 flex items-center justify-center rounded-full mx-6 z-10 border border-primary-200">
                                    <SvgIcon name="date" width="24px" height="24px" />
                                </div>

                                <!-- Event Text on Right Side -->
                                <div class="bg-error-50 text-orange-700 px-2 py-1 rounded-md text-sm font-semibold border border-error-200">
                                    {{ item.event }}
                                </div>
                            </div>

                            <!-- Subtext -->
                            <p class="text-gray-600 text-sm mt-1 ml-56 mb-10 font-semibold"></p>
                            <span class="ml-56 mt-1 text-blue-500 text-sm font-semibold mb-10"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <TimelineAddModal
        :is-modal-open="changeTimelineModalOpen"
        :single-employee="props.singleEmployee"
        @close="closeTimeLineModal"
        />
    </div>
</template>
<style>

</style>
