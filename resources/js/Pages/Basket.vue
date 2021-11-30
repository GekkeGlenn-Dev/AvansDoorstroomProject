<template>
    <layout>
        <div class="grid grid-cols-3 h-full gap-4 mt-8">

            <div class="h-full flex flex-col bg-white col-span-2">
                <div class="py-6 px-4 sm:px-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        Winkelmand
                    </h2>

                    <div class="mt-8">
                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-gray-200" v-if="basket">
                                <li v-for="product in basket.products" :key="product.id" class="py-6 flex">
                                    <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                        <img :src="'http://avansdoorstroomproject.loc/storage/' + product.image_path" class="w-full h-full object-center object-cover" />
                                    </div>

                                    <div class="ml-4 flex-1 flex flex-col">
                                        <div>
                                            <div
                                                class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>
                                                    <inertia-link :href="route('shop.product.show', {product: product})">
                                                        {{ product.title }}
                                                    </inertia-link>
                                                </h3>
                                                <p class="ml-4">
                                                    {{getCurrencyFormat(product.price) }}
                                                </p>
                                            </div>
                                            <!--                                                            <p class="mt-1 text-sm text-gray-500">-->
                                            <!--                                                                {{ product.color }}-->
                                            <!--                                                            </p>-->
                                        </div>
                                        <div class="flex-1 flex items-end justify-between text-sm">
                                            <p class="text-gray-500">Aantal {{ product.pivot.quantity }}</p>

                                            <div class="flex">
                                                <button @click.prevent="deleteItem(product)" class="font-medium text-indigo-600 hover:text-indigo-500">
                                                    Verwijder
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-2">
                <div class="bg-gray-200 p-4 rounded-lg">
                    <h2 class="text-lg font-medium text-gray-900 mb-2">
                        overzicht van de bestelling
                    </h2>

                    <div class="flex justify-between py-2 px-1 border-b border-gray-300">
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
                    <div class="mt-6">
                        <inertia-link :href="route('basket.checkout')"
                                      class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            uitchecken
                        </inertia-link>
                    </div>
                    <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
                        <p>
                            of
                            <inertia-link :href="route('shop')" class="text-indigo-600 font-medium hover:text-indigo-500">
                                Verder gaan met winkelen
                                <span aria-hidden="true"> &rarr;</span>
                            </inertia-link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
import Layout from "../Layouts/Layout";

export default {
    name: "Basket",
    components: {Layout},
    props: {
        basket: Object,
    },
    methods: {
        getCurrencyFormat(price) {
            return this.getCurrency.format(price / 100);
        },
        getSubTotal() {
            const total = this.getTotal();

            if (total === 0) {
                return total;
            }

            const tax = this.getTotalTax();
            return total - tax;
        },
        getTotal() {
            let total = 0;

            if (!this.basket) {
                return total;
            }

            this.basket.products.forEach(product => {
                const quantity = product.pivot.quantity;
                const price = product.price;
                const totalPrice = price * quantity;
                total += totalPrice;
            });

            return total;
        },
        getTotalTax() {
            const total = this.getTotal();

            if (total === 0) {
                return total;
            }

            return (total / 121) * 21;
        },
        deleteItem(product) {
            this.$inertia.post(route('shop.product.remove', {product: product}));
        }
    },
    computed: {
        getCurrency() {
            return new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'});
        }
    }
}
</script>
