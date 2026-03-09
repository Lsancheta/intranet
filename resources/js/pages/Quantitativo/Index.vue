<script setup>
import { Link, router } from "@inertiajs/vue3";
import route from "ziggy-js";
import { Ziggy } from "@/ziggy";
import AppLayout from "@/layouts/AppLayout.vue";
import Modal from "@/components/Modal.vue";
import FormCreateQuantitativo from "./FormCreateQuantitativo.vue";
import FormEditQuantitativo from "./FormEditQuantitativo.vue";
import { ref } from "vue";

const props = defineProps({
    quantitativo: Array,
    nome: String,
    fazenda: String,
    blocos: String,
    alojamentos: Array,
});

const showCreate = ref(false);
const showEdit = ref(false);
const selectedQuant = ref(null);

function onSaved(){
  showCreate.value = false;
  showEdit.value = false;
  selectedQuant.value = null;
}

function openEdit(item){
  selectedQuant.value = item;
  showEdit.value = true;
}

function confirmDelete(item){
  const mensagem = `Remover quantitativo de "${item.nome}" com ${item.quantidade} colaboradores?`;

  if (!confirm(mensagem)) return;
  router.delete(`/quantitativo/${item.id}`)
}

</script>

<template>
  <AppLayout>
    <template #header>
      <!-- MENU RESPONSIVO -->
      <div class="flex items-center justify-between mt-3 text-white">
        <h1 class="text-lg font-semibold">QUANTITATIVO COLABORADORES</h1>
      </div>
    </template>
    <!-- BOTÕES DE AÇÃO -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="flex gap-3">
        <button
          class="px-4 py-2 bg-blue-600 text-white rounded-lg"
          @click="showCreate = true"
        >
          + Dados
        </button>
      </div>
      <h1>pesquisar</h1>
    </div>
    <!-- TABELA -->
      <div class="overflow-x-auto rounded-2xl bg-white dark:bg-gray-800 shadow">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="px-4 py-3 text-left">Condomínio</th>
              <th class="px-4 py-3 text-left">Líder</th>
              <th class="px-4 py-3 text-left">Bloco</th>
              <th class="px-4 py-3 text-right">Fazenda</th>
              <th class="px-4 py-3 text-left">Quantidade</th>
              <th class="px-4 py-3 text-left">Opções</th>
            </tr>
          </thead>
          
          <tbody>
            <template v-for="item in quantitativo" :key="item.id">
              
                <tr >

                  <td class="px-4 py-3 text-left">{{ item.alojamento.nome }}</td>
                  <td class="px-4 py-3 text-left">{{ item.nome }}</td>
                  <td class="px-4 py-3 text-left">{{ item.bloco.nome }}</td>
                  <td class="px-4 py-3 text-right">{{ item.fazenda }}</td>
                  <td class="px-4 py-3 text-left">{{ item.quantidade }}</td>
                                <td class="p-3">
                <div class="flex gap-3">
                  <button
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg"
                    @click="openEdit(item)"
                  >
                    Editar
                  </button>

                  <button 
                    @click="confirmDelete(item)"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                  >
                    Deletar
                  </button>
                </div>
              </td>
                </tr>
            </template>
          </tbody>
        </table>
      </div>
      <!-- MODAL PARA CRIAR QUANTITATIVO -->
      <Modal v-if="showCreate" @close="showCreate = false">
        <FormCreateQuantitativo :alojamentos="props.alojamentos" @saved="onSaved" />
      </Modal>

      <!-- MODAL PARA EDITAR QUANTITATIVO -->
      <Modal v-if="showEdit" @close="showEdit = false">
        <FormEditQuantitativo v-if="selectedQuant" :quant="selectedQuant" :alojamentos="props.alojamentos" @saved="onSaved" />
      </Modal>

    </AppLayout>
</template>
