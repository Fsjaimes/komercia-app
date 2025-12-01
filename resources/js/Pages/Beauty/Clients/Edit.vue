<script setup>
import BeautyLayout from '@/Layouts/BeautyLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    client: Object
});

const form = useForm({
    first_name: props.client.first_name,
    last_name: props.client.last_name,
    phone: props.client.phone,
    email: props.client.email,
    alias: props.client.alias,
    document: props.client.document
});

const submit = () => {
    form.put(route('beauty.clients.update', props.client.id));
};
</script>

<template>
    <BeautyLayout title="Editar Cliente">
        <div class="p-6 max-w-2xl">
            <h1 class="text-2xl font-bold text-pink-700 mb-6">Editar Cliente</h1>

            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                    <div>
                        <label class="block text-sm font-medium">Nombre *</label>
                        <input v-model="form.first_name" class="input" required />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Apellido *</label>
                        <input v-model="form.last_name" class="input" required />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Teléfono *</label>
                        <input v-model="form.phone" class="input" required />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Cédula *</label>
                        <input v-model="form.document" class="input" required />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium">Correo</label>
                        <input v-model="form.email" class="input" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium">Alias</label>
                        <input v-model="form.alias" class="input" />
                    </div>
                </div>

                <div class="flex space-x-3">
                    <button class="btn-primary">Actualizar</button>
                    <Link :href="route('beauty.clients.index')" class="btn-secondary">Cancelar</Link>
                </div>
            </form>
        </div>
    </BeautyLayout>
</template>

<style scoped>
.input {
    @apply mt-1 block w-full border rounded px-3 py-2;
}
.btn-primary {
    @apply bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700;
}
.btn-secondary {
    @apply bg-gray-200 px-4 py-2 rounded hover:bg-gray-300;
}
</style>
