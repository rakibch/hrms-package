<template>
    <div class="group flex items-center justify-between gap-x-2 py-6 leading-6">
        <div
            class="group flex w-full cursor-pointer items-center gap-x-2 font-inter text-base font-semibold leading-6 text-darkslategrey-800 hover:bg-gray-50 hover:text-mirage-950 focus:bg-primary-50 focus:text-primary-600"
        >
            <img
                class="h-10 w-10 rounded-full"
                src="/images/sample-image.jpeg"
                v-if="!isSidebarCollapse"
            />
            <Popover
                :isOpen="isPopoverOpen"
                position="right-end"
                class="w-56 p-0"
                @close="isPopoverOpen = false"
            >
                <template #target>
                    <img
                        class="h-10 w-10 rounded-full"
                        src="/images/sample-image.jpeg"
                        @mouseenter="isPopoverOpen = true"
                        v-if="isSidebarCollapse"
                    />
                </template>
                <template #content>
                    <div class="p-3">
                        <Label
                            text="User"
                            class="mb-1 flex justify-between p-2 font-inter text-base font-semibold text-darkslategrey-800"
                        />
                        <hr class="w-full border-grayish-blue-200" />
                        <Button
                            intent="text"
                            @click="router.visit(route('#'))"
                            class="my-1 flex h-full w-full justify-between p-2 font-inter text-base text-darkslategrey-800 hover:bg-primary-50 hover:text-primary-600 focus:bg-primary-50 focus:text-primary-600"
                        >
                            Profile
                        </Button>
                        <Button
                            intent="text"
                            @click="isLogoutModalOpen = true"
                            class="flex h-full w-full justify-between p-2 font-inter text-base text-darkslategrey-800 hover:bg-primary-50 hover:text-primary-600 focus:bg-primary-50 focus:text-primary-600"
                        >
                            Logout
                        </Button>
                    </div>
                </template>
            </Popover>

            <span class="flex flex-col" v-if="!isSidebarCollapse">
                <span class="text-sm">{{ user?.name }}</span>
                <span class="text-sm font-normal text-light-darkslategrey-700">
                    {{ user?.email }}
                </span>
            </span>
        </div>

        <div
            @click="isLogoutModalOpen = true"
            v-if="!isSidebarCollapse"
            class="flex h-10 w-10 cursor-pointer items-center justify-center hover:text-red-600"
        >
            <component
                :is="ArrowRightStartOnRectangleIcon"
                :class="['h-5 w-5 shrink-0']"
                aria-hidden="true"
            />
        </div>
    </div>

    <LogoutModal
        @close="isLogoutModalOpen = false"
        :isLogoutModalOpen="isLogoutModalOpen"
    />
</template>
<script setup lang="ts">
import LogoutModal from '@/Layouts/Partials/Partials/LogoutModal.vue';
import { ArrowRightStartOnRectangleIcon } from '@heroicons/vue/24/outline';
import { router, usePage } from '@inertiajs/vue3';
import { Button, Label, Popover } from '@softzino/st-uikit';
import { ref } from 'vue';

interface Props {
    isSidebarCollapse: boolean;
}

withDefaults(defineProps<Props>(), {
    isSidebarCollapse: false,
});

const isLogoutModalOpen = ref<boolean>(false);
const isPopoverOpen = ref<boolean>(false);
const page = usePage();
const user = page.props?.auth?.user;
</script>
