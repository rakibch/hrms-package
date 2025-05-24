<template>
    <nav class="w-full h-[66px] flex justify-between">
        <slot name="left"> </slot>

        <div class="w-auto">
            <slot name="right"></slot>
        </div>
    </nav>
</template>

<script setup lang="ts"></script>
