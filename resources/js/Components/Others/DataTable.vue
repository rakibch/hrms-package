<script setup lang="ts">
import Popover from '@/Components/Others/Popover.vue';
import SearchInput from '@/Components/Others/SearchInput.vue';
import {
    EllipsisVerticalIcon,
    EyeIcon,
    PencilIcon,
} from '@heroicons/vue/16/solid';
import { Button, Checkbox } from '@softzino/st-uikit';
import { computed, ref } from 'vue';

type SortDirections = Record<string, 'asc' | 'desc' | undefined>;

interface Column {
    label: string;
    key: string;
    sortable?: boolean;
    minWidth?: string;
    align?: 'left' | 'center' | 'right';
}

interface Props {
    tableTitle?: string;
    columns: Column[];
    values: null | any[];
    totalValue?: number;
    selectionMode?: 'single' | 'multiple';
}

const props = withDefaults(defineProps<Props>(), {
    columns: () => [],
    values: () => [],
});

const emits = defineEmits<{
    (
        e: 'row-select',
        payload: { index: number; rowData: any; selected: boolean },
    ): void;
    (e: 'select-all', allSelected: boolean): void;
    (
        e: 'sort-change',
        payload: { columnKey: string; direction: 'asc' | 'desc' | undefined },
    ): void;
    (e: 'search-change', searchText: string): void;
    (
        e: 'row-action',
        payload: { index: number; rowData: any; action: string },
    ): void;
    (e: 'row-click', payload: { index: number; rowData: any }): void;
    (e: 'filter-click'): void;
}>();

const sortDirections = ref<SortDirections>({});
const sortBy = ref<string | null>(null);
const selectedRows = ref<Set<number>>(new Set());
const searchText = ref<string>('');
const hidePopover = ref(false);

function sort(columnKey: string) {
    if (!props.columns.find((col) => col.key === columnKey)?.sortable) return;

    const newDirection =
        sortDirections.value[columnKey] === 'asc' ? 'desc' : 'asc';
    sortDirections.value[columnKey] = newDirection;
    sortBy.value = columnKey;

    emits('sort-change', {
        columnKey,
        direction: newDirection,
    });
}

function toggleRowSelection(index: number) {
    if (selectedRows.value.has(index)) {
        selectedRows.value.delete(index);
        emits('row-select', {
            index,
            rowData: props.values?.[index],
            selected: false,
        });
        return;
    }

    if (props.selectionMode === 'single') {
        selectedRows.value.clear();
    }

    selectedRows.value.add(index);
    emits('row-select', {
        index,
        rowData: props.values?.[index],
        selected: true,
    });
}

function toggleAllRowSelection() {
    if (props.selectionMode === 'single') {
        return;
    }

    const allSelected = selectedRows.value.size !== props.values?.length;
    selectedRows.value = allSelected
        ? new Set(props.values?.map((_, index) => index))
        : new Set();

    emits('select-all', allSelected);
}

const filteredValues = computed(() => {
    if (!props.values) return [];
    const lowerSearchText = searchText.value.toLowerCase();

    return (
        props.values?.filter((row) => {
            return props.columns.some((col) => {
                const cellValue = row[col.key];
                return (
                    cellValue &&
                    String(cellValue).toLowerCase().includes(lowerSearchText)
                );
            });
        }) || []
    );
});

const sortedValues = computed(() => {
    if (!sortBy.value || !filteredValues.value) return filteredValues.value;

    const direction = sortDirections.value[sortBy.value] === 'asc' ? 1 : -1;

    return [...filteredValues.value].sort((a, b) => {
        if (sortBy.value && a[sortBy.value] > b[sortBy.value]) return direction;
        if (sortBy.value && a[sortBy.value] < b[sortBy.value])
            return -direction;
        return 0;
    });
});

function handleRowAction(index: number, action: string) {
    if (!props.values) return;

    hidePopover.value = true;
    emits('row-action', {
        index,
        rowData: props.values[index],
        action,
    });
}

