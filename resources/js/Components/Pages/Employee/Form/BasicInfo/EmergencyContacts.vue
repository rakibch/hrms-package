<script setup lang="ts">
import { ContactFormData } from '@/App/Interfaces/employees';
import EmptyListView from '@/Components/Others/EmptyListView.vue';
import ContactCard from '@/Components/Pages/Employee/Form/BasicInfo/ContactCard.vue';
import ContactForm from '@/Components/Pages/Employee/Form/BasicInfo/ContactForm.vue';
import { ref } from 'vue';

const contacts = defineModel<ContactFormData[]>({
    default: [],
});

const props = defineProps<{
    countries: Array<{
        id: number;
        name: string;
        iso2_code: string;
        phone_code: string;
    }>;
}>();

const isModalOpen = ref(false);
const editableContact = ref<null | ContactFormData>(null);
const editableContactIndex = ref<number | null>(null);

function closeForm() {
    isModalOpen.value = false;
}

function handleFormSubmit(contact: ContactFormData) {
    if (editableContactIndex.value !== null) {
        contacts.value[editableContactIndex.value] = contact;
        editableContactIndex.value = null;
        editableContact.value = null;
        closeForm();
        return;
    }

    contacts.value = [...contacts.value, contact];
    closeForm();
}

function editContact(contact: ContactFormData, index: number) {
    editableContact.value = contact;
    editableContactIndex.value = index;
    isModalOpen.value = true;
}
</script>

<template>
    <div class="w-full rounded-xl border border-gray-200 p-4">
        <div
            class="mb-4 flex items-center justify-between border-b border-gray-200 pb-4"
        >
            <div class="font-semibold leading-5 text-gray-800">
                Emergency/Family Contact
            </div>

            <button
                type="button"
                class="text-sm font-semibold leading-[20px] text-gray-600"
                @click="isModalOpen = true"
            >
                + Add New
            </button>
        </div>

        <div>
            <div v-if="contacts.length">
                <ContactCard
                    v-for="(contact, index) in contacts"
                    :key="contact.name + contact.relationship"
                    :contact="contact"
                    :countries="countries"
                    class="mt-4"
                    @edit="editContact(contact, index)"
                />
            </div>

            <EmptyListView
                v-else
                title="No Emergency/Family Contact Information"
                description="No data added yet. To add data click on add new button."
            />
        </div>

        <ContactForm
            v-if="editableContact"
            :is-modal-open="isModalOpen"
            :form-data="editableContact"
            :countries="countries"
            @close="closeForm"
            @on-submit="handleFormSubmit"
        />

        <ContactForm
            v-else
            :is-modal-open="isModalOpen"
            :countries="countries"
            @close="closeForm"
            @on-submit="handleFormSubmit"
        />
    </div>
</template>

<style scoped></style>
