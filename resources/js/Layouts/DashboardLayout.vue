<template>
    <div class="bg-dark-600 flex h-screen">
        <nav class="h-full w-60 hidden md:block flex-shrink-0 py-6 px-2 space-y-2 bg-dark-800">
            <nav-item :url="route('dashboard.home')"
                      :active="route().current('dashboard.home')"
            >
                Dashboard
            </nav-item>
            <nav-item :url="route('dashboard.product.index')"
                      :active="route().current('dashboard.product.index')"
            >
                Producten
            </nav-item>
            <nav-item :url="route('dashboard.order.index')"
                      :active="route().current('dashboard.order.index')"
            >
                Bestellingen
            </nav-item>
            <nav-item :url="route('dashboard.user.index')"
                      :active="route().current('dashboard.user.index')"
            >
                Gebruikers
            </nav-item>
        </nav>
        <main class="flex-1 overflow-y-auto py-4 px-6">
            <div class="pb-4 px-6 text-xl text-dark-100 flex justify-between">
                <h2>{{ title }}</h2>
                <slot name="extra" />
            </div>
            <slot></slot>
        </main>
    </div>
</template>

<script>
import NavItem from "../Components/NavItem";
export default {
    name: "DashboardLayout",
    components: {NavItem},
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
