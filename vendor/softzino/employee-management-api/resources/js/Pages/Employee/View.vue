<script setup lang="ts">
import AchievementInformation from '@/Components/Pages/Employee/View/AchievementInformation.vue';
import BasicInformation from '@/Components/Pages/Employee/View/BasicInformation.vue';
import LocationInformation from '@/Components/Pages/Employee/View/LocationInformation.vue';
import OfficeInformation from '@/Components/Pages/Employee/View/OfficeInformation.vue';
import { Head,Link } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import { route } from 'ziggy-js';

const props = defineProps<{
  singleEmployee: any;
  basicInformation: any;
  officialInformation: any;
  educationalInformation: any;
  professionalExperienceInformation: any;
  workLocationInformation: any;
  certificationInformation: any;
  countries: Array<{
    id: number;
    name: string;
  }>;
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

const activeTab = ref('Basic Information');
</script>
<template>
  <div>
    <Head title="View Information" />
    <div class="relative">
      <div class="relative flex h-32 items-center bg-gray-800 p-6">
        <!-- Profile Image -->
        <div
          class="absolute top-[100%] -translate-y-1/2 translate-x-[-50%] transform"
          style="margin-left: 80px"
        >
          <img
            :src="singleEmployee.profile_image"
            alt="Employee"
            class="h-[160px] w-[160px] rounded-full border-2 border-white bg-white"
          />
        </div>

        <div class="flex-1 text-white">
          <p class="mb-10 text-sm">
            Employee Management > Employees > Employee Details
          </p>
          <p class="mt-10 text-xl font-semibold" style="margin-left: 200px">
            {{ props.singleEmployee.full_name }}
          </p>
        </div>
        <div class="mt-10">
            <Link
                class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-800 shadow"
                :href="route('employee.edit', singleEmployee.id)"
            >
                Edit Profile
            </Link>
        </div>
      </div>
      <!-- White Section -->
      <div class="left-4 bg-white shadow">
        <p class="pt-5 text-sm" style="margin-left: 220px">
          Joined at: {{ formatDate(props.singleEmployee.join_date) }}
        </p>
        <div
          class="flex justify-start space-x-3 pt-1"
          style="margin-left: 220px"
        >
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
        <div class="mt-6 flex justify-end"></div>
      </div>
      <div class="bg-white">
        <div class="flex justify-center border-b">
          <button
            v-for="tab in [
              'Basic Information',
              'Office Information',
              'Achievements',
              'Location',
            ]"
            :key="tab"
            @click="activeTab = tab"
            class="cursor-pointer px-6 py-3 text-sm font-semibold text-gray-500"
            :class="{
              'border-b-2 border-black bg-gray-50 text-sm font-semibold text-primary-700':
                activeTab === tab,
            }"
          >
            {{ tab }}
          </button>
        </div>
        <!-- Tab Content -->
        <div class="bg-gray-50 p-6">
          <div v-if="activeTab === 'Basic Information'">
            <BasicInformation
              :singleEmployee="singleEmployee"
              :personalInfo="basicInformation"
              :countries="countries"
            />
          </div>

          <div v-if="activeTab === 'Office Information'">
            <OfficeInformation :officialInformation="officialInformation" />
          </div>

          <div v-if="activeTab === 'Achievements'">
            <AchievementInformation
              :certificationInformation="certificationInformation"
              :educationalInformation="educationalInformation"
              :professionalExperienceInformation="
                professionalExperienceInformation
              "
            />
          </div>

          <div v-if="activeTab === 'Location'">
            <LocationInformation
              :workLocationInformation="workLocationInformation"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style></style>
