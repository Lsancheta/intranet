<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';


const props = defineProps({
  setores: Array,
})

const form = useForm({
  name: '',
  email: '',
  password: '',
  setores: []
})

function submit() {
  form.post(route('usuarios.store'))
}
</script>

<template>
  <AppLayout>
    <!-- Breadcrumb -->
        <template #header>
      <!-- HEADER RESPONSIVO -->
      <div class="flex items-center justify-between mt-3 text-white">

        <h1 class="text-lg font-semibold">Usuários</h1>

        <button 
          @click="openMenu = !openMenu"
          class="md:hidden p-2 border rounded text-white"
        >
          ☰
        </button>

        <!-- DESKTOP -->
        <div class="hidden md:flex gap-4">
          <Link href="/admin" class="hover:underline">Dashboard</Link>
          <Link href="/index/usuarios" class="hover:underline font-semibold">
            Usuários
          </Link>
          <Link href="/index/usuarios/criar" class="hover:underline">Novo Usuário</Link>
        </div>
      </div>

      <!-- MOBILE -->
      <div v-if="openMenu" class="md:hidden mt-2 bg-gray-800 p-3 rounded">
        <Link href="/admin" class="block py-1 hover:underline">Dashboard</Link>
        <Link href="/index/usuarios" class="block py-1 hover:underline font-semibold">Usuários</Link>
        <Link href="/index/usuarios/criar" class="block py-1 hover:underline">Novo Usuário</Link>
      </div>
    </template>

    <!-- CONTAINER -->
    <div class="max-w-xl mx-auto mt-8 bg-white shadow-md rounded-lg p-6">

      <h1 class="text-2xl font-bold mb-6">Criar Usuário</h1>

      <form @submit.prevent="submit" class="space-y-5">

        <!-- Nome -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">Nome</label>
          <input 
            v-model="form.name" 
            class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
            required
          />
        </div>

        <!-- Email -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">Email</label>
          <input 
            v-model="form.email" 
            type="email"
            class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
            required
          />
        </div>

        <!-- Senha -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">Senha</label>
          <input 
            type="password" 
            v-model="form.password" 
            class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
            required
          />
        </div>

        <!-- Setores -->
        <div>
          <label class="block mb-2 font-medium text-gray-700">Setores</label>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div 
              class="flex items-center gap-2 p-2 border rounded-md hover:bg-gray-50"
              v-for="setor in setores" 
              :key="setor.id"
            >
              <input 
                type="checkbox" 
                :value="setor.id" 
                v-model="form.setores"
                class="w-4 h-4"
              >
              <span class="text-gray-700">{{ setor.cargo }}</span>
            </div>
          </div>
        </div>

        <!-- Botão -->
        <button 
          class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition"
        >
          Salvar
        </button>

      </form>
    </div>
  </AppLayout>
</template>
