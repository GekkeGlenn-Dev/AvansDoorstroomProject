<template>
    <div>
        <h2>Bedankt voor uw bestelling!</h2>
        <p>Wij hebben de bestelling met nummer {{ order.number }} in goede orde ontvangen. Wij gaan zo snel mogelijk aan
            de slag om je bestelling te bezorgen!</p>
        <p>Bedankt dat u voor ons koos!</p>
    </div>
</template>

<script>
export default {
    name: "CheckoutDetail",
    props: {
        order: Object
    }
}
</script>
