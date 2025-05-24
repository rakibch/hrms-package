<script setup lang="ts">
import DocumentItem from '@/Components/Others/DocumentItem.vue';
import ContactCard from '@/Components/Pages/Employee/Form/BasicInfo/ContactCard.vue';
import { defineProps } from 'vue';
const props = defineProps<{
    singleEmployee: any;
    personalInfo: any;
    countries: Array<{
        id: number;
        name: string;
    }>;
}>();

const formatDate = (dateString: any) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
const capitalizeWords = (sentence: string): string => {
    return sentence.replace(/\b\w/g, (char) => char.toUpperCase());
};
</script>
<template>
    <!-- Identical Info -->
    <div class="mx-48 rounded-xl border border-gray-300 bg-white p-4">
        <div class="mb-2 text-start font-semibold text-gray-800">Identical</div>
        <hr class="mb-4" />

        <div class="mb-4 flex justify-between">
            <div class="w-1/2">
                <p class="text-sm text-gray-600">Identity Number</p>
                <p class="tex-primary-800 text-sm font-medium">
                    {{ props.singleEmployee.employee_no || '-' }}
                </p>
            </div>
            <div class="w-1/2 text-left">
                <p class="text-sm text-gray-600">Username</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ props.singleEmployee.full_name || '-' }}
                </p>
            </div>
        </div>

        <div class="flex justify-between">
            <div class="w-1/2">
                <p class="text-sm text-gray-600">Joining Date</p>
                <p class="text-sm font-medium text-gray-800">
                    {{
                        formatDate(props.singleEmployee.join_date) ||
                        '0000-00-00'
                    }}
                </p>
            </div>
        </div>
    </div>
    <!-- Personal Info -->
    <div class="mx-48 mt-6 rounded-xl border border-gray-300 bg-white p-4">
        <div class="mb-2 text-start font-semibold text-gray-800">Personal</div>
        <hr class="mb-4" />

        <div class="mb-4 flex justify-between">
            <div class="w-1/2">
                <p class="text-sm text-gray-600">Full Name</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ props.singleEmployee.full_name || '-' }}
                </p>
            </div>
            <div class="w-1/2 text-left">
                <p class="text-sm text-gray-600">Date of Birth</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ formatDate(props.personalInfo.dob) || '-' }}
                </p>
            </div>
        </div>
        <div class="mb-4 flex justify-between">
            <div class="w-1/2">
                <p class="text-sm text-gray-600">Gender</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ capitalizeWords(props.personalInfo.gender) || '-' }}
                </p>
            </div>
            <div class="w-1/2 text-left">
                <p class="text-sm text-gray-600">Marital Status</p>
                <p class="text-sm font-medium text-gray-800">
                    {{
                        capitalizeWords(props.personalInfo.marital_status) ||
                        '-'
                    }}
                </p>
            </div>
        </div>
        <div class="mb-4 flex justify-between">
            <div class="w-1/2">
                <p class="text-sm text-gray-600">Religion</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ capitalizeWords(props.personalInfo.religion) || '-' }}
                </p>
            </div>
            <div class="w-1/2 text-left">
                <p class="text-sm text-gray-600">Blood Group</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ props.personalInfo.blood_group || '-' }}
                </p>
            </div>
        </div>
    </div>
    <!-- Personal Contact Info -->
    <div class="mx-48 mt-6 rounded-xl border border-gray-300 bg-white p-4">
        <div class="mb-2 text-start font-semibold text-gray-800">Contact</div>
        <hr class="mb-4" />

        <div class="mb-4 flex justify-between">
            <div class="w-1/2">
                <p class="text-sm text-gray-600">Personal Phone Number</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ props.personalInfo.personal_contact_no || '-' }}
                </p>
            </div>
            <div class="w-1/2 text-left">
                <p class="text-sm text-gray-600">Personal Email Address</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ props.personalInfo.personal_email || '-' }}
                </p>
            </div>
        </div>
    </div>
    <!-- Address Info -->
    <div class="mx-48 mt-6 rounded-xl border border-gray-300 bg-white p-4">
        <div class="mb-2 text-start font-semibold text-gray-800">Address</div>
        <hr class="mb-4" />

        <div class="mb-4 flex justify-between">
            <div class="w-1/2">
                <p class="text-sm text-gray-600">Present Address</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ props.personalInfo.present_street_address }},{{
                        props.personalInfo.present_state
                    }},{{ props.personalInfo.present_city }},
                    {{ props.personalInfo.present_postal_code }},
                    {{ props.personalInfo.present_country }}
                </p>
                <p class="pt-1 text-sm text-gray-600">Permanent Address</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ props.personalInfo.permanent_street_address }},{{
                        props.personalInfo.permanent_state
                    }},{{ props.personalInfo.permanent_city }},
                    {{ props.personalInfo.permanent_postal_code }},
                    {{ props.personalInfo.permanent_country }}
                </p>
            </div>
        </div>
    </div>
    <!-- Emergency/Family Contact Info -->
    <div class="mx-48 mt-6 rounded-xl border border-gray-300 bg-white p-4">
        <div class="mb-2 text-start font-semibold text-gray-800">
            Emergency/Family Contact
        </div>
        <hr class="mb-4" />
        <ContactCard
            v-for="contact in personalInfo.contacts"
            :key="contact.name + contact.relationship"
            :contact="contact"
            :countries="countries"
            class="mt-4"
            readonly
        />
    </div>
    <!-- Other Document Info -->
    <div class="mx-48 mt-6 rounded-xl border border-gray-300 bg-white p-4">
        <div class="mb-2 text-start font-semibold text-gray-800">
            Other Documents
        </div>
        <hr class="mb-4" />

        <div v-for="document in personalInfo.documents" :key="document.id">
            <DocumentItem
                class="mt-2"
                :attachment="document.url"
                :label="document.type"
                :expiry-date="document.expiry_date"
            />
        </div>
    </div>
</template>
<style></style>
