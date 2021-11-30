<template>
    <layout>
    <div class="bg-white">
        <div class="pt-6">

            <div class="container grid grid-cols-3 mt-4 px-8 gap-x-8">
                <inertia-link :href="route('shop')" class="col-span-3 block my-4">Terug naar winkel</inertia-link>

                <!-- gallery -->
                <div class="col-span-1">
                    <div class="hidden rounded-lg overflow-hidden lg:block">
                        <img :src="'http://avansdoorstroomproject.loc/storage/' + product.image_path"
                            class="w-full h-full object-center object-cover">
                    </div>
                </div>

                <div class="col-span-1 lg:border-r lg:border-gray-200"></div>

                <!-- options -->
                <div class="row-span-2">
                    <h2 class="sr-only">product informatie</h2>
                    <p class="text-3xl text-gray-900">{{ getCurrencyFormat(product.price) }}</p>

                    <!-- Add to basket -->
                    <form class="mt-10" @submit.prevent="submit">
                        <button type="submit" :disabled="disabled"
                                class="mt-10 w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Toevoegen aan winkelmand
                        </button>
                    </form>
                    <transition
                        enter-active-class="transition duration-150 ease-in-out"
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                        leave-active-class="transition duration-150 ease-in-out"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <div v-show="showNotification" class="mt-2 border-green-700 bg-green-300 rounded-lg p-2">
                            Product {{ product.title }} is toegevoegd aan winkelmand.
                        </div>
                    </transition>
                </div>

                <div class="col-span-2 lg:border-r lg:border-gray-200">
                    <div class="lg:col-span-2 lg:pr-8">
                        <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl mt-2">
                            {{ product.title }}
                        </h1>
                    </div>

                    <div class="py-10 lg:pt-6 lg:pb-16 lg:col-start-1 lg:col-span-2 lg:pr-8">
                        <!-- Description and details -->
                        <div>
                            <h3 class="sr-only">Beschrijving</h3>
                            <div class="space-y-6">
                                <p class="text-base text-gray-900" v-html="product.description_as_html" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </layout>
</template>

<script>
import Layout from '@/Layouts/Layout';

export default {
    name: "Show",
    props: {
        product: Object,
        basket_notification: String,
    },
    components: {
        Layout,
    },
    data() {
        return {
            disabled: false,
            showNotification: false,
        }
    },
    methods: {
        submit() {
            this.disabled = true;
            this.showNotification = false;
            this.$inertia.post(this.route('shop.product.add', {product: this.product}), null, {
                onSuccess: (response) => {
                    this.disabled = false;
                    this.showNotification = true;
                }
            })
        },
        getCurrencyFormat(price) {
            return this.getCurrency.format(price / 100);
        }
    },
    computed: {
        getCurrency() {
            return new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'});
        }
    }
}
</script>
