<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import Sidebar from './NewSideBar.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';

const page = usePage();
const user = page.props.history;

const user_data = ref([]);

onMounted(async () => {
  try {
    const res = await axios.get('/user_history');
    user_data.value = res.data;
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
    <Head title="Booking Management" />

    <div class="flex min-h-screen bg-gray-50">
        <Sidebar />

        <div class="ml-64 flex-1">
            <div class="p-6">
                <div class="mb-8 flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-blue-600">
                        Booking Management
                    </h1>
                    <button
                        class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition hover:bg-blue-700"
                    >
                        + New Booking
                    </button>
                </div>
                <!-- Bookings Table -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-xl">
                    <table class="w-full border-collapse text-left">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-4 py-3">Booking ID</th>
                                <th class="px-4 py-3">Passenger Name</th>
                                <th class="px-4 py-3">Flight No.</th>
                                <th class="px-4 py-3">Destination</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr
                                v-for="users in user_data"
                                :key="users.id"
                                class="border-b border-gray-200 transition hover:bg-gray-50"
                            >
                                <td class="px-4 py-3">{{ users.booking_id }}</td>
                                <td class="px-4 py-3">{{ users.firstname }}</td>
                                <td class="px-4 py-3">{{ users.flightNo }}</td>
                                <td class="px-4 py-3">
                                    {{ users.destination }}
                                </td>
                                <td class="px-4 py-3">{{ users.date }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700"
                                        >Done</span
                                    >
                                </td>
                                <td
                                    class="flex justify-center space-x-2 px-4 py-3"
                                >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Passenger Manifest Section -->
                <!-- <div class="mt-12 rounded-2xl bg-white p-6 shadow-xl">
                    <h2 class="mb-4 text-2xl font-bold text-blue-600">
                        Passenger Manifest
                    </h2>
                    <p class="mb-4 text-gray-600">
                        View passengers for a specific flight.
                    </p>
                    <div class="mb-6 flex space-x-4">
                        <input
                            type="text"
                            placeholder="Enter Flight Number (e.g., FL-230)"
                            class="flex-1 rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                        />
                        <button
                            class="rounded-lg bg-blue-600 px-6 py-2 font-medium text-white transition hover:bg-blue-700"
                        >
                            View Manifest
                        </button>
                    </div>

                    <table class="w-full border-collapse text-left">
                        <thead class="bg-blue-100">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Passenger Name</th>
                                <th class="px-4 py-2">Seat No.</th>
                                <th class="px-4 py-2">Ticket Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2">1</td>
                                <td class="px-4 py-2">John Dela Cruz</td>
                                <td class="px-4 py-2">12A</td>
                                <td
                                    class="px-4 py-2 font-medium text-green-600"
                                >
                                    Checked-In
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2">2</td>
                                <td class="px-4 py-2">Maria Santos</td>
                                <td class="px-4 py-2">14B</td>
                                <td
                                    class="px-4 py-2 font-medium text-yellow-600"
                                >
                                    Pending
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
            </div>
        </div>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
