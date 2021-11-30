<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
<!--                            <div>-->
<!--                                <jet-application-logo class="block h-12 w-auto" />-->
<!--                            </div>-->

                            <div class="mt-8 text-2xl">
                                Welkom terug {{ $page.props.user.name }}, dit is jou dashboard.
                            </div>

<!--                            <div class="mt-6 text-gray-500">-->
<!--                                Bekijk op je dashboard all de bestellingen die je hebt geplaatst.-->
<!--                            </div>-->
                        </div>

                        <div>
                            <h2>Bestellingen afgelopen 10 dagen.</h2>
                            <Table :columns="['Bestellingsnummer', 'Datum', 'Status', 'Totaal prijs']">
                                <table-column v-for="order in orders.data">
                                    <table-data>
                                        {{order.number}}
                                    </table-data>
                                    <table-data>
                                        {{order.created_at}}
                                    </table-data>
                                    <table-data>
                                        {{order.order_status.name}}
                                    </table-data>
                                    <table-data>
                                        {{currency.format(getOrderTotal(order) / 100)}}
                                    </table-data>
                                </table-column>
                            </Table>
                            <pagination :links="orders.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import Table from "../../Components/Table";
import TableColumn from "../../Components/TableColumn";
import TableData from "../../Components/TableData";
import Pagination from "../../Components/Pagination";

export default {
    name: 'DashboardCustomer',
    props: {
        orders: Object
    },
    components: {
        Pagination,
        TableData,
        TableColumn,
        Table,
        AppLayout,
        Welcome,
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
