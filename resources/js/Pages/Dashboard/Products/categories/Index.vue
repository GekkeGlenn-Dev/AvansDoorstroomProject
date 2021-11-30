<template>
    <dashboard-layout title="Product Categorieën">
        <div class="border-red-500 text-red-500" v-if="could_not_delete">
            {{ could_not_delete }}
        </div>
        <div class="grid grid-cols-12 col-span-12 gap-2">
            <div class="col-span-4">
                <Card class=" p-4">
                    <form @submit.prevent="submit">
                        <div class="form-group">
                            <h2 class="text-base text-dark-100">Maak een nieuwe categorie</h2>
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-label">Naam</label>
                            <input v-model="form.name" type="text" id="name" class="form-input">
                            <input-error :message="errors.name" />
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Toevoegen" :disabled="form.processing" class="form-submit-button">
                        </div>
                    </form>
                </Card>
            </div>

            <Card class="col-span-8">
                <Table :columns="columns">
                    <table-column v-for="category in categories.data">
                        <table-data>
                            {{ category.name }}
                        </table-data>
                        <table-data>
                            {{ category.slug }}
                        </table-data>
                        <table-data>
                            {{ category.products_count }}
                        </table-data>
                        <table-data :edit="true" class="space-x-2">
                            <!--                            <inertia-link class="font-medium text-dark-100 hover:text-dark-green"-->
                            <!--                                          :href="route('dashboard.product.edit', {product: product})">-->
                            <!--                                Bewerken-->
                            <!--                            </inertia-link>-->

                            <button
                                class="font-medium text-red-500 hover:text-red-400"
                                @click.prevent="submitDelete(category)"
                            >
                                verwijder
                            </button>
                        </table-data>
                    </table-column>
                </Table>
                <pagination :links="categories.links" class="mt-2"/>
            </Card>
        </div>
    </dashboard-layout>
</template>

<script>
import DashboardLayout from "../../../../Layouts/DashboardLayout";
import TableColumn from "../../../../Components/TableColumn";
import TableData from "../../../../Components/TableData";
import Pagination from "../../../../Components/Pagination";
import Table from "../../../../Components/Table";
import Card from "../../../../Components/Card";
import InputError from "../../../../Jetstream/InputError";

export default {
    name: "Index",
    props: {
        categories: Object,
        errors: Object,
        could_not_delete: String,
    },
    components: {InputError, Card, Pagination, TableData, TableColumn, DashboardLayout, Table},
    data() {
        return {
            columns: [
                'Categorie',
                'Slug',
                'Producten'
            ],
            form: this.$inertia.form({
               name: null,
            }),
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('dashboard.product.category.store'), {onSuccess: () => this.form.name = null});
        },
        submitDelete(category) {
            this.$inertia.delete(this.route('dashboard.product.category.destroy', {productCategory: category}));
        }
    }
}
</script>
