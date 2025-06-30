<script setup>
import { ref, computed, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    appointments: Object,
})

const processing = ref(false)
const search = ref('')
const todayOnly = ref(false)

const markDone = (id) => {
    if (processing.value) return
    if (confirm('Mark this appointment as done?')) {
        processing.value = true
        router.put(`/appointments/${id}/complete`, {}, {
            onFinish: () => {
                processing.value = false
                router.reload({ only: ['appointments'] })
            }
        })
    }
}

const cancelAppointment = (id) => {
    if (processing.value) return
    if (confirm('Are you sure you want to cancel this appointment permanently?')) {
        processing.value = true
        router.delete(`/appointments/${id}`, {
            onFinish: () => {
                processing.value = false
                router.reload({ only: ['appointments'] })
            }
        })
    }
}

// Watch search or filter and re-query
watch([search, todayOnly], () => {
    router.get('/appointments', {
        search: search.value,
        today: todayOnly.value,
    }, {
        preserveState: true,
        replace: true,
    })
})

const formatDate = (dateStr) => {
    const [year, month, day] = dateStr.split('-')
    return `${day}-${month}-${year}`
}

const formatTime = (timeStr) => {
    const [hour, minute] = timeStr.split(':')
    const h = parseInt(hour)
    const ampm = h >= 12 ? 'PM' : 'AM'
    const formattedHour = h % 12 === 0 ? 12 : h % 12
    return `${formattedHour}:${minute} ${ampm}`
}

</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">📋 Pending Appointments</h1>

        <!-- Filters -->
        <div class="mb-4 flex items-center gap-4">
            <input v-model="search" type="text" placeholder="Search name or phone..."
                class="border rounded px-3 py-2 w-64" />

            <label class="flex items-center space-x-2">
                <input type="checkbox" v-model="todayOnly" />
                <span>Today's Appointments Only</span>
            </label>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow rounded-xl">
            <table class="min-w-full text-left border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border text-center">Name</th>
                        <th class="p-3 border text-center">Phone</th>
                        <th class="p-3 border text-center">Date</th>
                        <th class="p-3 border text-center">Time</th>
                        <th class="p-3 border text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="a in appointments.data" :key="a.id" class="border-b hover:bg-gray-50">
                        <td class="p-3 text-center">{{ a.name }}</td>
                        <td class="p-3 text-center">{{ a.phone }}</td>
                        <td class="p-3 text-center">{{ formatDate(a.appointment_date) }}</td>
                        <td class="p-3 text-center">{{ formatTime(a.appointment_time) }}</td>
                        <td class="p-3 text-center">
                            <button @click="markDone(a.id)" :disabled="processing"
                                class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50">
                                DONE ✅
                            </button>
                            <button @click="cancelAppointment(a.id)" :disabled="processing"
                                class="px-3 py-1 ml-2 text-sm bg-red-700 text-white rounded hover:bg-red-800 disabled:opacity-50">
                                ❌
                            </button>
                        </td>
                    </tr>
                    <tr v-if="appointments.data.length === 0">
                        <td colspan="5" class="text-center py-4 text-gray-500">
                            No appointments found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-center space-x-2">
            <button v-for="(link, index) in appointments.links" :key="index" v-html="link.label"
                @click="() => link.url && router.get(link.url)" :disabled="!link.url"
                class="px-3 py-1 border rounded transition-all" :class="[
                    link.active ? 'bg-blue-600 text-white font-semibold' : '',
                    !link.url ? 'text-gray-400 border-gray-300 cursor-not-allowed' : 'hover:bg-gray-100'
                ]" />
        </div>
    </div>
</template>
