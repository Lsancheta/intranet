<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from "@inertiajs/vue3";
import { Ziggy } from "@/ziggy";

const props = defineProps({
  produtos_baixo_estoque: Array,
  top_consumidos: Array,
  previsao_reposicao: Array,
  pendentes: Array,
  produtos:Object,
  estoqueItems: Object,
  depositoItems: Object,
  naoPereciveis: Array,
  proteinas: Array,
  hortifrutis: Array
})



</script>

<style scoped>
</style>

<template>
  <AppLayout>
    <!-- HEADER LIMPO -->
    <template #header>
      <div class="flex justify-between items-center">    
        <h1 class="text-2xl font-semibold">NUTRICIONISTA</h1>
      </div>
        </template>
  
        <section class="grid sm:grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-5">
          <!-- Painel 1 - Cadastro produto -->
          <div class="bg-white shadow rounded-2xl p-5 hover:shadow-lg transition-shadow duration-500">
            <Link href="/estoque/produtos">
              <h2 class="text-lg font-semibold text-gray-700 mb-4 justify-center flex items-center">
                Cadastrar Matéria Prima
              </h2>
              <div class="flex items-center justify-center h-32">
                <span class="text-5xl font-bold text-gray-800">
                  <img src="/storage/app/public/icons/materia_icon.png" alt="icone de materia Prima" class="w-16 h-16 mb-6">
                </span>
              </div>
            </Link>
          </div>

          <!-- Painel 2 - Transferencia -->
          <div class="bg-white shadow rounded-2xl p-5 hover:shadow-lg transition-shadow duration-500">
            <Link href="/transferencias">
              <h2 class="text-lg font-semibold text-gray-700 mb-4 justify-center flex items-center">
                Transferências
              </h2>
              <div class="flex items-center justify-center h-32">
                <span class="text-5xl font-bold text-gray-800">
                  <img src="/storage/app/public/icons/transferencia_icon.png" alt="icone de materia Prima" class="w-16 h-16 mb-6">
                </span>
              </div>
            </Link>
          </div>

          <!-- Painel 3 - criar Cardapio -->
          <div class="bg-white shadow rounded-2xl p-5 hover:shadow-lg transition-shadow duration-500">
            <Link href="#">
              <h2 class="text-lg font-semibold text-gray-700 mb-4 justify-center flex items-center">
                Planejar Cardápios
              </h2>
              <div class="flex items-center justify-center h-32">
                <span class="text-5xl font-bold text-gray-800">
                  <img src="/storage/app/public/icons/cardapio_icon.png" alt="icone de materia Prima" class="w-16 h-16 mb-6">
                </span>
              </div>
            </Link>
          </div>
          
        </section>

      <div class="p-6 space-y-6">
        <!-- Painéis de Métricas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

          <div class="p-4 rounded-2xl shadow bg-white dark:bg-gray-800">
            <h2 class="text-lg font-semibold mb-2">Baixo Estoque</h2>
            <ul>
              <li v-for="item in baixoEstoque" :key="item.id">
                {{ item.produto.nome }} — {{ item.quantidade }} un
              </li>
            </ul>
          </div>

          <div class="p-4 rounded-2xl shadow bg-white dark:bg-gray-800">
            <h2 class="text-lg font-semibold mb-2">Produtos Mais Consumidos</h2>
            <ul>
              <li v-for="item in maisConsumidos" :key="item.id">
                {{ item.produto.nome }} — {{ item.usos }} usos
              </li>
            </ul>
          </div>

          <div class="p-4 rounded-2xl shadow bg-white dark:bg-gray-800">
            <h2 class="text-lg font-semibold mb-2">Próximas Compras</h2>
            <ul>
              <li v-for="item in proximasCompras" :key="item.id">
                {{ item.produto.nome }} — sugerir compra em: {{ item.data }}
              </li>
            </ul>
          </div>
          
        </div>

        <!-- cardápio semanal -->
        <div class="p-4 rounded-2xl shadow bg-white dark:bg-gray-800">
          <h2 class="text-lg font-semibold mb-4">Cardápio Semanal</h2>
          <span>ainda precisa montar o crud de cardapio</span>
        </div>
      </div>

      <!-- Tabelas de estoque -->
       <h1 class="px-4 py-3 font-semibold text-lg bg-gray-100 position-sticky top-0 z-10">
          Estoque Atual
       </h1>
       <section class="grid sm:grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-1 px-4">
        <!-- Não Perecivel -->
          <div class="overflow-x-auto bg-white shadow mb-3">
            <h2 class="px-4 py-3 font-semibold text-lg bg-gray-700">
              Não Perecíveis
            </h2>
            <table class="max-w-full text-sm">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-4 py-3 text-left">Produto</th>
                  <th class="px-4 py-3 text-right">Quantidade</th>
                </tr>
              </thead>

              <tbody>
                
                  <tr 
                  v-for="item in naoPereciveis"
                  :key="item.id"
                  class="border-b hover:bg-gray-50"
                  >
                  <td class="px-4 py-3">
                    {{ item?.nome }}
                  </td>

                  <td class="px-4 py-3 text-right font-semibold">
                        {{ item.estoque_items_sum_quantidade + item.deposito_items_sum_quantidade ?? 0 }}
                  </td>
                </tr>
                               
              </tbody>
            </table>
          </div>

          <!-- Proteínas -->
          <div class="overflow-x-auto bg-white shadow mb-8">
            <h2 class="px-4 py-3 font-semibold text-lg bg-gray-100">
              Proteínas
            </h2>
            <table class="min-w-full text-sm">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-4 py-3 text-left">Produto</th>
                  <th class="px-4 py-3 text-right">Quantidade</th>
                </tr>
              </thead>

              <tbody>
                <tr 
                  v-for="item in proteinas" 
                  :key="item.id"
                  class="border-b hover:bg-gray-50"
                  
                >
                  <td class="px-4 py-3">
                    {{ item?.nome }}
                  </td>

                  <td class="px-4 py-3 text-right font-semibold">
                    {{ item.estoque_items_sum_quantidade + item.deposito_items_sum_quantidade ?? 0 }}
                  </td>
                </tr>
                
              </tbody>
            </table>
          </div>
          

          <!-- Hortifruti -->
          <div class="overflow-x-auto bg-white shadow mb-8">
            <h2 class="px-4 py-3 font-semibold text-lg bg-gray-100">
              Hortifruti
            </h2>
            <table class="min-w-full text-sm">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-4 py-3 text-left">Produto</th>
                  <th class="px-4 py-3 text-right">Quantidade</th>
                </tr>
              </thead>

              <tbody>
                <tr 
                  v-for="item in hortifrutis" 
                  :key="item.id"
                  class="border-b hover:bg-gray-50"
                >
                  <td class="px-4 py-3">
                    {{ item?.nome }}
                  </td>

                  <td class="px-4 py-3 text-right font-semibold">
                    {{ item.estoque_items_sum_quantidade + item.deposito_items_sum_quantidade ?? 0 }}
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
        
      </section>
      
    
  </AppLayout>
</template>
