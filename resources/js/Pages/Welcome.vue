<script setup>
import { Link } from '@inertiajs/vue3'
defineProps(['canLogin'])
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-blue-50">
        <div class="text-center bg-white shadow-lg rounded-xl p-10">
            <h1 class="text-4xl font-bold text-blue-700 mb-4">🩺 Welcome to MediDesk</h1>
            <p class="text-gray-600 mb-6">Clinic Appointment Management System</p>

            <Link v-if="canLogin" href="/login" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Login
            </Link>
        </div>
    </div>
</template>
