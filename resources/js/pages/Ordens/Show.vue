<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { defineProps } from 'vue'

const props = defineProps({
  ordem: Object,
})
</script>

<template>
  <AppLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Detalhes da OS #{{ ordem.id }}</h1>

      <p><strong>Solicitação:</strong> {{ ordem.solicitacao }}</p>
      <p><strong>Bloco:</strong> {{ ordem.bloco }}</p>
      <p><strong>Apartamento:</strong> {{ ordem.apartamento }}</p>
      <p><strong>Descrição:</strong> {{ ordem.descricao }}</p>
      <p><strong>Status:</strong> {{ ordem.status }}</p>
      <p><strong>Data:</strong> {{ ordem.data }}</p>

      <div class="mt-6">
        <Link href="/ordens" class="text-blue-600 hover:underline">← Voltar para lista</Link>
      </div>
    </div>
  </AppLayout>
</template>
