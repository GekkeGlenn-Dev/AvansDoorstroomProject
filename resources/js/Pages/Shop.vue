<template>
    <ShopLayout :sort-options="sortingOptions" :filters="filters" @filtersUpdated="filterUpdate" @onQueryUpdate="fetchProducts">
        <div class="bg-white">
            <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Producten</h2>

                <div v-if="products" class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">

                    <product-card v-for="product in products.data" :product="product" />

                </div>
            </div>
        </div>
    </ShopLayout>
</template>

<script>
import ShopLayout from "../Layouts/ShopLayout";
import ProductCard from "../Components/ProductCard";

export default {
    name: "Shop",
    components: {ProductCard, ShopLayout},

    created() {
        this.sortingOptions = this.$page.props.shop.sortOptions;
    },
    mounted() {
        this.fetchProducts();
    },
    data() {
        return {
            products: null,
            sortingOptions: [],
            filters: null,
        }
    },
    methods: {
        fetchProducts() {
            axios.get(route('api.v1.product.index', {sortOptions: this.sortingOptions, filters: this.$page.props.shop.filterOptions }))
            .then(response => {
                this.products = response.data;
            });
        },
        filterUpdate(options) {
            this.sortingOptions = options;
            this.fetchProducts();
        },
    }
}
</script>
