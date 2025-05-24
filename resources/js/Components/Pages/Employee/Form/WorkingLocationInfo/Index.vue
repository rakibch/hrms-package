<script setup lang="ts">
import SectionNavList from '@/Components/Others/SectionNavList.vue';
import WorkingLocationInfo from "@/Components/Pages/Employee/Form/WorkingLocationInfo/WorkingLocationInfo.vue";
import { Location } from "@/App/Interfaces/employees";
import { nextTick, onMounted, reactive, ref } from 'vue';

const sections = ref([
    { title: 'Working Location', value: 'workingLocation' },
]);

const activeSection = ref<string>('workingLocation');

const sectionRefs = reactive<Record<string, HTMLElement | null>>(
    Object.fromEntries(sections.value.map((section) => [section.value, null])),
);

const model = defineModel<Location>({
    default: {
        isSameAsPresentAddress: false,
        country: '',
        city: '',
        streetAddress: '',
        stateOrProvince: '',
        postcode: '',
        lat: '',
        long: '',
    },
});

const sectionComponents = {
    workingLocation: WorkingLocationInfo,
};

function handleSectionChange() {
    const targetElement = sectionRefs[activeSection.value];
    if (targetElement) {
        targetElement.scrollIntoView({
            behavior: 'smooth',
        });
    }
}

onMounted(async () => {
    await nextTick();
});
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
                        Working Location
                    </div>
                    <div class="text-gray-600">
                        Write about employee working location information
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <div
                        v-for="section in sections"
                        :key="section.value"
                        :ref="(el) => (sectionRefs[section.value] = el)"
                    >

                        <component
                            :is="sectionComponents[section.value]"
                            v-model="model"
                        />
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
