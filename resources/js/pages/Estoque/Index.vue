<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from "@inertiajs/vue3";
import { Ziggy } from "@/ziggy";

// Simulações de dados até integrar com backend
const baixoEstoque = ref([
  { id: 1, nome: 'Produto A', quantidade: 3 },
  { id: 2, nome: 'Produto B', quantidade: 1 }
]);

const maisConsumidos = ref([
  { id: 1, nome: 'Produto A', usos: 120 },
  { id: 2, nome: 'Produto C', usos: 95 }
]);

const proximasCompras = ref([
  { id: 1, nome: 'Produto D', data: '2025-12-20' }
]);

const transferenciasPendentes = ref([
  { id: 10, produto: 'Produto A', quantidade: 15 },
  { id: 11, produto: 'Produto C', quantidade: 8 }
]);
</script>

<style scoped>
</style>

<template>
  <AppLayout>
    <!-- HEADER LIMPO -->
    <template #header>
      <div class="flex justify-between items-center">
            
        <h1 class="text-2xl font-semibold">Dashboard Estoque</h1>
        <div class="flex gap-3">
          <!-- Produtos -->
          <Link
              href="/estoque/produtos"
              class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700"
          >
                Produtos
          </Link>
          <!-- Itens do Estoque -->
          <Link 
            href="/estoque/estoque/itens"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
          >
              Estoque
          </Link>
          <!-- Depósito -->
          <Link
            href="/estoque/depositos/itens"
            class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700"
          >
              Depósito
          </Link>

            <!-- Transferências -->
            <Link
                
                href="/transferencias"
                class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700"
            >
                Transferências
            </Link>
            </div>

        </div>
        </template>

    <div class="p-6 space-y-6">

      <!-- Painéis de Métricas -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="p-4 rounded-2xl shadow bg-white dark:bg-gray-800">
          <h2 class="text-lg font-semibold mb-2">Baixo Estoque</h2>
          <ul>
            <li v-for="item in baixoEstoque" :key="item.id">
              {{ item.nome }} — {{ item.quantidade }} un
            </li>
          </ul>
        </div>

        <div class="p-4 rounded-2xl shadow bg-white dark:bg-gray-800">
          <h2 class="text-lg font-semibold mb-2">Produtos Mais Consumidos</h2>
          <ul>
            <li v-for="item in maisConsumidos" :key="item.id">
              {{ item.nome }} — {{ item.usos }} usos
            </li>
          </ul>
        </div>

        <div class="p-4 rounded-2xl shadow bg-white dark:bg-gray-800">
          <h2 class="text-lg font-semibold mb-2">Próximas Compras</h2>
          <ul>
            <li v-for="item in proximasCompras" :key="item.id">
              {{ item.nome }} — sugerir compra em: {{ item.data }}
            </li>
          </ul>
        </div>

      </div>

      <!-- Transferências pendentes -->
      <div class="p-4 rounded-2xl shadow bg-white dark:bg-gray-800">
        <h2 class="text-lg font-semibold mb-4">Transferências Pendentes</h2>
        <ul>
          <li v-for="tr in transferenciasPendentes" :key="tr.id">
            ID: {{ tr.id }} — {{ tr.produto }} ({{ tr.quantidade }} un)
          </li>
        </ul>
      </div>

    </div>

  </AppLayout>
</template>
