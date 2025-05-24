<script setup lang="ts">
import { ContactFormData } from '@/App/Interfaces/employees';
import { relations } from '@/App/Utils/const';
import Dropdown from '@/Components/Others/Dropdown.vue';
import PhoneInput from '@/Components/Others/PhoneInput.vue';
import TextInput from '@/Components/Others/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { Button, ModalDialog } from '@softzino/st-uikit';
import { ref } from 'vue';

const props = defineProps<{
    isModalOpen: boolean;
    formData?: ContactFormData;
    countries: Array<{
        id: number;
        name: string;
        iso2_code: string;
        phone_code: string;
    }>;
}>();

const emits = defineEmits<{
    (e: 'close'): void;
    (e: 'onSubmit', values: ContactFormData): void;
}>();

const form = useForm({
    id: props.formData?.id || null,
    relationship: props.formData?.relationship || null,
    name: props.formData?.name || '',
    contact_no: props.formData?.contact_no || null,
    address: {
        country:  props.formData?.country?.toString() || '',
        city: props.formData?.city || '',
        street: props.formData?.street || '',
        state: props.formData?.state || '',
        postal_code: props.formData?.postal_code || '',
    },
});

const relationOptions = ref(relations);
const countryOptions = ref(
    props.countries?.map((country) => ({
        label: country.name,
        value: String(country.id),
    })),
);

function closeForm() {
    form.reset();
    emits('close');
}

function handleFormSubmit() {
    emits('onSubmit', { ...form.data() });
    closeForm();
}
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
                <div class="min-w-[500px] px-1">
                    <div class="flex items-center justify-between">
                        <h3
                            class="order-0 flex-none self-stretch text-lg font-semibold leading-[28px] text-gray-800"
                        >
                            Add Emergency/Family Contact
                        </h3>

                        <SvgIcon
                            :height="12"
                            :width="12"
                            name="red-cross"
                            class="cursor-pointer"
                            @click="closeForm"
                        />
                    </div>
                    <p
                        class="order-1 flex-none self-stretch text-sm font-normal leading-[20px] text-gray-600"
                    >
                        You are about to add emergency/family contact.
                    </p>

                    <form @submit.prevent="handleFormSubmit" class="mt-5">
                        <Dropdown
                            :options="relationOptions"
                            label="Relation"
                            placeholder="Select"
                            required
                            v-model="form.relationship"
                        />

                        <TextInput
                            v-model="form.name"
                            label="Contact Person Name"
                            placeholder="Write Here"
                            class="mt-4"
                            required
                        />

                        <PhoneInput
                            v-model="form.contact_no"
                            label="Contact Number"
                            class="mt-4"
                            required
                        />

                        <p
                            class="mt-4 border-b border-gray-200 pb-4 text-sm font-semibold leading-[20px] text-gray-800"
                        >
                            Address
                        </p>

                        <div class="grid grid-cols-2 gap-4">
                            <Dropdown
                                label="Country"
                                :options="countryOptions"
                                placeholder="Select"
                                v-model="form.address.country"
                                clearable
                            />

                            <TextInput
                                label="City"
                                v-model="form.address.city"
                                type="text"
                                placeholder="Write Here"
                            />

                            <TextInput
                                class="col-span-2"
                                label="Street Address"
                                v-model="form.address.street"
                                type="text"
                                placeholder="Write Here"
                            />

                            <TextInput
                                label="State / Province"
                                v-model="form.address.state"
                                type="text"
                                placeholder="Write Here"
                            />

                            <TextInput
                                label="Postcode"
                                v-model="form.address.postal_code"
                                type="text"
                                placeholder="Write Here"
                            />
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
                                :class="['base-button create-button']"
                                type="submit"
                            >
                                Add
                            </Button>
                        </div>
                    </form>
                </div>
            </template>
        </ModalDialog>
    </div>
</template>

<style scoped></style>
