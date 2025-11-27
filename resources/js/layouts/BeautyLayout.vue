<script setup>
import { Link, router } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex">
        <aside class="w-64 bg-white shadow-md">
            <div class="p-4">
            <h1 class="text-xl font-bold text-pink-600">Komercia - Belleza</h1>
            </div>
            <nav class="mt-6">
            <a
                href="#"
                @click.prevent="router.visit('/beauty')"
                class="block px-4 py-2 text-gray-700 hover:bg-pink-100"
            >
                Dashboard
            </a>
            <a
                href="#"
                @click.prevent="router.visit('/beauty/clients')"
                class="block px-4 py-2 text-gray-700 hover:bg-pink-100"
            >
                Clientes
            </a>
            <a
                href="#"
                @click.prevent="router.visit('/beauty/services')"
                class="block px-4 py-2 text-gray-700 hover:bg-pink-100"
            >
                Servicios
            </a>
            <a
                href="#"
                @click.prevent="router.visit('/beauty/appointments')"
                class="block px-4 py-2 text-gray-700 hover:bg-pink-100"
            >
                Citas
            </a>
            </nav>
        </aside>
        <main class="flex-1 p-6">
            <slot />
        </main>
    </div>
</template>