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

      <!-- Tabela -->
      <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="py-2 px-4 border-b">N° OS</th>
            <th class="py-2 px-4 border-b">Título</th>
            <th class="py-2 px-4 border-b">Data Conclusão</th>
            <th class="py-2 px-4 border-b">Ações</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="ordem in props.ordens"
            :key="ordem.id"
            class="hover:bg-gray-50"
          >
            <td class="py-2 px-4 border-b">
              <span class="font-semibold text-blue-600">
                {{ ordem.id }}
              </span>
            </td>

            <td class="py-2 px-4 border-b">
              {{ ordem.titulo }}
            </td>

            <td class="py-2 px-4 border-b">
              {{ ordem.created_at }}
            </td>
              
            <td class="py-2 px-4 border-b">
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

      <div v-if="props.ordens.length === 0" class="text-center py-5 text-gray-600">
        Nenhuma OS finalizada encontrada.
      </div>

    </div>

  </AppLayout>
</template>
