<template>
    <div class="bg-dark-800 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-dark-100">
                {{ title }}
            </h3>
            <p v-if="subtitle" class="mt-1 max-w-2xl text-sm text-gray-400">
                {{ subtitle }}
            </p>
        </div>
        <div class="border-t border-dark-100">
            <dl>
                <slot></slot>
            </dl>
        </div>
    </div>
</template>

<script>
export default {
    name: "DataList",
    props: {
        title: String,
        subtitle: String,
    }
}
</script>

<style scoped>

</style>
