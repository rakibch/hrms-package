<script setup lang="ts">
import { onClickOutside } from '@vueuse/core';
import { computed, onMounted, ref, watch } from 'vue';

interface IProps {
    /**
     * Is popover hidden or not
     */
    hidePopover?: boolean;

    /**
     * Position of the popover relative to the container
     * @type: 'top' | 'top-left' | 'top-right' | 'bottom' | 'bottom-left' | 'bottom-right' | 'left' | 'left-top' | 'left-bottom' | 'right' | 'right-top' | 'right-bottom'
     */
    position?:
        | 'top'
        | 'top-left'
        | 'top-right'
        | 'bottom'
        | 'bottom-left'
        | 'bottom-right'
        | 'left'
        | 'left-top'
        | 'left-bottom'
        | 'right'
        | 'right-top'
        | 'right-bottom';

    /**
     * Show arrow or not
     */
    showArrow?: boolean;
}

const props = defineProps<IProps>();

const emits = defineEmits<{
    (e: 'onPopoverStateChange', popOverState: boolean): void;
}>();

const isPopOverOpen = ref(false);
const popoverContent = ref<HTMLDivElement | null>(null);
const popoverContainer = ref<HTMLDivElement | null>(null);
const arrowPosition = ref({
    top: '0px',
    left: '0px',
});

const popupPosition = computed(() => {
    if (!popoverContainer.value || !popoverContent.value) return {};

    const rectContainer = popoverContainer.value.getBoundingClientRect();
    const rectContent = popoverContent.value.getBoundingClientRect();

    let x = rectContainer.left + window.scrollX;
    let y = rectContainer.top + window.scrollY;

    switch (props.position) {
        case 'top':
            x += (rectContainer.width - rectContent.width) / 2;
            y -= rectContent.height + 8;
            arrowPosition.value = { top: '100%', left: '50%' };
            break;

        case 'top-left':
            y -= rectContent.height + 8;
            arrowPosition.value = { top: '100%', left: '20px' };
            break;

        case 'top-right':
            x += rectContainer.width - rectContent.width;
            y -= rectContent.height + 8;
            arrowPosition.value = { top: '100%', left: '80%' };
            break;

        case 'bottom':
            x += (rectContainer.width - rectContent.width) / 2;
            y += rectContainer.height + 8;
            arrowPosition.value = { top: '-8px', left: '50%' };
            break;

        case 'bottom-left':
            y += rectContainer.height + 8;
            arrowPosition.value = { top: '-8px', left: '20px' };
            break;

        case 'bottom-right':
            x += rectContainer.width - rectContent.width;
            y += rectContainer.height + 8;
            arrowPosition.value = { top: '-8px', left: '80%' };
            break;

        case 'left':
            x -= rectContent.width + 8;
            y += (rectContainer.height - rectContent.height) / 2;
            arrowPosition.value = { top: '50%', left: '100%' };
            break;

        case 'left-top':
            x -= rectContent.width + 8;
            arrowPosition.value = { top: '20px', left: '100%' };
            break;

        case 'left-bottom':
            x -= rectContent.width + 8;
            y += rectContainer.height - rectContent.height;
            arrowPosition.value = { top: '80%', left: '100%' };
            break;

        case 'right':
            x += rectContainer.width + 8;
            y += (rectContainer.height - rectContent.height) / 2;
            arrowPosition.value = { top: '50%', left: '-8px' };
            break;

        case 'right-top':
            x += rectContainer.width + 8;
            arrowPosition.value = { top: '20px', left: '-8px' };
            break;

        case 'right-bottom':
            x += rectContainer.width + 8;
            y += rectContainer.height - rectContent.height;
            arrowPosition.value = { top: '80%', left: '-8px' };
            break;
    }

    return {
        left: `${x}px`,
        top: `${y}px`,
    };
});

const togglePopOverContent = () => {
    isPopOverOpen.value = !isPopOverOpen.value;
    emits('onPopoverStateChange', isPopOverOpen.value);
};

const hidePopOverContent = () => {
    isPopOverOpen.value = false;
};

onMounted(() => {
    onClickOutside(popoverContent, hidePopOverContent, {
        ignore: [popoverContainer],
    });
});

watch(
    () => props.hidePopover,
    () => {
        if (props.hidePopover) {
            hidePopOverContent();
        }
    },
);
</script>

<template>
    <div>
        <div ref="popoverContainer" @click="togglePopOverContent">
            <slot />
        </div>

        <Teleport to="body">
            <div
                ref="popoverContent"
                class="popover"
                :class="{ invisible: !isPopOverOpen }"
                :style="popupPosition"
                tabindex="0"
            >
                <slot name="content" />

                <div
                    v-if="props.showArrow"
                    class="popover-arrow"
                    :style="arrowPosition"
                />
            </div>
        </Teleport>
    </div>
</template>

<style lang="scss" scoped>
.popover {
    position: absolute;
    z-index: 999;
    background: white;
    box-shadow: 1px 2px 9px 0 grey;
    border-radius: 4px;
    padding: 0;

    &.invisible {
        visibility: hidden;
    }

    .popover-arrow {
        position: absolute;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 8px;
        transform: translate(-50%, -50%);
    }

    &[data-position='top'] .popover-arrow {
        border-color: white transparent transparent transparent;
    }
    &[data-position='bottom'] .popover-arrow {
        border-color: transparent transparent white transparent;
    }
    &[data-position='left'] .popover-arrow {
        border-color: transparent white transparent transparent;
    }
    &[data-position='right'] .popover-arrow {
        border-color: transparent transparent transparent white;
    }
}
</style>
