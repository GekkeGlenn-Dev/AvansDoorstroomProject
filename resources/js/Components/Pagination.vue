<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null"
                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-dark-100 border border-dark-100 rounded"
                     v-html="link.label"/>
                <inertia-link v-else
                              class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded"
                              :class="link.active ? 'bg-dark-green text-black' : 'green-hover-state focus:border-dark-green focus:text-dark-green' " :href="link.url"
                              v-html="link.label"/>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    name: "Pagination",
    props: {
        links: Array
    }
}
</script>
