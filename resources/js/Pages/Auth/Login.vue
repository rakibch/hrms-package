<script setup lang="ts">
import TextInput from '@/Components/Others/TextInput.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineOptions({ layout: GuestLayout });

const form = useForm({
    user_name: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <div
        class="mx-auto flex min-h-screen w-full max-w-sm flex-col items-center justify-center"
    >
        <div class="flex w-full max-w-[440px] flex-col items-center gap-5">
            <div class="mb-6 flex flex-col items-center justify-center">
                <img
                    class="mb-6 h-16 w-20"
                    src="/images/hrms-logo-mark.svg"
                    alt="Softzino"
                />

                <h2
                    class="text-center text-[30px] font-semibold leading-[38px] text-gray-800"
                >
                    Log in to your account
                </h2>
                <p
                    class="text-center text-base font-normal leading-6 text-gray-600"
                >
                    Welcome back! Please enter your details.
                </p>
            </div>

            <form
                @submit.prevent="submit"
                class="flex h-[284px] w-[440px] flex-col items-center gap-6 rounded-xl bg-white p-8 shadow-sm"
            >
                <TextInput
                    v-model="form.user_name"
                    label="Username"
                    placeholder="Enter your username"
                    :error="form.errors.user_name"
                    :maxlength="60"
                    class="w-full"
                />

                <TextInput
                    v-model="form.password"
                    label="Password"
                    type="password"
                    placeholder="Enter your password"
                    :error="form.errors.password"
                    :maxlength="32"
                    class="w-full"
                />

                <Button
                    type="submit"
                    class="shadow-xs flex h-[44px] w-full items-center justify-center gap-2 rounded-lg border border-gray-600 bg-gray-700 px-4 py-2 text-white hover:bg-gray-50 hover:text-gray-700"
                    :disabled="form.processing"
                >
                    Sign in
                </Button>
            </form>
        </div>
    </div>
</template>
