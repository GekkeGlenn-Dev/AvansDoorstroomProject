<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="container">
                        <Table :columns="['Bestellingsnummer', 'Datum', 'Status', 'Totaal prijs']">
                            <table-column v-for="order in orders.data">
                                <table-data>
                                    <inertia-link :href="route('dashboard.me.orders.details', {order: order})">
                                        {{ order.number }}
                                    </inertia-link>
                                </table-data>
                                <table-data>
                                    {{ order.created_at }}
                                </table-data>
                                <table-data>
                                    {{ order.order_status.name }}
                                </table-data>
                                <table-data>
                                    {{ currency.format(getOrderTotal(order) / 100) }}
                                </table-data>
                            </table-column>
                        </Table>
                        <pagination :links="orders.links" />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout";
import Table from "../../../Components/Table";
import TableColumn from "../../../Components/TableColumn";
import TableData from "../../../Components/TableData";
import Pagination from "../../../Components/Pagination";

export default {
    name: "ShowAll",
    components: {Pagination, TableData, TableColumn, Table, AppLayout},
    props: {
        orders: Object,
    },
    methods: {
        getOrderTotal(order) {
            let total = 0;

            order.products.forEach(product => {
                let quantity = product.pivot.quantity;
                let price = product.price;
                let subTotal = quantity * price;
                total += subTotal;
            });

            return total;
        }
    },
    computed: {
        currency() {
            return new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'});
        }
    }
}
</script>
