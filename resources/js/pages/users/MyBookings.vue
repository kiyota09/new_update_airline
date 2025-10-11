<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { ref } from 'vue'

// === Demo Data (replace with backend later) ===

// Booked Flights
const bookedFlights = ref([
  {
    id: 1,
    flightNo: 'SW-301',
    origin: 'Manila (MNL)',
    destination: 'Cebu (CEB)',
    date: '2025-10-15',
    time: '08:30 AM',
    status: 'Confirmed',
    seat: '12A',
  },
  {
    id: 2,
    flightNo: 'SW-402',
    origin: 'Cebu (CEB)',
    destination: 'Davao (DVO)',
    date: '2025-10-20',
    time: '02:15 PM',
    status: 'Pending',
    seat: '7C',
  },
  {
    id: 3,
    flightNo: 'SW-220',
    origin: 'Manila (MNL)',
    destination: 'Iloilo (ILO)',
    date: '2025-11-05',
    time: '09:00 AM',
    status: 'Cancelled',
    seat: '15B',
  },
])

// Payment Transactions
const transactions = ref([
  {
    id: 1,
    date: '2025-10-10',
    reference: 'TXN-241019A',
    method: 'Credit Card',
    amount: 499.0,
    status: 'Completed',
  },
  {
    id: 2,
    date: '2025-10-12',
    reference: 'TXN-241021B',
    method: 'GCash',
    amount: 799.0,
    status: 'Pending',
  },
  {
    id: 3,
    date: '2025-10-13',
    reference: 'TXN-241022C',
    method: 'PayPal',
    amount: 299.0,
    status: 'Refunded',
  },
])
</script>

<template>
  <Head title="My Bookings - SkyWings" />
  <AppLayout>
    <div
      class="min-h-screen bg-gradient-to-b from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100"
    >
      <!-- HEADER -->
      <header
        class="bg-white/80 backdrop-blur-sm border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-700 sticky top-0 z-50"
      >
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
          <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400">
            My Bookings
          </h1>
        </div>
      </header>

      <main class="container mx-auto px-4 py-8 space-y-12">
        <!-- ✈️ Booked Flights Section -->
        <section>
          <h2 class="text-xl font-bold mb-4 text-blue-600 dark:text-blue-400">
            Flight Bookings
          </h2>

          <div
            v-if="bookedFlights.length"
            class="overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-xl"
          >
            <table class="w-full border-collapse">
              <thead class="bg-blue-600 text-white">
                <tr>
                  <th class="py-3 px-4 text-left">Flight No.</th>
                  <th class="py-3 px-4 text-left">Route</th>
                  <th class="py-3 px-4 text-left">Date</th>
                  <th class="py-3 px-4 text-left">Time</th>
                  <th class="py-3 px-4 text-left">Seat</th>
                  <th class="py-3 px-4 text-left">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="flight in bookedFlights"
                  :key="flight.id"
                  class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                >
                  <td class="py-3 px-4 font-medium">{{ flight.flightNo }}</td>
                  <td class="py-3 px-4">
                    {{ flight.origin }} → {{ flight.destination }}
                  </td>
                  <td class="py-3 px-4">{{ flight.date }}</td>
                  <td class="py-3 px-4">{{ flight.time }}</td>
                  <td class="py-3 px-4">{{ flight.seat }}</td>
                  <td class="py-3 px-4">
                    <span
                      class="px-3 py-1 rounded-full text-sm font-medium"
                      :class="{
                        'bg-green-100 text-green-700': flight.status === 'Confirmed',
                        'bg-yellow-100 text-yellow-700': flight.status === 'Pending',
                        'bg-red-100 text-red-700': flight.status === 'Cancelled',
                      }"
                    >
                      {{ flight.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <p v-else class="text-gray-500 dark:text-gray-400 mt-4 text-center">
            You have no booked flights yet.
          </p>
        </section>

        <!-- 💳 Payment Transactions Section -->
        <section>
          <h2 class="text-xl font-bold mb-4 text-blue-600 dark:text-blue-400">
            Payment Transactions
          </h2>

          <div
            v-if="transactions.length"
            class="overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-xl"
          >
            <table class="w-full border-collapse">
              <thead class="bg-blue-600 text-white">
                <tr>
                  <th class="py-3 px-4 text-left">Date</th>
                  <th class="py-3 px-4 text-left">Reference</th>
                  <th class="py-3 px-4 text-left">Method</th>
                  <th class="py-3 px-4 text-left">Amount</th>
                  <th class="py-3 px-4 text-left">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="txn in transactions"
                  :key="txn.id"
                  class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                >
                  <td class="py-3 px-4">{{ txn.date }}</td>
                  <td class="py-3 px-4 font-medium">{{ txn.reference }}</td>
                  <td class="py-3 px-4">{{ txn.method }}</td>
                  <td class="py-3 px-4">$ {{ txn.amount.toFixed(2) }}</td>
                  <td class="py-3 px-4">
                    <span
                      class="px-3 py-1 rounded-full text-sm font-medium"
                      :class="{
                        'bg-green-100 text-green-700': txn.status === 'Completed',
                        'bg-yellow-100 text-yellow-700': txn.status === 'Pending',
                        'bg-red-100 text-red-700': txn.status === 'Refunded',
                      }"
                    >
                      {{ txn.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <p v-else class="text-gray-500 dark:text-gray-400 mt-4 text-center">
            No payment transactions found.
          </p>
        </section>
      </main>
    </div>
  </AppLayout>
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
