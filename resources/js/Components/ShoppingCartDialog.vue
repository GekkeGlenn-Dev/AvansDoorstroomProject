<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="fixed inset-0 overflow-hidden z-50" @close="open = false">
            <div class="absolute inset-0 overflow-hidden">
                <TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0"
                                 enter-to="opacity-100" leave="ease-in-out duration-500" leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <DialogOverlay class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
                </TransitionChild>

                <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                    <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700"
                                     enter-from="translate-x-full" enter-to="translate-x-0"
                                     leave="transform transition ease-in-out duration-500 sm:duration-700"
                                     leave-from="translate-x-0" leave-to="translate-x-full">
                        <div class="w-screen max-w-md">
                            <div class="h-fu
                            ll flex flex-col bg-white shadow-xl overflow-y-scroll">
                                <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
                                    <div class="flex items-start justify-between">
                                        <DialogTitle class="text-lg font-medium text-gray-900">
                                            Winkelmand
                                        </DialogTitle>
                                        <div class="ml-3 h-7 flex items-center">
                                            <button type="button" class="-m-2 p-2 text-gray-400 hover:text-gray-500"
                                                    @click="open = false">
                                                <span class="sr-only">Sluit winkelmand</span>
                                                <XIcon class="h-6 w-6" aria-hidden="true"/>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-8">
                                        <div class="flow-root">
                                            <ul role="list" class="-my-6 divide-y divide-gray-200" v-if="basket">
                                                <li v-for="product in basket.products" :key="product.id" class="py-6 flex">
                                                    <div
                                                        class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                                        <!--                                                        <img :src="product.imageSrc" :alt="product.imageAlt" class="w-full h-full object-center object-cover" />-->
                                                    </div>

                                                    <div class="ml-4 flex-1 flex flex-col">
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
<!--                                                            <p class="mt-1 text-sm text-gray-500">-->
<!--                                                                {{ product.color }}-->
<!--                                                            </p>-->
                                                        </div>
                                                        <div class="flex-1 flex items-end justify-between text-sm">
                                                            <p class="text-gray-500">aantal {{ product.pivot.quantity }}</p>

                                                            <div class="flex">
                                                                <button type="button"
                                                                        class="font-medium text-indigo-600 hover:text-indigo-500">
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

                                <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <p>Sub totaal</p>
                                        <p>{{ getSubTotal() }}</p>
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
                                            <button type="button"
                                                    class="text-indigo-600 font-medium hover:text-indigo-500"
                                                    @click="open = false">Verder gaan met winkelen<span
                                                aria-hidden="true"> &rarr;</span></button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import {Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {XIcon} from '@heroicons/vue/outline'

export default {
    name: "ShoppingCartDialog",
    components: {
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        XIcon,
    },
    props: {
        open: {
            type: Boolean,
            default: true,
        }
    },
    data() {
        return {
            basket: null,
        }
    },
    mounted() {
        this.fetchBasketProducts();
    },
    methods: {
        fetchBasketProducts() {
            axios.get(route('api.v1.basket.index'))
                .then(response => {
                    this.basket = response.data;
                });
        },
        getCurrencyFormat(price) {
            return this.getCurrency.format(price / 100);
        },
        getSubTotal() {
            let subtotal = 0;

            if (!this.basket) {
                return this.getCurrencyFormat(subtotal);
            }

            this.basket.products.forEach(product => {
                const quantity = product.pivot.quantity;
                const price = product.price;
                const totalPrice = price * quantity;
                subtotal += totalPrice;
            });

            return this.getCurrencyFormat(subtotal);
        }
    },
    computed: {
        getCurrency() {
            return new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'});
        }
    }
}
</script>
