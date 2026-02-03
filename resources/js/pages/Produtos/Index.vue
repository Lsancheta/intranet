<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

// Props vindas do controller
const props = defineProps({
    produtos: Array,
});

// Busca
const search = ref('')

// Filtrar produtos localmente
const produtosFiltrados = computed(() => {
    if (!search.value) return props.produtos
    return props.produtos.filter(p =>
        p.nome.toLowerCase().includes(search.value.toLowerCase())
    )
})

// Excluir produto
function excluir(id) {
    if (!confirm("Tem certeza que deseja excluir este produto?")) return;

    router.delete(`/estoque/produtos/${id}`);
}
</script>

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
          <!-- Depósito 
          <Link
            href="/estoque/depositos/itens"
            class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700"
          >
              Depósito
          </Link>
          -->
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
        <Head title="Produtos" />

        <div class="p-6 space-y-6">

            <!-- Título e botão -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Produtos</h1>

                <Link
                    href="/estoque/produtos/criar"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                >
                    Novo Produto
                </Link>
            </div>

            <!-- Campo de busca -->
            <div>
                <input
                    v-model="search"
                    type="text"
                    placeholder="Buscar produto..."
                    class="w-full md:w-1/3 px-3 py-2 border rounded-md"
                />
            </div>

            <!-- Tabela -->
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold">ID</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Nome</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Unidade</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr 
                            v-for="produto in produtosFiltrados" 
                            :key="produto.id"
                            class="border-b hover:bg-gray-50"
                        >
                            <td class="px-4 py-2">{{ produto.id }}</td>
                            <td class="px-4 py-2">{{ produto.nome }}</td>
                            <td class="px-4 py-2">{{ produto.unidade }}</td>

                            <td class="px-4 py-2">
                                <div class="flex gap-2">

                                    <!-- Editar -->
                                    <Link
                                        :href="`/estoque/produtos/${produto.id}/editar`"
                                        class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                    >
                                        Editar
                                    </Link>

                                    <!-- Excluir -->
                                    <button
                                        @click="excluir(produto.id)"
                                        class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700"
                                    >
                                        Excluir
                                    </button>

                                </div>
                            </td>
                        </tr>

                        <tr v-if="produtosFiltrados.length === 0">
                            <td class="px-4 py-4 text-center text-gray-500" colspan="4">
                                Nenhum produto encontrado.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </AppLayout>
</template>
