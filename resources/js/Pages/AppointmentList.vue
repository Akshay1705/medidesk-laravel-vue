<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })
defineProps(['appointments'])

const processing = ref(false)

const markDone = (id) => {
    if (processing.value) return;

    if (confirm('Mark this appointment as done?')) {
        processing.value = true;
        router.put(`/appointments/${id}/complete`, {}, {
            onFinish: () => {
                processing.value = false;
                window.location.reload(); // Refresh the list
            }
        });
    }
};

const cancelAppointment = (id) => {
    if (processing.value) return;

    if (confirm('Are you sure you want to cancel this appointment permanently?')) {
        processing.value = true;
        router.delete(`/appointments/${id}`, {
            onFinish: () => {
                processing.value = false;
                window.location.reload(); // Refresh the list
            }
        });
    }
};

</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">📋 Pending Appointments</h1>

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
                    <tr v-for="a in appointments" :key="a.id" class="border-b hover:bg-gray-50">
                        <td class="p-3 text-center">{{ a.name }}</td>
                        <td class="p-3 text-center">{{ a.phone }}</td>
                        <td class="p-3 text-center">{{ a.appointment_date }}</td>
                        <td class="p-3 text-center">{{ a.appointment_time }}</td>
                        <td class="p-3 text-center">
                            <button @click="markDone(a.id)" :disabled="processing"
                                class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50">
                                {{ processing ? 'Processing...' : 'Done ✅' }}
                            </button>
                            <button @click="cancelAppointment(a.id)" :disabled="processing"
                                class="px-3 py-1 ml-2 text-sm bg-red-700 text-white rounded hover:bg-red-800 disabled:opacity-50">
                                ❌
                            </button>
                        </td>
                    </tr>
                    <tr v-if="appointments.length === 0">
                        <td colspan="5" class="text-center py-4 text-gray-500">
                            No appointments found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
