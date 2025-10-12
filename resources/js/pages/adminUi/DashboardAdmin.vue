<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import Sidebar from './NewSideBar.vue'
import { ref, onMounted, computed } from 'vue'

// Mock data
const stats = ref({
  totalFlights: 247,
  totalBookings: 1843,
  totalPassengers: 5234,
  totalIncome: 1254300,
  seatOccupancy: 78,
  upcomingFlights: 12,
  delayedFlights: 3,
  recentBookings: 28
})

const recentBookings = ref([
  { id: 'BK001', flight: 'SW501', passenger: 'John Doe', date: '2024-01-15', status: 'Confirmed' },
  { id: 'BK002', flight: 'SW502', passenger: 'Jane Smith', date: '2024-01-15', status: 'Pending' },
  { id: 'BK003', flight: 'SW503', passenger: 'Mike Johnson', date: '2024-01-14', status: 'Confirmed' },
  { id: 'BK004', flight: 'SW504', passenger: 'Sarah Wilson', date: '2024-01-14', status: 'Cancelled' },
  { id: 'BK005', flight: 'SW505', passenger: 'Chris Brown', date: '2024-01-13', status: 'Confirmed' },
])

const upcomingFlights = ref([
  { id: 'SW506', route: 'Manila - Cebu', departure: '2024-01-15 08:00', status: 'On Time' },
  { id: 'SW507', route: 'Cebu - Davao', departure: '2024-01-15 10:30', status: 'On Time' },
  { id: 'SW508', route: 'Manila - Palawan', departure: '2024-01-15 12:15', status: 'Delayed' },
  { id: 'SW509', route: 'Davao - Manila', departure: '2024-01-15 14:45', status: 'On Time' },
])


onMounted(() => {
  // Fetch dashboard data if needed
})

const page = usePage();
const userinfo = computed(() => page.props.UserData ?? [])


</script>

<template>
  <div class="flex min-h-screen bg-gray-50">
    <Sidebar />
    
    <div class="flex-1 ml-64">
      <div class="p-6">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-6">
          <!-- Example card -->
          <div class="rounded-2xl bg-gradient-to-br from-gray-500 to-blue-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-blue-100">Total Users</p>
                <p class="text-3xl font-bold">{{ userinfo.length}}</p>
              </div>
            </div>
          </div>
          <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-green-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-blue-100">Total Flights</p>
                <p class="text-3xl font-bold">{{ stats.totalFlights }}</p>
              </div>
            </div>
          </div>

          <div class="rounded-2xl bg-gradient-to-br from-green-500 to-violet-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-green-100">Total Bookings</p>
                <p class="text-3xl font-bold">{{ stats.totalBookings.toLocaleString() }}</p>
              </div>
            </div>
          </div>

          <div class="rounded-2xl bg-gradient-to-br from-purple-500 to-blue-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-purple-100">Total Passengers</p>
                <p class="text-3xl font-bold">{{ stats.totalPassengers.toLocaleString() }}</p>
              </div>
            </div>
          </div>

          <div class="rounded-2xl bg-gradient-to-br from-orange-500 to-blue-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-orange-100">Total Income</p>
                <p class="text-3xl font-bold">${{ (stats.totalIncome / 1000).toFixed(1) }}K</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Tables Example -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
          <!-- Recent Bookings -->
          <div class="rounded-2xl bg-white p-6 shadow-lg">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Recent Bookings</h3>
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booking ID</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Flight</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Passenger</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="booking in recentBookings" :key="booking.id" class="hover:bg-gray-50">
                  <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ booking.id }}</td>
                  <td class="px-4 py-3 text-sm text-gray-600">{{ booking.flight }}</td>
                  <td class="px-4 py-3 text-sm text-gray-600">{{ booking.passenger }}</td>
                  <td class="px-4 py-3 text-sm text-gray-600">{{ booking.date }}</td>
                  <td class="px-4 py-3">
                    <span :class="{
                      'px-2 py-1 text-xs rounded-full': true,
                      'bg-green-100 text-green-800': booking.status === 'Confirmed',
                      'bg-yellow-100 text-yellow-800': booking.status === 'Pending',
                      'bg-red-100 text-red-800': booking.status === 'Cancelled'
                    }">{{ booking.status }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Upcoming Flights -->
          <div class="rounded-2xl bg-white p-6 shadow-lg">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Upcoming Flights</h3>
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Flight ID</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Route</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Departure</th>
                  <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="flight in upcomingFlights" :key="flight.id" class="hover:bg-gray-50">
                  <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ flight.id }}</td>
                  <td class="px-4 py-3 text-sm text-gray-600">{{ flight.route }}</td>
                  <td class="px-4 py-3 text-sm text-gray-600">{{ flight.departure }}</td>
                  <td class="px-4 py-3">
                    <span :class="{
                      'px-2 py-1 text-xs rounded-full': true,
                      'bg-green-100 text-green-800': flight.status === 'On Time',
                      'bg-yellow-100 text-yellow-800': flight.status === 'Delayed'
                    }">{{ flight.status }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>