<script setup></script>

<template>
    <div class="rounded-lg shadow bg-white mt-6 flex flex-col">
        <div class="flex px-6 py-4 justify-between items-center">
            <div>
                <h3 class="text-base font-semibold leading-7 text-gray-900">
                    <slot name="title"></slot>
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-tight text-gray-500">
                    <slot name="subtitle"></slot>
                </p>
            </div>
            <slot name="button"></slot>
        </div>
        <div class="border-t border-gray-100">
            <slot name="content"></slot>
        </div>
    </div>
</template>
