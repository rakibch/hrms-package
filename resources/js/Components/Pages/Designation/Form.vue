<script setup lang="ts">
import { Department } from '@/App/Interfaces/departments';
import { Designation } from '@/App/Interfaces/designations';
import { showToast } from '@/App/Utils';
import Dropdown from '@/Components/Others/Dropdown.vue';
import MultiSelect from '@/Components/Others/MultiSelect.vue';
import TextInput from '@/Components/Others/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { Button, ModalDialog } from '@softzino/st-uikit';
import { ref, watch } from 'vue';

interface DesignationFromData {
  name: string;
  departments: number[];
  reporting_to_designation_id: number | null;
}
interface Props {
  departments: Department[];
  designations: Designation[];
  designation?: Designation;
  isModalOpen: boolean;
}

const props = defineProps<Props>();

const emits = defineEmits<{
  (e: 'close'): void;
}>();
const page = usePage();
const loading = ref(false);

const designationOptions = ref(
  props.designations.map((designation) => ({
    label: designation.name,
    value: designation.id,
  })) ?? [],
);

const form = useForm<DesignationFromData>({
  name: props?.designation?.name || '',
  departments: props?.designation?.departments.map((dept) => dept.id) || [],
  reporting_to_designation_id:
    props?.designation?.reporting_to_designation_id || null,
});

const handleFormSubmit = () => {
  console.log('Form data:', form);

  if (loading.value) return;
  loading.value = true;
  const url = props?.designation
    ? route('designations.update', { id: props.designation.id })
    : route('designations.store');

  const method = props?.designation ? 'put' : 'post';

  form['post'](url, {
    onSuccess: () => {
      const successMessage = page.props.flash?.success;
      if (successMessage) {
        showToast('success', successMessage, 3000, 'top-right');
      }
      handleClose();
      emits('close');
    },
    onError: () => {
      if (page.props?.errors) {
        showToast('error', 'Something went wrong!', 3000, 'top-right');
      }
      loading.value = false;
    },
    onFinish: () => {
      loading.value = false; // Ensure it's reset after request finishes
    },
  });
};

const resetForm = () => {
  form.reset();
  form.clearErrors();
};

const handleClose = () => {
  resetForm();
  emits('close');
};

watch(
  () => props.designation,
  () => {
    form.name = props?.designation?.name || '';
    form.departments =
      props?.designation?.departments.map((dept) => dept.id) || [];
    form.reporting_to_designation_id =
      props?.designation?.supervisor?.id || null;

    designationOptions.value = designationOptions.value.filter(
      (designation) => {
        return designation.value !== props?.designation?.id;
      },
    );
  },
  { deep: true },
);
</script>

<template>
  <div class="modal-dialog">
    <ModalDialog
      :isOpen="isModalOpen"
      :disableOutSideClick="true"
      :showIcon="false"
      @modal-close="emits('close')"
    >
      <template #content>
        <div class="form-container px-1 text-left">
          <h3 class="title">
            {{ props?.designation ? 'Edit Designation' : 'Create Designation' }}
          </h3>
          <p class="sub-title">
            You are about to
            {{ props?.designation ? 'edit' : 'create' }} a designation.
          </p>

          <form @submit.prevent="handleFormSubmit" class="mt-5">
            <TextInput
              label="Name of the Designation"
              v-model="form.name"
              required
              placeholder="e.g. UX Engineer"
              :error="form.errors?.name"
            />

            <MultiSelect
              class="mt-2"
              v-model="form.departments"
              :options="departments"
              label="Departments"
              placeholder="Select"
              required
              clearable
              :error="form.errors?.departments"
            />

            <Dropdown
              label="Reporting Designation"
              placeholder="Select"
              v-model="form.reporting_to_designation_id"
              :options="designationOptions"
              :error="form.errors?.reporting_to_designation_id"
            />

            <div class="mt-5 flex justify-end gap-3">
              <Button class="base-button" @click="handleClose" type="button">
                Close
              </Button>
              <Button
                :class="['base-button create-button']"
                :disabled="loading || !form.name || !form.departments.length"
                type="submit"
              >
                {{
                  loading
                    ? 'Processing...'
                    : props?.designation
                      ? 'Update'
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
  width: 500px;
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
  box-shadow: 0px 1px 2px rgba(16, 24, 40, 0.05);
  border-radius: 8px;
}

.option-avatar {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 0px;

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
