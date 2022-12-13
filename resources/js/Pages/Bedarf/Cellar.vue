<script>
import AppLayout from '../../Layouts/AppLayout.vue'
import SideNavWrapper from '../../Wrappers/SideNavWrapper.vue';

export default {
    components: {SideNavWrapper},
    // Using the shorthand
    layout: [AppLayout],

    props: {
        welcome: Object,
    },
}
</script>

<template>

<SideNavWrapper>
    Keller
</SideNavWrapper>

</template>
