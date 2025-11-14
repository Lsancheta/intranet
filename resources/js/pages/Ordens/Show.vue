<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { defineProps } from 'vue'

const { ordem } = defineProps({
  ordem: Object
})
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">
      Ordem de Serviço #{{ ordem.id }}
    </h1>

    <div class="space-y-3">
      <p><strong>Status:</strong> {{ ordem.status }}</p>
      <p><strong>Solicitante:</strong> {{ ordem.solicitante?.name }}</p>

      <p><strong>Descrição:</strong> {{ ordem.descricao }}</p>
      <p><strong>Criado em:</strong> {{ ordem.created_at }}</p>
    </div>

      <div class="mt-6">
        <Link href="/ordens" class="text-blue-600 hover:underline">← Voltar para lista</Link>
      </div>
  </div>
</template>
