<script setup>
const props = defineProps({
    form: Object,
});
</script>

<template>
    <el-form
        class="grid sm:grid-cols-2 gap-x-4 px-4"
        label-position="top"
        size="large">
        <el-form-item
            :error="form.errors.pitch"
            label="Dachneigung in Grad (Schätzung reicht)"
            required>
            <el-input-number
                v-model="form.pitch"
                :max="90"
                :min="0"
                :step="5"
                placeholder="0"></el-input-number>
        </el-form-item>
        <el-form-item
            label="Kniestockhöhe in cm"
            :error="form.errors.knee_wall">
            <el-input-number
                v-model="form.knee_wall"
                :max="250"
                :min="0"
                placeholder="0"></el-input-number>
        </el-form-item>
    </el-form>
</template>

<style scoped>
.el-input-number {
    width: 100%;
}
</style>
