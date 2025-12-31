<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { Link } from "@inertiajs/vue3";
import { Ziggy } from "@/ziggy";
import {ref, computed} from 'vue';


const props = defineProps({
  produtos: Array,
  locais: Array,
  tipos: Array,
  itens: [],
  alojamentos: Array,
})

const form = useForm({

  tipo_id: '',

  local_origem_id: '',
  local_destino_id: '',
  observacao: '',
  alojamento_id: '',
  itens: [],
})
const locaisFiltrados = computed(() =>{
  return props.locais.filter(
    l => l.alojamento_id === form.alojamento_id
  )
})

const produtoSelecionado = ref(null)

function submit() {
  form.post(route('transferencias.store'))
}

function precisaOrigem() {
  return ['2', '3'].includes(String(form.tipo_id))
}

function precisaDestino() {
  return ['1', '3', '4'].includes(String(form.tipo_id))
}

function adicionarProduto(){
    if(!produtoSelecionado.value) return

    const existe = form.itens.find(
        i => i.produto_id === produtoSelecionado.value.id
    )

    if (existe){
        existe.quantidade += 1 
    
        } else{
            form.itens.push({
                produto_id: produtoSelecionado.value.id,
                nome: produtoSelecionado.value.nome,
                quantidade: 1,
            })
        }
        produtoSelecionado.value = null
    }


function removerItem(index){
    form.itens.splice(index, 1)
}

</script>

<template>
  <AppLayout>
    <!-- HEADER -->
    <template #header>
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold">Nova Transferência</h1>
      </div>
    </template>

    <div class="p-6 max-w-4xl mx-auto">
      <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">

        <!-- TIPO -->
        <div>
          <label class="block mb-1 font-medium">Tipo de Movimentação</label>
          <select v-model="form.tipo_id" class="w-full border rounded px-3 py-2">
            <option value="">Selecione</option>
            <option v-for="t in tipos" :key="t.id" :value="t.id">
              {{ t.nome }}
            </option>
          </select>
          <div v-if="form.errors.tipo_id" class="text-red-600 text-sm">{{ form.errors.tipo_id }}</div>
        </div>

        <!-- ALOJAMENTO-->
         <div>
          <label class="block mb-1 font-medium">Condomínio</label>
          <select v-model="form.alojamento_id" class="w-full border rounded px-3 py-2">
            <option :value="null">Selecione</option>
            <option v-for="a in alojamentos" :key="a.id" :value="a.id">
              {{ a.nome }}
            </option>
          </select>
         </div>

        <!-- PRODUTO -->
        <div class="flex gap-2">
          <select v-model="produtoSelecionado" class="flex-1 border rounded px-3 py-2">Selecione um Produto
            <option :value="null">Selecione o produto</option>
            <option :value="p" v-for="p in produtos" :key="p.id">
              {{ p.nome }}
            </option>
          </select>

          <button 
            type="button"
            @click="adicionarProduto"
            class="px-4 py-2 bg-green-600 text-white rounded">
              Adicionar
          </button>
        </div>

        <!-- ORIGEM -->
        <div v-if="precisaOrigem()">
          <label class="block mb-1 font-medium">Local de Origem</label>
          <select v-model="form.local_origem_id" :disabled="!form.alojamento_id" class="w-full border rounded px-3 py-2">
            <option value="">Selecione</option>
            <option v-for="l in locaisFiltrados" :key="l.id" :value="l.id">
              {{ l.nome }}
            </option>
          </select>
        </div>

        <!-- DESTINO -->
        <div v-if="precisaDestino()">
          <label class="block mb-1 font-medium">Local de Destino</label>
          <select v-model="form.local_destino_id" :disabled="!form.alojamento_id" class="w-full border rounded px-3 py-2">
            <option value="">Selecione</option>
            <option v-for="l in locaisFiltrados" :key="l.id" :value="l.id">
              {{ l.nome }}
            </option>
          </select>
        </div>

        <!-- OBSERVAÇÃO -->
        <div>
          <label class="block mb-1 font-medium">Observação</label>
          <textarea
            v-model="form.observacao"
            rows="3"
            class="w-full border rounded px-3 py-2"
          ></textarea>
        </div>

        <!-- Tabela de seleção de itens e quantidade-->
         <table class="w-full text-sm border mt-4">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-3 py-2 text-left">Produto</th>
              <th class="px-3 py-2 text-right">Quantidade</th>
              <th class="px-3 py-2 text-center">Opções</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="(item, index) in form.itens" :key="item.produto_id">
              <td class="px-3 py-2">{{ item.nome }}</td>

              <td class="px-3 py-2 text-right">
                <input
                  type="number"
                  min="0.001"
                  step="0.001"
                  v-model="item.quantidade"
                  class="w-24 border rounded px-2 py-1 text-right"
                />
              </td>

              <td class="px-3 py-2 text-center">
                <button
                  type="button"
                  @click="removerItem(index)"
                  class="text-red-600 hover:underline"
                >
                  Remover
                </button>
              </td>
            </tr>

            <tr v-if="form.itens.length === 0">
              <td colspan="3" class="text-center py-4 text-gray-500">
                Nenhum produto adicionado
              </td>
            </tr>
          </tbody>
        </table>


        <!-- AÇÕES -->
        <div class="flex justify-end gap-3">
          <Link
            href="/transferencias"
            class="px-4 py-2 rounded border"
          >
            Cancelar
          </Link>

          <button
            type="submit"
            :disabled="form.processing"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          >
            Registrar Transferência
          </button>
        </div>

      </form>
    </div>
  </AppLayout>
</template>
