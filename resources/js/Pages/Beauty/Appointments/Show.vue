<script setup>
import BeautyLayout from '@/Layouts/BeautyLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    appointment: Object
});
</script>

<template>
    <BeautyLayout title="Detalles de Cita">
        <div class="p-6 max-w-3xl">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-2xl font-bold text-pink-700">Cita #{{ appointment.id }}</h1>
            <div class="space-x-2">
            <Link :href="route('beauty.appointments.edit', appointment.id)" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">Editar</Link>
            <Link :href="route('beauty.appointments.index')" class="bg-gray-200 px-3 py-1 rounded text-sm">Volver</Link>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Información de la Cita</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Fecha y Hora</p>
                <p class="font-medium">{{ new Date(appointment.scheduled_at).toLocaleString() }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Cliente</p>
                <p class="font-medium">{{ appointment.client.first_name }} {{ appointment.client.last_name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Teléfono</p>
                <p class="font-medium">{{ appointment.client.phone }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Duración Total</p>
                <p class="font-medium">{{ appointment.total_duration_minutes }} minutos</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total a Pagar</p>
                <p class="font-medium">$ {{ appointment.total_price }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Estado</p>
                <p class="font-medium capitalize">{{ appointment.status }}</p>
            </div>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Servicios</h2>
            <div v-for="as in appointment.services" :key="as.id" class="border-b border-gray-100 pb-3 last:border-0 last:pb-0">
            <p class="font-medium">{{ as.service.name }}</p>
            <p class="text-sm text-gray-600">
                Duración: {{ as.service.duration_minutes }} min • Precio: ${{ as.service.price }}
            </p>
            <p class="text-sm text-gray-600">
                Especialista: {{ as.staff ? as.staff.name : 'No asignado' }}
            </p>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pago</h2>
            <div v-if="appointment.payment">
            <p class="font-medium">Pagado: ${{ appointment.payment.amount }}</p>
            <p class="text-sm text-gray-600">Método: {{ appointment.payment.method }}</p>
            </div>
            <p v-else class="text-gray-500">No se ha registrado pago.</p>
        </div>
        </div>
    </BeautyLayout>
</template>