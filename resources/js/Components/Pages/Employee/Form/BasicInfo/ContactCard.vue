<script setup lang="ts">
import { ContactFormData } from '@/App/Interfaces/employees';

const props = defineProps<{
    contact: ContactFormData;
    countries: { id: number; name: string }[];
    readonly?: boolean;
}>();

const emits = defineEmits<{
    (e: 'edit'): void;
}>();

const getFormattedAddress = () => {
    const addressParts = [
        props.contact.address?.city ?? props.contact?.city,
        props.contact.address?.street ?? props.contact?.street,
        props.contact.address?.state ?? props.contact?.state,
        props.contact.address?.postal_code ?? props.contact?.postal_code,
    ]
        .filter(Boolean)
        .join(', ');

    const countryName = props.countries.find(
        (country) => country.id === Number(props.contact.country),
    )?.name;

    return [addressParts, countryName].filter(Boolean).join(', ') || '-';
};
</script>

<template>
    <div>
        <div class="mb-3 flex items-center justify-between">
            <h3 class="text-sm font-medium capitalize leading-5 text-gray-700">
                {{ props.contact.relationship }}
            </h3>

            <p
                v-if="!props.readonly"
                class="cursor-pointer text-sm text-gray-600"
                @click="emits('edit')"
            >
                Edit
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <p class="text-sm text-gray-600">Name</p>
                    <p class="text-sm font-medium text-gray-800">
                        {{ props.contact.name || '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Contact Number</p>
                    <p class="text-sm font-medium text-gray-800">
                        {{ props.contact.contact_no || '-' }}
                    </p>
                </div>

                <div class="col-span-2 mt-2">
                    <p class="text-sm text-gray-600">Address</p>
                    <p
                        class="whitespace-pre-line text-sm font-medium text-gray-800"
                    >
                        {{ getFormattedAddress() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
