<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  password: ''
})

function submit() {
  form.post('/login')
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white rounded shadow p-6 w-full max-w-sm">

      <h1 class="text-2xl font-bold mb-4 text-center">Login</h1>
      <h2 class="text-1xl font-bold mb-4 text-center">Pannela de Pedra Gestão de Alojamentos</h2>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block mb-1">Nome</label>
          <input
            type="text"
            v-model="form.name"
            class="border rounded w-full px-3 py-2"
          />
          <div v-if="form.errors.name" class="text-red-600 text-sm">
            {{ form.errors.name }}
          </div>
        </div>

        <div class="mb-4">
          <label class="block mb-1">Senha</label>
          <input
            type="password"
            v-model="form.password"
            class="border rounded w-full px-3 py-2"
          />
          <div v-if="form.errors.password" class="text-red-600 text-sm">
            {{ form.errors.password }}
          </div>
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
        >
          Entrar
        </button>
      </form>

    </div>
  </div>
</template>
