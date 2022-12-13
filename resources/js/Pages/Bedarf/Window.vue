<template>
<SideNavWrapper>
    Window
</SideNavWrapper>
</template>

<script>
import SideNavWrapper from '../../Wrappers/SideNavWrapper.vue';
import AppLayout from '../../Layouts/AppLayout.vue';

export default {
    name: 'Window',
    layout: [AppLayout],
    components: {SideNavWrapper},
};
</script>

<style scoped>

</style>
