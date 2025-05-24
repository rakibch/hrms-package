<script setup lang="ts">
import Permission from "@/App/Types/permission";
import { computed, onMounted } from "vue";

const props = defineProps<{
    permissions: Permission[];
    label: string;
    selectedPermission: number[];
}>();

const emit = defineEmits<{
    change: [permission: number, action: "checked" | "uncheck"];
}>();

const selected = defineModel<number[]>({ required: true });

const selectAllPermission = computed(() => {
    return props.permissions.find((p: Permission) =>
        isPatternMatchedForAllSelected(p.name)
    );
});

function isChecked(id: number) {
    return selected.value.includes(id);
}

function isPatternMatchedForAllSelected(value: string) {
    const regex = new RegExp(".\\*$", "g");
    return regex.test(value);
}

function onChange(permission: Permission, event: Event) {
    const target = event.target as HTMLInputElement;
    const state = target.checked;

    if (state && isPatternMatchedForAllSelected(permission.name)) {
        const newSelectedIds = props.permissions
            .map((p: Permission) => p.id)
            .filter((id) => !selected.value.includes(id));
        selected.value = [...selected.value, ...newSelectedIds];
        newSelectedIds.forEach((id) => emit("change", id, "checked"));
    }
    // Handle Deselect All
    if (!state && isPatternMatchedForAllSelected(permission.name)) {
        const deselectIds = selected.value.filter((id) =>
            props.permissions.some((p) => p.id === id)
        );
        selected.value = selected.value.filter(
            (id) => !deselectIds.includes(id)
        );
        deselectIds.forEach((id) => emit("change", id, "uncheck"));
    }

    if (
        state &&
        !isChecked(permission.id) &&
        !isPatternMatchedForAllSelected(permission.name)
    ) {
        const len = props.permissions.length > 2 ? 2 : 1;
        const arr =
            props.permissions.length - len === selected.value.length
                ? [permission.id, selectAllPermission.value!.id]
                : [permission.id];
        selected.value = [...selected.value, ...arr];
        emit("change", permission.id, state ? "checked" : "uncheck");
    }

    if (
        !state &&
        !isPatternMatchedForAllSelected(permission.name) &&
        isChecked(permission.id)
    ) {
        selected.value = [
            ...selected.value.filter((value) => {
                if (value == permission.id) {
                    return false;
                }
                return value != selectAllPermission.value!.id;
            }),
        ];
        emit("change", permission.id, state ? "checked" : "uncheck");
    }
}

onMounted(() => {
    selected.value = [...props?.selectedPermission];
});
</script>

<template>
    <div class="flex w-full justify-between px-4">
        <div>{{ label }}</div>
        <div class="flex w-[600px] justify-end">
            <div
                class="permission-column"
                v-for="(permission, index) in permissions"
            >
                <input
                    class="h-4 w-4 rounded border-gray-400 border-[1.5px]"
                    type="checkbox"
                    :key="index"
                    :checked="isChecked(permission?.id)"
                    @change="(value: Event) => onChange(permission, value)"
                />
            </div>
        </div>
    </div>
</template>
