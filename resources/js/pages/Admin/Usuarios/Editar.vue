<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    setores:{
        type: Array,
        required:true
    }
});

const form = useForm({
    name: props.user?.name ?? '',
    email: props.user?.email ?? '',
    password: '',
    setores: props.user?.setores?.map(s => s.id) ?? []
});

function atualizar() {
    form.put(route('usuarios.update', props.user.id));
}
</script>

<template>
    <AppLayout>
        <!-- Breadcrumb simples -->
        <template #header>
            <div class="flex gap-4 mt-3 text-white text-sm">
                <Link href="/admin" class="hover:underline">Dashboard</Link>
                <span>/</span>
                <Link href="/index/usuarios" class="hover:underline">Usuários</Link>
                <span>/</span>
                <span class="font-semibold">Editar</span>
            </div>
        </template>

        <!-- Card principal -->
        <div class="max-w-xl mx-auto mt-8 bg-white shadow-md rounded-lg p-8">
            <h1 class="text-2xl font-semibold mb-6">Editar Usuário</h1>

            <form @submit.prevent="atualizar" class="space-y-5">

                <!-- Nome -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Nome</label>
                    <input 
                        v-model="form.name"
                        type="text"
                        class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
                    />
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Email</label>
                    <input 
                        v-model="form.email"
                        type="email"
                        class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
                    />
                </div>

                <!-- Senha -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">
                        Senha <span class="text-gray-500 text-sm">(opcional)</span>
                    </label>
                    <input 
                        v-model="form.password"
                        type="password"
                        class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-200"
                    />
                </div>

                <!-- Setores -->
                    <label class="block mb-1 font-medium text-gray-700">Setores</label>
                    <div v-for="setor in setores" :key="setor.id">
                        <label>
                            <input
                            type="checkbox"
                            :value="setor.id"
                            v-model="form.setores"
                            >
                            {{ setor.cargo }}
                        </label>
                    </div>

                <!-- Botão -->
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition"
                >
                    Salvar Alterações
                </button>
            </form>
        </div>
    </AppLayout>
</template>
