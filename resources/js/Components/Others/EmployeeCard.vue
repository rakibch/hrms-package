<script setup lang="ts">
import { onMounted } from "vue";

interface Employee {
    id: string;
    name: string;
    designation: string;
    avatar: string;
    employee_no: string;
    [key: string]: any;
}

const props = defineProps<{
    employee: Employee;
}>();

</script>

<template>
    <div class="flex items-center justify-between py-1.5">
        <div class="flex items-center space-x-2.5">
            <img
                :src="employee.avatar"
                alt="Avatar"
                class="h-8 w-8 rounded-full object-cover"
            />
            <div>
                <p class="text-sm font-semibold leading-5 text-gray-800">
                    {{ employee.name }}
                </p>
                <p class="text-xs leading-[14px] text-gray-600">
                    {{ employee.employee_no }}
                </p>
            </div>
        </div>

        <slot name="right-side" v-bind="employee">
            <p
                class="text-right text-xs font-medium leading-[18px] text-gray-700"
            >
                {{ employee.designation }}
            </p>
        </slot>
    </div>
</template>

<style scoped></style>
