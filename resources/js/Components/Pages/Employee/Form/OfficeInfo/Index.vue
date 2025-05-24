<script setup lang="ts">
import { Department } from '@/App/Interfaces/departments';
import { Designation } from '@/App/Interfaces/designations';
import { OfficialInfo } from '@/App/Interfaces/employees';
import { employmentTypes, jobNatures } from '@/App/Utils/const';
import Dropdown from '@/Components/Others/Dropdown.vue';
import PhoneInput from '@/Components/Others/PhoneInput.vue';
import RadioInputGroup from '@/Components/Others/RadioInputGroup.vue';
import SectionNavList from '@/Components/Others/SectionNavList.vue';
import TextInput from '@/Components/Others/TextInput.vue';
import { computed, reactive, ref } from 'vue';

const props = defineProps<{
    errors: Object;
    departments: Department[];
    designations: Designation[];
}>();

const emits = defineEmits<{ (e: 'validate', field: string): void }>();

const sections = ref([
    { title: 'Job Type Information', value: 'jobType' },
    { title: 'Employment Information', value: 'employment' },
    { title: 'Official Contact', value: 'officialContact' },
]);

const activeSection = ref<string>('jobType');

const sectionRefs = reactive<Record<string, HTMLElement | null>>(
    Object.fromEntries(sections.value.map((section) => [section.value, null])),
);

const jobNatureOptions = ref(jobNatures);

function handleSectionChange() {
    const targetElement = sectionRefs[activeSection.value];
    if (targetElement) {
        targetElement.scrollIntoView({
            behavior: 'smooth',
        });
    }
}

const model = defineModel<OfficialInfo>({ default: {} });

const departmentOptions = computed(() => {
    return props.departments.map((dept) => ({
        value: dept.id,
        label: dept.name,
    }));
});

const empTypeOptions = ref(employmentTypes);

const designationOptions = computed(() => {
    return props.designations.map((dept) => ({
        value: dept.id,
        label: dept.name,
    }));
});

function validate(field: string) {
    emits('validate', field);
}
</script>

<template>
    <div class="flex h-full w-full">
        <div style="width: 30%">
            <SectionNavList
                :sections="sections"
                v-model="activeSection"
                @section-selected="handleSectionChange"
            />
        </div>

        <div
            style="height: 70vh; width: 70%"
            class="overflow-y-auto border-l pl-8"
        >
            <div>
                <div class="mb-6">
                    <div class="font-semibold leading-6 text-gray-700">
                        Official Information
                    </div>
                    <div class="text-gray-600">
                        Write about employee official information
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <div
                        :ref="(el) => (sectionRefs['jobType'] = el)"
                        class="rounded-xl border border-gray-200 p-4"
                    >
                        <div
                            class="mb-4 border-b border-gray-200 pb-4 font-semibold leading-5 text-gray-800"
                        >
                            Job Type
                        </div>

                        <RadioInputGroup
                            name="identity_type"
                            :options="jobNatureOptions"
                            label="Select Job Type"
                            v-model="model.job_type"
                            @on-change="validate('job_details.job_type')"
                        />
                    </div>

                    <div
                        :ref="(el) => (sectionRefs['employment'] = el)"
                        class="rounded-xl border border-gray-200 p-4"
                    >
                        <div
                            class="mb-4 border-b border-gray-200 pb-4 font-semibold leading-5 text-gray-800"
                        >
                            Employment Information
                        </div>
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <Dropdown
                                    label="Department"
                                    placeholder="Select"
                                    required
                                    :options="departmentOptions"
                                    v-model="model.department_id"
                                    :error="errors?.department_id"
                                    @on-change="
                                        validate('job_details.department_id')
                                    "
                                />

                                <Dropdown
                                    label="Designation"
                                    placeholder="Select"
                                    required
                                    :options="designationOptions"
                                    v-model="model.designation_id"
                                    :error="errors?.designation_id"
                                    @on-change="
                                        validate('job_details.designation_id')
                                    "
                                />

                                <RadioInputGroup
                                    name="employment_type"
                                    required
                                    :options="empTypeOptions"
                                    label="Employment Type"
                                    v-model="model.employment_type"
                                    :error="errors?.employment_type"
                                    @on-change="
                                        validate('job_details.employment_type')
                                    "
                                />
                            </div>
                        </div>
                    </div>

                    <div
                        :ref="(el) => (sectionRefs['officialContact'] = el)"
                        class="rounded-xl border border-gray-200 p-4"
                    >
                        <div
                            class="mb-4 border-b border-gray-200 pb-4 font-semibold leading-5 text-gray-800"
                        >
                            Official Contact
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <PhoneInput
                                v-model="model.official_contact_no"
                                label="Personal Phone Number"
                                @onBlur="
                                    validate('job_details.official_contact_no')
                                "
                            />
                            <TextInput
                                id="personal-email"
                                label="Email(Official)"
                                v-model="model.official_email"
                                type="text"
                                placeholder="Write Here"
                                @onBlur="validate('job_details.official_email')"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.overflow-y-auto {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.overflow-y-auto::-webkit-scrollbar {
    display: none;
}
</style>
