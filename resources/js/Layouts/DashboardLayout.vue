<template>
    <div class="bg-dark-600 flex h-screen">
        <nav class="h-full hidden md:block">
            <inertia-link :href="route('dashboard.home')" class="block">Dashboard</inertia-link>
            <inertia-link :href="route('dashboard.product.index')" class="block">Producten</inertia-link>
        </nav>
        <main class="flex-1 overflow-y-auto py-4 px-6">
            <div class="pb-4 px-6 text-xl text-dark-100">
                <h2>{{ title }}</h2>
            </div>
            <slot></slot>
        </main>
    </div>
</template>

<script>

export default {
    name: "DashboardLayout",
    props: {
        title: {
            type: String,
            required: true,
        }
    }
}
</script>

<style scoped>

</style>
