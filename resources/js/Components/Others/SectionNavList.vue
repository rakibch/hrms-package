<script setup lang="ts">
interface Section {
    title: string;
    value: string;
}

defineProps<{
    sections: Section[];
}>();

const model = defineModel<string>({
    default: '',
});

const emits = defineEmits<{
    (e: 'sectionSelected', value: string): void;
}>();

const selectSection = (value: string) => {
    if (model.value !== value) {
        model.value = value;
        emits('sectionSelected', value);
    }
};
</script>

<template>
    <nav
        class="section-nav-list"
        role="tablist"
        aria-label="Section Navigation"
    >
        <div
            v-for="section in sections"
            :key="section.value"
            class="section-item cursor-pointer border-l-2 py-2.5 pl-3.5 odd:bg-gray-50 even:bg-white"
            :class="{
                'border-primary-700 font-bold text-primary-700':
                    model === section.value,
                'border-transparent text-gray-700': model !== section.value,
            }"
            role="tab"
            :aria-selected="model === section.value"
            @click="selectSection(section.value)"
        >
            {{ section.title }}
        </div>
    </nav>
</template>

<style scoped>
.section-item:hover {
    background-color: #f9fafb;
}
</style>
