<template>
    <nav class="flex flex-1 flex-col">
        <div class="parent flex flex-col justify-between h-full">
            <div class="flex-grow">
                <ul
                    v-for="item in menus"
                    class="flex flex-col justify-start space-y-1"
                >
                    <li class="mx-4">
   
                        <MenuLink
                            :name="item.name"
                            :routeName="item.routeName"
                        />
                    </li>
                </ul>
            </div>    
        </div>
    </nav>
</template>

<script lang="ts" setup>
import { usePage } from "@inertiajs/vue3";
import { Menu } from "@/App/Types/menu";
import MenuLink from "@/Layouts/Partials/MenuLink.vue";

withDefaults(defineProps<{ menus: Menu[] }>(), {
    menus: () => [],
});
</script>
