<template>
    <dashboard-layout title="Producten">
        <card class="col-span-12">
            <Table :columns="columns">
                <table-column v-for="user in users.data">
                    <table-data>
                        {{user.name}}
                    </table-data>
                    <table-data>
                        {{ user.email }}
                    </table-data>
                    <table-data>
                        {{user.email_verified_at ? 'Ja' : 'Nee' }}
                    </table-data>
                    <table-data>
                        {{ user.is_admin ? 'Administrator' : 'Klant'}}
                    </table-data>
                    <table-data>
                        {{user.orders_count}}
                    </table-data>
                    <table-data :edit="true">
                        <inertia-link :href="route('dashboard.user.edit', {user: user})">
                            Bewerken
                        </inertia-link>
                    </table-data>
                </table-column>
            </Table>
            <pagination :links="users.links" class="mt-2"/>
        </card>
    </dashboard-layout>
</template>

<script>
import DashboardLayout from "../../../Layouts/DashboardLayout";
import Card from "../../../Components/Card";
import Table from "../../../Components/Table";
import TableColumn from "../../../Components/TableColumn";
import TableData from "../../../Components/TableData";
import Pagination from "../../../Components/Pagination";

export default {
    name: "Index",
    components: {Pagination, TableData, TableColumn, Table, Card, DashboardLayout},
    props: {
        users: Object,
    },
    data() {
        return {
            currency: new Intl.NumberFormat('nl-NL', {style: 'currency', currency: 'EUR'}),
            columns: [
                'name',
                'email',
                'Geverifieerd',
                'rol',
                'bestellingen'
            ]
        }
    }
}
</script>
