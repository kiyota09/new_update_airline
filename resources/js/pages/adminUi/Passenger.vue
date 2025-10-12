<script setup>
import { ref } from 'vue'
import Sidebar from './NewSideBar.vue'

// Dummy passengers (replace with backend data later)
const passengers = ref([
  {
    id: 1,
    name: 'John Dela Cruz',
    email: 'john@example.com',
    contact: '09171234567',
    nationality: 'Filipino',
    totalFlights: 12,
    status: 'Active'
  },
  {
    id: 2,
    name: 'Maria Santos',
    email: 'maria@example.com',
    contact: '09181234567',
    nationality: 'Filipino',
    totalFlights: 7,
    status: 'Pending Refund'
  },
  {
    id: 3,
    name: 'Alex Mendoza',
    email: 'alex@example.com',
    contact: '09221234567',
    nationality: 'Filipino',
    totalFlights: 5,
    status: 'Complaint Filed'
  }
])

const selectedPassenger = ref(null)
const showProfileModal = ref(false)
const showHistoryModal = ref(false)

// Actions
const viewProfile = (passenger) => {
  selectedPassenger.value = passenger
  showProfileModal.value = true
}

const viewHistory = (passenger) => {
  selectedPassenger.value = passenger
  showHistoryModal.value = true
}

const closeModals = () => {
  showProfileModal.value = false
  showHistoryModal.value = false
}
</script>

<template>
  <Head title="Passenger Management" />

  <div class="flex min-h-screen bg-gray-50">
    <Sidebar />
    
    <div class="flex-1 ml-64">
      <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Passenger Management</h1>
            <p class="text-gray-600">Manage passenger information and travel history</p>
          </div>
          <button
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition"
          >
            + Add Passenger
          </button>
        </div>

        <!-- Section Header -->
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-bold text-gray-700">
            Registered Passengers
          </h2>
          <input
            type="text"
            placeholder="Search by name or email..."
            class="border border-gray-300 rounded-lg px-4 py-2 text-sm bg-gray-50"
          />
        </div>

        <!-- Passenger Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
          <table class="w-full text-left border-collapse">
            <thead class="bg-blue-600 text-white">
              <tr>
                <th class="py-3 px-4">#</th>
                <th class="py-3 px-4">Name</th>
                <th class="py-3 px-4">Email</th>
                <th class="py-3 px-4">Contact</th>
                <th class="py-3 px-4">Nationality</th>
                <th class="py-3 px-4">Flights</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4 text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="passenger in passengers"
                :key="passenger.id"
                class="border-b border-gray-200 hover:bg-gray-50 transition"
              >
                <td class="py-3 px-4">{{ passenger.id }}</td>
                <td class="py-3 px-4 font-medium">{{ passenger.name }}</td>
                <td class="py-3 px-4">{{ passenger.email }}</td>
                <td class="py-3 px-4">{{ passenger.contact }}</td>
                <td class="py-3 px-4">{{ passenger.nationality }}</td>
                <td class="py-3 px-4 text-center">{{ passenger.totalFlights }}</td>
                <td class="py-3 px-4">
                  <span
                    class="px-3 py-1 rounded-full text-sm font-medium"
                    :class="{
                      'bg-green-100 text-green-700': passenger.status === 'Active',
                      'bg-yellow-100 text-yellow-700': passenger.status === 'Pending Refund',
                      'bg-red-100 text-red-700': passenger.status === 'Complaint Filed'
                    }"
                    >{{ passenger.status }}</span
                  >
                </td>
                <td class="py-3 px-4 flex justify-center gap-2">
                  <button
                    @click="viewProfile(passenger)"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm py-1 px-3 rounded"
                  >
                    View
                  </button>
                  <button
                    @click="viewHistory(passenger)"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-1 px-3 rounded"
                  >
                    History
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Summary -->
        <div
          class="mt-8 text-center text-gray-700 font-medium"
        >
          <p>Total Registered Passengers: {{ passengers.length }}</p>
        </div>

        <!-- Passenger Profile Modal -->
        <div
          v-if="showProfileModal"
          class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
          <div
            class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md"
          >
            <h3 class="text-xl font-bold mb-4 text-blue-600">
              Passenger Profile
            </h3>
            <p><strong>Name:</strong> {{ selectedPassenger.name }}</p>
            <p><strong>Email:</strong> {{ selectedPassenger.email }}</p>
            <p><strong>Contact:</strong> {{ selectedPassenger.contact }}</p>
            <p><strong>Nationality:</strong> {{ selectedPassenger.nationality }}</p>
            <p><strong>Total Flights:</strong> {{ selectedPassenger.totalFlights }}</p>
            <p><strong>Status:</strong> {{ selectedPassenger.status }}</p>

            <div class="flex justify-end mt-6 gap-2">
              <button
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg"
                @click="closeModals"
              >
                Close
              </button>
              <button
                class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg"
              >
                Edit
              </button>
            </div>
          </div>
        </div>

        <!-- Travel History Modal -->
        <div
          v-if="showHistoryModal"
          class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
          <div
            class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-2xl"
          >
            <h3 class="text-xl font-bold mb-4 text-blue-600">
              Travel History — {{ selectedPassenger.name }}
            </h3>
            <table class="w-full text-left border-collapse">
              <thead class="bg-blue-100">
                <tr>
                  <th class="py-2 px-4">Date</th>
                  <th class="py-2 px-4">Flight</th>
                  <th class="py-2 px-4">Route</th>
                  <th class="py-2 px-4">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr class="border-b border-gray-200">
                  <td class="py-2 px-4">2025-09-10</td>
                  <td class="py-2 px-4">FL-102</td>
                  <td class="py-2 px-4">Manila → Cebu</td>
                  <td class="py-2 px-4 text-green-600 font-medium">Completed</td>
                </tr>
                <tr class="border-b border-gray-200">
                  <td class="py-2 px-4">2025-08-22</td>
                  <td class="py-2 px-4">FL-076</td>
                  <td class="py-2 px-4">Cebu → Davao</td>
                  <td class="py-2 px-4 text-yellow-600 font-medium">Refunded</td>
                </tr>
              </tbody>
            </table>

            <div class="flex justify-end mt-6">
              <button
                class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg"
                @click="closeModals"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
button {
  transition: all 0.2s ease;
}
</style>