function onSearchInput(value: string) {
    emits('search-change', value);
}

function handleFilterClick() {
    emits('filter-click');
}
</script>
<template>
    <div class="table-container">
        <slot name="table-header">
            <div class="flex justify-between p-6">
                <slot name="table-header-left">
                    <div class="flex items-center gap-2">
                        <p
                            class="text-lg font-semibold leading-7 text-gray-800"
                        >
                            All {{ tableTitle }}
                        </p>
                        <span class="table-data-count">
                            {{ totalValue ?? sortedValues?.length ?? 0 }}
                            {{ tableTitle }}
                        </span>
                    </div>
                </slot>

                <slot name="table-header-right">
                    <div class="flex items-center gap-4">
                        <SearchInput
                            v-model="searchText"
                            @input="onSearchInput"
                        />

                        <Button
                            class="button"
                            style="height: 40px"
                            @click="handleFilterClick"
                        >
                            <SvgIcon name="filter-lines" />
                            Filter
                        </Button>
                    </div>
                </slot>
            </div>
        </slot>

        <div class="overflow-x-auto">
            <table class="relative table min-w-full">
                <thead class="table-header">
                    <tr class="py-3">
                        <th
                            v-if="selectionMode"
                            class="sticky left-0 z-10 pl-6"
                        >
                            <Checkbox
                                class="checkbox"
                                :disabled="selectionMode === 'single'"
                                :checked="
                                    values?.length !== 0 &&
                                    selectedRows.size === values?.length
                                "
                                @click="toggleAllRowSelection"
                            />
                        </th>

                        <th
                            scope="col"
                            v-for="col in columns"
                            :key="col.key"
                            :class="[
                                'px-1.5',
                                { 'cursor-pointer': col.sortable },
                            ]"
                            :aria-sort="
                                sortBy === col.key
                                    ? sortDirections[col.key] === 'asc'
                                        ? 'ascending'
                                        : 'descending'
                                    : 'none'
                            "
                            :style="{ minWidth: col?.minWidth }"
                            @click="sort(col.key)"
                        >
                            <slot
                                :name="'table-column-header-' + col.key"
                                :header="col"
                            >
                                <div class="column-header">
                                    {{ col.label }}

                                    <span v-if="col.sortable">
                                        <SvgIcon
                                            v-if="
                                                sortDirections[col.key] ===
                                                'asc'
                                            "
                                            name="arrow-up"
                                            width="16px"
                                            height="16px"
                                        />
                                        <SvgIcon
                                            v-else
                                            name="arrow-down"
                                            class="arrow"
                                            width="16px"
                                            height="16px"
                                        />
                                    </span>
                                </div>
                            </slot>
                        </th>

                        <th class="sticky right-0 z-10 px-1.5">
                            <slot
                                name="table-column-header-action"
                                header="Action"
                            >
                                <div class="column-header">Action</div>
                            </slot>
                        </th>
                    </tr>
                </thead>

                <tbody v-if="sortedValues?.length">
                    <tr
                        v-for="(row, index) in sortedValues"
                        :key="index"
                        class="border-b"
                    >
                        <slot name="table-row" :rowData="row" :index="index">
                            <td
                                v-if="selectionMode"
                                class="sticky left-0 z-10 py-4 pl-6"
                            >
                                <Checkbox
                                    class="checkbox"
                                    :checked="selectedRows.has(index)"
                                    @change="toggleRowSelection(index)"
                                />
                            </td>

                            <td
                                v-for="col in columns"
                                :key="`${index}-${col.key}`"
                                class="px-1.5"
                                :class="[
                                    'text-left',
                                    {
                                        'text-center': col.align === 'center',
                                        'text-right': col.align === 'right',
                                    },
                                ]"
                            >
                                <slot
                                    :name="'table-col-' + col.key"
                                    :rowData="row"
                                    :index="index"
                                >
                                    {{ row[col.key] }}
                                </slot>
                            </td>

                            <td class="sticky right-0 z-10">
                                <slot name="actions" :row="row" :index="index">
                                    <div
                                        class="flex items-center justify-center"
                                    >
                                        <Popover
                                            :position="'bottom-right'"
                                            :showArrow="false"
                                            :hide-popover="hidePopover"
                                        >
                                            <button>
                                                <EllipsisVerticalIcon
                                                    class="flex h-5 w-5 justify-start hover:text-primary-600"
                                                />
                                            </button>

                                            <template #content>
                                                <div
                                                    class="w-[200px] px-0.5 py-1"
                                                >
                                                    <Button
                                                        class="m-0 flex w-full items-center justify-start gap-2 bg-transparent py-2 pl-1 text-darkslategrey-800 hover:bg-gray-100"
                                                        @click="
                                                            handleRowAction(
                                                                index,
                                                                'view',
                                                            )
                                                        "
                                                    >
                                                        <EyeIcon
                                                            class="flex h-5 w-5 justify-start hover:text-primary-600"
                                                        />
                                                        <span> View </span>
                                                    </Button>

                                                    <Button
                                                        class="m-0 flex w-full items-center justify-start gap-2 bg-transparent py-2 pl-1 text-darkslategrey-800 hover:bg-gray-100"
                                                        @click="
                                                            handleRowAction(
                                                                index,
                                                                'edit',
                                                            )
                                                        "
                                                    >
                                                        <PencilIcon
                                                            class="flex h-5 w-5 justify-start hover:text-primary-600"
                                                        />
                                                        <span> Edit </span>
                                                    </Button>
                                                </div>
                                            </template>
                                        </Popover>
                                    </div>
                                </slot>
                            </td>
                        </slot>
                    </tr>
                </tbody>

                <tr v-else>
                    <td
                        :colspan="columns.length + (selectionMode ? 1 : 0)"
                        class="empty-state-cell"
                    >
                        <slot name="empty">
                            <div>No data available</div>
                        </slot>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>
