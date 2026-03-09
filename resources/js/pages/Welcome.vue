<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from "@inertiajs/vue3";
//import Modal from "@/Components/Modal.vue";

const props = defineProps({
  totalOs: {type: Number, default: 0},
  osResolvidas: {type: Number, default: 0},
  osPendentes: {type: Number, default: 0},
  osAbertas: {type: Number, default: 0},
  osEmAndamento: {type: Number, default: 0}
  ,
  totalQuant: { type: Number, default: 0 },
  sumQuantidade: { type: Number, default: 0 },
  recentQuant: { type: Array, default: () => [] },
})

</script>

<template>
  <AppLayout>
    <div class="p-6 space-y-8">
      <!-- Cabeçalho -->
      <section>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
          <span class="font-bold">{{ $page.props.auth.user.name }}</span>, bem-vindo 👋
        </h1>
        <p class="text-gray-600">
          Acompanhe os indicadores e comunicados do sistema.
        </p>
      </section>

      <!-- GRID PRINCIPAL -->
      <section class="grid grid-cols-1 lg:grid-cols-2 sm:grid-cols-1 gap-6">

        <!-- Painel 1 - Colaboradores -->
        <div class="bg-white shadow rounded-2xl p-6">
          
              <div class="w-full">
                <div class="mt-4">
                  <div v-if="recentQuant.length" class="overflow-x-auto max-h-52 overflow-y-auto">
                    <table class="w-full text-sm">
                      <thead class="bg-gray-100">
                        <tr>
                          <th class="px-3 py-2 text-left">Nome</th>
                          <th class="px-3 py-2 text-left">Quantidade</th>
                          <th class="px-3 py-2 text-left">Fazenda</th>
                          <th class="px-3 py-2 text-left">Bloco</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr v-for="q in recentQuant" :key="q.id" class="border-t">
                          <td class="px-3 py-2">{{ q.nome }}</td>
                          <td class="px-3 py-2">{{ q.quantidade }}</td>
                          <td class="px-3 py-2">{{ q.fazenda }}</td>
                          <td class="px-3 py-2">{{ q.bloco?.nome ?? '—' }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          
            <div class="text-center">
              <p class="text-2xl font-semibold text-gray-700 mt-2">{{ sumQuantidade }}</p>
              <p class="text-md text-gray-400">Total de Moradores cadastrados</p>
            </div>
        </div>

        <!-- Painel 2 - Ordens de Serviço -->
        <div class="bg-white shadow rounded-2xl p-6">
          <Link href="/ordens">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">
              🛠 Ordens de Serviço
            </h2>

            <div class="grid grid-cols-2 gap-4 text-center">
              <div>
                <p class="text-3xl font-bold text-gray-800">{{ totalOs }}</p>
                <p class="text-sm text-gray-500">Total </p>
              </div>

              <div>
                <p class="text-3xl font-bold text-blue-800">{{ osResolvidas }}</p>
                <p class="text-sm text-gray-500">Resolvidas</p>
              </div>

              <div>
                <p class="text-3xl font-bold text-green-600">{{ osAbertas }}</p>
                <p class="text-sm text-gray-500">Abertas</p>
              </div>

              <div>
                <p class="text-3xl font-bold text-yellow-500">{{ osEmAndamento }}</p>
                <p class="text-sm text-gray-500">Em andamento</p>
              </div>

              <div>
                <p class="text-3xl font-bold text-red-500">{{ osPendentes }}</p>
                <p class="text-sm text-gray-500">Pendentes</p>
              </div>
            </div>
          </Link>
        </div>
        <!-- Painel 3 - Avisos -->
        <div class="bg-white shadow rounded-2xl p-6">
          <h2 class="text-lg font-semibold text-gray-700 mb-4">
            📢 Avisos e Atualizações
          </h2>

          <div class="space-y-4">
            <div>
              <h3 class="font-semibold text-gray-800">
                Fase de testes do sistema
              </h3>
              <p class="text-sm text-gray-600">
                A primeira versão entrou em testes com a equipe de manutenção.
              </p>
              <span class="text-xs text-gray-400">
                02/12/2025
              </span>
            </div>

            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-800">
                Nova funcionalidade
              </h3>
              <p class="text-sm text-gray-600">
                Agora é possível visualizar fotos das OS em tela cheia.
              </p>
              <span class="text-xs text-gray-400">
                31/01/2026
              </span>
            </div>
          </div>
        </div>


        <!-- Painel 4 - Reservado -->
        <div class="bg-white shadow rounded-2xl p-6 flex items-center justify-center">
          <span class="text-gray-400 italic">
            Painel reservado para futuras funcionalidades
          </span>
        </div>

      </section>
    </div>
  </AppLayout>
</template>
