<template>
  <AppLayout>
    <template #header>
      <!-- HEADER RESPONSIVO -->
      <div class="flex items-center justify-between mt-3 text-white">

        <h1 class="text-lg font-semibold">Usuários</h1>

        <button 
          @click="openMenu = !openMenu"
          class="md:hidden p-2 border rounded text-white"
        >
          ☰
        </button>

        <!-- DESKTOP -->
        <div class="hidden md:flex gap-4">
          <Link href="/admin" class="hover:underline">Dashboard</Link>
          <Link href="/index/usuarios" class="hover:underline font-semibold">
            Usuários
          </Link>
          <Link href="/index/usuarios/criar" class="hover:underline">Novo Usuário</Link>
        </div>
      </div>

      <!-- MOBILE -->
      <div v-if="openMenu" class="md:hidden mt-2 bg-gray-800 p-3 rounded">
        <Link href="/admin" class="block py-1 hover:underline">Dashboard</Link>
        <Link href="/index/usuarios" class="block py-1 hover:underline font-semibold">Usuários</Link>
        <Link href="/index/usuarios/criar" class="block py-1 hover:underline">Novo Usuário</Link>
      </div>
    </template>

    <div class="max-w-4xl mx-auto px-4 py-6">
      <h3 class="text-xl font-semibold mb-4">Lista de Usuários</h3>

      <div class="overflow-x-auto rounded-lg shadow bg-white">
        <table class="w-full text-sm">
          <thead class="bg-gray-100 border-b">
            <tr>
              <th class="p-3 text-left">Nome</th>
              <th class="p-3 text-left">Email</th>
              <th class="p-3 text-left">Opções</th>
            </tr>
          </thead>

          <tbody>
            <tr 
              v-for="u in usuarios" 
              :key="u.id"
              class="border-b hover:bg-gray-50"
            >
              <td class="p-3">{{ u.name }}</td>
              <td class="p-3">{{ u.email }}</td>
              <td class="p-3">
                <div class="flex gap-3">
                  <Link :href="`/index/usuarios/${u.id}/editar`" class="text-blue-600 hover:underline">
                    Alterar
                  </Link>

                  <button 
                    @click="confirmDelete(u)"
                    class="text-red-600 hover:underline"
                  >
                    Deletar
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- MODAL -->
      <div
        v-if="showDeleteModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-4"
      >
        <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full">
          <h2 class="text-lg font-bold mb-4">Confirmar exclusão</h2>

          <p class="mb-6">
            Deseja excluir o usuário
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

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const openMenu = ref(false)
const showDeleteModal = ref(false)
const userToDelete = ref(null)

function confirmDelete(user) {
  userToDelete.value = user
  showDeleteModal.value = true
}

function deleteUser() {
  router.delete(`/index/usuarios/${userToDelete.value.id}`, {
    onSuccess: () => {
      showDeleteModal.value = false
    }
  })
}

const props = defineProps({
  usuarios: Array
})
</script>
