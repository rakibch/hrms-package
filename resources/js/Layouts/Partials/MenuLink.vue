<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { defineEmits, onMounted, ref, watch } from 'vue';
import { route } from 'ziggy-js';

interface Props {
    name: string;
    routeName: string;
    icon: any;
}

const props = withDefaults(defineProps<Props>(), {
    name: '',
    routeName: 'dashboard',
    icon: '',
});

const isActive = ref(false);

const page = usePage();

const emit = defineEmits(['updatePopover']);

const closePopover = () => {
    emit('updatePopover', false);
};

watch(
    () => page.url,
    () => {
        isActive.value = route().current(props.routeName);
    },
    { deep: true },
);

onMounted(() => {
    isActive.value = route().current(props.routeName);
});
</script>

<template>
    <li class="mb-1 w-full list-none">
        <Link
            @click="closePopover"
            :href="route(routeName)"
            :class="[
                'flex h-full w-full justify-between rounded-md pl-3 font-inter text-base',
                'hover:bg-gray-50 hover:text-mirage-950',
                isActive
                    ? 'font-semibold text-gray-800'
                    : 'font-normal text-gray-700',
            ]"
        >
            <div class="flex gap-x-3 py-2">
                <component
                    :is="icon"
                    :class="[
                        'h-6 w-6 shrink-0',
                        isActive ? 'text-gray-800' : '',
                    ]"
                    aria-hidden="true"
                />
                <span
                    class="max-w-48 overflow-hidden text-ellipsis whitespace-nowrap"
                >
                    {{ name }}
                </span>
            </div>

            <div
                v-if="isActive"
                class="rounded-l-[6px] rounded-r-none border border-primary-400"
            />
        </Link>
    </li>
</template>
