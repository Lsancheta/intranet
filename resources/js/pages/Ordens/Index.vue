<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Modal from '@/Components/Modal.vue'
import FormCreateOS from './FormCreateOS.vue'
import {useForm} from '@inertiajs/vue3'
import {ref} from 'vue'

const props = defineProps({
  ordens: {
    type: Array,
    required: true
  }
})
const showCreate = ref(false)
function onSaved(){
  showCreate.value = false
}

function openCreate(){
  console.log('Botao de criar Os clicado, showCreate antes:', showCreate,value);
  showCreate.value = true;
  console.log('showCreate depois:', showCreate.value);
}

</script>

<template>
  <AppLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Ordens de Serviço</h1>
      <button type="button" class="px-3 py-1 bg-blue-600 text-white rounded" @click="showCreate = true">
        NOVA OS
      </button>
      <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="py-2 px-4 border-b">N° OS</th> <!-- Aqui é o ID do banco-->
            <th class="py-2 px-4 border-b">Solicitação</th>
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
            <td class="py-2 px-4 border-b">{{ ordem.status }}</td>
            <td class="py-2 px-4 border-b">{{ ordem.solicitante?.name ?? '---' }}</td>
            <td class="classpy-2 px-4 border-b">{{ ordem.created_at }}</td>
          </tr>
        </tbody>
      </table>
      <!-- MODAL DE CRIAÇAO DE OS-->
       <Modal v-if="showCreate" @close="showCreate = false">
          <FormCreateOS @saved="onSaved" />
      </Modal>
    </div>
  </AppLayout>
</template>
