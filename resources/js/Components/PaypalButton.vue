<script setup>
import { Inertia } from '@inertiajs/inertia';
import { loadScript } from '@paypal/paypal-js';
import { onMounted } from 'vue';

const props = defineProps({
    price: {
        type: String,
        required: true,
    },
    order: {
        type: Object,
        required: true,
    },
});

// TODO from env or so
const CLIENT_ID =
    'AWRMY-wMujyJ8_yET3Z7hE66No1Hs6pQpIb_cJWEARRq4UWugyzJ9hWCeNoV8vecqB_kgNfAi1ytZs27';

onMounted(async () => {
    try {
        const paypal = await loadScript({
            'client-id': CLIENT_ID,
            currency: 'EUR',
        });

        await paypal
            .Buttons({
                createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [
                            {
                                amount: {
                                    value: props.price,
                                },
                                reference_id: props.order.id,
                            },
                        ],
                    });
                },
                onApprove: function (data, actions) {
                    return actions.order.capture().then(function (orderData) {
                        Inertia.post(
                            route('checkout.paypal.capture', props.order.id),
                            orderData,
                            {
                                preserveScroll: true,
                            }
                        );
                    });
                },
                style: {
                    layout: 'vertical',
                    color: 'gold',
                    shape: 'rect',
                    label: 'paypal',
                },
                fundingSource: paypal.FUNDING.PAYPAL,
            })
            .render('#paypal-button-container');
    } catch (error) {
        console.error(error);
    }
});
</script>

<template>
    <div id="paypal-button-container"></div>
</template>
