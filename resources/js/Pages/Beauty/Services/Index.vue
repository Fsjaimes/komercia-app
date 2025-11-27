<script setup>
import BeautyLayout from '@/Layouts/BeautyLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    services: Object
});
</script>

<template>
    <BeautyLayout title="Servicios">
        <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-pink-700">Servicios</h1>
            <Link :href="route('beauty.services.create')" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
            Nuevo Servicio
            </Link>
        </div>

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duración (min)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Activo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="service in services.data" :key="service.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ service.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ service.duration_minutes }}</td>
                <td class="px-6 py-4 whitespace-nowrap">$ {{ service.price }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ service.category || '—' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="service.active ? 'text-green-600' : 'text-red-600'">
                    {{ service.active ? 'Sí' : 'No' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <Link :href="route('beauty.services.edit', service.id)" class="text-blue-600 hover:underline mr-3">Editar</Link>
                    <button @click="router.delete(route('beauty.services.destroy', service.id))" class="text-red-600 hover:underline">Eliminar</button>
                </td>
                </tr>
            </tbody>
            </table>
            <div class="p-4" v-if="services.links">
            <div v-html="services.links" />
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