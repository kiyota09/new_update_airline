<script setup lang="ts">
import Topbar from '@/components/Topbar.vue';
import { usePage } from '@inertiajs/vue3';
import { ref,computed } from 'vue';
import QRCodeVue from 'qrcode.vue';
const page = usePage();

// Flights booked by the logged-in user from backend
const bookedFlights = page.props.user_history || [];

// Modal controls
const show = ref(false);
const selectedTicket = ref(null);

const openModal = (flight: any) => {
    selectedTicket.value = flight;
    show.value = true;
};

const close = () => {
    show.value = false;
    selectedTicket.value = null;
};

const qrData = computed(() => {
  if (!selectedTicket.value) return '';
  return `
  Ticket: ${selectedTicket.value.ticket}
  Name: ${selectedTicket.value.name}
  Flight No: ${selectedTicket.value.flightNo}
  Route: ${selectedTicket.value.origin} → ${selectedTicket.value.destination}
  Date: ${selectedTicket.value.date}
  Time: ${selectedTicket.value.time}
  Class: ${selectedTicket.value.class}
  Passenger: ${selectedTicket.value.passenger}
  Price: ${selectedTicket.value.price} USD
  `;
});

</script>

<template>
    <div
        class="min-h-screen bg-gradient-to-b from-blue-50 to-white text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100"
    >
        <Topbar />

        <main class="container mx-auto space-y-12 px-4 py-8">
            <!-- ✈️ Booked Flights Section -->
            <section>
                <h2
                    class="mb-4 text-xl font-bold text-blue-600 dark:text-blue-400"
                >
                    Flight Bookings
                </h2>
                <div
                    v-if="bookedFlights.length"
                    class="overflow-hidden rounded-2xl bg-white shadow-xl dark:bg-gray-800"
                >
                    <table class="w-full border-collapse">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">Flight No.</th>
                                <th class="px-4 py-3 text-left">Route</th>
                                <th class="px-4 py-3 text-left">Date</th>
                                <th class="px-4 py-3 text-left">Ticket</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="flight in bookedFlights"
                                :key="flight.id"
                                class="border-b border-gray-200 transition hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700"
                            >
                                <td class="px-4 py-3 font-medium">
                                    ✈️ {{ flight.flightNo }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ flight.origin }} →
                                    {{ flight.destination }}
                                </td>
                                <td class="px-4 py-3">{{ flight.date }}</td>
                                <td class="px-4 py-3">
                                    <button @click="openModal(flight)">
                                        <div
                                            class="rounded-md bg-blue-100 px-2 py-1 text-sm font-medium text-blue-700 shadow-md transition hover:bg-blue-200 hover:shadow-lg"
                                        >
                                            View Ticket
                                        </div>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p
                    v-else
                    class="mt-4 text-center text-gray-500 dark:text-gray-400"
                >
                    You have no booked flights yet.
                </p>
            </section>
        </main>

        <!-- Ticket Modal -->
        <div
            v-if="show"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
        >
            <div
                class="relative w-[400px] rounded-2xl border border-gray-200 bg-gradient-to-br from-white to-gray-100 p-6 shadow-2xl"
            >
                <!-- Header -->
                <div
                    class="mb-4 flex items-center justify-between border-b border-gray-300 pb-2"
                >
                    <h2
                        class="flex items-center gap-2 text-xl font-bold text-blue-700"
                    >
                        🎟️ Ticket
                    </h2>
                    <span class="text-sm text-gray-500">SkyWings</span>
                </div>

                <!-- Ticket Body -->
                <div v-if="selectedTicket" class="space-y-3 text-gray-700">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold">Ticket No:</span>
                        <span class="text-sm">{{
                            selectedTicket.ticket || selectedTicket.id
                        }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold">Name:</span>
                        <span class="text-sm">{{
                            selectedTicket.name || 'N/A'
                        }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold">Flight No:</span>
                        <span class="text-sm">{{
                            selectedTicket.flightNo
                        }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold">Route:</span>
                        <span class="text-sm"
                            >{{ selectedTicket.origin }} →
                            {{ selectedTicket.destination }}</span
                        >
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold">Date:</span>
                        <span class="text-sm">{{ selectedTicket.date }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold">Time:</span>
                        <span class="text-sm">{{
                            selectedTicket.time || 'N/A'
                        }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold">Class:</span>
                        <span class="text-sm">{{
                            selectedTicket.class || 'N/A'
                        }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold">Passenger:</span>
                        <span class="text-sm">{{
                            selectedTicket.passenger || 1
                        }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold">Total Price:</span>
                        <span class="text-sm"
                            >{{ selectedTicket.price || 'N/A' }} USD</span
                        >
                    </div>

                    <!-- QR Code / Placeholder -->
                    <div class="mt-4 flex justify-center">
                        <div
                            class="flex h-40 w-40 items-center justify-center rounded-lg bg-gray-200 text-xs text-gray-400"
                        >
                             <QRCodeVue :value="qrData" :size="120" />
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-6 flex justify-center">
                    <button
                        @click="close"
                        class="rounded-full bg-blue-500 px-6 py-2 font-semibold text-white shadow-lg transition hover:bg-blue-300"
                    >
                        Close
                    </button>
                </div>

                <!-- Decorative line to simulate boarding pass perforation -->
                <div
                    class="absolute top-32 left-0 w-full border-t border-dashed border-gray-300"
                ></div>
            </div>
        </div>
    </div>
</template>

<style scoped>
table {
    width: 100%;
    border-spacing: 0;
}
th,
td {
    padding: 0.75rem 1rem;
    text-align: left;
}
</style>
