<script setup>
import { Link, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import Modal from "@/components/Modal.vue";
import FormCreateOS from "./FormCreateOS.vue";
import { ref } from "vue";

const props = defineProps({
    ordens: Array,
    alojamentos: Array,
    prioridades: Array,
    filtros: Object,
});

const showCreate = ref(false);

function onSaved() {
    showCreate.value = false;
}

const filtro = ref({
    texto: props.filtros?.texto ?? "",
    prioridade: props.filtros?.prioridade ?? "",
});

function statusColor(statusId) {
    switch (statusId) {
        case 1:
            return "bg-blue-100 text-blue-800"; // aberta
        case 2:
            return "bg-yellow-100 text-yellow-800"; // andamento
        case 3:
            return "bg-red-100 text-red-800"; // pendente
        case 4:
            return "bg-green-100 text-green-800"; // resolvida
        default:
            return "bg-gray-200 text-gray-700";
    }
}

function buscar() {
    router.get(route("ordens.index"), filtro.value, {
        preserveState: true,
        replace: true,
    });
}

function truncate(text, limit){
    return text.length > limit ? text.slice(0, limit) + '...' : text;
}

</script>

<template>
    <AppLayout>
        <!-- HEADER LIMPO -->
        <template #header>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Ordens de Serviço</h1>

                <div class="flex gap-3">
                    <Link
                        href="/ordens/finalizadas"
                        class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800"
                    >
                        OS Finalizadas
                    </Link>

                    <button
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        @click="showCreate = true"
                    >
                        Nova OS
                    </button>
                </div>
            </div>
        </template>

        <!-- CONTEÚDO -->
        <div class="p-6"><!-- iSSO AQUI ENGLOBA A MODAL, CUIDADO--> 
            <!-- ====== DESKTOP – TABELA ====== -->
            <div class="hidden md:block">
                <table class="w-full bg-white text-black shadow rounded-lg overflow-hidden">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="py-2 px-4 text-left">N°</th>
                            <th class="py-2 px-4 text-left">Solicitação</th>
                            <th class="py-2 px-4 text-left">Condomínio</th>
                            <th class="py-2 px-4 text-left">Setor</th>
                            <th class="py-2 px-4 text-left">Prioridade</th>
                            <th class="py-2 px-4 text-left">Status</th>
                            <th class="py-2 px-4 text-left">Solicitante</th>
                            <th class="py-2 px-4 text-left">Data</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="ordem in props.ordens"
                            :key="ordem.id"
                            class="border-b hover:bg-gray-50 cursor-pointer"
                        >
                            <td class="py-2 px-4">
                                <Link :href="`/ordens/${ordem.id}`" class="text-blue-600 hover:underline">
                                    {{ ordem.id }}
                                </Link>
                            </td>

                            <td class="py-2 px-4">{{ ordem.titulo }}</td>
                            <td class="py-2 px-4">{{ ordem.alojamento?.nome }}</td>
                            <td class="py-2 px-4">{{ ordem.bloco?.nome }}</td>

                            <td class="py-2 px-4">
                                <span
                                    class="px-3 py-1 rounded text-white text-sm"
                                    :style="{ backgroundColor: ordem.prioridade?.cor ?? '#777' }"
                                >
                                    {{ ordem.prioridade?.nome ?? "Sem prioridade" }}
                                </span>
                            </td>

                            <td class="py-2 px-4">
                                <span
                                    :class="`${statusColor(ordem.status_id)} px-3 py-1 rounded-full text-sm font-semibold`"
                                >
                                    {{ ordem.status.nome }}
                                </span>
                            </td>

                            <td class="py-2 px-4">{{ ordem.solicitante?.name ?? "---" }}</td>
                            <td class="py-2 px-4">{{ ordem.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <!-- ====== MOBILE – CARDS ====== -->
            <div class="md:hidden space-y-3">
                <Link
                    v-for="ordem in props.ordens"
                    :key="ordem.id"
                    :href="`/ordens/${ordem.id}`"
                    class="block bg-white shadow rounded-lg p-4 border active:bg-gray-50"
                >
                    <!-- Cabeçalho -->
                    <div class="flex justify-between items-start gap-2">
                        <h2 class="font-semibold text-lg break-words">{{ truncate(ordem.titulo, 20) }}</h2>

                        <span
                            :class="`${statusColor(ordem.status_id)} px-2 py-1 rounded-full text-xs withespace-nowrap`"
                        >
                            {{ ordem.status.nome }}
                        </span>
                    </div>

                    <!-- Grid pequeno com informações -->
                    <div class="mt-2 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span class="font-semibold">Solicitante:</span>
                            <span>{{ ordem.solicitante?.name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold">Condomínio:</span>
                            <span>{{ ordem.alojamento?.nome }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-semibold">Setor:</span>
                            <span>{{ ordem.bloco?.nome }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-semibold">Criado em:</span>
                            <span>{{ ordem.created_at }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-semibold">Prioridade:</span>
                            <span
                                class="px-2 py-0.5 rounded text-white"
                                :style="{ backgroundColor: ordem.prioridade?.cor ?? '#777' }"
                            >
                                {{ ordem.prioridade?.nome ?? "—" }}
                            </span>
                        </div>
                    </div>
                </Link>
            </div>


            <!-- MODAL PARA CRIAR OS -->
            <Modal v-if="showCreate" @close="showCreate = false">
                <FormCreateOS
                    :alojamentos="props.alojamentos"
                    :prioridades="props.prioridades"
                    @saved="onSaved"
                />
            </Modal>
        </div>
    </AppLayout>
</template>

