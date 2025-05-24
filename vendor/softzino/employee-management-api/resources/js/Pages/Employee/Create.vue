<script setup lang="ts">
import {Department} from '@/App/Interfaces/departments';
import {Designation} from '@/App/Interfaces/designations';
import Stepper from '@/Components/Others/Stepper.vue';
import PageHeader from '@/Components/PageHeader.vue';
import AchievementInfo from '@/Components/Pages/Employee/Form/AchievementInfo/Index.vue';
import BasicInfo from '@/Components/Pages/Employee/Form/BasicInfo/Index.vue';
import OfficialInfo from '@/Components/Pages/Employee/Form/OfficeInfo/Index.vue';
import WorkLocationInfo from '@/Components/Pages/Employee/Form/WorkingLocationInfo/Index.vue';
import {Head} from '@inertiajs/vue3';
import {Button} from '@softzino/st-uikit';
import {useForm} from 'laravel-precognition-vue-inertia';
import {ref, watch, computed} from 'vue';
import {DateTime} from "luxon";

interface Country {
    id: number;
    iso2_code: string;
    phone_code: string;
}

const props = defineProps<{
    employee: any;
    designations: Designation[];
    departments: Department[];
    countries: Country[];
    work_location: any;
}>();

const isEdit = computed(() => !!props.employee);

const breadCrumbs = [
    {name: 'Dashboard', routeName: 'dashboard'},
    {name: 'Employees', routeName: 'employee.index'},
    {name: 'Create Employee', routeName: 'employee.create'},
];

const steps = [
    {id: 'basicInfo', title: 'Basic Information'},
    {id: 'officialInfo', title: 'Official Information'},
    {id: 'achievements', title: 'Achievements'},
    {id: 'location', title: 'Location'},
];
const currentStep = ref<number>(1);

const form = useForm(
    isEdit.value ? 'post' : 'post',
    isEdit.value
        ? route('employee.update', props.employee.data.id)
        : route('employee.store'),
    {
        profile_status: '',

        basic_info: {
            identity_type: props.employee ? props.employee.data.basic_info.identity_type : 'manual',
            employee_no: props.employee ? props.employee.data.basic_info.employee_no : '',
            user_name: props.employee ? props.employee.data.basic_info.user_name : '',
            join_date: props.employee
                ? DateTime.fromISO(props.employee.data.basic_info.join_date, {zone: 'utc'})
                    .setZone('local')
                    .toFormat('yyyy-MM-dd')
                : '',

            profile_image: props.employee ? props.employee.data.basic_info.profile_image : null,
            first_name: props.employee ? props.employee.data.basic_info.first_name : '',
            last_name: props.employee ? props.employee.data.basic_info.last_name : '',
            dob: props.employee
                ? DateTime.fromISO(props.employee.data.basic_info.dob, {zone: 'utc'})
                    .setZone('local')
                    .toFormat('yyyy-MM-dd')
                : '',
            gender: props.employee ? props.employee.data.basic_info.gender : '',
            marital_status: props.employee ? props.employee.data.basic_info.marital_status : '',
            religion: props.employee ? props.employee.data.basic_info.religion : '',
            blood_group: props.employee ? props.employee.data.basic_info.blood_group : '',

            personal_contact_no: props.employee ? props.employee.data.basic_info.personal_contact_no : '',
            personal_email: props.employee ? props.employee.data.basic_info.personal_email : '',

            present_address: {
                country: props.employee ? props.employee.data.basic_info.present_address?.country.toString() : '',
                city: props.employee ? props.employee.data.basic_info.present_address?.city : '',
                street: props.employee ? props.employee.data.basic_info.present_address?.street : '',
                state: props.employee ? props.employee.data.basic_info.present_address?.state : '',
                postal_code: props.employee ? props.employee.data.basic_info.present_address?.postal_code : '',
            },

            permanent_address_same_as_present_address: props.employee
                ? props.employee.data.basic_info?.permanent_address_same_as_present_address
                : false,

            permanent_address: {
                country: props.employee ? props.employee.data.basic_info.permanent_address?.country.toString() : '',
                city: props.employee ? props.employee.data.basic_info.permanent_address?.city : '',
                street: props.employee ? props.employee.data.basic_info.permanent_address?.street : '',
                state: props.employee ? props.employee.data.basic_info.permanent_address?.state : '',
                postal_code: props.employee ? props.employee.data.basic_info.permanent_address?.postal_code : '',
            },

            contacts: props.employee ? props.employee.data.basic_info.contacts : [],
            documents: props.employee ? props.employee.data.basic_info.documents : [],
        },
        job_details: {
            job_type: props.employee ? props.employee.data.job_details.job_type : '',
            department_id: props.employee ? props.employee.data.job_details.department_id : null,
            designation_id: props.employee ? props.employee.data.job_details.designation_id : null,
            employment_type: props.employee ? props.employee.data.job_details.employment_type : '',
            official_contact_no: props.employee ? props.employee.data.job_details.official_contact_no : '',
            official_email: props.employee ? props.employee.data.job_details.official_email : '',
        },
        achievements: {
            education: props.employee ? props.employee.data.achievements.education : [],
            work_experience: props.employee ? props.employee.data.achievements.work_experience : [],
            certifications: props.employee ? props.employee.data.achievements.certifications : [],
        },
        work_location: {
            is_same_as_present_address: props.employee
                ? props.employee.data.work_location.is_same_as_present_address
                : false,
            country: props.employee ? props.work_location?.country.toString() : '',
            city: props.employee ? props.work_location?.city : '',
            street: props.employee ? props.work_location?.street : '',
            state: props.employee ? props.work_location?.state : '',
            postal_code: props.employee ? props.work_location?.postal_code : '',
        },
    }
);
const formErrors = ref<Object>({});

