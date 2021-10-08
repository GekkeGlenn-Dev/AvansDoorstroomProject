<template>
    <dashboard-layout title="Dashboard">
        <div class="grid sm:grid-cols-12 gap-3 mx-auto px-1">
            <card class="sm:col-span-6 lg:col-span-3">
                <h2>Totale verkoop</h2>
                <p>{{ total.sales.toLocaleString('nl-NL') }}</p>
            </card>
            <card class="sm:col-span-6 lg:col-span-3">
                <h2>Totale omzet</h2>
                <p>{{ currency.format(total.revenue / 100.0) }}</p>
            </card>
            <card class="sm:col-span-6 lg:col-span-3">
                <h2>Totale bestellingen</h2>
                <p>{{ total.orders.toLocaleString('nl-NL') }}</p>
            </card>
            <card class="sm:col-span-6 lg:col-span-3">
                <h2>Totale klanten</h2>
                <p>{{ total.users.toLocaleString('nl-NL') }}</p>
            </card>
            <card class="sm:col-span-12 lg:col-span-7">
                <apexchart type="area" :options="options" :series="series"></apexchart>
            </card>
            <div class="sm:col-span-12 lg:col-span-5">
                <card class="space-y-2">
                    <h2>Top 5 producten</h2>
                    <inertia-link v-for="product in topProducts"
                                  :href="route('dashboard.product.edit', {product: product})"
                                  class="block border rounded border-dark-100 py-2 px-4 green-hover-state"
                    >
                        <h2> {{ product.title }}</h2>
                        <p>Gevonden op {{ product.orders_count.toLocaleString('nl-NL') }} bestellingen</p>
                    </inertia-link>
                </card>
            </div>
        </div>
    </dashboard-layout>
</template>

<script>
import DashboardLayout from "@/Layouts/DashboardLayout";
import Card from "../../Components/Card";

export default {
    name: "Dashboard",
    components: {Card, DashboardLayout},
    props: {
        series: Object,
        total: Object,
        topProducts: Array,
    },
    data() {
        return {
            currency: new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'}),
            options: {
                // #10CB8A

                colors: ['#10CB8A', '#797BF2', '#1E8BC7'],
                chart: {
                    background: 'rgba(0,0,0,0)',
                    toolbar: {
                        tools: {
                            download: false,
                            zoom: true,
                            pan: false,

                        },
                    },
                },
                theme: {
                    mode: 'dark',
                    palette: 'palette1',
                    // monochrome: {
                    //     enabled: true,
                    //     color: '#255aee',
                    //     shadeTo: 'light',
                    //     shadeIntensity: 0.65
                    // },
                },
                dataLabels: {
                    enabled: false
                },
                tooltip: {
                    theme: "dark",
                },
                xaxis: {
                    type: "string",
                    labels: {
                        show: false,
                    },
                    tooltip: {
                        enabled: false,
                    },
                },
            },
        }
    },
}
</script>
