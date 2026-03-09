<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const emit = defineEmits(["saved"]);

const props = defineProps({
  quant: Object,
  alojamentos: Array,
});

const form = useForm({
  fazenda: props.quant?.fazenda ?? "",
  nome: props.quant?.nome ?? "",
  quantidade: props.quant?.quantidade ?? "",
  alojamento_id: props.quant?.alojamento_id ?? "",
  bloco_id: props.quant?.bloco_id ?? "",
});

const blocos = ref(props.alojamentos?.find(a => a.id == form.alojamento_id)?.blocos ?? []);

watch(() => form.alojamento_id, (v) => {
  const aloj = props.alojamentos.find(a => a.id == v);
  blocos.value = aloj ? aloj.blocos : [];
  if(!aloj) form.bloco_id = '';
});

function submit() {
  form.put(route("quantitativo.update", props.quant.id, undefined, Ziggy), {
    onSuccess: () => emit("saved"),
  });
}
</script>

<template>
  <div class="p-6 bg-white rounded-lg shadow-md w-full max-w-lg mx-auto md:w-[550px]">
    <h2 class="text-xl font-bold mb-4 text-gray-700 text-center md:text-left">Editar Quantitativo</h2>

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
        <select v-model="form.alojamento_id" class="border p-2 rounded w-full">
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

      <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Salvar</button>
    </form>
  </div>
</template>
