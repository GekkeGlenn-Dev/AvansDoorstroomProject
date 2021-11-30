<template>
    <layout>
        <div>
            <h2>Bedankt voor uw bestelling!</h2>
            <p>Wij hebben de bestelling met nummer {{ order.number }} in goede orde ontvangen. Wij gaan zo snel mogelijk
                aan
                de slag om je bestelling te bezorgen!</p>
            <p>Bedankt dat u voor ons koos!</p>
        </div>
    </layout>
</template>

<script>
import Layout from "../../Layouts/Layout";

export default {
    name: "CheckoutDetail",
    components: {Layout},
    props: {
        order: Object
    }
}
</script>
