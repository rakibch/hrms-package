<script lang="ts" setup>
import { menus, responsiveMenus } from '@/App/Utils/const';
import SidebarNav from '@/Layouts/Partials/Menus.vue';
import SidebarFooter from '@/Layouts/Partials/SidebarFooter.vue';
import ResponsiveSidebar from '@/Layouts/ResponsiveSidebar.vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/outline';
import { router } from '@inertiajs/vue3';
import { Button } from '@softzino/st-uikit';
import { useStorage } from '@vueuse/core';
import { defineEmits } from 'vue';

const isSidebarCollapse = useStorage('isSidebarCollapse', false);
const emit = defineEmits(['updateSidebarCollapse', 'showSettingMenu']);

emit('updateSidebarCollapse', isSidebarCollapse.value);

const onToggleSidebar = () => {
    isSidebarCollapse.value = !isSidebarCollapse.value;
    emit('updateSidebarCollapse', isSidebarCollapse.value);
};
const handelSidebarOpen = (refValue: boolean) => {
    emit('showSettingMenu', refValue);
};
</script>

<template>
    <div>
        <div
            :class="{
                'min-h-screen transition-all duration-1000 ease-in-out max-sm:hidden md:hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-80 lg:flex-col':
                    !isSidebarCollapse,
                'min-h-screen transition-all duration-1000 ease-in-out max-sm:hidden md:hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-20 lg:flex-col':
                    isSidebarCollapse,
            }"
        >
            <div
                class="flex grow flex-col overflow-y-auto border border-gray-200 bg-white px-4 pt-5"
            >
                <div
                    class="flex h-16 shrink-0 items-center justify-between"
                    v-if="!isSidebarCollapse"
                >
                    <img
                        class="h-10 w-auto cursor-pointer"
                        @click="router.visit(route('dashboard'))"
                        src="/images/hrms-logo-light-with-text.svg"
                        alt="Logo"
                    />

                    <Button
                        intent="text"
                        outline
                        class="flex h-10 w-10 items-center justify-center rounded-full border-grayish-blue-200"
                        @click="onToggleSidebar"
                    >
                        <ChevronLeftIcon class="h-6 w-6" />
                    </Button>
                </div>
                <div v-else class="flex h-16 items-center justify-between">
                    <Button
                        intent="text"
                        outline
                        class="flex h-10 w-10 items-center justify-center rounded-full border-grayish-blue-200"
                        @click="onToggleSidebar"
                    >
                        <ChevronRightIcon class="h-6 w-6" />
                    </Button>
                </div>
                <SidebarNav
                    :menus="menus"
                    :isSidebarCollapse="isSidebarCollapse"
                    @showSettingMenu="handelSidebarOpen"
                />
                <hr class="-mt-3" />
                <SidebarFooter :isSidebarCollapse="isSidebarCollapse" />
            </div>
        </div>

        <ResponsiveSidebar :menus="responsiveMenus" />
    </div>
</template>

