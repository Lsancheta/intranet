<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Modal from '@/Components/Modal.vue'
import FormCreateOS from './FormCreateOS.vue'
import { ref } from 'vue'

const props = defineProps({
  ordens: {
    type: Array,
    required: true
  },
  alojamentos: Array,
  prioridades: Array
})

const showCreate = ref(false)

function onSaved() {
  showCreate.value = false
}

function statusColor(statusId) {
    switch (statusId) {
        case 1:
            return "bg-blue-100 text-blue-800";     // aberta
        case 2:
            return "bg-yellow-100 text-yellow-800"; // em andamento
        case 3:
            return "bg-red-100 text-red-800";       // pendente
        case 4:
            return "bg-green-100 text-green-800";   // resolvida
        default:
            return "bg-gray-100 text-gray-800";     // desconhecido
    }
}
</script>

<template>
  <AppLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Ordens de Serviço</h1>

      <button
        type="button"
        class="px-3 py-1 bg-blue-600 text-white rounded"
        @click="showCreate = true"
      >
        NOVA OS
      </button>

      <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="py-2 px-4 border-b">N° OS</th>
            <th class="py-2 px-4 border-b">Solicitação</th>
            <th class="py-2 px-4 border-b">Prioridade</th>
            <th class="py-2 px-4 border-b">Status</th>
            <th class="py-2 px-4 border-b">Solicitante</th>
            <th class="py-2 px-4 border-b">Data da Solicitação</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="ordem in props.ordens"
            :key="ordem.id"
            class="hover:bg-gray-50 cursor-pointer"
          >
            <td class="py-2 px-4 border-b">
              <Link :href="`/ordens/${ordem.id}`" class="text-blue-600 hover:underline">
                {{ ordem.id }}
              </Link>
            </td>

            <td class="py-2 px-4 border-b">{{ ordem.titulo }}</td>

            <!-- PRIORIDADE -->
            <td class="py-2 px-1 border-b">
              <span
                class="px-10 py-1 rounded text-white text-1xl"
                :style="{ backgroundColor: ordem.prioridade?.cor ?? '#777' }"
              >
                {{ ordem.prioridade?.nome ?? 'Sem prioridade' }}
              </span>
            </td>

            <!-- STATUS -->
            <td class="py-2 px-4 border-b">
              <span
                  :class="`${statusColor(ordem.status_id)} px-3 py-1 rounded-full text-sm font-semibold`"
              >
                {{ ordem.status.nome }}
              </span>
            </td>

            <td class="py-2 px-4 border-b">{{ ordem.solicitante?.name ?? '---' }}</td>

            <td class="py-2 px-4 border-b">{{ ordem.created_at }}</td>
          </tr>
        </tbody>
      </table>

      <!-- MODAL DE CRIAÇÃO -->
      <Modal v-if="showCreate" @close="showCreate = false">
        <FormCreateOS 
          :alojamentos="props.alojamentos" 
          :prioridades="props.prioridades"
          @saved="onSaved" />
      </Modal>
    </div>
  </AppLayout>
</template>

<!--

-->

