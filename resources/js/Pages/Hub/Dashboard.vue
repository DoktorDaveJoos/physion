<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import {InertiaLink} from '@inertiajs/inertia-vue3';

export default {
    layout: [AppLayout],
    components: {
        InertiaLink,
    },
    props: {
        user: Object,
    },
}
</script>

<template>
        <div class="py-12">
            <div class="flex flex-col">
                <el-empty description="EnergieHub noch nicht verfügbar">

                    <InertiaLink :href="route('hub.admin.blog')">Zum Admin Panel</InertiaLink>

                </el-empty>
            </div>
        </div>
</template>
