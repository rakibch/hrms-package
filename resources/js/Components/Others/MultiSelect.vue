<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';

const model = defineModel<Array<string | number>>({ default: [] });

const props = defineProps<{
    id?: string;
    label?: string;
    options: { label: string; value: string | number }[];
    placeholder?: string;
    error?: string;
    disabled?: boolean;
    required?: boolean;
    clearable?: boolean;
}>();

const emits = defineEmits<{
    (e: 'onChange', value: Array<string | number>): void;
}>();

const computedId = computed(() => {
    return (
        props.id || `dropdown-input-${Math.random().toString(36).slice(2, 11)}`
    );
});

const isOpen = ref(false);
const search = ref('');
const dropdownWrapper = ref<HTMLElement | null>(null);

const toggleDropdown = () => {
    if (!props.disabled) {
        isOpen.value = !isOpen.value;
    }
};

const isSelected = (value: string | number) => {
    return model.value.includes(value);
};

const selectOption = (value: string | number) => {
    if (isSelected(value)) {
        model.value = model.value.filter((v) => v !== value);
    } else {
        model.value.push(value);
    }
};

const removeSelected = (value: string | number) => {
    model.value = model.value.filter((v) => v !== value);
};

const filteredOptions = computed(() => {
    if (!search.value) return props.options;
    return props.options.filter((opt) =>
        opt.label.toLowerCase().includes(search.value.toLowerCase()),
    );
});

watch(
    () => model.value,
    (value) => {
        emits('onChange', value);
    },
);

// Handle outside click
const handleClickOutside = (event: MouseEvent) => {
    if (
        dropdownWrapper.value &&
        !dropdownWrapper.value.contains(event.target as Node)
    ) {
        isOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <div ref="dropdownWrapper" class="relative flex h-full w-full flex-col">
        <label
            v-if="label"
            :for="computedId"
            class="mb-1 text-sm font-medium text-gray-700"
        >
            {{ label }} <span v-if="required" class="text-red-500">*</span>
        </label>

        <div
            class="shadow-xs relative w-full cursor-pointer rounded-lg border px-3 py-2 text-sm focus-within:ring-4"
            :class="[
                error
                    ? 'border-error-300 focus-within:ring-error-100'
                    : 'border-gray-300 focus-within:ring-purple-100',
                disabled ? 'cursor-not-allowed bg-gray-100' : 'bg-white',
            ]"
            @click="toggleDropdown"
        >
            <span v-if="!model.length" class="text-gray-400">
                {{ placeholder }}
            </span>
            <span v-else class="text-gray-700">
                {{ model.length }} selected
            </span>
        </div>

        <div class="mt-2 flex w-full flex-wrap gap-1">
            <template v-for="item in model" :key="item">
                <div
                    class="flex max-w-full items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-700"
                >
                    <span class="truncate">
                        {{
                            options.find((opt) => opt.value === item)?.label ??
                            item
                        }}
                    </span>
                    <button
                        type="button"
                        class="text-gray-600 hover:text-gray-800"
                        @click.stop="removeSelected(item)"
                    >
                        ×
                    </button>
                </div>
            </template>
        </div>

        <div
            v-if="isOpen"
            class="absolute top-full z-10 max-h-60 w-full overflow-auto rounded-lg border border-gray-300 bg-white shadow-md"
        >
            <input
                v-model="search"
                type="text"
                placeholder="Search..."
                class="w-full border-b border-gray-200 px-3 py-2 text-sm focus:outline-none"
            />

            <div v-if="filteredOptions.length" class="flex flex-col">
                <div
                    v-for="option in filteredOptions"
                    :key="option.value"
                    class="cursor-pointer px-4 py-2 text-sm hover:bg-purple-100"
                    :class="{
                        'bg-gray-100 text-gray-800': isSelected(option.value),
                    }"
                    @click.stop="selectOption(option.value)"
                >
                    {{ option.label }}
                </div>
            </div>

            <div v-else class="p-4 text-center text-sm text-gray-400">
                No options found.
            </div>
        </div>

        <p class="mt-1 min-h-[5px] text-sm text-error-700">
            <span v-show="error">{{ error }}</span>
        </p>
    </div>
</template>
