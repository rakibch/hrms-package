<script setup lang="ts">
import { Designation } from '@/App/Interfaces/designations';
import { Achievements } from '@/App/Interfaces/employees';
import SectionNavList from '@/Components/Others/SectionNavList.vue';
import CertificationInfo from '@/Components/Pages/Employee/Form/AchievementInfo/CertificationInfo.vue';
import EducationalInfo from '@/Components/Pages/Employee/Form/AchievementInfo/EducationalInfo.vue';
import ProfessionalExperienceInfo from '@/Components/Pages/Employee/Form/AchievementInfo/ProfessionalExperienceInfo.vue';
import { reactive, ref } from 'vue';

const sections = ref([
    { title: 'Educational Information', value: 'educationalInfo' },
    {
        title: 'Professional Experience Information',
        value: 'professionalExperienceInfo',
    },
    { title: 'Certification Information', value: 'certificationInfo' },
]);

const activeSection = ref<string>('educationalInfo');

const sectionRefs = reactive<Record<string, HTMLElement | null>>(
    Object.fromEntries(sections.value.map((section) => [section.value, null])),
);

const model = defineModel<Achievements>({ default: {} });

function handleSectionChange() {
    const targetElement = sectionRefs[activeSection.value];
    if (targetElement) {
        targetElement.scrollIntoView({
            behavior: 'smooth',
        });
    }
}

const props = defineProps<{
    designations: Designation[];
}>();
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
                        Achievements Information
                    </div>
                    <div class="text-gray-600">
                        Add required information to employee
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <div :ref="(el) => (sectionRefs['educationalInfo'] = el)">
                        <EducationalInfo v-model="model.education" />
                    </div>

                    <div
                        :ref="
                            (el) =>
                                (sectionRefs['professionalExperienceInfo'] = el)
                        "
                    >
                        <ProfessionalExperienceInfo
                            :designations="designations"
                            v-model="model.work_experience"
                        />
                    </div>

                    <div :ref="(el) => (sectionRefs['certificationInfo'] = el)">
                        <CertificationInfo v-model="model.certifications" />
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
