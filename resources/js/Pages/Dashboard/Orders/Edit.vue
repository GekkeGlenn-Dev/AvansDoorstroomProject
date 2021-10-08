<template>
    <dashboard-layout :title="'Bestelling: ' + order.number">
        <data-list title="Bestelling" :subtitle="order.number">
            <data-list-item>
                <template #term>
                    Nummer
                </template>
                {{ order.number }}
            </data-list-item>
            <data-list-item>
                <template #term>
                    Status
                </template>
                {{ order.order_status.name }}
            </data-list-item>
            <data-list-item>
                <template #term>
                    klant
                </template>
                <div>
                    <p class="font-bold">
                        <inertia-link :href="route('dashboard.user.edit', {user: order.user})" class="green-hover-state">
                            {{ order.user.name }}
                        </inertia-link>
                    </p>
                    <p>{{ order.user.email }}</p>
                </div>
            </data-list-item>
            <data-list-item>
                <template #term>
                    Adres
                </template>
                {{ order.address }}
            </data-list-item>
            <data-list-item>
                <template #term>
                    Aangemaakt op
                </template>
                {{ order.created_at_formated }}
            </data-list-item>
            <data-list-item>
                <template #term>
                    Producten
                </template>
                <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                    <li v-for="product in order.products"
                        class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span class="ml-2 flex-1 w-0 truncate">
                                {{ product.title }}
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex-1">
                            {{ product.pivot.quantity }}
                        </div>
                        <div class="ml-4 flex-shrink-0 space-x-4">
                            <span class="w-14">
                            {{ currency.format(product.price / 100) }}
                            </span>
                            <span class="w-14">
                            {{ getSubTotal(product) }}
                            </span>
                        </div>
                    </li>
                </ul>
                <div class="flex justify-end py-3 space-x-4 font-bold">
                    <div>
                        Totaal:
                    </div>
                    <div class="pr-4">
                        {{ getTotal }}
                    </div>
                </div>
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
        order: Object
    },
    data() {
        return {
            currency: new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'}),
        }
    },
    methods: {
        getSubTotal(product) {
            return this.currency.format((product.price * product.pivot.quantity) / 100);
        },
    },
    computed: {
        getTotal() {
            let total = 0;

            this.order.products.forEach(product => {
                total += (product.price * product.pivot.quantity)
            });
            return this.currency.format(total / 100);
        }
    }
}
</script>

<style scoped>

</style>
