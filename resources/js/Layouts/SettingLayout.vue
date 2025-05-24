<template>
    <div>
        <div
            :class="{'max-sm:hidden md:hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-[580px] lg:flex-col flex grow flex-col border-r border-gray-200 bg-white pl-80 pt-8': !isSidebarCollapse,
            'max-sm:hidden md:hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-78 lg:flex-col flex grow flex-col border-r border-gray-200 bg-white pl-20 pt-8': isSidebarCollapse,
            }"
        >
            <SettingMenus :menus="settings" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import SettingMenus from "@/Layouts/Partials/Partials/SettingMenus.vue";
import { settings } from "@/App/Utils/const";

interface Props {
    isSidebarCollapse: boolean
}

withDefaults(defineProps<Props>(),{
    isSidebarCollapse : false
})
</script>