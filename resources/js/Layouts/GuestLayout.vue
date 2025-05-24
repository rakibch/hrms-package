<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Content Security Policy -->
        <head>
            <meta
                http-equiv="Content-Security-Policy"
                content="upgrade-insecure-requests"
            />
        </head>

        <!-- Slot for dynamic content (login form, etc.) -->
        <slot />
    </div>
</template>
