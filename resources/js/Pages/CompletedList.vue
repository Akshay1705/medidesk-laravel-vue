<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })
defineProps(['appointments'])

//formating date to display as dd-mm-yyyy
const formatDate = (dateStr) => {
    const [year, month, day] = dateStr.split('-')
    return `${day}-${month}-${year}`
}

//formating time to display as 9:30 am/pm
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
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">✅ Completed Appointments</h1>

            <a href="/appointments/export" download
            class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-md shadow hover:bg-indigo-700 transition">
                ⬇ Export
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-xl">
            <table class="min-w-full text-left border">
                <thead class="bg-blue-100">
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
