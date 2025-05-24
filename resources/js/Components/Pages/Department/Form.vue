<script setup lang="ts">
import { Department } from '@/App/Interfaces/departments';
import { Employee } from '@/App/Interfaces/employees';
import { showToast } from '@/App/Utils';
import InputError from '@/Components/Others/InputError.vue';
import TextInput from '@/Components/Others/TextInput.vue';
import { usePage } from '@inertiajs/vue3';
import { Button, Label, ModalDialog, Select } from '@softzino/st-uikit';
import { useForm } from 'laravel-precognition-vue-inertia';
import { computed, ref, watchEffect } from 'vue';

const props = defineProps<{
    department?: Department;
    employees: Employee[];
    isModalOpen: boolean;
}>();

const emits = defineEmits<{
    (e: 'close'): void;
}>();

const page = usePage();
const loading = ref(false);

const form = useForm<{
    name: string;
    head_id: number | null;
}>(
    () => (props.department ? 'post' : 'post'),
    () =>
        props.department
            ? route('departments.update', { department: props.department.id })
            : route('departments.store'),
    {
        name: '',
        head_id: null,
    },
);

watchEffect(() => {
    form.name = props.department?.name || '';
    form.head_id = props.department?.department_head?.id || null;
});

const handleFormSubmit = () => {
    form.submit({
        onSuccess: () => {
            if (page.props.flash?.success) {
                showToast(
                    'success',
                    page.props.flash.success,
                    3000,
                    'top-right',
                );
            }
            closeForm();
        },
        onError: () => {
            if (page.props.flash?.error) {
                showToast('error', page.props.flash.error, 3000, 'top-right');
            }
            loading.value = false;
        },
        onFinish: () => {
            loading.value = false; // Ensure it's reset after request finishes
        },
    });
};

const closeForm = () => {
    form.reset();
    emits('close');
};

const isSubmitDisabled = computed(() => {
    return (
        form.processing ||
        !form.isDirty ||
        form.hasErrors ||
        !form.name ||
        !form.head_id ||
        (props.department &&
            props.department.name.trim() === form.name.trim() &&
            props.department.department_head?.id === form.head_id)
    );
});
</script>

<template>
    <div class="modal-dialog">
        <ModalDialog
            :isOpen="isModalOpen"
            :disableOutSideClick="true"
            :showIcon="false"
            dialogType="alert"
            layoutClasses="w-120"
            @modal-close="emits('close')"
        >
            <template #content>
                <div class="form-container px-1 text-left">
                    <h3 class="title">
                        {{
                            props?.department
                                ? 'Edit Department'
                                : 'Create Department'
                        }}
                    </h3>
                    <p class="sub-title">
                        You are about to
                        {{ props?.department ? 'edit' : 'create' }} a
                        department.
                    </p>

                    <form @submit.prevent="handleFormSubmit" class="mt-5">
                        <TextInput
                            label="Name of the Department"
                            placeholder="e.g. Creative"
                            :required="true"
                            v-model="form.name"
                            :error="form.errors.name"
                            @onBlur="form.validate('name')"
                        />

                        <div class="mt-4">
                            <Label
                                text="Select Department Head"
                                required
                                class="input-label"
                            />

                            <Select
                                v-model="form.head_id"
                                :options="employees"
                                required
                                placeholder="Select"
                                clearable
                                class="input mt-1.5"
                            >
                                <template #option="{ option }">
                                    <div class="flex">
                                        <img
                                            class="option-avatar"
                                            src="/images/Avatar.png"
                                            :alt="option.label"
                                        />

                                        <p class="option-label">
                                            {{ option.label }}
                                        </p>
                                    </div>
                                </template>
                            </Select>

                            <div class="h-[5px]">
                                <InputError :message="form.errors.head_id" />
                            </div>
                        </div>

                        <div class="mt-5 flex justify-end gap-3">
                            <Button
                                class="base-button"
                                type="button"
                                @click="closeForm"
                            >
                                Close
                            </Button>
                            <Button
                                class="base-button create-button"
                                :disabled="isSubmitDisabled"
                                type="submit"
                            >
                                {{
                                    loading
                                        ? 'Processing...'
                                        : props?.department
                                          ? 'Save'
                                          : 'Create'
                                }}
                            </Button>
                        </div>
                    </form>
                </div>
            </template>
        </ModalDialog>
    </div>
</template>

<style scoped>
.form-container {
    min-width: 500px;
}

.title {
    font-style: normal;
    font-weight: 600;
    font-size: 18px;
    line-height: 28px;

    color: #1d2939;
}

.sub-title {
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 20px;

    color: #475467;
}

.input-label {
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 20px;

    color: #344054;
}

.input {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 8px 12px;
    gap: 8px;

    width: 100%;
    margin-top: 6px;

    background: #ffffff;
    border: 1px solid #d0d5dd;
    box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
    border-radius: 8px;
}

.form-action-button {
    box-sizing: border-box;

    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    padding: 10px 18px;
    gap: 8px;

    width: 81px;
    height: 44px;

    background: #ffffff;
    border: 1px solid #d0d5dd;
    box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
    border-radius: 8px;

    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;

    color: #344054;
}

.disabled {
    background: #e5e7eb;
    border: 1px solid #e5e7eb;

    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;

    color: #98a2b3;
}

.option-avatar {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0;

    width: 24px;
    height: 24px;

    border-radius: 200px;
}

.option-label {
    margin-left: 8px;
    font-style: normal;
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;

    color: #1d2939;
}
</style>
