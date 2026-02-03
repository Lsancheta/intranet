<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import Form from './Form.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <AppLayout>
        <Head title="Novo Produto" />

        <div class="p-6 space-y-4">
            <h1 class="text-2xl font-bold">Novo Produto</h1>

            <Form
                submitRoute="/estoque/produtos"
                method="post"
            />
        </div>
    </AppLayout>
</template>
