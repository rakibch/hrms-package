<template>
    <Popover
        :isOpen="index !=null && popoverState[index] || false"
        :position="position"
        :offset="offset ?? [12, 14]"
    >
        <template #target>
            <slot>
                <component
                    @click="clickHandler && clickHandler()"
                @mouseenter="index !=null &&  togglePopover(index, true)"
                @mouseleave="index !=null &&  togglePopover(index, false)"
                :is=icon
                class="h-5 w-5 hover:text-primary-600 cursor-pointer text-darkslategrey-800"
                aria-hidden="true"
                />
            </slot>
        </template>
        <template #content>
            <span class="bg-white text-sm text-mirage-950">
                {{ text }}
            </span>
        </template>
    </Popover>
</template>

<script lang="ts" setup>
import { Popover } from "@softzino/st-uikit";
import { PencilSquareIcon } from "@heroicons/vue/24/outline";
import { usePopoverState } from "@/Composables/usePopoverState";
import { FunctionalComponent } from 'vue';

type Offset = [number, number]

interface Props {
    index: number | null;
    text: string;
    icon: FunctionalComponent;
    position: string;
    offset: Offset | null
    clickHandler?: () => void;
}

withDefaults(defineProps<Props>(), {
    index: null,
    text: 'Sample text',
    icon: PencilSquareIcon,
    position: 'top-end',
    offset: null
});

const { popoverState, togglePopover } = usePopoverState();
</script>
