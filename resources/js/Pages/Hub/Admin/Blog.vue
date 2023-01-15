<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import SideNavWrapper from '../Components/SideNavWrapper.vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';


import {CalendarIcon, ChartBarIcon, FolderIcon, HomeIcon, InboxIcon, UsersIcon} from '@heroicons/vue/24/outline';

export default {
    layout: [AppLayout],
    components: {
        CalendarIcon,
        ChartBarIcon,
        FolderIcon,
        HomeIcon,
        InboxIcon,
        UsersIcon,
        SideNavWrapper,
        QuillEditor
    },

    props: {
        user: Object,
    },

    setup(props) {

        return {
            user: props.user,

        };
    },
};
</script>
<template>

    <SideNavWrapper>
        <el-card class="col-span-5">
            <QuillEditor theme="snow" />
        </el-card>
    </SideNavWrapper>

</template>
