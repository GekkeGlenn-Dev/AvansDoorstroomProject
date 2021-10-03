<template>
    <td v-if="!edit" class="px-4 py-2 whitespace-nowrap">
        <slot></slot>
    </td>
    <td v-else class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">
        <slot></slot>
<!--        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>-->
    </td>
</template>

<script>
export default {
    name: "TableData",
    props: {
        edit: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>

</style>
