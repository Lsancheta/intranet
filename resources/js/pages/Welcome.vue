<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <div class="p-6 space-y-8">
      <!-- Cabeçalho -->
      <section>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
          👋 Bem-vindo
        </h1>
        <p class="text-gray-600">
          Acompanhe os comunicados e utilize o menu lateral para acessar as áreas do sistema.
        </p>
      </section>

      <!-- Painel de Avisos -->
      <section>
        <h2 class="text-xl font-semibold text-gray-700 mb-3">📢 Avisos Internos</h2>

        <div class="bg-white shadow rounded-2xl p-4 divide-y divide-gray-200">
          <div class="py-3">
            <h3 class="font-semibold text-gray-800">Atualização do Sistema</h3>
            <p class="text-gray-600 text-sm">
              A nova versão da intranet será publicada amanhã às 18h. O sistema poderá ficar indisponível por alguns minutos.
            </p>
            <span class="text-xs text-gray-400">Postado em: 12/11/2025</span>
          </div>

          <div class="py-3">
            <h3 class="font-semibold text-gray-800">Reunião da Equipe Técnica</h3>
            <p class="text-gray-600 text-sm">
              Reunião marcada para quinta-feira às 9h no escritório principal. Compareçam pontualmente.
            </p>
            <span class="text-xs text-gray-400">Postado em: 11/11/2025</span>
          </div>

          <div class="py-3">
            <h3 class="font-semibold text-gray-800">Novo Procedimento de OS</h3>
            <p class="text-gray-600 text-sm">
              As Ordens de Serviço agora deverão ser cadastradas diretamente pelo sistema até o final do expediente.
            </p>
            <span class="text-xs text-gray-400">Postado em: 10/11/2025</span>
          </div>
        </div>
      </section>
    </div>
  </AppLayout>
</template>
