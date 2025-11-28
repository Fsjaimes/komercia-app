<script setup>
import BeautyLayout from '@/Layouts/BeautyLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    description: '',
    duration_minutes: 30,
    price: 0,
    category: '',
    active: true
});

const submit = () => {
    form.post(route('beauty.services.store'));
};
</script>

<template>
    <BeautyLayout title="Nuevo Servicio">
        <div class="p-6 max-w-2xl">
        <h1 class="text-2xl font-bold text-pink-700 mb-6">Registrar Nuevo Servicio</h1>
        <form @submit.prevent="submit">
            <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nombre *</label>
            <input v-model="form.name" type="text" class="mt-1 block w-full border rounded px-3 py-2" required />
            </div>
            <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea v-model="form.description" class="mt-1 block w-full border rounded px-3 py-2"></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Duración (minutos) *</label>
                <input v-model.number="form.duration_minutes" type="number" min="5" class="mt-1 block w-full border rounded px-3 py-2" required />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Precio ($)*</label>
                <input v-model.number="form.price" type="number" step="0.01" min="0" class="mt-1 block w-full border rounded px-3 py-2" required />
            </div>
            </div>
            <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Categoría (ej: Manicura, Corte, etc)</label>
            <input v-model="form.category" type="text" class="mt-1 block w-full border rounded px-3 py-2" />
            </div>
            <div class="mb-6">
            <label class="inline-flex items-center">
                <input v-model="form.active" type="checkbox" class="rounded" />
                <span class="ml-2 text-gray-700">Servicio activo</span>
            </label>
            </div>
            <div class="flex space-x-3">
            <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">Guardar</button>
            <Link :href="route('beauty.services.index')" class="bg-gray-200 px-4 py-2 rounded">Cancelar</Link>
            </div>
        </form>
        </div>
    </BeautyLayout>
</template>