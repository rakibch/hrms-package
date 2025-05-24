<template>
    <ModalDialog
        :isOpen="isOpen"
        @modal-close="emit('close')"
        dialogType="alert"
        class="flex justify-center items-center"
        :disableOutSideClick="true"
        :showIcon="false"
    >
        <template #title>
            <h3
                class="text-lg font-medium text-mirage-950 flex justify-start my-1 w-[500px]"
            >
                Are you sure you want to proceed?
            </h3>
        </template>
        <template #content>
            <div class="w-[500px]">
                <p>{{ info }}</p>

                <div
                    class="flex justify-end space-x-2 mt-7 pr-3 mb-4"
                >
                    <Button
                        @click="emit('close')"
                        intent="secondary"
                        outline
                        class="px-4 rounded-lg border-grayish-blue-200 text-mirage-950"
                    >
                        Cancel
                    </Button>

                    <Button
                        type="submit"
                        intent="primary"
                        class="px-4 rounded-lg"
                        @click="$emit('changeStatus')"
                    >
                        Confirm
                    </Button>
                </div>
            </div>
        </template>
    </ModalDialog>
</template>

<script setup lang="ts">
import { defineEmits } from "vue";
import { ModalDialog, Button } from "@softzino/st-uikit";

interface Props {
    isOpen: boolean;
    info: string;
}

withDefaults(defineProps<Props>(), {
    isOpen: false,
    info: "",
});

const emit = defineEmits<{
    (e: "close"): void;
    (e: "changeStatus"): void;
}>();
</script>
