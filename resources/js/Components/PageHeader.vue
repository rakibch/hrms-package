<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface BreadCrumb {
    name: string;
    routeName: string;
}

interface Props {
    breadCrumbs?: BreadCrumb[];
    title: string;
    titleMeta?: string;
    subtitle: string;
    showBorderBottom?: boolean;
}

withDefaults(defineProps<Props>(), {
    showBorderBottom: true,
});
</script>

<template>
    <div :class="[{ 'border-b-2': showBorderBottom }, 'pb-5']">
        <div class="flex" v-if="breadCrumbs?.length">
            <Link
                :key="breadCrumb.routeName"
                v-for="(breadCrumb, index) in breadCrumbs"
                :href="route(breadCrumb.routeName)"
                :class="[
                    'breadcrumb-link',
                    { 'link-active': index === breadCrumbs.length - 1 },
                ]"
            >
                {{ breadCrumb.name }}
                <span class="px-1" v-if="index !== breadCrumbs.length - 1">
                    >
                </span>
            </Link>
        </div>

        <div :class="['flex justify-between', { 'mt-5': breadCrumbs?.length }]">
            <slot name="leftSideContent">
                <div>
                    <slot name="title">
                        <div class="flex gap-2">
                            <h3 class="title">{{ title }}</h3>
                            <slot name="titleMeta">
                                <div class="title-meta" v-if="titleMeta">
                                    {{ titleMeta }}
                                </div>
                            </slot>
                        </div>
                    </slot>

                    <p class="sub-title">{{ subtitle }}</p>
                </div>
            </slot>

            <slot name="rightSideContent" />
        </div>
    </div>
</template>

<style scoped>
.breadcrumb-link {
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 20px;

    color: #475467;
}

.link-active {
    font-style: normal;
    font-weight: 600;
    font-size: 14px;
    line-height: 20px;

    color: #374151;
}

.title {
    font-style: normal;
    font-weight: 600;
    font-size: 30px;
    line-height: 38px;

    color: #1d2939;
}

.sub-title {
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 24px;

    color: #475467;
}

.title-meta {
    box-sizing: border-box;

    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 4px 10px;

    background: #f9fafb;
    border: 1px solid #eaecf0;
    border-radius: 8px;
}
</style>
