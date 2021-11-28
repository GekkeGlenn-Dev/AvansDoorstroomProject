<template>
    <layout>
        <form class="grid grid-cols-3 h-full gap-4 mt-8" @submit.prevent="submit">
            <div class="col-span-2 gap-2">
                <div class="grid grid-cols-4 grid-cols-12">
                    <!-- ROW 1 -->
                    <div class="col-span-6 form-group">
                        <label for="name">Naam</label>
                        <input v-model="form.name" type="text" id="name" class="form-input-checkout">
                        <input-error :message="errors.name" />
                    </div>
                    <div class="col-span-6 form-group">
                        <label for="email">Email</label>
                        <input v-model="form.email" type="text" id="email" class="form-input-checkout">
                        <input-error :message="errors.email" />
                    </div>

                    <!-- ROW 2 -->
                    <div class="col-span-6 form-group">
                        <label for="street">Straat</label>
                        <input v-model="form.street" type="text" id="street" class="form-input-checkout">
                        <input-error :message="errors.street" />
                    </div>
                    <div class="col-span-3 form-group">
                        <label for="house_number">Huisnummer</label>
                        <input v-model="form.house_number" type="number" id="house_number" class="form-input-checkout">
                        <input-error :message="errors.house_number" />
                    </div>
                    <div class="col-span-3 form-group">
                        <label for="house_number_addition">toevoeging</label>
                        <input v-model="form.house_number_addition" type="text" id="house_number_addition" class="form-input-checkout">
                        <input-error :message="errors.house_number_addition" />
                    </div>

                    <!-- ROW 3 -->
                    <div class="col-span-6 form-group">
                        <label for="postal_code">Postcode</label>
                        <input v-model="form.postal_code" type="text" id="postal_code" class="form-input-checkout">
                        <input-error :message="errors.postal_code" />
                    </div>
                    <div class="col-span-6 form-group">
                        <label for="city">Woonplaats</label>
                        <input v-model="form.city" type="text" id="city" class="form-input-checkout">
                        <input-error :message="errors.city" />
                    </div>
                    <!-- ROW 4 -->
                    <div class="col-span-12 form-group">
                        <label for="country">Land</label>
                        <input v-model="form.country" type="text" id="country" class="form-input-checkout">
                        <input-error :message="errors.country" />
                    </div>
                </div>
            </div>

            <div class="p-2">
                <div class="bg-gray-200 p-4 rounded-lg">
                    <h2 class="text-lg font-medium text-gray-900 mt-2 mb-6">
                        Producten
                    </h2>

                    <div class="flex flex-col mb-10">
                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-gray-300" v-if="basket">
                                <li v-for="product in basket.products" :key="product.id" class="py-4">
                                    <div class="flex-1 flex flex-col">
                                        <div>
                                            <div
                                                class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>
                                                    <a :href="'#'">
                                                        {{ product.title }}
                                                    </a>
                                                </h3>
                                                <p class="ml-4">
                                                    {{ getCurrencyFormat(product.price) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex-1 flex items-end justify-between text-sm">
                                            <p class="text-gray-500">Aantal {{ product.pivot.quantity }}</p>

                                            <div class="flex">
                                                <inertia-link
                                                    :href="route('shop.product.remove', {product: product})"
                                                    class="font-medium text-indigo-600 hover:text-indigo-500">
                                                    Verwijder
                                                </inertia-link>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <h2 class="text-lg font-medium text-gray-900 mt-2 mb-6">
                        Overzicht van de bestelling
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
                        <button
                            type="submit"
                            :disabled="basket.products.length < 1"
                            class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                        >
                            uitchecken
                        </button>
                    </div>
                    <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
                        <p>
                            of
                            <inertia-link :href="route('shop')"
                                          class="text-indigo-600 font-medium hover:text-indigo-500">
                                Verder gaan met winkelen
                                <span aria-hidden="true"> &rarr;</span>
                            </inertia-link>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </layout>
</template>

<script>
import Layout from "@/Layouts/Layout";
import Button from "../../Jetstream/Button";
import InputError from "../../Jetstream/InputError";

export default {
    name: "Checkout",
    components: {InputError, Button, Layout},
    props: {
        basket: Object,
        errors: Object
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.$page.props.user ? this.$page.props.user.name : null,
                email: this.$page.props.user ? this.$page.props.user.email : null,
                street: null,
                house_number: null,
                house_number_addition: null,
                postal_code: null,
                city: null,
                country: 'Nederland'
            }),
        }
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
        submit() {
            this.form.post(this.route('basket.checkout.process'));
        }
    },
    computed: {
        getCurrency() {
            return new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'});
        }
    }
}
</script>
