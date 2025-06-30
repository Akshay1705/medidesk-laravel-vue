<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { toast } from 'vue3-toastify' // optional for notification

defineOptions({ layout: AppLayout })

const form = useForm({
    name: '',
    phone: '',
    appointment_date: '',
    appointment_time: '',
})

const submit = () => {
    form.post('/appointments', {
        onSuccess: () => {
            form.reset()
            toast.success('✅ Appointment added successfully!')
        },
        onError: () => {
            if (form.errors.phone) {
                toast.error(form.errors.phone)
            }
        }
    })
}
</script>


<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">➕ Add New Appointment</h1>

        <form @submit.prevent="submit" class="space-y-4 bg-white p-6 rounded shadow max-w-md">
            <!-- Name -->
            <div>
                <label class="block font-medium">Patient Name</label>
                <input v-model="form.name" class="w-full mt-1 p-2 border rounded" required />
                <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
            </div>

            <!-- Phone -->
            <div>
                <label class="block font-medium">Phone Number</label>
                <input v-model="form.phone" type="text" inputmode="numeric" pattern="\d{10}" maxlength="10"
                    @input="form.phone = form.phone.replace(/\D/g, '')" class="w-full mt-1 p-2 border rounded"
                    placeholder="Enter 10-digit phone number" required />
                <p v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</p>
            </div>

            <!-- Appointment Date -->
            <div>
                <label class="block font-medium">Appointment Date</label>
                <input v-model="form.appointment_date" type="date" class="w-full mt-1 p-2 border rounded" required />
                <p v-if="form.errors.appointment_date" class="text-red-500 text-sm mt-1">{{ form.errors.appointment_date
                    }}</p>
            </div>

            <!-- Appointment Time -->
            <div>
                <label class="block font-medium">Appointment Time</label>
                <input v-model="form.appointment_time" type="time" class="w-full mt-1 p-2 border rounded" required />
                <p v-if="form.errors.appointment_time" class="text-red-500 text-sm mt-1">
                    {{ form.errors.appointment_time }}
                </p>
            </div>

            <!-- Submit -->
            <button type="submit" :disabled="form.processing"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50">
                {{ form.processing ? 'Saving...' : 'Save Appointment' }}
            </button>
        </form>
    </div>
</template>
  
