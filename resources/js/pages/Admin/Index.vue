<template>
  <AppLayout>
    <template #header>


      <!-- SUBMENU -->
      <div class="flex gap-4 mt-3">
        <Link href="/admin/" class="text-white hover:underline">Dashboard</Link>
        <Link href="/index/usuarios" class="text-white hover:underline">Usuários</Link>
      </div>
    </template>

    <div class="p-6">
      <h3 class="text-lg font-semibold mb-2">Bem-vindo ao painel administrativo</h3>
      <p>Escolha uma opção no menu acima.</p>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>
