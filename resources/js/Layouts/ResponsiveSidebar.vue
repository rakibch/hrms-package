<template>
    <TransitionRoot as="template" :show="sidebarOpen">
        <Dialog class="relative z-50 lg:hidden" @close="sidebarOpen = false">
            <TransitionChild
                as="template"
                enter="transition-opacity ease-linear duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-900/80" />
            </TransitionChild>

            <div class="fixed inset-0 flex">
                <TransitionChild
                    as="template"
                    enter="transition ease-in-out duration-300 transform"
                    enter-from="-translate-x-full"
                    enter-to="translate-x-0"
                    leave="transition ease-in-out duration-300 transform"
                    leave-from="translate-x-0"
                    leave-to="-translate-x-full"
                >
                    <DialogPanel
                        class="relative mr-16 flex w-full max-w-xs flex-1"
                    >
                        <TransitionChild
                            as="template"
                            enter="ease-in-out duration-300"
                            enter-from="opacity-0"
                            enter-to="opacity-100"
                            leave="ease-in-out duration-300"
                            leave-from="opacity-100"
                            leave-to="opacity-0"
                        >
                            <div
                                class="absolute left-full top-0 flex w-16 justify-center pt-5"
                            >
                                <button
                                    type="button"
                                    class="-m-2.5 p-2.5"
                                    @click="sidebarOpen = false"
                                >
                                    <XMarkIcon
                                        class="h-6 w-6 text-white"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                        </TransitionChild>

                        <div
                            class="flex grow flex-col overflow-y-auto bg-white px-6 pb-2"
                        >
                            <div class="flex h-16 shrink-0 items-center">
                                <img
                                    class="mr-1 h-10 w-auto"
                                    src="/images/hrms-logo-light-with-text.svg"
                                    alt="Logo"
                                />
                            </div>
                            <SidebarNav :menus="menus" />
                            <hr />
                            <SidebarFooter />
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>

    <div
        class="sticky top-0 z-40 items-center bg-white px-4 py-4 shadow-sm lg:hidden"
    >
        <div class="flex gap-x-6">
            <button
                type="button"
                class="-m-2.5 p-2.5 lg:hidden"
                @click="sidebarOpen = true"
            >
                <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </button>
            <img
                class="mr-1 h-10 w-auto"
                src="/images/hrms-logo-light-with-text.svg"
                alt="Logo"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Menu } from '@/App/Types/menu';
import SidebarNav from '@/Layouts/Partials/Menus.vue';
import SidebarFooter from '@/Layouts/Partials/SidebarFooter.vue';
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

interface Props {
    menus: Menu[] | [];
}

withDefaults(defineProps<Props>(), {
    menus: () => [],
});

const sidebarOpen = ref<boolean>(false);
</script>
