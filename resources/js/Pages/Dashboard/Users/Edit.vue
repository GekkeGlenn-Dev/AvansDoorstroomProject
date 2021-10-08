<template>
    <dashboard-layout :title="user.name">
        <data-list title="Gebruiker">
            <data-list-item>
                <template #term>
                    Naam
                </template>
                {{ user.name }}
            </data-list-item>
            <data-list-item>
                <template #term>
                    E-mail
                </template>
                {{ user.email }}
            </data-list-item>
            <data-list-item>
                <template #term>
                    Rol
                </template>
                <div>
                    {{ user.is_admin ? 'Administrator' : 'klant' }}
                </div>
            </data-list-item>
<!--            <data-list-item>-->
<!--                <template #term>-->
<!--                    Aangemaakt op-->
<!--                </template>-->
<!--                {{ order.created_at_formated }}-->
<!--            </data-list-item>-->
            <data-list-item>
                <template #term>
                    Bestellingen
                </template>
                <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                    <li v-for="order in user.orders"
                        class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span class="ml-2 flex-1 w-0 truncate">
                                {{ order.number }}
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <inertia-link :href="route('dashboard.order.edit', {order: order})" class="green-hover-state">
                                Bekijk bestelling
                            </inertia-link>
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
        user: Object
    }
}
</script>

<style scoped>

</style>