function handleFormSubmit(status: 'draft' | 'complete') {
    form.profile_status = status;

    form.submit({
        onSuccess: () => {
            console.log('Employee created successfully!');
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
}

function convertToNestedObject(errors) {

    const result = {};

    Object.entries(errors).forEach(([key, value]) => {
        key.split('.').reduce((acc, part, index, array) => {
            // Convert numeric keys to integers for arrays
            const normalizedKey = isNaN(part) ? part : parseInt(part, 10);

            // If it's the last key, set the value
            if (index === array.length - 1) {
                acc[normalizedKey] = value;
            } else {
                // Ensure the next level is an object or an array
                acc[normalizedKey] =
                    acc[normalizedKey] || (isNaN(array[index + 1]) ? {} : []);
            }

            return acc[normalizedKey];
        }, result);
    });

    return result;
}
const goBack = () => window.history.back();

watch(
    () => form.errors,
    (errors) => {
        formErrors.value = convertToNestedObject(errors);
    },
);
</script>

<template>
    <div>
        <Head :title="isEdit ? 'Update' : 'Create'"/>
        <form @submit.prevent>
            <PageHeader
                :title="isEdit ? 'Update Employee' : 'Create Employee'"
                subtitle="Provide all required information"
                :bread-crumbs="breadCrumbs"
                :show-border-bottom="false"
            >
                <template #rightSideContent>
                    <div class="flex gap-3">
                        <Button @click="goBack" class="base-button"> Cancel</Button>
                        <Button
                            class="base-button"
                            type="button"
                            @click="handleFormSubmit('draft')"
                        >
                            Save as Draft
                        </Button>
                        <Button
                            type="button"
                            class="base-button create-button"
                            @click="handleFormSubmit('complete')"
                        >
                            {{ isEdit ? 'Update' : 'Create' }}
                        </Button>
                    </div>
                </template>
            </PageHeader>
            <Stepper v-model="currentStep" :steps="steps"/>

            <BasicInfo
                class="mt-10"
                v-show="currentStep === 1"
                v-model="form.basic_info"
                :countries="countries"
                :errors="formErrors?.basic_info"
                @validate="(field) => form.validate(field)"
            />

            <OfficialInfo
                class="mt-10"
                v-if="currentStep === 2"
                v-model="form.job_details"
                :designations="designations"
                :departments="departments"
                :errors="formErrors.job_details"
                @validate="(field) => form.validate(field)"
            />
            <AchievementInfo
                class="mt-10"
                v-if="currentStep === 3"
                v-model="form.achievements"
                :designations="designations"
            />

            <WorkLocationInfo
                class="mt-10"
                v-if="currentStep === 4"
                v-model="form.work_location"
            />
        </form>
    </div>
</template>

<style scoped></style>
