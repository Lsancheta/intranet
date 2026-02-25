<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import {  reactive, watch } from 'vue'
//import { Ziggy } from "@/ziggy";

const props = defineProps({
  transferencias: Object,
  filters: Object
})

const filtros = reactive({
  produto: props.filters?.produto || '',
  tipo_id: props.filters?.tipo_id || '',
  data_inicio: props.filters?.data_inicio || '',
  data_fim: props.filters?.data_fim || '',
})

let timeout = null

watch(
  filtros,
  (value) => {
    clearTimeout(timeout)

    timeout = setTimeout(() => {
      router.get('/transferencias', value, {
        preserveState: true,
        replace: true,
      })
    }, 400)
  },
  { deep: true }
)

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

      <!-- FILTROS -->
      <div class="p-4 rounded-2xl bg-white dark:bg-gray-800 shadow">
        <h2 class="font-semibold mb-3">Filtros</h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <input
            v-model="filtros.produto"
            type="text"
            placeholder="Produto"
            class="border rounded px-3 py-2 w-full"
          />

          <select
              v-model="filtros.tipo_id"
              class="border rounded px-3 py-2 w-full"
            >
            <option value="">Tipo</option>
            <option value="1">Entrada</option>
            <option value="2">Saída</option>
            <option value="3">Transferência</option>
            <option value="4">Ajuste</option>
          </select>

          <input
            v-model="filtros.data_inicio"
            type="date"
            class="border rounded px-3 py-2 w-full"
          />

          <input
            v-model="filtros.data_fim"
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
            <template v-for="transferencia in transferencias.data" :key="transferencia.id">
              
              <tr v-for="item in transferencia.itens" :key="item.id">

                <td class="px-4 py-3">
                  {{ item.produto?.nome }}
                </td>

                <td class="px-4 py-3">
                  <span
                    class="px-2 py-1 rounded text-xs font-semibold"
                    :class="{
                      'bg-green-100 text-green-800': transferencia.tipo?.id === 1,
                      'bg-red-100 text-red-800': transferencia.tipo?.id === 2,
                      'bg-blue-100 text-blue-800': transferencia.tipo?.id === 3,
                      'bg-yellow-100 text-yellow-800': transferencia.tipo?.id === 4,
                    }"
                  >
                    {{ transferencia.tipo?.nome }}
                  </span>
                </td>

                <td class="px-4 py-3 text-right">
                  {{ item.quantidade }}
                </td>

                <td class="px-4 py-3">
                  {{ transferencia.origem?.nome ?? '-' }}
                </td>

                <td class="px-4 py-3">
                  {{ transferencia.destino?.nome ?? '-' }}
                </td>

                <td class="px-4 py-3">
                  {{ transferencia.usuario?.name ?? '-' }}
                </td>

                <td class="px-4 py-3">
                  {{ new Date(transferencia.created_at).toLocaleDateString() }}
                </td>

              </tr>

            </template>

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
