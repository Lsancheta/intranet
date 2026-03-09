<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import route from "ziggy-js";
import { Ziggy } from "@/ziggy";

const emit = defineEmits(["saved"]);

const props = defineProps({
  alojamentos: Array,
});

const form = useForm({
  fazenda: "",
  nome: "",
  quantidade: "",
  alojamento_id: "",
  bloco_id: "",
});

const blocos = ref([]);

function selecionarAlojamento() {
  const alojamento = props.alojamentos.find((a) => a.id == form.alojamento_id);
  blocos.value = alojamento ? alojamento.blocos : [];
  form.bloco_id = "";
}

function submit() {
  form.post(route("quantitativo.store"), {
    onSuccess: () => emit("saved"),
  });
}
</script>

<template>
  <div class="p-6 bg-white rounded-lg shadow-md w-full max-w-lg mx-auto md:w-[550px]">
    <h2 class="text-xl font-bold mb-4 text-gray-700 text-center md:text-left">Adicionar Quantitativo</h2>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="font-medium text-sm md:text-base">Fazenda</label>
        <input v-model="form.fazenda" type="text" class="border p-2 rounded w-full" />
      </div>

      <div>
        <label class="font-medium text-sm md:text-base">Nome / Líder</label>
        <input v-model="form.nome" type="text" class="border p-2 rounded w-full" />
      </div>

      <div>
        <label class="font-medium text-sm md:text-base">Quantidade</label>
        <input v-model="form.quantidade" type="number" class="border p-2 rounded w-full" />
      </div>

      <div>
        <label class="font-medium text-sm md:text-base">Condomínio</label>
        <select v-model="form.alojamento_id" @change="selecionarAlojamento" class="border p-2 rounded w-full">
          <option value="">Selecione...</option>
          <option v-for="a in props.alojamentos" :key="a.id" :value="a.id">{{ a.nome }}</option>
        </select>
      </div>

      <div>
        <label class="font-medium text-sm md:text-base">Bloco</label>
        <select v-model="form.bloco_id" class="border p-2 rounded w-full">
          <option value="">Selecione...</option>
          <option v-for="b in blocos" :key="b.id" :value="b.id">{{ b.nome }}</option>
        </select>
      </div>

      <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Criar</button>
    </form>
  </div>
</template>
