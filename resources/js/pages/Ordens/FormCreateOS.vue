<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

// Props recebidas do Inertia
const props = defineProps({
    alojamentos: Array,
    prioridades: Array
});

// Formulário Inertia
const form = useForm({
    alojamento_id: "",
    bloco_id: "",
    quarto_id: "",
    titulo: "",
    descricao: "",
    prioridade_id: ""
});

// Arrays dinâmicos
const blocos = ref([]);
const quartos = ref([]);

// Quando o usuário escolher um alojamento
function selecionarAlojamento() {
    const alojamento = props.alojamentos.find(
        (a) => a.id == form.alojamento_id
    );

    blocos.value = alojamento ? alojamento.blocos : [];

    // Resetar níveis abaixo
    quartos.value = [];
    form.bloco_id = "";
    form.quarto_id = "";
}

// Quando o usuário escolher um bloco
function selecionarBloco() {
    const bloco = blocos.value.find((b) => b.id == form.bloco_id);

    quartos.value = bloco ? bloco.quartos : [];

    // Resetar nível abaixo
    form.quarto_id = "";
}
// Função de enviar os dados para o banco.
function submit() {
  console.log("POST enviado:", form)

  form.post('/ordens', {
    onSuccess: () => emit('saved'),
  })
}

console.log(props.alojamentos);
</script>

<template>
    <div class="p-6 bg-white shadow rounded">

        <h2 class="text-xl font-bold mb-4">Criar Ordem de Serviço</h2>

        <form @submit.prevent="form.post('/ordens')">

            <!-- Alojamento -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Alojamento</label>

                <select
                    class="border p-2 rounded w-full"
                    v-model="form.alojamento_id"
                    @change="selecionarAlojamento"
                >
                    <option value="">Selecione o Alojamento</option>

                    <option
                        v-for="a in alojamentos"
                        :key="a.id"
                        :value="a.id"
                    >
                        {{ a.nome }}
                    </option>
                </select>
            </div>

            <!-- Bloco -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Bloco</label>

                <select
                    class="border p-2 rounded w-full"
                    v-model="form.bloco_id"
                    @change="selecionarBloco"
                >
                    <option value="">Selecione o Bloco</option>

                    <option
                        v-for="b in blocos"
                        :key="b.id"
                        :value="b.id"
                    >
                        {{ b.nome }}
                    </option>
                </select>
            </div>

            <!-- Apartamento / Quarto -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Apartamento
                </label>

                <select
                    class="border p-2 rounded w-full"
                    v-model="form.quarto_id"
                >
                    <option value="">Selecione o Apartamento</option>

                    <option
                        v-for="q in quartos"
                        :key="q.id"
                        :value="q.id"
                    >
                        {{ q.numero }}
                    </option>
                </select>
            </div>

            <!-- Título -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Título da OS
                </label>

                <input
                    type="text"
                    class="border p-2 rounded w-full"
                    v-model="form.titulo"
                />
            </div>

            <!-- Descrição -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Descrição
                </label>

                <textarea
                    class="border p-2 rounded w-full"
                    v-model="form.descricao"
                ></textarea>
            </div>

            <!-- Prioridade -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Prioridade
                </label>
                <select v-model="form.prioridade_id" class="border rounded p-2 w-full">
                  <option value="">Selecione...</option>
                  <option
                   v-for="p in prioridades"
                    :key="p.id"
                    :value="p.id">
                      {{ p.nome }}
                  </option>
                </select>
            </div>

            <!-- Botão -->
            <button
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                Criar OS
            </button>
        </form>

    </div>
</template>



<!-- SEGUNDO MODELO DE FORMULARIO
  // O ALOJAMENTO NÃO ESTAVA SENDO CARREGADO

<script setup>
import { ref, computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  alojamentos: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['saved']);

const form = useForm({
  titulo: '',
  descricao: '',
  prioridade: '',
  alojamento_id: null,
  bloco_id: null,
  quarto_id: null,
});

const selectedAlojamento = ref(form.alojamento_id);
const selectedBloco = ref(form.bloco_id);

// atualizar os campos do form quando os refs mudam
watch(selectedAlojamento, (val) => {
  form.alojamento_id = val;
  // resetar bloco e quarto quando trocar alojamento
  form.bloco_id = null;
  form.quarto_id = null;
  selectedBloco.value = null;
});

