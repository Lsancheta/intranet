<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const openMenu = ref(false)
</script>


<template>
  <AppLayout>
    <template #header>
      <!-- MENU RESPONSIVO -->
      <div class="flex items-center justify-between mt-3 text-white">
        <h1 class="text-lg font-semibold">PAINEL DE GESTÃO DO SISTEMA</h1>
      </div>
    </template>

    <section class="grid sm:grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-5">
        
      <!-- Painel 1 - Usuarios -->
        <div class="bg-white shadow rounded-2xl p-5 hover:shadow-lg transition-shadow duration-500">
          <Link href="/index/usuarios">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 justify-center flex items-center">
              Usuarios
            </h2>
            <div class="flex items-center justify-center h-32">
              <span class="text-5xl font-bold text-gray-800">
                <img src="/storage/app/public/icons/user_icon.png" alt="icone de usuários" class="w-16 h-16 mb-6">
              </span>
            </div>

            <p class="text-center text-sm text-gray-600 mt-2">
              Configurações de usuários, permissões e acesso ao sistema
            </p>
          </Link>
        </div>

        <!-- Painel 2 - Colaboradores da cutrale -->
        <div class="bg-white shadow rounded-2xl p-6 hover:shadow-lg transition-shadow duration-500">
          <Link href="/quantitativo/">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 justify-center flex items-center">
              Quantitativo
            </h2>
            <div class="flex items-center justify-center h-32">
              <span class="text-5xl font-bold text-gray-800">
                <img src="/storage/app/public/icons/quantitativo_icon.png" alt="icone de moradores" class="w-16 h-16 mb-6">
              </span>
            </div>

            <p class="text-center text-sm text-gray-500 mt-2">
              Total de Moradores cadastrados
            </p>
          </Link>
        </div>
                <!-- Painel 3 - Auditoria-->
        <div class="bg-white shadow rounded-2xl p-6 hover:shadow-lg transition-shadow duration-500">
          <h2 class="text-lg font-semibold text-gray-700 mb-4 justify-center flex items-center">
            Auditoria Interna
          </h2>
          <div class="flex items-center justify-center h-32">
            <span class="text-5xl font-bold text-gray-800">
              <img src="/storage/app/public/icons/auditoria_icon.png" alt="icone de estoque" class="w-16 h-16 mb-6">
            </span>
          </div>

          <p class="text-center text-sm text-gray-500 mt-2">
            Auditoria de processos, conformidade e segurança, com relatórios detalhados
          </p>
        </div>
        
        <!-- Painel 4 - manutenção -->
        <div class="bg-white shadow rounded-2xl p-6 hover:shadow-lg transition-shadow duration-500">
          <h2 class="text-lg font-semibold text-gray-700 mb-4 justify-center flex items-center">
            Manutenção
          </h2>
          <div class="flex items-center justify-center h-32">
            <span class="text-5xl font-bold text-gray-800">
              <img src="/storage/app/public/icons/os_icon.png" alt="icone de OS" class="w-16 h-16 mb-6">
            </span>
          </div>

          <p class="text-center text-sm text-gray-500 mt-2">
            Análise de status e prazos das ordens de serviço, Estoque de materiais e equipamentos, com alertas de reposição
          </p>
        </div>

        <!-- Painel 5 - Nutricionistas
          <div class="bg-white shadow rounded-2xl p-6 hover:shadow-lg transition-shadow duration-500">
            <Link href="/estoque">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 justify-center flex items-center">
              Nutricionistas
            </h2>
            <div class="flex items-center justify-center h-32">
              <span class="text-5xl font-bold text-gray-800">
                <img src="/storage/app/public/icons/nutricionista_icon.png" alt="icone de nutricionista" class="w-16 h-16 mb-6">
              </span>
            </div>
        

            <p class="text-center text-sm text-gray-500 mt-2">
              Planejamento de cardápios, análise de consumo e controle de estoque de alimentos
            </p>
            </Link>
          </div>
        -->
        
        <!-- Painel 6 - basta copiar o modelo acima para criar um novo card. -->
    </section>
  </AppLayout>
</template>

