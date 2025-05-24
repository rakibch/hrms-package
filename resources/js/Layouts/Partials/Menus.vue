<script lang="ts" setup>
import { Menu } from '@/App/Types/menu';
import MenuGroup from '@/Layouts/Partials/MenuGroup.vue';
import MenuLink from '@/Layouts/Partials/MenuLink.vue';
import { usePage } from '@inertiajs/vue3';
import { Popover } from '@softzino/st-uikit';
import { useStorage } from '@vueuse/core';
import { onMounted, ref, watch } from 'vue';
import { route } from 'ziggy-js';

interface Props {
    menus: Menu[] | [];
    isSidebarCollapse: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    menus: () => [],
    isSidebarCollapse: false,
});

const rotatedValue = useStorage<string>('currentRotateIndex', null);
const currentRotateIndex = ref<number | null>(parseInt(rotatedValue.value, 10));
const isPopoverOpen = ref<boolean[]>(new Array(props.menus.length).fill(false));
const isSettingPopoverOpen = ref<boolean>(false);
const isSettingMenuShow = ref<boolean>(false);
const page = usePage();

const toggleRotate = (index: number) => {
    currentRotateIndex.value =
        currentRotateIndex.value === index ? null : index;
    rotatedValue.value = currentRotateIndex.value?.toString();
};

const togglePopover = (index: number) => {
    isPopoverOpen.value = isPopoverOpen.value.map(
        (_: boolean, i: number) => i === index,
    );
    isSettingPopoverOpen.value = false;
};

watch(
    () => page.url,
    () => {
        isSettingMenuShow.value = route().current('settings.*');
    },
    { immediate: true },
);

onMounted(() => {
    isSettingMenuShow.value = route().current('settings.*');
});
</script>

<template>
    <nav class="flex h-screen flex-1 flex-col py-3">
        <div class="flex h-full flex-col justify-between">
            <div>
                <ul
                    v-for="(item, index) in menus"
                    :key="index"
                    class="flex flex-col justify-center"
                >
                    <div v-if="item.subMenu && isSidebarCollapse">
                        <Popover
                            :isOpen="isPopoverOpen[index]"
                            position="right-start"
                            class="w-56 p-0"
                            @close="isPopoverOpen[index] = false"
                        >
                            <template #target>
                                <MenuGroup
                                    :icon="item.icon"
                                    :isSidebarCollapse="isSidebarCollapse"
                                    @mouseenter="togglePopover(index)"
                                />
                            </template>
                            <template #content>
                                <div class="py-2.5 pl-1 pr-3">
                                    <MenuGroup
                                        :submenu="item.subMenu"
                                        :name="item.name"
                                        :isSidebarCollapse="isSidebarCollapse"
                                        :isPopoverOpen="isPopoverOpen[index]"
                                        @updatePopover="
                                            (newValue) =>
                                                (isPopoverOpen[index] =
                                                    newValue)
                                        "
                                    />
                                </div>
                            </template>
                        </Popover>
                    </div>
                    <MenuGroup
                        v-if="item.subMenu && !isSidebarCollapse"
                        :submenu="item.subMenu"
                        :name="item.name"
                        :icon="item.icon"
                        :isSidebarCollapse="isSidebarCollapse"
                        :isRotated="currentRotateIndex === index"
                        @rotate="toggleRotate(index)"
                        :index="index"
                    />

                    <MenuLink
                        v-if="!item.subMenu && !isSidebarCollapse"
                        :name="item.name"
                        :icon="item.icon"
                        :routeName="item.routeName"
                    />

                    <Popover
                        :isOpen="isPopoverOpen[index]"
                        position="right"
                        class="-p-3 w-56"
                        v-if="!item.subMenu && isSidebarCollapse"
                        @close="isPopoverOpen[index] = false"
                    >
                        <template #target>
                            <MenuLink
                                :icon="item.icon"
                                :routeName="item.routeName"
                                @mouseenter="togglePopover(index)"
                            />
                        </template>
                        <template #content>
                            <div
                                class="-mb-1 p-0 font-inter font-semibold text-darkslategrey-800"
                            >
                                <p>
                                    <MenuLink
                                        :name="item.name"
                                        :routeName="item.routeName"
                                    />
                                </p>
                            </div>
                        </template>
                    </Popover>
                </ul>
            </div>
        </div>
    </nav>
</template>
