<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue';
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
        <template #header>
          <div class="flex gap-4 mt-3">
            <Link href="/admin" class="text-white hover:underline">Dashboard</Link>
            <Link href="/index/usuarios" class="text-white hover:underline font-semibold">
                Usuários
            </Link>
            <Link href="/index/usuarios/criar" class="text-white hover:underline">
                Novo Usuário
            </Link>
          </div>
        </template>
      <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Criar Usuário</h1>

        <form @submit.prevent="submit">

          <label>Nome</label>
          <input v-model="form.name" class="border p-2 w-full mb-4" />

          <label>Email</label>
          <input v-model="form.email" class="border p-2 w-full mb-4" />

          <label>Senha</label>
          <input type="password" v-model="form.password" class="border p-2 w-full mb-4" />

          <label>Setor</label>
          <div class="grid grid-cols-2 gap-2 mb-4">
            <div class="flex items-center gap-2" v-for="setor in setores" :key="setor.id">
              <input type="checkbox" :value="setor.id" v-model="form.setores">
              <span>{{ setor.cargo }}</span>
            </div>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
        </form>
      </div>
  </AppLayout>
</template>