<template>
    <dashboard-layout title="Producten">
        <template #extra>
            <div class="flex justify-between space-x-4 items-center">
                <inertia-link class="form-submit-button" :href="route('dashboard.product.category.index')">
                    Categorieën
                </inertia-link>

                <inertia-link class="form-submit-button" :href="route('dashboard.product.create')">
                    Product toevoegen
                </inertia-link>
            </div>
        </template>

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
                    <table-data :edit="true" class="space-x-2">
                        <inertia-link class="font-medium text-dark-100 hover:text-dark-green"
                                      :href="route('dashboard.product.edit', {product: product})">
                            Bewerken
                        </inertia-link>

                        <button @click.prevent="deleteItem(product)" class="font-medium text-red-500 hover:text-red-400">
                            verwijder
                        </button>
                    </table-data>
                </table-column>
            </Table>
            <pagination :links="products.links" class="mt-2"/>
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
    },
    methods: {
        deleteItem(product) {
            this.$inertia.delete(this.route('dashboard.product.destroy', {product: product}))
        }
    }
}
</script>
