<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  ordens: Array
})
</script>

<template>
  <AppLayout>

    <!-- Header da Página -->
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-white">
          Ordens de Serviço Finalizadas
        </h2>

        <!--<Link
          href="/ordens"
          class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition"
        >
          ← Voltar para OS Abertas
        </Link>-->
      </div>
    </template>

<div class="bg-white p-6 rounded shadow">

  <!-- ====== DESKTOP – TABELA ====== -->
  <div class="hidden md:block">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow table-auto">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="py-3 px-4 border-b">N° OS</th>
          <th class="py-3 px-4 border-b">Título</th>
          <th class="py-3 px-4 border-b">Data Conclusão</th>
          <th class="py-3 px-4 border-b">Ações</th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="ordem in props.ordens"
          :key="ordem.id"
          class="hover:bg-gray-50 transition"
        >
          <td class="py-3 px-4 border-b">
            <span class="font-semibold text-blue-600">
              {{ ordem.id }}
            </span>
          </td>

          <td class="py-3 px-4 border-b">
            {{ ordem.titulo }}
          </td>

          <td class="py-3 px-4 border-b">
            {{ ordem.created_at }}
          </td>

          <td class="py-3 px-4 border-b">
            <Link
              :href="`/ordens/${ordem.id}`"
              class="text-blue-600 hover:underline"
            >
              Ver Detalhes
            </Link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>


  <!-- ====== MOBILE – CARDS ====== -->
  <div class="md:hidden space-y-3 mt-2">
    <Link
      v-for="ordem in props.ordens"
      :key="ordem.id"
      :href="`/ordens/${ordem.id}`"
      class="block bg-white shadow rounded-lg p-4 border active:bg-gray-50"
    >
      <!-- Cabeçalho -->
      <div class="flex justify-between">
        <h2 class="font-semibold text-lg">{{ ordem.titulo }}</h2>

        <span class="px-2 py-1 bg-green-600 text-white rounded-full text-xs">
          Finalizada
        </span>
      </div>

      <!-- Informações -->
      <div class="mt-2 text-sm text-gray-700">
        <div class="flex justify-between">
          <span class="font-semibold">Nº OS:</span>
          <span>{{ ordem.id }}</span>
        </div>

        <div class="flex justify-between">
          <span class="font-semibold">Concluída em:</span>
          <span>{{ ordem.created_at }}</span>
        </div>
      </div>
    </Link>
  </div>

  <!-- Mensagem quando vazio -->
  <div v-if="props.ordens.length === 0" class="text-center py-5 text-gray-600">
    Nenhuma OS finalizada encontrada.
  </div>

</div>


  </AppLayout>
</template>
