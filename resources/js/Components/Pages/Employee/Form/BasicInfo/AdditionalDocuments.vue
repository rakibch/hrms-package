<script setup lang="ts">
import { ref, computed } from 'vue';
import { Document } from '@/App/Interfaces/employees';
import DocumentItem from '@/Components/Others/DocumentItem.vue';
import DocumentInsertModal from '@/Components/Pages/Employee/Modal/DocumentInsertModal.vue';
import { router } from '@inertiajs/vue3';

// Modal visibility & edit index
const isFormVisible = ref(false);
const editingIndex = ref<number | null>(null);

// The list of documents (v-model style)
const model = defineModel<Document[]>({
    default: [],
});

// Open "Add New" modal
const openAdd = () => {
    editingIndex.value = null;
    isFormVisible.value = true;
};

// Open "Edit" modal for a specific document
const openEdit = (idx: number) => {
    editingIndex.value = idx;
    isFormVisible.value = true;
};

// Handle add or update from modal
const addOrUpdateDocument = (doc: Document) => {
    if (editingIndex.value === null) {
        model.value.push(doc);
    } else {
        model.value.splice(editingIndex.value, 1, doc);
    }
    closeModal();
};

const viewFile = (attachment: File|string) => {
    if (typeof attachment === 'string') {
        window.open(attachment, '_blank');
    } else {
        const url = URL.createObjectURL(attachment);
        window.open(url, '_blank');
    }
};

// in <script setup lang="ts">
const removeDocument = (docToRemove: Document) => {
    const idx = model.value.findIndex(d => d === docToRemove);
    if (idx === -1) return;
    if (model.value[idx].id) {
        // mark existing doc for deletion
        model.value[idx] = { ...model.value[idx], _delete: true };
    } else {
        // brand‑new, unsaved doc: drop outright
        model.value.splice(idx, 1);
    }
};

// computed list for display: hide anything flagged _delete
const visibleDocuments = computed(() =>
    model.value.filter((d) => !d._delete)
);

// Close modal
const closeModal = () => {
    isFormVisible.value = false;
};
</script>

<template>
    <div class="w-full rounded-xl border border-gray-200 p-4">
        <div
            class="mb-4 flex items-center justify-between border-b border-gray-200 pb-4 font-semibold text-gray-800"
        >
            <span>Other Documents</span>
            <button
                class="cursor-pointer font-semibold text-gray-800"
                @click="openAdd"
            >
                + Add New
            </button>
        </div>
        <div v-if="visibleDocuments.length">
            <div
                v-for="(doc, idx) in visibleDocuments"
                :key="doc.id ?? doc.type"
                class="mb-6"
            >
                <div class="mt-2 flex items-center justify-between">
          <span class="text-sm font-medium text-gray-700">
            {{ doc.type }}
          </span>
                    <button
                        type="button"
                        class="text-sm font-semibold text-primary-700"
                        @click="openEdit(idx)"
                    >
                        Edit
                    </button>
                </div>

                <DocumentItem
                    v-for="(file, i) in doc.files"
                    :key="i"
                    class="mt-2"
                    @view="() => viewFile(file)"
                    @remove="removeDocument(doc)"
                    :attachment="file"
                    :expiry-date="doc.expiry_date"
                    hide-download-button
                />
            </div>
        </div>

        <div v-else class="flex flex-col items-center justify-center py-8">
            <div class="rounded-md border border-gray-200 p-2">
                <SvgIcon name="info-files" />
            </div>
            <p class="pt-4 font-semibold text-gray-800">No Documents Uploaded</p>
            <p class="pt-1 text-gray-600">Click "Add New" to upload documents.</p>
        </div>

        <DocumentInsertModal
            :isModalOpen="isFormVisible"
            :document="editingIndex !== null ? model[editingIndex] : undefined"
            @onSubmit="addOrUpdateDocument"
            @close="closeModal"
        />
    </div>
</template>

<style scoped>
/* add any extra spacing or styles here */
</style>
