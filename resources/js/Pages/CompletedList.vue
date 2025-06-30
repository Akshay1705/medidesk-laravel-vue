<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })
defineProps(['appointments'])

//formating date for dd-mm-yyyy
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
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">✅ Completed Appointments</h1>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-xl">
            <table class="min-w-full text-left border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border text-center">Name</th>
                        <th class="p-3 border text-center">Phone</th>
                        <th class="p-3 border text-center">Date</th>
                        <th class="p-3 border text-center">Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="a in appointments" :key="a.id" class="border-b hover:bg-gray-50">
                        <td class="p-3 text-center">{{ a.name }}</td>
                        <td class="p-3 text-center">{{ a.phone }}</td>
                        <td class="p-3 text-center">{{ formatDate(a.appointment_date) }}</td>
                        <td class="p-3 text-center">{{ formatTime(a.appointment_time) }}</td>
                    </tr>

                    <tr v-if="appointments.length === 0">
                        <td colspan="4" class="text-center py-4 text-gray-500">
                            No completed appointments found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
