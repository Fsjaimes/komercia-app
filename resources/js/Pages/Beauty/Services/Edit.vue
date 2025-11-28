<script setup>
import BeautyLayout from '@/Layouts/BeautyLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    service: Object
});

const form = useForm({
    name: props.service.name,
    description: props.service.description,
    duration_minutes: props.service.duration_minutes,
    price: props.service.price,
    category: props.service.category,
    active: props.service.active
});

const submit = () => {
    form.put(route('beauty.services.update', props.service.id));
};
</script>

<template>
    <BeautyLayout title="Editar Servicio">
        <div class="p-6 max-w-2xl">
        <h1 class="text-2xl font-bold text-pink-700 mb-6">Editar Servicio</h1>
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
            <label class="block text-sm font-medium text-gray-700">Categoría</label>
            <input v-model="form.category" type="text" class="mt-1 block w-full border rounded px-3 py-2" />
            </div>
            <div class="mb-6">
            <label class="inline-flex items-center">
                <input v-model="form.active" type="checkbox" class="rounded" />
                <span class="ml-2 text-gray-700">Servicio activo</span>
            </label>
            </div>
            <div class="flex space-x-3">
            <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">Actualizar</button>
            <Link :href="route('beauty.services.index')" class="bg-gray-200 px-4 py-2 rounded">Cancelar</Link>
            </div>
        </form>
        </div>
    </BeautyLayout>
</template>