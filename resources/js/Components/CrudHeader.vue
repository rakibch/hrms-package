<template>
    <Navbar class="mb-6">
        <template #left>
            <div class="flex flex-col gap-1">
                <span class="font-inter font-semibold text-3xl text-mirage-950">{{ title }}</span>
                <span class="font-normal font-inter text-base text-light-darkslategrey-700">{{ subtitle }}</span>
            </div>
        </template>
        <template #right>
            <div class="flex justify-between w-full pb-8 gap-2">
                <Button
                    type="button"
                    class="w-20 bg-white font-inter font-semibold"
                    intent="secondary"
                    outline
                    @click="router.visit(route(link));"
                >
                    Cancel
                </Button>
                <Button
                    :disabled="isDisabled"
                    type="submit"
                    class="w-34 font-inter font-semibold"
                >
                    Save
                </Button>
            </div>
        </template>
    </Navbar>
</template>

<script lang="ts" setup>
import Navbar from "@/Components/Navbar/Navbar.vue";
import {Button} from "@softzino/st-uikit";
import {router} from "@inertiajs/vue3";
import {route} from "ziggy-js";

interface Props{
    isDisabled: boolean,
    title: string,
    subtitle: string,
    link: string,
}
withDefaults(defineProps<Props>(), {
    isDisabled: true,
    title: "Title",
    subtitle: "Subtitle",
    link: '#'
});
</script>
