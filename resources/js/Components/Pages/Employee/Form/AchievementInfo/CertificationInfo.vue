<script setup lang="ts">
import { Certification } from '@/App/Interfaces/employees';
import DocumentItem from '@/Components/Others/DocumentItem.vue';
import CertificationInfoModal from '@/Components/Pages/Employee/Modal/CertificationInfoModal.vue';
import { ref } from 'vue';

const certificationList = defineModel<Certification[]>({
    default: [],
});

const isFormModalOpen = ref(false);
const selectedCertification = ref<Certification | null>(null);
const editingIndex = ref<number | null>(null);

const openModal = (certificate?: Certification, index?: number) => {
    if (certificate && typeof index === 'number') {
        selectedCertification.value = { ...certificate };
        editingIndex.value = index;
    } else {
        selectedCertification.value = null;
        editingIndex.value = null;
    }
    isFormModalOpen.value = true;
};

const closeActionModal = () => {
    isFormModalOpen.value = false;
    selectedCertification.value = null;
    editingIndex.value = null;
};

const addCertification = (certificate: Certification) => {
    if (editingIndex.value !== null) {
        certificationList.value.splice(editingIndex.value, 1, certificate);
    } else {
        certificationList.value.push({
            ...certificate,
            isNew: true,
            });
    }
    closeActionModal();
};

const formatDate = (date: string | Date | null): string => {
    if (!date) return '';
    const options: Intl.DateTimeFormatOptions = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };
    return new Date(date).toLocaleDateString('en-US', options);
};

const viewFile = (file: any): void => {
    if (file.isImage) {
        const imageUrl = file.preview;
        const imgWindow = window.open();
        imgWindow?.document.write(
            `<img src="${imageUrl}" alt="File Preview" style="width: 100%; height: auto;" />`,
        );
    } else if (!file.isImage) {
        let pdfUrl = file.preview;

        if (file.preview.startsWith('data:')) {
            // If the file.preview contains a Base64 data URL, use it directly
            pdfUrl = file.preview;
        } else if (!file.preview.startsWith('http')) {
            // If it's a relative path, construct the full URL
            pdfUrl = `${window.location.origin}/${file.preview}`;
        }
        window.open(pdfUrl, '_blank');
    } else {
        alert('Preview is only available for images.');
    }
};

const removeCertificate = (index: number) => {
    if (certificationList.value[index].isNew) {
        certificationList.value.splice(index, 1); // hard delete
    } else {
        const item = {
            ...certificationList.value[index],
            _delete: true
        };
        certificationList.value.splice(index, 1, item); // soft delete
    }
};

</script>

<template>
    <div class="w-full rounded-xl border border-gray-200 p-4">
        <div
            class="mb-4 flex items-center justify-between border-b border-gray-200 pb-4 font-semibold text-gray-800"
        >
            <span>Certification Information</span>
            <span
                class="cursor-pointer font-semibold text-gray-800"
                @click="openModal"
            >
                + Add New
            </span>
        </div>

        <div>
            <div v-if="certificationList.length">
                <ul
                    v-for="(certificate, index) in certificationList"
                    :key="index"
                >
                    <li v-if="!certificate._delete">
                        <div class="flex items-center justify-between">
                            <strong class="text-gray-700">
                                {{ certificate.issuing_organization }}
                            </strong>

                            <span class="cursor-pointer text-sm text-gray-600"  @click="openModal(certificate, index)">
                                Edit
                            </span>
                        </div>
                        <div
                            class="mt-4 relative rounded-xl border border-gray-200 bg-gray-50 p-4"
                        >
                            <!-- Trash Icon Top Right -->
                            <div class="absolute top-1/2 right-2 -translate-y-1/2">
                                <button
                                    @click="removeCertificate(index)"
                                    class="text-red-500 hover:text-red-700"
                                    title="Delete"
                                >
                                    <SvgIcon name="trash" />
                                </button>
                            </div>


                            <div>
                                <p class="text-sm leading-[20px] text-gray-600">Course Name</p>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ certificate.course_name }}
                                </p>

                                <p class="mt-3 text-sm leading-[20px] text-gray-600">Duration</p>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ formatDate(certificate.start_date) }} -
                                    {{ formatDate(certificate.completion_date) }}
                                </p>

                                <p class="mt-4 inline-flex items-center text-sm text-gray-500">
                                    <SvgIcon name="date" :width="15" />
                                    <span class="pl-2">Completed On:</span>
                                    <span class="pl-2">{{ formatDate(certificate.completion_date) }}</span>
                                </p>
                                <p class="text-gray-700">Share Links</p>
                                {{ certificate.certificate_urls }}
                            </div>
                        </div>

                    </li>
                </ul>
            </div>
            <div class="flex flex-col items-center justify-center" v-else>
                <div class="rounded-md border border-gray-200 p-2">
                    <SvgIcon name="info-files" />
                </div>
                <p class="pt-4 font-semibold text-gray-800">
                    No Certification Information
                </p>
                <p class="pt-[2px] text-gray-600">
                    No information added yet. To add information click on new
                    add new button
                </p>
            </div>
        </div>
    </div>
    <CertificationInfoModal
        :is-modal-open="isFormModalOpen"
        @onSubmit="addCertification"
        @close="closeActionModal"
        :certification="selectedCertification"
    />
</template>

<style scoped></style>
