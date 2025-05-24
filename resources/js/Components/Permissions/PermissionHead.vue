<script setup lang="ts">
defineProps<{
    columns: string[]
}>()


</script>

<template>
    <div class="flex w-full justify-between px-4">
        <div class="font-semibold">Section</div>
        <div class="flex justify-end w-[700px]">
            <div class="permission-column text-center" :class="{
                'px-4': i !== 0
            }" v-for="(cell, i) in columns" :key="`p-head-${i}`">
                {{ cell }}
            </div>
        </div>
    </div>
    <div class="w-full h-[1px] bg-gray-300 my-3"></div>
</template>

