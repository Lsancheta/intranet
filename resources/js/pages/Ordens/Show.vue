<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-6">

            <!-- Cabeçalho -->
            <div class="flex justify-between border-b pb-4">
                <h1 class="text-2xl font-bold">
                    Ordem de Serviço #{{ ordem.id }}
                </h1>

                

                <div class="text-right text-sm">
                    <p><strong>Status:</strong> {{ ordem.status.nome }}</p>
                    <p><strong>Prioridade:</strong> {{ ordem.prioridade.nome }}</p>
                    <p><strong>Data:</strong> {{ ordem.created_at }}</p>
                </div>
            </div>

            <!-- Descrição -->
            <div class="mt-6 border-b pb-4">
                <div class="text-left text-sl">
                    <p><strong>Área:</strong> {{ ordem.bloco.nome }}, {{ ordem.quarto.numero }}</p>
                </div>
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
                        <tr v-for="comentario in comentarioVisiveis" :key="comentario.id" class="border-b border-gray-300">
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
                <div class="mt-3 text-center" v-if="ordem.comentarios.length > 4">
                    <button @click="mostrarTodos = !mostrarTodos"
                    class="text-blue-600 font-semibold hover:underline">
                        {{ mostrarTodos ? 'Ver menos':'Ver todos os Comentários' }}
                </button>
                </div>
            </div>

            <!-- Adicionar Comentário -->
            <div class="mt-6" v-if="ordem.status_id !==4">
                <h2 class="font-semibold mb-2 text-lg">Adicionar Comentário</h2>

                <textarea
                    v-model="form.comentario"
                    rows="4"
                    class="w-full border rounded-lg p-3"
                    placeholder="Escreva um comentário..."
                ></textarea>
            
                <!-- Botão de Finalizar OS-->
            
                <button
                    @click="enviar"
                    class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
                >
                    Enviar Comentário
                </button>
                <button
                    @click="abrirModal"
                    class="mt-3 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 ml-3"
                >
                    Finalizar OS
                </button>
            </div>
            <!-- Adicionar foto-->
            <div class="mt-6" v-if="ordem.status_id !==4">
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
                    class="border rounded-lg overflow-hidden shadow-sm hover:shadow-lg"
                >
                    <img :src="`/storage/${foto.caminho}`" class="w-full h-50 object-cover transition-transform duration-300 hover:scale-130 cursor-pointer">
                </div>
            </div>
            </div>
        </div>
    </AppLayout>
        <div v-if="ordem.status_id !==4">
            <!-- MODAL DE CONCLUSAO DE OS-->
            <div v-if="modalAberta" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-xl w-96">

                <h2 class="text-xl font-semibold mb-3">Finalizar OS</h2>

                <textarea
                    v-model="formFinalizar.comentario"
                    rows="4"
                    class="w-full border rounded-lg p-3"
                    placeholder="Digite o comentário final..."
                ></textarea>

                <div class="flex justify-end mt-4">
                    <button
                        @click="modalAberta = false"
                        class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 mr-2"
                    >
                        Cancelar
                    </button>

                    <button
                        @click="finalizarOS"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"
                    >
                        Concluir
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, computed} from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue'

const modalAberta = ref(false);
const mostrarTodos = ref(false);

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

// modal de finalizar a os


function abrirModal(){
    modalAberta.value = true;
}

const formFinalizar = useForm({
    comentario: ""
});

function finalizarOS(){
    formFinalizar.post(
        route("ordens.finalizar", props.ordem.id),{
            onSuccess: () => {
                modalAberta.value = false;
                formFinalizar.reset();
            }
        }
    );
}

const comentarioVisiveis = computed(() => {
    if(mostrarTodos.value){
        return props.ordem.comentarios;
    }
    return props.ordem.comentarios.slice(0, 4);
});

</script>




