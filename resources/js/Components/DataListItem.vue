<template>
    <div class="odd:bg-dark-700 text-dark-100 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium">
            <slot name="term"></slot>
        </dt>
        <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
            <slot></slot>
        </dd>
    </div>
</template>

<script>
export default {
    name: "DataListItem"
}
</script>

<style scoped>

</style>
