<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { toast } from 'vue3-toastify' // optional for notification

defineOptions({ layout: AppLayout })

const form = useForm({
    name: '',
    phone: '',
    appointment_date: '',
    hour: '',
    minute: '',
    ampm: 'AM',
})

const submit = () => {
    // Convert to 24-hour format
    let hour = parseInt(form.hour)
    if (form.ampm === 'PM' && hour !== 12) hour += 12
    if (form.ampm === 'AM' && hour === 12) hour = 0
    const time = `${String(hour).padStart(2, '0')}:${form.minute}`

    const payload = {
        name: form.name,
        phone: form.phone,
        appointment_date: form.appointment_date,
        appointment_time: time,
    }

    form.post('/appointments', {
        data: payload,
        onSuccess: () => {
            form.reset()
            alert('Appointment added successfully!')
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
                <label class="block font-medium mb-1">Appointment Time</label>
                <div class="flex gap-3 items-center">
                    <!-- Hour -->
                    <select v-model="form.hour" required
                        class="w-24 p-2 border rounded focus:outline-none focus:ring focus:ring-blue-300">
                        <option disabled value="">Hour</option>
                        <option v-for="h in 12" :key="h" :value="String(h).padStart(2, '0')">
                            {{ String(h).padStart(2, '0') }}
                        </option>
                    </select>

                    <span class="text-xl font-semibold">:</span>

                    <!-- Minute -->
                    <select v-model="form.minute" required
                        class="w-24 p-2 border rounded focus:outline-none focus:ring focus:ring-blue-300">
                        <option disabled value="">Min</option>
                        <option v-for="m in [0, 15, 30, 45]" :key="m" :value="String(m).padStart(2, '0')">
                            {{ String(m).padStart(2, '0') }}
                        </option>
                    </select>

                    <!-- AM/PM -->
                    <select v-model="form.ampm" required
                        class="w-20 p-2 border rounded focus:outline-none focus:ring focus:ring-blue-300">
                        <option disabled value="">AM/PM</option>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>

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
  
