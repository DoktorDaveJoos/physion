<script setup>
import GuestLayout from '../../Layouts/GuestLayout.vue';
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';

const options = [
    {
        value: 'ziegel',
        label: 'Ziegel',
        children: [
            {
                value: 'hohlloch',
                label: 'Hohlloch',
                children: [
                    {
                        value: 'lm36',
                        label: 'LM 36',
                    },
                    {
                        value: 'sonstiges',
                        label: 'Sonstiges',
                    },
                ],
            },
            {
                value: 'sonstiges',
                label: 'Sonstiges',
            },
        ],
    },
    {
        value: 'holzständer',
        label: 'Holzständer',
    },
];

const cascaderProps = {
    checkStrictly: true,
};
</script>

<template>
    <GuestLayout>
        <StepperWrapper>
            <div class="flex flex-col space-y-4">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Wandaufbau
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Angaben zum Wandaufbau
                    </p>
                </div>

                <div class="flex">
                    <div
                        class="h-[150px] w-[150px] rounded bg-gray-200 relative">
                        <!--                        <div class="absolute inset-0 text-xs text-gray-400 uppercase flex items-center justify-center">-->
                        <!--                            vorschau-->
                        <!--                        </div>-->
                        <div class="absolute inset-0 flex justify-center">
                            <div
                                class="h-full bg-rose-300 shadow-lg ziegel border-r-2 border-l-2 border-rose-400"></div>
                        </div>
                    </div>
                    <div class="flex-1 ml-4">
                        <el-form
                            label-position="top"
                            class="grid sm:grid-cols-2 gap-4">
                            <el-form-item label="Material" :required="true">
                                <el-cascader
                                    class="w-full"
                                    size="large"
                                    :options="options"
                                    :props="cascaderProps"
                                    placeholder="Material"
                                    clearable />
                            </el-form-item>
                            <el-form-item
                                label="Stärke in Zentimeter"
                                :required="true">
                                <el-input-number
                                    class="w-full"
                                    :precision="2"
                                    :step="0.1"
                                    :max="500"
                                    :min="0"
                                    size="large"
                                    placeholder="Materialstärke" />
                            </el-form-item>
                        </el-form>
                    </div>
                </div>
            </div>
        </StepperWrapper>
    </GuestLayout>
</template>

<style scoped>
.el-input-number {
    width: 100%;
}

.ziegel {
    background-image: url("data:image/svg+xml,%3Csvg width='32' height='34' viewBox='0 0 42 44' xmlns='http://www.w3.org/2000/svg'%3E%3Cg id='Page-1' fill='none' fill-rule='evenodd'%3E%3Cg id='brick-wall' fill='%23fb7185' fill-opacity='1'%3E%3Cpath d='M0 0h42v44H0V0zm1 1h40v20H1V1zM0 23h20v20H0V23zm22 0h20v20H22V23z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
</style>
