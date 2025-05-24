<script lang="ts" setup>
import SettingLayout from '@/Layouts/SettingLayout.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import { provide, ref, computed } from 'vue';
import { usePage } from "@inertiajs/vue3";

const showSidebar = ref(true);
const showSettingSidebar = ref(false);
const isSidebarCollapse = ref(false);

provide('showSidebar', showSidebar);
const page = usePage();
const isSpecialRoute = computed(() =>
    page.url.includes("/employee-timeline") || page.url.includes("/view-information")
);
</script>

<template>
    <div>
        <div class="h-screen">
            <Sidebar
                v-if="showSidebar"
                @updateSidebarCollapse="(value) => (isSidebarCollapse = value)"
                @showSettingMenu="(value) => (showSettingSidebar = value)"
            />
            <SettingLayout
                v-if="showSettingSidebar && showSidebar"
                :isSidebarCollapse="isSidebarCollapse"
            />
            <main :class="{
                    'w-full bg-lavender-blue-50 py-4':
                    !showSidebar && !isSidebarCollapse,
                    'lg:pl-78': isSpecialRoute,
                    'sidebar-layout lg:pl-[572px]':
                    showSidebar && !isSidebarCollapse && showSettingSidebar && !isSpecialRoute,
                    'sidebar-layout lg:pl-78':
                    showSidebar && !isSidebarCollapse && !showSettingSidebar && !isSpecialRoute,
                    'sidebar-layout lg:pl-[72px]':
                    showSidebar && isSidebarCollapse && !showSettingSidebar && !isSpecialRoute,
                    'sidebar-layout lg:pl-[304px]':
                    showSidebar && isSidebarCollapse && showSettingSidebar && !isSpecialRoute,
                }">
                <div :class="isSpecialRoute ? 'mx-0' : showSidebar ? 'mx-8' : 'mx-1'">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>


