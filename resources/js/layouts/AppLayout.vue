<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="min-h-screen flex bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
      <div class="p-4 font-bold text-xl border-b">Pannela de Pedra</div>
      <nav class="p-4 space-y-2">
        <Link href="/" class="block text-gray-700 hover:text-blue-600">🏠 Início</Link>
        <Link href="/ordens" class="block text-gray-700 hover:text-blue-600">🧾 Ordens de Serviço</Link>
        <Link href="/estoque" class="block text-gray-700 hover:text-blue-600">📦 Estoque</Link>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6">
      <header class="mb-6 border-b pb-2">
        <h1 class="text-2xl font-semibold"></h1>
      </header>

      <slot />
    </main>
  </div>
</template>
