<script lang="ts" setup>
import PageHeader from '@/Components/PageHeader.vue';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth.user;

const today = new Date().toLocaleDateString('en-US', {
    weekday: 'long',
    month: 'long',
    day: 'numeric',
    year: 'numeric',
});
</script>

<template>
    <Head title="Dashboard" />

    <PageHeader
        :title="'Welcome back, ' + user.first_name"
        subtitle="It's so good to see you again! Let's catch up on all the updates you missed."
        :title-meta="today"
    >
        <template #rightSideContent>
            <div class="flex gap-3">
                <Button class="button">
                    <SvgIcon name="settings-03" />
                    Customize
                </Button>
                <Button class="button">
                    <SvgIcon name="bell-01" />
                </Button>
            </div>
        </template>
    </PageHeader>
</template>

<style>
.button {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    padding: 10px;
    gap: 8px;

    height: 40px;

    background: #ffffff;
    border: 1px solid #d0d5dd;

    box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
    border-radius: 8px;

    font-style: normal;
    font-weight: 600;
    font-size: 14px;
    line-height: 20px;

    color: #1d2939;
}
</style>
