<script setup lang="ts">
import { BasicInfoForm } from '@/App/Interfaces/employees';
import {
    bloodGroups,
    genders,
    identityTypes,
    maritalStatus,
    religions,
} from '@/App/Utils/const';
import Checkbox from '@/Components/Checkbox.vue';
import Dropdown from '@/Components/Others/Dropdown.vue';
import ImageUpload from '@/Components/Others/ImageUpload.vue';
import PhoneInput from '@/Components/Others/PhoneInput.vue';
import RadioInputGroup from '@/Components/Others/RadioInputGroup.vue';
import SectionNavList from '@/Components/Others/SectionNavList.vue';
import TextInput from '@/Components/Others/TextInput.vue';
import AdditionalDocuments from '@/Components/Pages/Employee/Form/BasicInfo/AdditionalDocuments.vue';
import EmergencyContacts from '@/Components/Pages/Employee/Form/BasicInfo/EmergencyContacts.vue';
import { Label } from '@softzino/st-uikit';
import { reactive, ref } from 'vue';

interface Country {
    id: number;
    name: string;
    iso2_code: string;
    phone_code: string;
}

const props = defineProps<{ errors: Object; countries: Country[] }>();

const emits = defineEmits<{ (e: 'validate', field: string): void }>();

const sections = ref([
    { title: 'Identical Information', value: 'identity' },
    { title: 'Personal Information', value: 'personal' },
    { title: 'Contact Information', value: 'contact' },
    { title: 'Address', value: 'address' },
    { title: 'Emergency Contact Information', value: 'emergencyContact' },
    { title: 'Other Documents', value: 'document' },
]);

const activeSection = ref<string>('identity');

const identityOptions = ref(identityTypes);
const genderOptions = ref(genders);
const maritalStatusOptions = ref(maritalStatus);
const religionOptions = ref(religions);
const bloodGroupOptions = ref(bloodGroups);
const countryOptions = ref(
    props.countries.map((country) => ({
        label: country.name,
        value: String(country.id),
    })),
);

const sectionRefs = reactive<Record<string, HTMLElement | null>>(
    Object.fromEntries(sections.value.map((section) => [section.value, null])),
);

const model = defineModel<BasicInfoForm>({ default: {} });

function handleSectionChange() {
    const targetElement = sectionRefs[activeSection.value];
    if (targetElement) {
        targetElement.scrollIntoView({
            behavior: 'smooth',
        });
    }
}

function validate(field: string) {
    emits('validate', field);
}

function handleIdentityTypeChange() {
    if (model.value.identity_type === 'automatic') {
        model.value.employee_no = '';
    }
}
</script>

