<template>
    <div class="flex items-center border-b border-gray-200" role="tablist">
        <button
            v-for="(tab, index) in items"
            :key="index"
            @click="handleTabClick(tab)"
            :class="[
                'flex items-center border-b-2 px-1 pb-3 pt-2 text-sm font-medium outline-none transition-all duration-300 ease-in-out',
                model === tab.value
                    ? 'border-primary-700 font-medium text-primary-700'
                    : 'border-transparent text-primary-500 hover:text-primary-700',
            ]"
            :role="'tab'"
            :aria-selected="model === tab.value"
            :tabindex="model === tab.value ? 0 : -1"
        >
            <span>{{ tab.title }}</span>
            <span
                v-if="tab.badge !== undefined && tab.badge !== null"
                class="ml-2 flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 text-xs font-medium text-gray-700"
            >
                {{ tab.badge }}
            </span>
        </button>
    </div>
</template>

<script setup lang="ts">
interface TabItem {
    title: string;
    value: any;
    badge?: number | string | null;
    [key: string]: any;
}

defineProps<{
    items: TabItem[];
}>();

const emits = defineEmits<{
    (e: 'tab-change', tab: TabItem): void;
}>();

const model = defineModel<any>();

const handleTabClick = (tab: TabItem) => {
    if (model.value !== tab.value) {
        model.value = tab.value;
        emits('tab-change', tab);
    }
};
</script>

<style scoped></style>
