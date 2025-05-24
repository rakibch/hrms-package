<template>
    <li class="list-none">
        <div class="flex flex-col justify-center">
            <div
                @click="$emit('rotate')"
                :class="{
                    'font-semibold text-base text-darkslategrey-800 font-inter w-full h-full rounded-md flex justify-between gap-2 py-2 pl-3 pr-2 mb-1 cursor-pointer focus:bg-primary-50 hover:bg-gray-50 hover:text-mirage-950':
                        !isPopoverOpen,
                    'font-semibold text-base text-darkslategrey-800 font-inter w-full h-full rounded-md flex justify-between gap-2 py-2 pl-3 pr-2 mb-1':
                        isPopoverOpen,
                }"
            >
                <span class="flex gap-x-3">
                    <component
                        :is="icon"
                        :class="[
                            'group-hover:text-primary-600',
                            'h-6 w-6 shrink-0',
                        ]"
                        aria-hidden="true"
                    />
                    <span
                        class="whitespace-nowrap overflow-hidden text-ellipsis max-w-full"
                        :class="isPopoverOpen ? 'pl-2' : ''"
                        v-if="
                            (isPopoverOpen && isSidebarCollapse) ||
                            !isSidebarCollapse
                        "
                        >{{ name }}</span
                    >
                </span>

                <ChevronDownIcon
                    :class="isRotated ? 'rotate-180 transform' : ''"
                    class="h-5 w-5 group-hover:text-primary-600 mt-1 mr-1"
                    v-if="submenu && !isSidebarCollapse"
                />
            </div>
            <hr
                class="border-grayish-blue-200 w-full"
                :class="isPopoverOpen ? 'mx-1 mb-1' : ''"
                v-if="isPopoverOpen"
            />

            <div
                v-if="isRotated || isPopoverOpen"
                :class="{
                    'pl-9 gap-1': !isPopoverOpen,
                    'pl-2 gap-1': isPopoverOpen,
                }"
            >
                <div v-for="(subItem, subIndex) in submenu" :key="subItem.name">
                    <MenuLink
                        :key="subIndex"
                        :name="subItem.name"
                        :icon="null"
                        :routeName="subItem.routeName"
                        :isPopoverOpen="isPopoverOpen"
                        @click="toggleSubmenu(index, subIndex)"
                        @update-popover="emitUpdatePopover"
                    />
                </div>
            </div>
        </div>
    </li>
</template>

<script setup lang="ts">
import { ChevronDownIcon } from "@heroicons/vue/24/outline";
import MenuLink from "@/Layouts/Partials/MenuLink.vue";
import { defineEmits } from "vue";

interface Submenu {
    routeName: string;
    name: string;
}

interface Props {
    name: string;
    icon: any;
    submenu: Submenu[];
    isSidebarCollapse: boolean;
    isPopoverOpen: boolean;
    isRotated: boolean;
    index: number;
}

withDefaults(defineProps<Props>(), {
    name: "",
    icon: "",
    submenu: () => [],
    isSidebarCollapse: false,
    isRotated: false,
});

const emit = defineEmits(["updatePopover", "submenuRotate", "rotate"]);

const emitUpdatePopover = (newValue: boolean) => {
    emit("updatePopover", newValue);
};

const toggleSubmenu = (mainIndex: number, subIndex: number) => {
    emit("submenuRotate", mainIndex, subIndex);
};
</script>