<template>

    <div class="flex h-full w-full">
        <div style="width: 30%">
            <SectionNavList
                :sections="sections"
                v-model="activeSection"
                @section-selected="handleSectionChange"
            />
        </div>
        <div
            style="height: 70vh; width: 70%"
            class="overflow-y-auto border-l pl-8"
        >
            <div>
                <div class="mb-6">
                    <div class="font-semibold leading-6 text-gray-700">
                        Basic Information
                    </div>
                    <div class="text-gray-600">
                        Write about employee basic information
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div
                        :ref="(el) => (sectionRefs['identity'] = el)"
                        class="rounded-xl border border-gray-200 p-4"
                    >
                        <div
                            class="mb-4 border-b border-gray-200 pb-4 font-semibold leading-5 text-gray-800"
                        >
                            Identical
                        </div>

                        <RadioInputGroup
                            name="identity_type"
                            :options="identityOptions"
                            label="Employee Identity Type"
                            required
                            v-model="model.identity_type"
                            @on-change="handleIdentityTypeChange"
                        />

                        <div class="flex">
                            <TextInput
                                id="employee-no"
                                :disabled="model.identity_type === 'automatic'"
                                :required="model.identity_type === 'manual'"
                                :error="
                                    model.identity_type === 'manual'
                                        ? errors?.employee_no
                                        : null
                                "
                                label="Employee Identity Number"
                                v-model="model.employee_no"
                                type="text"
                                placeholder="e.g. 10001"
                                class="mt-4 w-1/2 pr-3"
                                @focusout="validate('basic_info.employee_no')"
                            />

                            <TextInput
                                id="user_name"
                                class="mt-4 w-1/2 pl-3"
                                required
                                label="Set Username"
                                v-model="model.user_name"
                                :error="errors?.user_name"
                                type="text"
                                placeholder="Write here"
                                @focusout="validate('basic_info.user_name')"
                            />
                        </div>
                        <div class="pt-2">
                        <label class="" for="joining_date">Joining Date</label>
                        <input type="date" name="" id="joining_date"
                               class="block w-full px-4 py-2 border border-gray-300
                                       rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 bg-white"
                               v-model="model.join_date">
                        </div>
                    </div>

                    <div
                        :ref="(el) => (sectionRefs['personal'] = el)"
                        class="rounded-xl border border-gray-200 p-4"
                    >
                        <div
                            class="mb-4 border-b border-gray-200 pb-4 font-semibold leading-5 text-gray-800"
                        >
                            Personal
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <ImageUpload
                                class="col-span-2"
                                v-model="model.profile_image"
                            />

                            <TextInput
                                id="first-name"
                                label="First Name"
                                v-model="model.first_name"
                                type="text"
                                placeholder="Write here"
                                required
                                :error="errors?.first_name"
                                @focusout="validate('basic_info.first_name')"
                            />

                            <TextInput
                                id="last-name"
                                label="Last Name"
                                v-model="model.last_name"
                                type="text"
                                placeholder="Write here"
                                required
                                :error="errors?.last_name"
                                @focusout="validate('basic_info.last_name')"
                            />
                            <div>
                                <label for="dob">Date of birth</label>
                                <input type="date" name="" id="dob"
                                       class="block w-full  px-4 border border-gray-300 mt-1
                                       rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 bg-white"
                                       v-model="model.dob">
                            </div>
                            <Dropdown
                                label="Gender"
                                required
                                :options="genderOptions"
                                v-model="model.gender"
                                placeholder="Select"
                                :error="errors?.gender"
                                @on-change="validate('basic_info.gender')"
                            />

                            <RadioInputGroup
                                name="marital_status"
                                :options="maritalStatusOptions"
                                label="Marital Status"
                                v-model="model.marital_status"
                                :error="errors?.marital_status"
                                class="col-span-2"
                                @change="validate('basic_info.marital_status')"
                            />

                            <Dropdown
                                label="Religion"
                                placeholder="Select"
                                v-model="model.religion"
                                :options="religionOptions"
                                :error="errors?.religion"
                                @change="validate('basic_info.religion')"
                            />

                            <Dropdown
                                label="Blood Group"
                                placeholder="Select"
                                v-model="model.blood_group"
                                :options="bloodGroupOptions"
                                :error="errors?.blood_group"
                                @change="validate('basic_info.blood_group')"
                            />
                        </div>
                    </div>

                    <div
                        :ref="(el) => (sectionRefs['contact'] = el)"
                        class="w-full rounded-xl border border-gray-200 p-4"
                    >
                        <div
                            class="mb-4 border-b border-gray-200 pb-4 font-semibold leading-5 text-gray-800"
                        >
                            Contact
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <PhoneInput
                                v-model="model.personal_contact_no"
                                label="Personal Phone Number"
                                :error="errors?.personal_contact_no"
                                required
                                @onBlur="
                                    validate('basic_info.personal_contact_no')
                                "
                            />

                            <TextInput
                                id="personal-email"
                                label="Personal Email Address"
                                v-model="model.personal_email"
                                type="text"
                                placeholder="Write Here"
                                required
                                :error="errors?.personal_email"
                                @onBlur="validate('basic_info.personal_email')"
                            />
                        </div>
                    </div>

                    <div
                        :ref="(el) => (sectionRefs['address'] = el)"
                        class="w-full rounded-xl border border-gray-200 p-4"
                    >
                        <div
                            class="mb-4 border-b border-gray-200 pb-4 font-semibold leading-5 text-gray-800"
                        >
                            Present Address
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <Dropdown
                                label="Country"
                                :options="countryOptions"
                                placeholder="Select"
                                v-model="model.present_address.country"
                                clearable
                                error=""
                            />

                            <TextInput
                                id="present-city"
                                label="City"
                                v-model="model.present_address.city"
                                type="text"
                                placeholder="Write Here"
                            />

                            <TextInput
                                id="present-street-address"
                                class="col-span-2"
                                label="Street Address"
                                v-model="model.present_address.street"
                                type="text"
                                placeholder="Write Here"
                            />

                            <TextInput
                                id="present-state"
                                label="State / Province"
                                v-model="model.present_address.state"
                                type="text"
                                placeholder="Write Here"
                            />

                            <TextInput
                                id="present-postcode"
                                label="Postcode"
                                v-model="model.present_address.postal_code"
                                type="text"
                                placeholder="Write Here"
                            />
                        </div>
                    </div>

                    <div
                        class="mt-4 w-full rounded-xl border border-gray-200 p-4"
                    >
                        <div
                            class="mb-4 border-b border-gray-200 pb-4 font-semibold leading-5 text-gray-800"
                        >
                            Permanent Address
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 flex items-center gap-2">
                                <Checkbox
                                    id="is-permanent-address-same-as-present"
                                    :checked="
                                        model.permanent_address_same_as_present_address
                                    "
                                    v-model="
                                        model.permanent_address_same_as_present_address
                                    "
                                />

                                <Label
                                    text="Same as present address"
                                    for="is-permanent-address-same-as-present"
                                    class="cursor-pointer font-medium text-gray-700"
                                >
                                    Same as present address
                                </Label>
                            </div>

                            <Dropdown
                                label="Country"
                                id="present-country"
                                :options="countryOptions"
                                placeholder="Select"
                                v-model="model.permanent_address.country"
                                :disabled="
                                    model.permanent_address_same_as_present_address
                                "
                                clearable
                                error=""
                            />

                            <TextInput
                                id="permanent-city"
                                label="City"
                                v-model="model.permanent_address.city"
                                :disabled="
                                    model.permanent_address_same_as_present_address
                                "
                                type="text"
                                placeholder="Write Here"
                            />

                            <TextInput
                                id="permanent-street-address"
                                class="col-span-2"
                                label="Street Address"
                                v-model="model.permanent_address.street"
                                :disabled="
                                    model.permanent_address_same_as_present_address
                                "
                                type="text"
                                placeholder="Write Here"
                            />

                            <TextInput
                                id="permanent-state"
                                label="State / Province"
                                v-model="model.permanent_address.state"
                                :disabled="
                                    model.permanent_address_same_as_present_address
                                "
                                type="text"
                                placeholder="Write Here"
                            />
                            <TextInput
                                id="permanent-postcode"
                                label="Postcode"
                                v-model="model.permanent_address.postal_code"
                                :disabled="
                                    model.permanent_address_same_as_present_address
                                "
                                type="text"
                                placeholder="Write Here"
                            />
                        </div>
                    </div>
                    <div :ref="(el) => (sectionRefs['emergencyContact'] = el)">
                        <EmergencyContacts
                            v-model="model.contacts"
                            :countries="countries"
                        />
                    </div>

                    <div :ref="(el) => (sectionRefs['document'] = el)">
                        <AdditionalDocuments v-model="model.documents" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.overflow-y-auto {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.overflow-y-auto::-webkit-scrollbar {
    display: none;
}
</style>
