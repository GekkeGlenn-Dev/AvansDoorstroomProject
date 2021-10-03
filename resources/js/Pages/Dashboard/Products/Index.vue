<template>
    <dashboard-layout title="Producten">
        <card class="col-span-12">
            <Table :columns="columns">
                <table-column v-for="product in products.data">
                    <table-data>
                        {{product.title}}
                    </table-data>
                    <table-data>
                        {{ currency.format(product.price / 100) }}
                    </table-data>
                    <table-data>
                        {{product.stock}}
                    </table-data>
                    <table-data>
                        {{product.orders_count}}
                    </table-data>
                    <table-data :edit="true">
                        <inertia-link :href="route('dashboard.product.edit', {product: product})">
                            Bewerken
                        </inertia-link>
                    </table-data>
                </table-column>
            </Table>
        </card>
    </dashboard-layout>
</template>

<script>
import DashboardLayout from "../../../Layouts/DashboardLayout";
import Card from "../../../Components/Card";
import Table from "../../../Components/Table";
import TableColumn from "../../../Components/TableColumn";
import TableData from "../../../Components/TableData";

export default {
    name: "Index",
    components: {TableData, TableColumn, Table, Card, DashboardLayout},
    props: {
        products: Object,
    },
    data() {
        return {
            currency: new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'}),
            columns: [
                'Titel',
                'Prijs',
                'Voorraad',
                'bestellingen'
            ]
        }
    }
}
</script>
