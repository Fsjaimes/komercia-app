<script setup>
import BeautyLayout from '@/Layouts/BeautyLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    clients: Object,
    search: String
});

const searchTerm = ref(props.search || '');
const page = usePage();

watch(searchTerm, () => {
    router.get(route('beauty.clients.index'), { search: searchTerm.value }, { preserveState: true });
}, { debounce: 300 });
</script>

<template>
    <BeautyLayout title="Clientes">
        <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-pink-700">Clientes</h1>
            <Link :href="route('beauty.clients.create')" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
            Nuevo Cliente
            </Link>
        </div>

        <div class="mb-4">
            <input
            v-model="searchTerm"
            type="text"
            placeholder="Buscar por nombre, teléfono o cédula..."
            class="border rounded px-3 py-2 w-64"
            />
        </div>

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cédula</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="client in clients.data" :key="client.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ client.first_name }} {{ client.last_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ client.phone }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ client.document }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <Link :href="route('beauty.clients.edit', client.id)" class="text-blue-600 hover:underline mr-3">Editar</Link>
                    <button @click="router.delete(route('beauty.clients.destroy', client.id))" class="text-red-600 hover:underline">Eliminar</button>
                </td>
                </tr>
            </tbody>
            </table>
            <div class="p-4" v-if="clients.links">
            <div v-html="clients.links" />
            </div>
        </div>
        </div>
    </BeautyLayout>
</template>

<style scoped>
.pagination a {
    text-decoration: none;
}
</style>