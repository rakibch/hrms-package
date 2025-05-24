<template>
    <Switch
        :disabled="disabled"
        v-model="data.is_active"
        :class="{
            '!opacity-50 !cursor-not-allowed': disabled,
            'bg-blue-600': data.is_active,
            'bg-gray-400': !data.is_active,
        }"
        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
        @update:model-value="(value: boolean) =>  onStatusChange ? onStatusChange(value) : changeStatus(value)"
    >
        <span
            aria-hidden="true"
            :class="data.is_active ? 'translate-x-5' : 'translate-x-0'"
            class="pointer-events-no ne inline-block h-5 w-5 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"
        />
    </Switch>
</template>

<script lang="ts" setup>
import { Switch } from "@headlessui/vue";
import { InertiaForm, useForm } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { Toast } from "@/App/Utils";
import { useInertiaSession } from "@/Composables/useInertiaSession";


interface Data {
    id: number;
    is_active: boolean;
}

interface FormData {
    is_active: boolean;
}

interface Props {
    data: Data;
    disabled?: boolean;
    routeName: string;
    onStatusChange?: (status: boolean) => void;
}

const props = withDefaults(defineProps<Props>(), {
    data: () => ({ id: 0, is_active: false }),
    routeName: "#",
    onStatusChange: undefined,
});

const form: InertiaForm<FormData> = useForm({
    is_active: props.data?.is_active,
});

/**
 * Updates the status of the form by sending a PUT request to the specified route.
 *
 * @return {Promise<void>} A Promise that resolves when the request is complete.
 */
const changeStatus = (status: boolean) => {
    form.is_active = status;

    form.put(route(props.routeName, props.data?.id), {
        onSuccess: () => {
            const message = useInertiaSession<
                string[],
                { success?: string; error?: string }
            >(["success", "error"]);

            if (!message) {
                return;
            }

            if (message.success) {
                Toast.Success(message.success);
            }

            if (message.error) {
                Toast.Error(message.error);
            }
        },
        onError: (errors) => {
            Toast.Error(errors[Object.keys(errors)[0]]);
        },
    });
};
</script>
