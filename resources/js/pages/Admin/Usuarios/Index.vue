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
                    <li>Alterar</li>
                    <li>Deletar</li>
                </ul>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  usuarios: Array
});
</script>
