<template>
    <form @submit.prevent="submit">
        <input type="text" id="title" v-model="form.title">
        <textarea id="description" cols="30" rows="10" v-model="form.description" />
        <input type="number" id="price" v-model="form.price">
        <input type="number" id="stock" v-model="form.stock">
        <input type="submit" value="POST">
    </form>
</template>

<script>
export default {
    name: "Create",
    data() {
        return {
            form: this.$inertia.form({
                title: null,
                description: null,
                price: 0,
                stock: 0
            }),
        }
    },
    methods: {
        submit() {
            this.form.post(route('dashboard.product.store'));
        }
    }
}
</script>
