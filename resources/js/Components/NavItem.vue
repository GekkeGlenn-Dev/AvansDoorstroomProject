<template>
    <inertia-link
        :href="url"
        :class="active ? 'bg-dark-700' : ''"
        class="py-2 px-4 block text-dark-100 rounded transition-colors duration-150 ease-in-out border border-dark-800 hover:text-dark-green hover:border-dark-green"
    >
        <slot />
    </inertia-link>
</template>

<script>
export default {
    name: "NavItem",
    props: {
        url: {
            type: String,
            required: true,
        },
        active: {
            type: Boolean,
            default: false,
        }
    }
}
</script>

<style scoped>

</style>
