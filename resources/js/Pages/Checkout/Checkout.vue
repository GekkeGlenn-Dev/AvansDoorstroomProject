<template>
    <layout>
        <div class="grid grid-cols-8">
            <div class="col-span-3 border">
                Formulier
            </div>

            <div class="col-span-5 border">
                <h2>Producten</h2>

                    <div class="flex justify-between items-center px-2 py-1">
                        <table class="w-full">
                            <tbody>
                                <tr v-for="product in basket.products">
                                    <td>
                                        <h3>{{ product.title }}</h3>
                                    </td>
                                    <td>{{ product.pivot.quantity }}x</td>
                                    <td>{{ currency.format(product.price / 100.0) }}</td>
                                    <td>{{ currency.format((product.price * product.pivot.quantity) / 100.0) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </layout>
</template>

<script>
import Layout from "@/Layouts/Layout";

export default {
    name: "Checkout",
    components: {Layout},
    props: {
        basket: Object
    },
    data() {
        return {
            currency: new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'}),
        }
    }
}
</script>
