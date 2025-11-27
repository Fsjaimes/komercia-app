<script setup>
import BeautyLayout from '@/Layouts/BeautyLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    appointments: Object,
    date: String
});

const selectedDate = ref(props.date);

watch(selectedDate, () => {
    router.get(route('beauty.appointments.index'), { date: selectedDate.value }, { preserveState: true });
});
</script>

<template>
    <BeautyLayout title="Citas">
        <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-pink-700">Citas del Día</h1>
            <Link :href="route('beauty.appointments.create')" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
            Nueva Cita
            </Link>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Seleccionar fecha</label>
            <input v-model="selectedDate" type="date" class="border rounded px-3 py-2" />
        </div>

        <div class="bg-white rounded shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hora</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Servicios</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Especialista</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="apt in appointments.data" :key="apt.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ new Date(apt.scheduled_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ apt.client.first_name }} {{ apt.client.last_name }}</td>
                <td class="px-6 py-4">
                    <div v-for="as in apt.services" :key="as.id">
                    {{ as.service.name }}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div v-for="as in apt.services" :key="as.id">
                    {{ as.staff ? as.staff.name : '—' }}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="{
                    'text-yellow-600': apt.status === 'pending',
                    'text-green-600': apt.status === 'confirmed' || apt.status === 'completed',
                    'text-blue-600': apt.status === 'in_progress',
                    'text-red-600': apt.status === 'cancelled'
                    }">
                    {{ apt.status }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <Link :href="route('beauty.appointments.show', apt.id)" class="text-blue-600 hover:underline mr-3">Ver</Link>
                    <button @click="router.delete(route('beauty.appointments.destroy', apt.id))" class="text-red-600 hover:underline">Cancelar</button>
                </td>
                </tr>
            </tbody>
            </table>
            <div class="p-4" v-if="appointments.links">
            <div v-html="appointments.links" />
            </div>
        </div>
        </div>
    </BeautyLayout>
</template>