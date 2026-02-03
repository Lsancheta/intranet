<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    produto: {
        type: Object,
        default: () => ({
            nome: '',
            unidade: '',
            preco_custo: 0,
            estoque_minimo: 0,
            ativo: true,
        })
    },
    submitRoute: String,
    method: {
        type: String,
        default: 'post'
    }
});

const form = useForm({
    nome: props.produto.nome,
    unidade: props.produto.unidade,
    preco_custo: props.produto.preco_custo,
    estoque_minimo: props.produto.estoque_minimo,
    ativo: props.produto.ativo,
});

function submit() {
    form[props.method](props.submitRoute);
}
</script>

<template>
    <form @submit.prevent="submit" class="space-y-4">

        <div>
            <label class="block text-sm font-medium">Nome</label>
            <input v-model="form.nome" type="text" class="border rounded px-3 py-2 w-full">
            <div v-if="form.errors.nome" class="text-red-500 text-sm">{{ form.errors.nome }}</div>
        </div>

        <div>
            <label class="block text-sm font-medium">Unidade</label>
            <input v-model="form.unidade" type="text" class="border rounded px-3 py-2 w-full">
            <div v-if="form.errors.unidade" class="text-red-500 text-sm">{{ form.errors.unidade }}</div>
        </div>

        <div>
            <label class="block text-sm font-medium">Preço de Custo</label>
            <input v-model="form.preco_custo" type="number" step="0.01"
                   class="border rounded px-3 py-2 w-full">
        </div>

        <div>
            <label class="block text-sm font-medium">Estoque Mínimo</label>
            <input v-model="form.estoque_minimo" type="number"
                   class="border rounded px-3 py-2 w-full">
        </div>

        <div class="flex items-center gap-2">
            <input v-model="form.ativo" id="ativo" type="checkbox" class="h-4 w-4">
            <label for="ativo">Ativo</label>
        </div>

        <button
            type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            :disabled="form.processing"
        >
            Salvar
        </button>

    </form>
</template>
