<template>
    <ModalDialog
        :isOpen="isLogoutModalOpen"
        @modal-close="emit('close')"
        dialogType="alert"
        class="flex justify-center items-center"
        layoutClasses="w-full"
        :disableOutSideClick="true"
        :showIcon="false"
    >
        <template #title>
            <h3
                class="text-lg font-medium text-mirage-950 flex justify-start my-1"
            >
                Are you sure, you want to logout?
            </h3>
        </template>
        <template #content>
            <div class="flex justify-between w-full space-x-2 mt-7 pr-3 mb-4">
                <Button
                    @click="emit('close')"
                    intent="text"
                    outline
                    class="px-16 rounded-lg border-grayish-blue-200 text-mirage-950"
                >
                    Cancel
                </Button>
                <Button
                    type="submit"
                    intent="danger"
                    class="px-16 rounded-lg"
                    @click="logout"
                >
                    logout
                </Button>
            </div>
        </template>
    </ModalDialog>
</template>
<script setup lang="ts">
import { defineEmits, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { Toast } from "@/App/Utils";
import { ModalDialog, Button } from "@softzino/st-uikit";

interface Props {
    isLogoutModalOpen: boolean;
}

withDefaults(defineProps<Props>(), {
    isLogoutModalOpen: false,
});

const emit = defineEmits<{
    (e: "close"): void;
}>();

const logout = () => {
    router.visit(route("logout"), {
        method: "post",
        onError: (errors: Record<string, any>) => {
            Toast.Error(errors[Object.keys(errors)[0]]);
        },
    });
};
</script>
