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

