<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

const sidebarOpen = ref(false)
const user = usePage().props.auth.user
const toggleSidebar = () => sidebarOpen.value = !sidebarOpen.value
</script>

<template>
  <div class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside
      :class="[
        'bg-white w-64 p-6 shadow flex flex-col justify-between fixed top-0 bottom-0 z-50 transform transition-transform duration-300',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full',
        'lg:translate-x-0'
      ]"
    >
      <div>
        <h1 class="text-2xl font-bold mb-6 text-blue-600">🩺 MediDesk</h1>
        <nav class="space-y-3">
          <Link
            href="/appointments"
            :class="[
              'block px-3 py-2 rounded hover:text-blue-600',
              $page.url.startsWith('/appointments') && !$page.url.includes('create') && !$page.url.includes('completed')
                ? 'text-blue-600 bg-blue-100 border-l-4 border-blue-600 font-semibold'
                : 'text-gray-800'
            ]"
            @click="sidebarOpen = false"
          >
            📋 Appointments
          </Link>
          <Link
            href="/appointments/completed"
            :class="[
              'block px-3 py-2 rounded hover:text-blue-600',
              $page.url.includes('/appointments/completed')
                ? 'text-blue-600 bg-blue-100 border-l-4 border-blue-600 font-semibold'
                : 'text-gray-800'
            ]"
            @click="sidebarOpen = false"
          >
            ✅ Completed
          </Link>
          <Link
            href="/appointments/create"
            :class="[
              'block px-3 py-2 rounded hover:text-blue-600',
              $page.url.includes('/appointments/create')
                ? 'text-blue-600 bg-blue-100 border-l-4 border-blue-600 font-semibold'
                : 'text-gray-800'
            ]"
            @click="sidebarOpen = false"
          >
            ➕ Add Appointment
          </Link>
        </nav>
      </div>

      <div class="text-sm text-gray-600 mt-auto">
        <p class="mb-1">👤 {{ user.name }}</p>
        <Link href="/logout" method="post" as="button" class="text-red-600 hover:underline">Logout</Link>
      </div>
    </aside>

    <!-- Overlay -->
    <div
      v-if="sidebarOpen"
      class="fixed inset-0 bg-black bg-opacity-40 z-40 lg:hidden"
      @click="sidebarOpen = false"
    ></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden lg:ml-64">
      <!-- Topbar (visible on mobile/tablet) -->
      <div class="lg:hidden p-4 shadow bg-white flex justify-between items-center">
        <h2 class="text-lg font-bold text-blue-600">MediDesk</h2>
        <button @click="toggleSidebar" class="text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <main class="flex-1 overflow-y-auto p-6">
        <slot />
      </main>
    </div>
  </div>
</template>
