<template>
    <header class="container flex justify-between items-center border-b border-gray-200 py-2 my-2">
        <inertia-link :href="route('shop')">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Bestel Snel</h1>
        </inertia-link>
        <nav class="h-full flex justify-between items-center">
            <inertia-link :href="route('basket')" type="button" class="p-2 -m-2 ml-4 sm:ml-6 text-gray-400 hover:text-gray-500">
                <span class="sr-only">Winkelmand</span>
                <ShoppingCartIcon class="w-6 h-6" aria-hidden="true"/>
            </inertia-link>

            <inertia-link :href="route('dashboard.home')" type="button" class="p-2 -m-2 ml-4 sm:ml-6 text-gray-400 hover:text-gray-500">
                <span class="sr-only">Dashboard</span>
                <UserIcon class="w-6 h-6" aria-hidden="true"/>
            </inertia-link>
        </nav>
    </header>
    <main class="container">
        <slot></slot>
    </main>
</template>

<script>
import {ShoppingCartIcon, UserIcon} from "@heroicons/vue/solid";
export default {
    name: "Layout",
    components: {
        ShoppingCartIcon,
        UserIcon
    }
}
</script>

<style scoped>

</style>
