<template>
    <dashboard-layout title="Bestellingen">
        <card class="col-span-12">
            <Table :columns="columns">
                <table-column v-for="order in orders.data">
                    <table-data>
                        {{order.number}}
                    </table-data>
                    <table-data>
                        {{ order.user?.name }}
                    </table-data>
                    <table-data>
                        {{ order.order_status?.name }}
                    </table-data>
                    <table-data>
                        {{ order.products_count }}
                    </table-data>
                    <table-data :edit="true">
                        <inertia-link :href="route('dashboard.order.edit', {order: order})" class="green-hover-state">
                            Bewerken
                        </inertia-link>
                    </table-data>
                </table-column>
            </Table>
            <pagination :links="orders.links" class="mt-2"/>
        </card>
    </dashboard-layout>
</template>

<script>
import DashboardLayout from "../../../Layouts/DashboardLayout";
import Card from "../../../Components/Card";
import Table from "../../../Components/Table";
import TableColumn from "../../../Components/TableColumn";
import TableData from "../../../Components/TableData";
import Pagination from "../../../Components/Pagination";

export default {
    name: "Index",
    components: {Pagination, TableData, TableColumn, Table, Card, DashboardLayout},
    props: {
        orders: Object,
    },
    data() {
        return {
            // currency: new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'}),
            columns: [
                'Nummer',
                'Gebruiker',
                'status',
                'Aantal producten',
            ]
        }
    }
}
</script>
