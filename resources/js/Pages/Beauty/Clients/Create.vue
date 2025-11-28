<script setup>
import BeautyLayout from '@/Layouts/BeautyLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    first_name: '',
    last_name: '',
    phone: '',
    email: '',
    alias: '',
    document: ''
});

const submit = () => {
    form.post(route('beauty.clients.store'));
};
</script>

<template>
    <BeautyLayout title="Nuevo Cliente">
        <div class="p-6 max-w-2xl">
        <h1 class="text-2xl font-bold text-pink-700 mb-6">Registrar Nuevo Cliente</h1>
        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nombre *</label>
                <input v-model="form.first_name" type="text" class="mt-1 block w-full border rounded px-3 py-2" required />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Apellido *</label>
                <input v-model="form.last_name" type="text" class="mt-1 block w-full border rounded px-3 py-2" required />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Teléfono *</label>
                <input v-model="form.phone" type="text" class="mt-1 block w-full border rounded px-3 py-2" required />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Cédula *</label>
                <input v-model="form.document" type="text" class="mt-1 block w-full border rounded px-3 py-2" required />
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input v-model="form.email" type="email" class="mt-1 block w-full border rounded px-3 py-2" />
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Alias</label>
                <input v-model="form.alias" type="text" class="mt-1 block w-full border rounded px-3 py-2" />
            </div>
            </div>
            <div class="flex space-x-3">
            <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">Guardar</button>
            <Link :href="route('beauty.clients.index')" class="bg-gray-200 px-4 py-2 rounded">Cancelar</Link>
            </div>
        </form>
        </div>
    </BeautyLayout>
</template>