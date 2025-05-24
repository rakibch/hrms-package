<script setup lang="ts">
import { defineEmits, defineModel, defineProps, ref, watch } from 'vue';

defineProps<{
    id?: string;
    label?: string;
    placeholder?: string;
    error?: string;
    disabled?: boolean;
    required?: boolean;
}>();

const emit = defineEmits<{
    (e: 'onBlur'): void;
    (e: 'onFocus'): void;
}>();

const model = defineModel<string>({ default: '' });
const phone = ref('');
const validationError = ref<string>('');

const selectedCountry = ref('BD');
const phoneCode = ref('+88');

const countryCodes = [
    { code: 'BD', phoneCode: '+88' },
    { code: 'US', phoneCode: '+1' },
    { code: 'GB', phoneCode: '+44' },
    { code: 'CA', phoneCode: '+1' },
    { code: 'AU', phoneCode: '+61' },
    { code: 'IN', phoneCode: '+91' },
];

// Parse the full phone number into country code and local number
function parsePhoneNumber(value: string) {
    if (!value) return;

    // Find a matching country code from the start of the value
    const country = countryCodes.find((c) => value.startsWith(c.phoneCode));
    if (country) {
        selectedCountry.value = country.code;
        phoneCode.value = country.phoneCode;
        phone.value = value.slice(country.phoneCode.length);
    } else {
        // Fallback to default if no match
        selectedCountry.value = 'BD';
        phoneCode.value = '+88';
        phone.value = value;
    }
}

// Watch model.value and update internal state
watch(model, (newValue) => {
    parsePhoneNumber(newValue);
}, { immediate: true });

// Update phoneCode when country changes
watch(selectedCountry, (newCountry) => {
    phoneCode.value =
        countryCodes.find((c) => c.code === newCountry)?.phoneCode || '';
    updateModelValue();
});

// Validate and update model when phone changes
watch(phone, (newValue) => {
    validatePhoneNumber(newValue);
    updateModelValue();
});

function updateModelValue() {
    model.value = `${phoneCode.value}${phone.value.replace(/\D/g, '')}`;
}

function validatePhoneNumber(value: string) {
    if (!/^\d*$/.test(value.replace(phoneCode.value, ''))) {
        validationError.value = 'Invalid phone number. Only digits allowed.';
    } else {
        validationError.value = '';
    }
}
</script>

<template>
    <div class="flex h-full flex-col">
        <label :for="id" v-if="label" class="text-sm font-medium text-gray-700">
            {{ label }} <span v-if="required" class="text-red-500">*</span>
        </label>

        <div
            class="mt-1.5 flex rounded-lg border border-gray-300 focus-within:ring-4 focus-within:ring-purple-100"
            :class="{
                'border-error-300 focus-within:border-error-300 focus-within:ring-error-100':
                    validationError || error,
            }"
        >
            <select
                v-model="selectedCountry"
                class="rounded-l-lg border-none bg-white py-2 pl-2 text-gray-800 focus:outline-none"
                :disabled="disabled"
            >
                <option
                    v-for="country in countryCodes"
                    :key="country.code"
                    :value="country.code"
                >
                    {{ country.code }}
                </option>
            </select>

            <div class="relative flex flex-grow items-center">
                <span class="absolute top-2/4 -translate-y-2/4 text-gray-500">
                    {{ phoneCode }}
                </span>
                <input
                    :id="id"
                    v-model="phone"
                    type="text"
                    :placeholder="placeholder || 'Phone Number'"
                    :disabled="disabled"
                    class="w-full rounded-r-lg border-none p-2 pl-8 text-sm focus:outline-none"
                    @blur="emit('onBlur')"
                    @focus="emit('onFocus')"
                />
            </div>
        </div>

        <p class="min-h-[5px] text-sm text-error-700">
            <span v-show="validationError">{{ validationError }}</span>
            <span v-show="error">{{ error }}</span>
        </p>
    </div>
</template>

<style scoped>
select {
    width: 60px;
}

select:focus {
    outline: none;
    box-shadow: none;
}

input:focus {
    outline: none;
    box-shadow: none;
}
</style>