watch(selectedBloco, (val) => {
  form.bloco_id = val;
  // reset quarto
  form.quarto_id = null;
});

// computed para blocos e quartos disponíveis
const blocosDisponiveis = computed(() => {
  const a = props.alojamentos.find(a => a.id === Number(selectedAlojamento.value));
  return a ? a.blocos : [];
});

const quartosDisponiveis = computed(() => {
  const b = blocosDisponiveis.value.find(b => b.id === Number(selectedBloco.value));
  return b ? b.quartos : [];
});

function submit() {
  form.post('/ordens', {
    onSuccess: () => {
      emit('saved');
      // opcional: limpar form
      form.reset('titulo', 'descricao', 'prioridade', 'alojamento_id', 'bloco_id', 'quarto_id');
      selectedAlojamento.value = null;
      selectedBloco.value = null;
    },
    onError: () => {
      // erros de validação aparecem em form.errors
    },
  });
}
</script>

<template>
  <form @submit.prevent="submit" class="space-y-4">
    <h2 class="text-xl font-bold">Criar Ordem de Serviço</h2>

    <div>
      <label class="block mb-1">Alojamento</label>
      <select v-model="selectedAlojamento" class="w-full border p-2">
        <option :value="null">-- selecione --</option>
        <option v-for="a in props.alojamentos" :key="a.id" :value="a.id">{{ a.nome }}</option>
      </select>
    </div>

    <div>
      <label class="block mb-1">Bloco</label>
      <select v-model="selectedBloco" class="w-full border p-2" :disabled="!blocosDisponiveis.length">
        <option :value="null">-- selecione --</option>
        <option v-for="b in blocosDisponiveis" :key="b.id" :value="b.id">{{ b.nome }}</option>
      </select>
    </div>

    <div>
      <label class="block mb-1">Quarto</label>
      <select v-model="form.quarto_id" class="w-full border p-2" :disabled="!quartosDisponiveis.length">
        <option :value="null">-- selecione --</option>
        <option v-for="q in quartosDisponiveis" :key="q.id" :value="q.id">{{ q.numero ?? q.nome ?? q.id }}</option>
      </select>
    </div>

    <div>
      <label class="block mb-1">Título</label>
      <input v-model="form.titulo" class="w-full border p-2" />
      <div v-if="form.errors.titulo" class="text-red-600 text-sm">{{ form.errors.titulo }}</div>
    </div>

    <div>
      <label class="block mb-1">Descrição</label>
      <textarea v-model="form.descricao" class="w-full border p-2"></textarea>
      <div v-if="form.errors.descricao" class="text-red-600 text-sm">{{ form.errors.descricao }}</div>
    </div>

    <div>
      <label class="block mb-1">Prioridade</label>
      <select v-model="form.prioridade" class="w-full border p-2">
        <option value="">Normal</option>
        <option value="Baixa">Baixa</option>
        <option value="Média">Média</option>
        <option value="Alta">Alta</option>
      </select>
    </div>

    <div class="flex justify-end">
      <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Salvar</button>
    </div>
  </form>
</template>


  FORM INICIAL - O PRIMEIRO MODELO
<template>
  <form @submit.prevent="submit">
    <h2 class="text-xl font-bold mb-3">Criar Ordem de Serviço</h2>

    <div class="mb-2">
      <label>Título</label>
      <input v-model="form.titulo" class="border p-2 w-full" />
    </div>

    <div class="mb-2">
      <label>Descrição</label>
      <textarea v-model="form.descricao" class="border p-2 w-full"></textarea>
    </div>

    <div class="mb-2">
      <label>Status</label>
      <input v-model="form.status" class="border p-2 w-full" />
    </div>

    <div class="mb-2">
      <label>Prioridade</label>
      <input v-model="form.prioridade" class="border p-2 w-full" />
    </div>

    <button class="px-4 py-2 bg-green-600 text-white rounded">
      Salvar
    </button>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'


const emit = defineEmits(['saved'])

const form = useForm({
  titulo: '',
  descricao: '',
  status: '',
  prioridade: '',
})

function submit() {
  console.log("POST enviado:", form)

  form.post('/ordens', {
    onSuccess: () => emit('saved'),
  })
}
</script>
-->
