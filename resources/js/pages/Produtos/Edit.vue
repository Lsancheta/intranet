<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import Form from './Form.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    produto: Object
})
</script>

<template>
    <AppLayout>
        <Head title="Editar Produto" />

        <div class="p-6 space-y-4">
            <h1 class="text-2xl font-bold">Editar Produto</h1>

            <Form
                :produto="props.produto"
                :submitRoute="`/estoque/produtos/${props.produto.id}`"
                method="put"
            />
        </div>
    </AppLayout>
</template>
