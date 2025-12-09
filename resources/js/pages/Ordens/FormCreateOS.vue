<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import route from "ziggy-js";
import { Ziggy } from "@/ziggy";

const emit = defineEmits(["saved"]);

const props = defineProps({
    alojamentos: Array,
    prioridades: Array,
});

const form = useForm({
    alojamento_id: "",
    bloco_id: "",
    quarto_id: "",
    titulo: "",
    descricao: "",
    prioridade_id: "",
    fotos:[],
});

const blocos = ref([]);
const quartos = ref([]);

// Ao selecionar Alojamento
function selecionarAlojamento() {
    const alojamento = props.alojamentos.find(
        (a) => a.id == form.alojamento_id
    );

    blocos.value = alojamento ? alojamento.blocos : [];
    quartos.value = [];

    form.bloco_id = "";
    form.quarto_id = "";
}

// Ao selecionar Bloco
function selecionarBloco() {
    const bloco = blocos.value.find((b) => b.id == form.bloco_id);
    quartos.value = bloco ? bloco.quartos : [];
    form.quarto_id = "";
}

function submit() {
    form.post(route("ordens.store", undefined, undefined, Ziggy), {
        onSuccess: () => emit("saved"),
    });
}

//function enviarFoto(){
async function enviarFoto() {
    if (!formFoto.foto) {
        console.log("Nenhuma foto selecionada");
        return;
    }

    try {
        // 1. Comprimir a foto antes do envio
        const compressed = await compressImage(formFoto.foto, 0.6, 1280);

        const fd = new FormData();
        fd.append("foto", compressed);

        // 2. Sobrescreve apenas o arquivo no form
        formFoto.foto = compressed;

        // 3. Enviar para o backend
        formFoto.post(route("ordens.foto", props.ordem.id,undefined, Ziggy), {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => formFoto.reset(),
            onError: (e) => console.log("ERRO MOBILE:", e)
        });

    } catch (error) {
        console.log("Erro ao comprimir a imagem", error);
    }
}


//função para comprimir imagem e nao perder tanta qualidade
function compressImage(file, quality = 0.6, maxWidth = 1280) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();

        reader.onload = (event) => {
            const img = new Image();
            img.src = event.target.result;

            img.onload = () => {
                const canvas = document.createElement("canvas");
                const ctx = canvas.getContext("2d");

                const scaleFactor = maxWidth / img.width;
                canvas.width = maxWidth;
                canvas.height = img.height * scaleFactor;

                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                canvas.toBlob(
                    (blob) => {
                        if (blob) {
                            const compressedFile = new File([blob], file.name, {
                                type: "image/jpeg",
                                lastModified: Date.now()
                            });
                            resolve(compressedFile);
                        } else {
                            reject(new Error("Falha ao comprimir"));
                        }
                    },
                    "image/jpeg",
                    quality
                );
            };

            img.onerror = () => reject("Erro ao carregar imagem");
        };

        reader.onerror = () => reject("Erro ao ler arquivo");
        reader.readAsDataURL(file);
    });
}

</script>
<template>
    <!-- Wrapper responsivo -->
    <div
        class="p-6 bg-white rounded-lg shadow-md 
               w-full max-w-lg mx-auto
               md:w-[550px]"
    >
        <h2 class="text-xl font-bold mb-4 text-gray-700 text-center md:text-left">
            Criar Ordem de Serviço
        </h2>

        <form @submit.prevent="submit" class="space-y-4">

            <!-- Alojamento -->
            <div>
                <label class="font-medium text-sm md:text-base">Condomínio</label>
                <select
                    class="border p-2 rounded w-full text-sm md:text-base"
                    v-model="form.alojamento_id"
                    @change="selecionarAlojamento"
                >
                    <option value="">Selecione...</option>
                    <option
                        v-for="a in props.alojamentos"
                        :key="a.id"
                        :value="a.id"
                    >
                        {{ a.nome }}
                    </option>
                </select>
            </div>

            <!-- Bloco -->
            <div>
                <label class="font-medium text-sm md:text-base">Setor</label>
                <select
                    class="border p-2 rounded w-full text-sm md:text-base"
                    v-model="form.bloco_id"
                    @change="selecionarBloco"
                >
                    <option value="">Selecione...</option>
                    <option v-for="b in blocos" :key="b.id" :value="b.id">
                        {{ b.nome }}
                    </option>
                </select>
            </div>

            <!-- Título -->
            <div>
                <label class="font-medium text-sm md:text-base">Título da OS</label>
                <input
                    type="text"
                    class="border p-2 rounded w-full text-sm md:text-base"
                    v-model="form.titulo"
                />
            </div>

            <!-- Descrição -->
            <div>
                <label class="font-medium text-sm md:text-base">Descrição</label>
                <textarea
                    class="border p-2 rounded w-full h-24 text-sm md:text-base"
                    v-model="form.descricao"
                ></textarea>
            </div>

            <!-- Prioridade -->
            <div>
                <label class="font-medium text-sm md:text-base">Prioridade</label>
                <select
                    v-model="form.prioridade_id"
                    class="border p-2 rounded w-full text-sm md:text-base"
                >
                    <option value="">Selecione...</option>
                    <option
                        v-for="p in props.prioridades"
                        :key="p.id"
                        :value="p.id"
                    >
                        {{ p.nome }}
                    </option>
                </select>
            </div>
            <!-- Adicionar foto-->
            <div>
                <label class="font-medium text-sm md:text-base">Adicionar Foto</label>
                <input
                    type="file"
                    accept="image/*"
                    multiple
                    name="fotos[]"
                    @change="(e) => form.fotos = Array.from(e.target.files)"
                    class="w-full border rounded-lg p-2"
                >
            </div>

            <!-- Botão -->
            <button
                class="
                    w-full bg-blue-600 text-white py-2 rounded 
                    hover:bg-blue-700 text-base
                    md:text-lg
                "
            >
                Criar OS
            </button>
        </form>
    </div>
</template>
