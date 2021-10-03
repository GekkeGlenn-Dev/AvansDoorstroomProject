<template>
        <Disclosure as="div" v-for="section in filters" :key="section.id" class="border-b border-gray-200 py-6" v-slot="{ open }">
            <h3 class="-my-3 flow-root">
                <DisclosureButton class="py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400 hover:text-gray-500">
                    <span class="font-medium text-gray-900">
                      {{ section.name }}
                    </span>
                    <span class="ml-6 flex items-center">
                      <PlusSmIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                      <MinusSmIcon v-else class="h-5 w-5" aria-hidden="true" />
                    </span>
                </DisclosureButton>
            </h3>
            <DisclosurePanel class="pt-6">
                <div class="space-y-4">
                    <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex items-center">
                        <input :id="`filter-${section.id}-${optionIdx}`" :name="`${section.id}[]`" :value="option.value" type="checkbox" :checked="option.checked" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" />
                        <label :for="`filter-${section.id}-${optionIdx}`" class="ml-3 text-sm text-gray-600">
                            {{ option.label }}
                        </label>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>
</template>

<script>
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
} from "@headlessui/vue";
import { MinusSmIcon, PlusSmIcon } from "@heroicons/vue/solid";
import {XIcon} from "@heroicons/vue/outline";

export default {
    name: "ShopFilters",
    components: {
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        MinusSmIcon,
        PlusSmIcon,
        XIcon,
    },
    props: {
        filters: {
            type: Object,
            required: true,
        }
    }
}
</script>

<style scoped>

</style>
