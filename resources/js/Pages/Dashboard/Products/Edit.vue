<template>
    <dashboard-layout :title="product.title">
        <template #extra>
            <div class="flex space-x-2">
                <button class="form-submit-button" @click.prevent="submit">
                    Opslaan
                </button>
                <button
                    class="px-2 py-1 bg-transparent block text-red-500 rounded transition-colors duration-150 ease-in-out border border-red-500 hover:text-red-400 hover:border-red-400"
                    @click.prevent="submitRemove"
                >
                    Verwijderen
                </button>
            </div>
        </template>
        <data-list title="Product" :subtitle="`Op ${product.orders_count} bestellingen.`">
            <data-list-item>
                <template #term>
                    <label for="title" class="form-label">Titel</label>
                </template>
                <input type="text" id="title" v-model="form.title" class="form-input">
            </data-list-item>
            <data-list-item>
                <template #term>
                    <label for="description" class="form-label">Beschrijving</label>
                </template>
                <textarea id="description" cols="30" rows="5" v-model="form.description" class="form-input"/>
            </data-list-item>
            <data-list-item>
                <template #term>
                    <label for="price" class="form-label">Prijs</label>
                </template>
                <input type="number" id="price" v-model="form.price" class="form-input">
            </data-list-item>
            <data-list-item>
                <template #term>
                    <label for="stock" class="form-label">Voorraad</label>
                </template>
                <input type="number" id="stock" v-model="form.stock" class="form-input">
            </data-list-item>
            <data-list-item>
                <template #term>
                    Categorieën
                </template>

                <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                    <li v-for="category in product.categories" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span class="ml-2 flex-1 w-0 truncate">
                                {{ category.name }}
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="#" class="font-medium text-red-500 hover:text-red-400">
                                Verwijderen
                            </a>
                        </div>
                    </li>
                </ul>
            </data-list-item>
        </data-list>
    </dashboard-layout>
</template>

<script>
import DashboardLayout from "../../../Layouts/DashboardLayout";
import DataList from "../../../Components/DataList";
import DataListItem from "../../../Components/DataListItem";
import Button from "../../../Jetstream/Button";

export default {
    name: "Edit",
    components: {Button, DataListItem, DataList, DashboardLayout},
    props: {
        product: Object
    },
    data() {
        return {
            currency: new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'}),
            form: this.$inertia.form({
                title: this.product.title,
                description: this.product.description,
                price: this.product.price,
                stock: this.product.stock
            }),
        }
    },
    methods: {
        submit() {
            this.form.put(this.route('dashboard.product.update', {product: this.product}));
        },
        submitRemove() {
            this.form.delete(this.route('dashboard.product.destroy', {product: this.product}));
        }
    }
}
</script>
