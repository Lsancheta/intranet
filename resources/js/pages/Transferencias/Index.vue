<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
//import { Ziggy } from "@/ziggy";

defineProps({
  transferencias: Object,
})
</script>

<template>
  <AppLayout>

    <!-- HEADER -->
    <template #header>
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold">Transferências</h1>
        <div class="flex gap-3">
        <Link
          href="estoque/"
          class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700"
        >
          Voltar
        </Link>

        <Link
          href="transferencias/criar"
          class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700"
        >
          Nova Transferência
        </Link>
        </div>
      </div>
    </template>

    <div class="p-6 space-y-6">

      <!-- FILTROS (estrutura pronta) -->
      <div class="p-4 rounded-2xl bg-white dark:bg-gray-800 shadow">
        <h2 class="font-semibold mb-3">Filtros</h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <input
            type="text"
            placeholder="Produto"
            class="border rounded px-3 py-2 w-full"
          />

          <select class="border rounded px-3 py-2 w-full">
            <option value="">Tipo</option>
            <option>Entrada</option>
            <option>Saída</option>
            <option>Transferência</option>
            <option>Ajuste</option>
          </select>

          <input
            type="date"
            class="border rounded px-3 py-2 w-full"
          />

          <input
            type="date"
            class="border rounded px-3 py-2 w-full"
          />
        </div>
      </div>

      <!-- TABELA -->
      <div class="overflow-x-auto rounded-2xl bg-white dark:bg-gray-800 shadow">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="px-4 py-3 text-left">Produto</th>
              <th class="px-4 py-3 text-left">Tipo</th>
              <th class="px-4 py-3 text-right">Quantidade</th>
              <th class="px-4 py-3 text-left">Origem</th>
              <th class="px-4 py-3 text-left">Destino</th>
              <th class="px-4 py-3 text-left">Usuário</th>
              <th class="px-4 py-3 text-left">Data</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="tr in transferencias.data"
              :key="tr.id"
              class="border-t hover:bg-gray-50 dark:hover:bg-gray-700"
            >
              <td class="px-4 py-3">
                {{ item.produto.nome }}
              </td>

              <td class="px-4 py-3">
                <span
                  class="px-2 py-1 rounded text-xs font-semibold"
                  :class="{
                    'bg-green-100 text-green-800': tr.tipo?.id === 1,
                    'bg-red-100 text-red-800': tr.tipo?.id === 2,
                    'bg-blue-100 text-blue-800': tr.tipo?.id === 3,
                    'bg-yellow-100 text-yellow-800': tr.tipo?.id === 4,
                  }"
                >
                  {{ tr.tipo?.nome }}
                </span>
              </td>

              <td class="px-4 py-3 text-right">
                {{ item.quantidade }}
              </td>

              <td class="px-4 py-3">
                {{ tr.origem?.nome ?? '-' }}
              </td>

              <td class="px-4 py-3">
                {{ tr.destino?.nome ?? '-' }}
              </td>

              <td class="px-4 py-3">
                {{ tr.usuario?.name }}
              </td>

              <td class="px-4 py-3">
                {{ new Date(tr.created_at).toLocaleDateString() }}
              </td>
            </tr>

            <tr v-if="transferencias.data.length === 0">
              <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                Nenhuma transferência encontrada.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- PAGINAÇÃO -->
      <div class="flex justify-center gap-1">
        <Link
          v-for="link in transferencias.links"
          :key="link.label"
          :href="link.url ?? ''"
          v-html="link.label"
          class="px-3 py-1 rounded border"
          :class="{
            'bg-blue-600 text-white': link.active,
            'text-gray-400 pointer-events-none': !link.url
          }"
        />
      </div>

    </div>
  </AppLayout>
</template>
