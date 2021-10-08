<template>
    <dashboard-layout :title="product.title">
        <data-list title="Product" :subtitle="`Op ${product.orders_count} bestellingen.`">
            <data-list-item>
                <template #term>
                    Naam
                </template>
                {{ product.title }}
            </data-list-item>
            <data-list-item>
                <template #term>
                    Beschrijving
                </template>
                {{ product.description }}
            </data-list-item>
            <data-list-item>
                <template #term>
                    Prijs
                </template>
                {{ currency.format(product.price / 100) }}
            </data-list-item>
            <data-list-item>
                <template #term>
                    Voorraad
                </template>
                {{ product.stock }}
            </data-list-item>
            <data-list-item>
                <template #term>
                    Categorieën
                </template>

                <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                    <li v-for="category in product.categories" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span class="ml-2 flex-1 w-0 truncate">
                                {{ category.name }}
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="#" class="font-medium text-red-500 hover:text-red-400">
                                Verwijderen
                            </a>
                        </div>
                    </li>
                </ul>
            </data-list-item>
        </data-list>
    </dashboard-layout>
</template>

<script>
import DashboardLayout from "../../../Layouts/DashboardLayout";
import DataList from "../../../Components/DataList";
import DataListItem from "../../../Components/DataListItem";

export default {
    name: "Edit",
    components: {DataListItem, DataList, DashboardLayout},
    props: {
        product: Object
    },
    data() {
        return {
            currency: new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'}),
        }
    }
}
</script>

<style scoped>

</style>