<style scoped lang="scss">
.table-container {
    font-weight: 500;
    font-size: 14px;
    line-height: 20px;

    color: #1d2939;

    .table {
        width: 100%;
        table-layout: auto;
        border-collapse: collapse;

        th,
        td {
            white-space: wrap;
        }

        th:first-child,
        th:last-child {
            background: #f9fafb;
        }

        tr:nth-child(even) td {
            background: #f9fafb;
        }

        tr:nth-child(odd) td {
            background: #ffffff;
        }

        .column-header {
            display: flex;
            gap: 4px;

            font-style: normal;
            font-weight: 500;
            font-size: 12px;
            line-height: 18px;
            color: #475467;
        }

        .empty-state-cell {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #6b7280;
            background: #ffffff !important;
        }
    }

    .table-header {
        height: 44px;
        padding: 0 24px;

        background: #f9fafb;
        border-bottom: 1px solid #d1d5db;

        .arrow {
            color: #475467;

            svg {
                width: 9.33px;
                height: 9.33px;
            }
        }
    }

    .button {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 0;
        gap: 12px;

        width: 95px;
        height: 40px;

        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 20px;

        color: #1d2939;

        background: #ffffff;
        border: 1px solid #d0d5dd;
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
        border-radius: 8px;
    }

    .button:hover {
        background: #f9fafb;
    }

    .checkbox {
        display: block;
        width: 20px;
        height: 20px;

        background: #ffffff;
        border: 1px solid #d0d5dd;
        border-radius: 6px;
    }

    .table-data-count {
        border: 1px solid #d0d5dd;
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
        border-radius: 6px;

        padding: 2px 8px;
        height: 24px;

        font-style: normal;
        font-weight: 500;
        font-size: 14px;
        line-height: 20px;
        text-align: center;

        color: #344054;
    }
}
</style>
