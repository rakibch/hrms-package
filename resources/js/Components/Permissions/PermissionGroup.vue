<script setup lang="ts">

import PermissionHead from "@/Components/Permissions/PermissionHead.vue";
import PermissionRow from "@/Components/Permissions/PermissionRow.vue";
import {type PermissionRow as IPermissionRow} from "@/App/Types/permission";
import {ref} from "vue";

const emit = defineEmits<{
    syncPermission: [id: number, action: 'checked' | 'uncheck'];
}>()

const props = defineProps<{
    name: string,
    permissions: IPermissionRow[],
    columns: string[],
    selectedPermissions: number[];
}>();

const selected = ref<number[]>([]);
const handlePermission = (id: number, action: 'checked' | 'uncheck') => {
    emit('syncPermission', id, action)
}


</script>

<template>
    <div>
        <div class="font-semibold text-xl mb-3">{{ name }}</div>
        <div class="w-full h-[1px] bg-gray-300"></div>
        <div class="ml-10 mt-4 w-auto">
            <PermissionHead :columns="columns"/>
            <PermissionRow :selected-permission="selectedPermissions" @change="handlePermission" v-for="(permission, i) in permissions"
                           :key="`permission-row-${i}-${permission.name}`" :permissions="permission.value" :label="permission.name"
                           v-model="selected"/>
            <div class="w-full h-[1px] bg-gray-200 my-3"></div>

        </div>
    </div>
</template>

<style scoped>

</style>
