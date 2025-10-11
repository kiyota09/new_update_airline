<script lang="ts">

import { ref, computed } from 'vue'
import { format, startOfMonth, endOfMonth, startOfWeek, endOfWeek, addDays, isSameDay, isSameMonth } from 'date-fns'

// === Demo Flight Data ===
const schedules = ref([
  { id: 1, flightNo: 'FL-1101', origin: 'MNL', destination: 'CEB', date: '2025-10-11', time: '08:30 AM', status: 'On Time' },
  { id: 2, flightNo: 'FL-1102', origin: 'MNL', destination: 'DVO', date: '2025-10-11', time: '10:00 AM', status: 'Delayed' },
  { id: 3, flightNo: 'FL-1103', origin: 'CEB', destination: 'MNL', date: '2025-10-12', time: '01:15 PM', status: 'Cancelled' },
  { id: 4, flightNo: 'FL-1104', origin: 'MNL', destination: 'ILO', date: '2025-10-12', time: '03:45 PM', status: 'On Time' },
  { id: 5, flightNo: 'FL-1105', origin: 'DVO', destination: 'MNL', date: '2025-10-13', time: '06:00 AM', status: 'On Time' },
])

// === State ===
const currentMonth = ref(new Date('2025-10-01'))
const showEditModal = ref(false)
const showNotifyModal = ref(false)
const selectedFlight = ref(null)

// === Calendar Computation ===
const monthStart = computed(() => startOfMonth(currentMonth.value))
const monthEnd = computed(() => endOfMonth(currentMonth.value))
const calendarStart = computed(() => startOfWeek(monthStart.value, { weekStartsOn: 0 }))
const calendarEnd = computed(() => endOfWeek(monthEnd.value, { weekStartsOn: 0 }))

const days = computed(() => {
  const daysArr = []
  let day = calendarStart.value
  while (day <= calendarEnd.value) {
    daysArr.push(day)
    day = addDays(day, 1)
  }
  return daysArr
})

const getFlightsForDay = (date) => {
  return schedules.value.filter((f) => isSameDay(new Date(f.date), date))
}

// === Methods ===
const nextMonth = () => (currentMonth.value = addDays(endOfMonth(currentMonth.value), 1))
const prevMonth = () => (currentMonth.value = addDays(startOfMonth(currentMonth.value), -1))

const openEditModal = (flight) => {
  selectedFlight.value = { ...flight }
  showEditModal.value = true
}
const openNotifyModal = (flight) => {
  selectedFlight.value = { ...flight }
  showNotifyModal.value = true
}
const closeModals = () => {
  showEditModal.value = false
  showNotifyModal.value = false
}
const saveChanges = () => {
  const index = schedules.value.findIndex((f) => f.id === selectedFlight.value.id)
  if (index !== -1) schedules.value[index] = { ...selectedFlight.value }
  closeModals()
}
const sendNotification = () => {
  alert(`Passengers on flight ${selectedFlight.value.flightNo} have been notified.`)
  closeModals()
}
</script>

<template>
  <Head title="Schedule Management" />
  
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100">
      <!-- Header -->
      <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-700 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
          <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400">Schedule Management</h1>
          <div class="flex gap-2">
            <button @click="prevMonth" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-lg">‹</button>
            <h2 class="text-lg font-semibold">
              {{ format(currentMonth, 'MMMM yyyy') }}
            </h2>
            <button @click="nextMonth" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-lg">›</button>
          </div>
        </div>
      </header>

      <!-- Calendar -->
      <main class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-7 text-center font-semibold text-gray-600 mb-2">
          <div>Sun</div>
          <div>Mon</div>
          <div>Tue</div>
          <div>Wed</div>
          <div>Thu</div>
          <div>Fri</div>
          <div>Sat</div>
        </div>

        <div class="grid grid-cols-7 gap-2">
          <div
            v-for="day in days"
            :key="day"
            class="border rounded-lg p-2 min-h-[140px] flex flex-col justify-start relative overflow-y-auto"
            :class="{
              'bg-white dark:bg-gray-800': isSameMonth(day, currentMonth),
              'bg-gray-100 dark:bg-gray-700': !isSameMonth(day, currentMonth)
            }"
          >
            <div class="font-bold mb-1 text-sm text-right">{{ format(day, 'd') }}</div>

            <div v-for="flight in getFlightsForDay(day)" :key="flight.id" class="text-xs mb-1 rounded-lg p-2 shadow-sm cursor-pointer"
              :class="{
                'bg-green-100 text-green-800': flight.status === 'On Time',
                'bg-yellow-100 text-yellow-800': flight.status === 'Delayed',
                'bg-red-100 text-red-800': flight.status === 'Cancelled'
              }"
            >
              <div class="flex justify-between items-center">
                <span class="font-semibold">{{ flight.flightNo }}</span>
                <span>{{ flight.time }}</span>
              </div>
              <div class="flex justify-between items-center mt-1">
                <span>{{ flight.origin }} → {{ flight.destination }}</span>
              </div>
              <div class="flex gap-1 mt-2 justify-end">
                <button @click.stop="openEditModal(flight)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 text-[10px] rounded">Edit</button>
                <button @click.stop="openNotifyModal(flight)" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 text-[10px] rounded">Notify</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Reschedule Modal -->
        <div v-if="showEditModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4 text-yellow-600">Reschedule Flight</h3>

            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium mb-1">Flight No.</label>
                <input
                  v-model="selectedFlight.flightNo"
                  type="text"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 dark:bg-gray-700"
                  readonly
                />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">New Date</label>
                <input
                  v-model="selectedFlight.date"
                  type="date"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 dark:bg-gray-700"
                />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">New Time</label>
                <input
                  v-model="selectedFlight.time"
                  type="time"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 dark:bg-gray-700"
                />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select
                  v-model="selectedFlight.status"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 dark:bg-gray-700"
                >
                  <option>On Time</option>
                  <option>Delayed</option>
                  <option>Cancelled</option>
                </select>
              </div>
            </div>

            <div class="flex justify-end mt-6 gap-2">
              <button @click="closeModals" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg">Cancel</button>
              <button @click="saveChanges" class="bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded-lg">Save</button>
            </div>
          </div>
        </div>

        <!-- Notify Modal -->
        <div v-if="showNotifyModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4 text-blue-600">Notify Passengers</h3>
            <p class="mb-4 text-gray-700 dark:text-gray-300">
              Notify all passengers of flight <strong>{{ selectedFlight.flightNo }}</strong>?
            </p>
            <div class="flex justify-end gap-2">
              <button @click="closeModals" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg">Cancel</button>
              <button @click="sendNotification" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">Send</button>
            </div>
          </div>
        </div>
      </main>
    </div>
 
 </template>

<style scoped>
button {
  transition: all 0.2s ease;
}
::-webkit-scrollbar {
  width: 4px;
}
::-webkit-scrollbar-thumb {
  background: #93c5fd;
  border-radius: 10px;
}
</style>
