<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

</script>

<template>
  <AppLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Ordens de Serviço</h1>

      <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="py-2 px-4 border-b">N° OS</th> <!-- Aqui é o ID do banco-->
            <th class="py-2 px-4 border-b">Solicitação</th>
            <th class="py-2 px-4 border-b">Status</th>
            <th class="py-2 px-4 border-b">Data</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="ordem in ordens"
            :key="ordem.id"
            class="hover:bg-gray-50 cursor-pointer"
          >
            <td class="py-2 px-4 border-b">
              <Link :href="`/ordens/${ordem.id}`" class="text-blue-600 hover:underline">
                {{ ordem.id }}
              </Link>
            </td>
            <td class="py-2 px-4 border-b">{{ ordem.solicitacao }}</td>
            <td class="py-2 px-4 border-b">{{ ordem.status }}</td>
            <td class="py-2 px-4 border-b">{{ ordem.data }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
