<template>
  <AppLayout>
    <div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-6">

        <!-- Cabeçalho -->
        <div class="flex justify-between border-b pb-4">
            <h1 class="text-2xl font-bold">
                Ordem de Serviço #{{ ordem.id }}
            </h1>

            <div class="text-right text-sm">
                <p><strong>Status:</strong> {{ ordem.status }}</p>
                <p><strong>Data:</strong> {{ ordem.created_at }}</p>
            </div>
        </div>

        <!-- Descrição -->
        <div class="mt-6 border-b pb-4">
            <h2 class="font-semibold mb-2 text-lg">Descrição</h2>
            <p class="text-gray-700">{{ ordem.descricao }}</p>
        </div>

        <!-- Lista de Comentários -->
        <div class="mt-6">
            <h2 class="font-semibold mb-3 text-lg">Comentários</h2>

            <table class="w-full border divide-y table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-3 text-left">Funcionário</th>
                        <th class="py-2 px-3 text-left">Comentário</th>
                        <th class="py-2 px-3 text-left">Data</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="comentario in ordem.comentarios" :key="comentario.id" class="border-b border-gray-300">
                        <td class="py-2 px-3">
                            {{ comentario.user.name }}
                        </td>
                        <td class="py-2 px-3 whitespace-normal break-words break-all max-w-xs">
                            {{ comentario.comentario }}
                        </td>
                        <td class="py-2 px-3">
                            {{ comentario.created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Adicionar Comentário -->
        <div class="mt-6">
            <h2 class="font-semibold mb-2 text-lg">Adicionar Comentário</h2>

            <textarea
                v-model="form.comentario"
                rows="4"
                class="w-full border rounded-lg p-3"
                placeholder="Escreva um comentário..."
            ></textarea>

            <button
                @click="enviar"
                class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
            >
                Enviar Comentário
            </button>
        </div>
        <!-- Adicionar foto-->
         <div class="mt-6">
            <h2 class="font-semibold mb-2 text-lg">Adicionar Foto</h2>
            <input
                type="file"
                @change="e => formFoto.foto = e.target.files[0]"
                class="w-full border rounded-lg p-2"
            >

        <button
            @click="enviarFoto"
            class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
            >
            Enviar Foto
        </button>
        </div>
        <!-- Mostrar as fotos-->
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">Fotos</h2>

            <div class="grid grid-cols-3 gap-4">
            <div
                v-for="foto in ordem.fotos"
                :key="foto.id"
                class="border rounded-lg overflow-hidden"
            >
                <img :src="`/storage/${foto.caminho}`" class="w-full">
            </div>
        </div>
        </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    ordem: Object
});

const form = useForm({
    comentario: ""
});

function enviar() {
    form.post(route("ordens.comentario", props.ordem.id), {
        onSuccess: () => {
            form.reset();
        }
    });
}
const formFoto = useForm({
    foto: null
})

function enviarFoto(){
    formFoto.post(route("ordens.foto",props.ordem.id),{
        forceFormData: true,
        onSuccess:()=>formFoto.reset()
    });
}

</script>



<!-- 
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { defineProps } from 'vue'

const { ordem } = defineProps({
  ordem: Object
})
</script>

<template>
  <AppLayout>
      <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">
          Ordem de Serviço #{{ ordem.id }}
        </h1>

      <div class="space-y-3">
        <p><strong>Status:</strong> {{ ordem.status }}</p>
        <p><strong>Solicitante:</strong> {{ ordem.solicitante?.name }}</p>

        <p><strong>Descrição:</strong> {{ ordem.descricao }}</p>
        <p><strong>Criado em:</strong> {{ ordem.created_at }}</p>
      </div>

      <div class="mt-6">
        <Link href="/ordens" class="text-blue-600 hover:underline">← Voltar para lista</Link>
      </div>
  </div>
  </AppLayout>
</template>
-->