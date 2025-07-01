<script setup>
import { Link, usePage } from '@inertiajs/vue3'

const user = usePage().props.auth.user
</script>

<template>
    <div class="flex h-screen bg-gray-100">
        <aside class="bg-white w-64 p-6 shadow flex flex-col justify-between fixed left-0 top-0 bottom-0">
            <div>
                <h1 class="text-2xl font-bold mb-6 text-blue-600">🩺 MediDesk</h1>
                <nav class="space-y-3">
                <Link
                    href="/appointments"
                    :class="[
                    'block hover:text-blue-600',
                    $page.url.startsWith('/appointments') && !$page.url.includes('create') && !$page.url.includes('completed')
                        ? 'text-blue-600 bg-blue-100 border-l-4 border-blue-600 font-semibold'
                        : 'text-gray-800'
                    ]"
                >
                    📋 Appointments
                </Link>
                <Link
                    href="/appointments/completed"
                    :class="[
                    'block hover:text-blue-600',
                    $page.url.includes('/appointments/completed') ? 'text-blue-600 bg-blue-100 border-l-4 border-blue-600 font-semibold' : 'text-gray-800'
                    ]"
                >
                    ✅ Completed
                </Link>
                <Link
                    href="/appointments/create"
                    :class="[
                    'block hover:text-blue-600',
                    $page.url.includes('/appointments/create') ? 'text-blue-600 bg-blue-100 border-l-4 border-blue-600 font-semibold' : 'text-gray-800'
                    ]"
                >
                    ➕ Add Appointment
                </Link>
                </nav>
            </div>
            <div class="text-sm text-gray-600">
                <p class="mb-1">👤 {{ user.name }}</p>
                <Link href="/logout" method="post" as="button" class="text-red-600 hover:underline">Logout</Link>
            </div>
        </aside>


        <!-- Main Content -->
        <main class="flex-1 ml-64 overflow-y-auto p-6">
            <slot />
        </main>
    </div>
</template>
