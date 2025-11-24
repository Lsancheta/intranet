<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const mobileOpen = ref(false)
const openDropdown = ref(null)

function toggleDropdown(name) {
  openDropdown.value = openDropdown.value === name ? null : name
}
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-100">

    <!-- =======================
        BARRA SUPERIOR
    ======================== -->
    <div class="bg-blue-700 text-white flex justify-between items-center px-6 py-2 text-sm">
      <div class="font-semibold text-base">
        Seu Logotipo Aqui
      </div>

      <div class="flex items-center space-x-4">
        <span class="bg-white/20 px-2 rounded text-xs">🔔 7</span>
        <span class="font-medium">{{ $page.props.auth.user.name }}</span>
        <Link href="/logout" method="post" as="button" class="hover:underline">Sair</Link>

        <img src="https://via.placeholder.com/40" class="rounded-full ml-2 border border-white/30" />
      </div>
    </div>

    <!-- =======================
        MENU PRINCIPAL
    ======================== -->
    <nav class="bg-blue-600 text-white px-6">
      <div class="flex justify-between items-center py-3">
        <ul class="hidden md:flex space-x-6 font-semibold">
          <li><Link href="/" class="hover:text-gray-200 px-2">INICIAL</Link></li>
          <li><Link href="/ordens" class="hover:text-gray-200 px-2">ORDEM DE SERVIÇO</Link></li>
          <li><Link href="#" class="hover:text-gray-200 px-2">ESTOQUE</Link></li>
          <li><Link href="#" class="hover:text-gray-200 px-2">COZINHA</Link></li>
          <li><Link href="/admin/" class="hover:text-gray-200 px-2">ADMINISTRAÇÃO</Link></li>

          <!--<li class="relative"
            @mouseenter="toggleDropdown('admin')"
            @mouseleave="toggleDropdown(null)">
            <button class="hover:text-gray-200 flex items-center space-x-1">
              <span>ADMIN</span>
              <span>▼</span>
            </button>
            <div v-if="openDropdown === 'admin'"
                class="absolute left-0 top-full bg-white text-black shadow-lg rounded py-2 w-40">
              <Link href="#" class="block px-4 py-2 hover:bg-gray-100">Usuários</Link>
              <Link href="#" class="block px-4 py-2 hover:bg-gray-100">Configurações</Link>
            </div>
          </li>-->
          
        </ul>

        <button class="md:hidden" @click="mobileOpen = !mobileOpen">
          <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h18M3 18h18" />
          </svg>
        </button>
      </div>
    </nav>

    <!-- =======================
        SUBMENU DINÂMICO
    ======================== -->
    <div v-if="$slots.header" class="bg-blue-600 border-b px-5 py-1">
      <slot name="header"></slot>
    </div>

    <!-- =======================
        CONTEÚDO DAS PÁGINAS
    ======================== -->
    <div class="p-6">
      <slot />
    </div>

  </div>
</template>
