<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import route from 'ziggy-js';
const mobileOpen = ref(false)

function toggleMobile() {
  mobileOpen.value = !mobileOpen.value
}
</script>

<template class="min-h-screen w-full max-w-full flex flex-col bg-gray-100">
  <div >

    <!-- =======================
         BARRA SUPERIOR
    ======================== -->
    <header class="bg-blue-700 text-white flex justify-between items-center px-4 md:px-6 py-2">
      
      <!-- Título -->
      <div class="font-semibold text-base">
        PANNELA DE PEDRA v0.3
      </div>

      <!-- Parte direita -->
      <div class="hidden md:flex items-center space-x-4">
        <span class="font-medium">{{ $page.props.auth.user.name }}</span>
        <Link href="/logout" method="post" as="button" class="hover:underline">Sair</Link>
        <img src="https://via.placeholder.com/40" class="rounded-full ml-2 border border-white/30" />
      </div>

      <!-- Botão mobile -->
      <button class="md:hidden" @click="toggleMobile">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h18M3 18h18" />
        </svg>
      </button>

    </header>



    <!-- =======================
         MENU DESKTOP
    ======================== -->
    <nav class="bg-blue-600 text-white px-6 py-3 hidden md:block">
      <ul class="flex space-x-6 font-semibold">
        <li><Link href="/" class="hover:text-gray-200 px-2">INICIAL</Link></li>
        <li><Link href="/ordens" class="hover:text-gray-200 px-2">ORDEM DE SERVIÇO</Link></li>
        <li><Link href="/estoque" class="hover:text-gray-200 px-2">ESTOQUE</Link></li>
        <li><Link href="#" class="hover:text-gray-200 px-2">COZINHA</Link></li>
        <li><Link href="/admin/" class="hover:text-gray-200 px-2">ADMINISTRAÇÃO</Link></li>
      </ul>
    </nav>



    <!-- =======================
         MENU MOBILE
    ======================== -->
    <transition name="slide-fade">
      <div 
        v-if="mobileOpen" 
        class="md:hidden bg-blue-600 text-white px-6 py-3 space-y-3 font-semibold"
      >
        <div class="flex items-center justify-between mb-4">
          <span>{{ $page.props.auth.user.name }}</span>
          <img src="https://via.placeholder.com/40" class="rounded-full border border-white/30" />
        </div>

        <Link href="/" class="block py-2 border-b border-white/20">INICIAL</Link>
        <Link href="/ordens" class="block py-2 border-b border-white/20">ORDEM DE SERVIÇO</Link>
        <Link href="#" class="block py-2 border-b border-white/20">ESTOQUE</Link>
        <Link href="#" class="block py-2 border-b border-white/20">COZINHA</Link>
        <Link href="/admin/" class="block py-2 border-b border-white/20">ADMINISTRAÇÃO</Link>

        <Link href="/logout" method="post" as="button" class="block py-2 text-red-300 font-normal mt-3">
          Sair
        </Link>
      </div>
    </transition>



    <!-- =======================
         HEADER DA PÁGINA (slot)
    ======================== -->
    <div v-if="$slots.header" class="bg-blue-600 border-b px-5 py-1 text-white">
      <slot name="header"></slot>
    </div>



    <!-- =======================
         CONTEÚDO  p-4 md:p-6
    ======================== -->
    <main class="px-4 sm:px-6 lg:px-8 w-full max-w-full">
      <slot />
    </main>

  </div>
</template>

<style>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.25s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
