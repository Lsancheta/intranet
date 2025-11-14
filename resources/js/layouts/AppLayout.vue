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
        <span class="font-medium">{{ $page.props.auth.user.name}}</span>

        <Link href="#" class="hover:underline">Preferências</Link>
        <Link href="#" class="hover:underline">Ajuda</Link>
        <Link href="/logout" method="post" as="button" class="hover:underline">Sair</Link>

        <img src="https://via.placeholder.com/40" class="rounded-full ml-2 border border-white/30" />
      </div>
    </div>

    <!-- =======================
        MENU PRINCIPAL
    ======================== -->
    <nav class="bg-blue-600 text-white px-6">

      <div class="flex justify-between items-center py-3">

        <!-- Menu Desktop -->
        <ul class="hidden md:flex space-x-6 font-semibold">

          <!-- AGENDA 
          <li class="relative"
              @mouseenter="toggleDropdown('agenda')"
              @mouseleave="toggleDropdown(null)">
            <button class="hover:text-gray-200 flex items-center space-x-1">
              <span>AGENDA</span>
              <span>▼</span>
            </button>

            <div v-if="openDropdown === 'agenda'"
                 class="absolute left-0 top-full bg-white text-black shadow-lg rounded py-2 w-40">
              <Link href="#" class="block px-4 py-2 hover:bg-gray-100">Compromissos</Link>
              <Link href="#" class="block px-4 py-2 hover:bg-gray-100">Tarefas</Link>
            </div>
          </li>
          -->

          <!-- CADASTRO (removido dropdown, agora links diretos) -->
           <li>
            <Link href="/" class="hover:text-gray-200 px-2">
              INICIAL
            </Link>
          </li>
          <li>
            <Link href="/ordens" class="hover:text-gray-200 px-2">
              ORDEM DE SERVIÇO
            </Link>
          </li>

          <li>
            <Link href="/estoque" class="hover:text-gray-200 px-2">
              ESTOQUE
            </Link>
          </li>


          <!-- ADMIN -->
          <li class="relative"
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
          </li>

        </ul>

        <!-- Botão Mobile -->
        <button class="md:hidden" @click="mobileOpen = !mobileOpen">
          <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h18M3 18h18" />
          </svg>
        </button>

      </div>

      <!-- Menu Mobile -->
      <div v-if="mobileOpen" class="md:hidden bg-blue-500 text-white py-2 space-y-2">

        <!-- Agenda -->
        <div class="border-t border-blue-400">
          <button @click="toggleDropdown('agenda')" class="w-full text-left px-4 py-2 font-semibold">
            AGENDA
          </button>
          <div v-if="openDropdown === 'agenda'" class="bg-blue-400">
            <Link href="#" class="block px-6 py-2 hover:bg-blue-300">Compromissos</Link>
            <Link href="#" class="block px-6 py-2 hover:bg-blue-300">Tarefas</Link>
          </div>
        </div>

        <!-- Cadastro -->
        <div class="border-t border-blue-400">
          <button @click="toggleDropdown('cadastro')" class="w-full text-left px-4 py-2 font-semibold">
            CADASTRO
          </button>
          <div v-if="openDropdown === 'cadastro'" class="bg-blue-400">
            <Link href="/ordens" class="block px-6 py-2 hover:bg-blue-300">Ordens</Link>
            <Link href="/estoque" class="block px-6 py-2 hover:bg-blue-300">Estoque</Link>
          </div>
        </div>

        <!-- Admin -->
        <div class="border-t border-blue-400">
          <button @click="toggleDropdown('admin')" class="w-full text-left px-4 py-2 font-semibold">
            ADMIN
          </button>
          <div v-if="openDropdown === 'admin'" class="bg-blue-400">
            <Link href="#" class="block px-6 py-2 hover:bg-blue-300">Usuários</Link>
            <Link href="#" class="block px-6 py-2 hover:bg-blue-300">Configurações</Link>
          </div>
        </div>

      </div>

    </nav> <!-- ← FECHAMENTO QUE FALTAVA !!! -->

    <!-- =======================
        CONTEÚDO DAS PÁGINAS
    ======================== -->
    <div class="p-6">
      <slot />
    </div>

  </div>
</template>
