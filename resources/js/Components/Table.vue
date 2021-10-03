<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-dark-600">
                        <thead>
                        <tr>
                            <th v-for="column in columns" scope="col" class="px-4 py-3 text-left text-xs font-medium text-dark-100 uppercase tracking-wider">
                                {{ column }}
                            </th>
                            <th v-if="options" scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Bewerken</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-dark-600">
                        <slot></slot>
<!--                        <tr v-for="row in data.data">-->
<!--                            <td v-for="(column) in columns" class="px-4 py-2 whitespace-nowrap">-->
<!--                                {{ row[column.key] }}-->
<!--                            </td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap">-->
<!--                                <div class="flex items-center">-->
<!--                                    <div class="flex-shrink-0 h-10 w-10">-->
<!--                                        <img class="h-10 w-10 rounded-full" :src="person.image" alt=""/>-->
<!--                                    </div>-->
<!--                                    <div class="ml-4">-->
<!--                                        <div class="text-sm font-medium text-gray-900">-->
<!--                                            {{ person.name }}-->
<!--                                        </div>-->
<!--                                        <div class="text-sm text-gray-500">-->
<!--                                            {{ person.email }}-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap">-->
<!--                                <div class="text-sm text-gray-900">{{ person.title }}</div>-->
<!--                                <div class="text-sm text-gray-500">{{ person.department }}</div>-->
<!--                            </td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap">-->
<!--                                <span-->
<!--                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">-->
<!--                                    Active-->
<!--                                </span>-->
<!--                            </td>-->
<!--                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-->
<!--                                {{ person.role }}-->
<!--                            </td>-->
<!--                            <td v-if="routeName" class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">-->
<!--                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>-->
<!--                            </td>-->
<!--                        </tr>-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Table",
    props: {
        columns: {
            type: Array,
            required: true
        },
        options: {
            type: Boolean,
            default: true,
        }
    }
}
</script>

<style scoped>

</style>
