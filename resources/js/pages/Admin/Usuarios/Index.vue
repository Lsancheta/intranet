
<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue'
import {router } from '@inertiajs/vue3'

const showDeleteModal = ref(false)
const userToDelete = ref(null)

function confirmDelete(user){
  userToDelete.value = user
  showDeleteModal.value= true  
}

function deleteUser(){
  router.delete(`/index/usuarios/${userToDelete.value.id}`,{
    onSuccess: () => {
      showDeleteModal.value = false
    }
  })
}

const props = defineProps({
  usuarios: Array
});
</script>

<template>
  <AppLayout>
    <template #header>
      <div class="flex gap-4 mt-3">
        <Link href="/admin" class="text-white hover:underline">Dashboard</Link>
        <Link href="/index/usuarios" class="text-white hover:underline font-semibold">
          Usuários
        </Link>
        <Link href="/index/usuarios/criar" class="text-white hover:underline">
          Novo Usuário
        </Link>
      </div>
    </template>

    <div class="p-6">
      <h3 class="text-lg font-semibold mb-4">Lista de Usuários Cadastrados</h3>

      <table class="min-w-full bg-white rounded shadow">
        <thead>
          <tr class="border-b bg-gray-100">
            <th class="p-3 text-left">Nome</th>
            <th class="p-3 text-left">Email</th>
            <th class="p3 text-left">Opções</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="u in usuarios" :key="u.id" class="border-b hover:bg-gray-50">
            <td class="p-3">{{ u.name }}</td>
            <td class="p-3">{{ u.email }}</td>
            <td class="p3">
                <ul class="flex gap-3">
                    <li>
                      <Link :href="`/index/usuarios/${u.id}/editar`" class="hover:underline">
                        Alterar
                      </Link>
                    </li>
                    <li>
                      <button
                        class="text-red-600 hover:underline"
                        @click="confirmDelete(u)"
                      >
                        Deletar
                    </button>
                    </li>
                </ul>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- Modal -->
      <div
        v-if="showDeleteModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"
      >
        <div class="bg-white p-6 rounded shadow-lg w-[350px]">
          <h2 class="text-lg font-bold mb-4">
            Confirmar exclusão
          </h2>

          <p class="mb-6">
            Quer mesmo deletar o usuário 
            <strong>{{ userToDelete?.name }}</strong>?
          </p>

          <div class="flex justify-end gap-2">
            <button
              class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
              @click="showDeleteModal = false"
            >
              Cancelar
            </button>

            <button
              class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
              @click="deleteUser"
            >
              Deletar
            </button>
          </div>
        </div>
      </div>

    </div>
  </AppLayout>
</template>

