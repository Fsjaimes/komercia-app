<script setup>
import BeautyLayout from '@/Layouts/BeautyLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
  appointment: Object,
  clients: Array,
  services: Array,
  staff: Array
});

const form = useForm({
    client_id: props.appointment.client_id,
    scheduled_at: new Date(props.appointment.scheduled_at).toISOString().slice(0, 16),
    services: props.appointment.services.map(as => ({
        service_id: as.service_id,
        staff_id: as.staff_id
    }))
});

const addService = () => {
    form.services.push({ service_id: '', staff_id: '' });
};

const removeService = (index) => {
    form.services.splice(index, 1);
};

const totalDuration = ref(0);
const totalPrice = ref(0);

watch(() => form.services, () => {
    totalDuration.value = 0;
    totalPrice.value = 0;
    form.services.forEach(item => {
        const service = props.services.find(s => s.id == item.service_id);
        if (service) {
        totalDuration.value += service.duration_minutes;
        totalPrice.value += service.price;
        }
    });
}, { deep: true });
</script>

<template>
    <BeautyLayout title="Editar Cita">
        <div class="p-6 max-w-3xl">
        <h1 class="text-2xl font-bold text-pink-700 mb-6">Editar Cita</h1>
        <form @submit.prevent="form.put(route('beauty.appointments.update', appointment.id))">
            <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Cliente *</label>
            <select v-model="form.client_id" class="mt-1 block w-full border rounded px-3 py-2" required>
                <option value="">Seleccionar cliente</option>
                <option v-for="client in clients" :key="client.id" :value="client.id">
                {{ client.first_name }} {{ client.last_name }} ({{ client.phone }})
                </option>
            </select>
            </div>

            <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Fecha y Hora *</label>
            <input v-model="form.scheduled_at" type="datetime-local" class="mt-1 block w-full border rounded px-3 py-2" required />
            </div>

            <div class="mb-6">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-medium text-gray-800">Servicios</h2>
                <button type="button" @click="addService" class="text-pink-600 hover:underline">+ Agregar servicio</button>
            </div>

            <div v-for="(item, index) in form.services" :key="index" class="border rounded p-4 mb-3 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-600">Servicio *</label>
                    <select v-model="item.service_id" class="mt-1 block w-full border rounded px-3 py-2" required>
                    <option value="">Seleccionar</option>
                    <option v-for="service in services" :key="service.id" :value="service.id">
                        {{ service.name }} (${{ service.price }}, {{ service.duration_minutes }} min)
                    </option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600">Especialista</label>
                    <select v-model="item.staff_id" class="mt-1 block w-full border rounded px-3 py-2">
                    <option value="">No asignado</option>
                    <option v-for="person in staff" :key="person.id" :value="person.id">
                        {{ person.name }}
                    </option>
                    </select>
                </div>
                </div>
                <button type="button" @click="removeService(index)" class="mt-2 text-red-600 text-sm">Eliminar</button>
            </div>
            </div>

            <div class="mb-6 p-4 bg-pink-50 rounded">
            <p class="font-medium">Total: ${{ totalPrice.toFixed(2) }} — Duración: {{ totalDuration }} minutos</p>
            </div>

            <div class="flex space-x-3">
            <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">Actualizar Cita</button>
            <Link :href="route('beauty.appointments.show', appointment.id)" class="bg-gray-200 px-4 py-2 rounded">Cancelar</Link>
            </div>
        </form>
        </div>
    </BeautyLayout>
</template>