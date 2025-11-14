<template>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 relative min-w-[400px]">
            <button
                class="absolute top-2 right-2 text-gray-600"
                @click="$emit('close')"
            >
                ✖
            </button>
            <slot />
        </div>
    </div>
</template>

<script setup>
</script>

<style>
</style>
