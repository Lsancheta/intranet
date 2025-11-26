<template>
  <AppLayout>
    <template #header>
      <!-- MENU RESPONSIVO -->
      <div class="flex items-center justify-between mt-3 text-white">

        <h1 class="text-lg font-semibold">Admin</h1>

        <!-- BOTÃO MOBILE -->
        <button 
          @click="openMenu = !openMenu"
          class="md:hidden p-2 border rounded text-white"
        >
          ☰
        </button>

        <!-- MENU DESKTOP -->
        <div class="hidden md:flex gap-4">
          <Link href="/admin" class="hover:underline">Dashboard</Link>
          <Link href="/index/usuarios" class="hover:underline">Usuários</Link>
        </div>
      </div>

      <!-- MENU MOBILE DROPDOWN -->
      <div v-if="openMenu" class="md:hidden mt-2 bg-gray-800 p-3 rounded">
        <Link href="/admin" class="block py-1 hover:underline text-white">Dashboard</Link>
        <Link href="/index/usuarios" class="block py-1 hover:underline text-white">Usuários</Link>
      </div>
    </template>

    <div class="max-w-3xl mx-auto px-4 py-6">
      <h3 class="text-xl font-semibold mb-2">Bem-vindo ao painel administrativo</h3>
      <p class="text-gray-600">Escolha uma opção no menu acima.</p>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const openMenu = ref(false)
</script>
