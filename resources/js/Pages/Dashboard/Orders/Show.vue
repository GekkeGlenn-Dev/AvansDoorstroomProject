<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4">
                        <h2>Bestelling: {{ order.number }}</h2>
                        <div class="flex my-8">
                            <div>
                                <p class="my-2 mr-4">Naam: </p>
                                <p class="my-2 mr-4">Email: </p>
                                <p class="mt-2 mr-4">Adres: </p>
                            </div>
                            <div>
                                <p class="my-2">{{ order.name }}</p>
                                <p class="my-2">{{ order.email }}</p>
                                <p class="mt-2">{{ order.street }} {{ order.house_number }} {{ order.house_number_addition }}</p>
                                <p>{{ order.postal_code }}, {{ order.city }}, {{ order.country }}</p>
                            </div>
                        </div>

                        <Table :columns="['Product', 'Aantal', 'Prijs', 'Sub totaal']">
                            <table-column v-for="product in order.products">
                                <table-data>
                                    {{ product.title }}
                                </table-data>
                                <table-data>
                                    {{ product.pivot.quantity }}
                                </table-data>
                                <table-data>
                                    {{ currency.format(product.price / 100) }}
                                </table-data>
                                <table-data>
                                    {{ getProductSubTotal(product) }}
                                </table-data>
                            </table-column>
                        </Table>
                        <div class="mt-4 flex justify-between py-2 px-1 border-b border-gray-300">
                            <h3 class="text-gray-600 text-base">sub totaal</h3>
                            <p>{{ getCurrencyFormat(getSubTotal()) }}</p>
                        </div>
                        <div class="flex justify-between py-2 px-1 border-b border-gray-300">
                            <h3 class="text-gray-600 text-base">BTW</h3>
                            <p>{{ getCurrencyFormat(getTotalTax()) }}</p>
                        </div>
                        <div class="flex justify-between py-2 px-1 border-b border-gray-300">
                            <h3 class="text-gray-900 text-base">Totaal</h3>
                            <p>{{ getCurrencyFormat(getTotal()) }}</p>
                        </div>
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

export default {
    name: "Show",
    components: {TableData, TableColumn, Table, AppLayout},
    props: {
        order: Object,
    },
    data() {
        return {
            currency: new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'}),
        }
    },
    methods: {
        getProductSubTotal(product) {
            const subTotal = product.price * product.pivot.quantity;
            return this.currency.format(subTotal / 100);
        },
        getCurrencyFormat(price) {
            return this.currency.format(price / 100);
        },
        getSubTotal() {
            return this.getTotal() - this.getTotalTax();
        },
        getTotal() {
            let total = 0;

            this.order.products.forEach(product => {
                const quantity = product.pivot.quantity;
                const price = product.price;
                const totalPrice = price * quantity;
                total += totalPrice;
            });

            return total;
        },
        getTotalTax() {
            return (this.getTotal() / 121) * 21;
        },
    }
}
</script>
