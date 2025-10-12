<script setup lang="ts">
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import { format, startOfMonth, endOfMonth, startOfWeek, endOfWeek, addDays, isSameDay, isSameMonth } from 'date-fns'
import Sidebar from './NewSideBar.vue'

// === Types ===
interface Flight {
  id: number
  flightNo: string
  origin: string
  destination: string
  date: string
  time: string
  status: 'On Time' | 'Delayed' | 'Cancelled'
}

// === Demo Flight Data ===
const schedules = ref<Flight[]>([
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
const showAddModal = ref(false)
const showDeleteModal = ref(false)
const selectedFlight = ref<Flight | null>(null)
const selectedDate = ref<string>('')

// === New Flight Form ===
const newFlight = ref<Omit<Flight, 'id'>>({
  flightNo: '',
  origin: '',
  destination: '',
  date: '',
  time: '',
  status: 'On Time'
})

// === Calendar Computation ===
const monthStart = computed(() => startOfMonth(currentMonth.value))
const monthEnd = computed(() => endOfMonth(currentMonth.value))
const calendarStart = computed(() => startOfWeek(monthStart.value, { weekStartsOn: 0 }))
const calendarEnd = computed(() => endOfWeek(monthEnd.value, { weekStartsOn: 0 }))

const days = computed(() => {
  const daysArr: Date[] = []
  let day = calendarStart.value
  while (day <= calendarEnd.value) {
    daysArr.push(day)
    day = addDays(day, 1)
  }
  return daysArr
})

const getFlightsForDay = (date: Date) => {
  return schedules.value.filter((f) => isSameDay(new Date(f.date), date))
}

// === Methods ===
const nextMonth = () => {
  currentMonth.value = addDays(endOfMonth(currentMonth.value), 1)
}

const prevMonth = () => {
  currentMonth.value = addDays(startOfMonth(currentMonth.value), -1)
}

const openAddModal = (date: Date) => {
  selectedDate.value = format(date, 'yyyy-MM-dd')
  newFlight.value = {
    flightNo: '',
    origin: '',
    destination: '',
    date: selectedDate.value,
    time: '08:00',
    status: 'On Time'
  }
  showAddModal.value = true
}

const openEditModal = (flight: Flight) => {
  selectedFlight.value = { ...flight }
  showEditModal.value = true
}

const openNotifyModal = (flight: Flight) => {
  selectedFlight.value = { ...flight }
  showNotifyModal.value = true
}

const openDeleteModal = (flight: Flight) => {
  selectedFlight.value = { ...flight }
  showDeleteModal.value = true
}

const closeModals = () => {
  showEditModal.value = false
  showNotifyModal.value = false
  showAddModal.value = false
  showDeleteModal.value = false
  selectedFlight.value = null
  selectedDate.value = ''
}

const saveChanges = () => {
  if (selectedFlight.value) {
    const index = schedules.value.findIndex((f) => f.id === selectedFlight.value!.id)
    if (index !== -1) {
      schedules.value[index] = { ...selectedFlight.value }
    }
  }
  closeModals()
}

const addNewFlight = () => {
  if (newFlight.value.flightNo && newFlight.value.origin && newFlight.value.destination) {
    const newId = Math.max(...schedules.value.map(f => f.id), 0) + 1
    schedules.value.push({
      id: newId,
      ...newFlight.value
    })
    closeModals()
  } else {
    alert('Please fill in all required fields')
  }
}

const deleteFlight = () => {
  if (selectedFlight.value) {
    const flightNumber = selectedFlight.value.flightNo
    schedules.value = schedules.value.filter(f => f.id !== selectedFlight.value!.id)
    closeModals()
    alert(`Flight ${flightNumber} has been cancelled and deleted successfully.`)
  }
}

const sendNotification = () => {
  if (selectedFlight.value) {
    alert(`Passengers on flight ${selectedFlight.value.flightNo} have been notified.`)
  }
  closeModals()
}

const formatTimeForInput = (timeStr: string) => {
  // Convert "08:30 AM" to "08:30" for input[type="time"]
  if (timeStr.includes('AM') || timeStr.includes('PM')) {
    const [time, period] = timeStr.split(' ')
    let [hours, minutes] = time.split(':')
    if (period === 'PM' && hours !== '12') {
      hours = String(parseInt(hours) + 12)
    } else if (period === 'AM' && hours === '12') {
      hours = '00'
    }
    return `${hours.padStart(2, '0')}:${minutes}`
  }
  return timeStr
}

const formatTimeForDisplay = (timeStr: string) => {
  // Convert "08:30" to "08:30 AM" for display
  if (!timeStr.includes('AM') && !timeStr.includes('PM')) {
    const [hours, minutes] = timeStr.split(':')
    const hourNum = parseInt(hours)
    const period = hourNum >= 12 ? 'PM' : 'AM'
    const displayHour = hourNum % 12 || 12
    return `${displayHour}:${minutes} ${period}`
  }
  return timeStr
}
</script>

<template>
  <Head title="Schedule Management" />
  
  <div class="flex min-h-screen bg-gray-50">
    <Sidebar />
    
    <div class="flex-1 ml-64">
      <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold text-blue-600">Schedule Management</h1>
          <div class="flex gap-2">
            <button @click="prevMonth" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-lg">‹</button>
            <h2 class="text-lg font-semibold">
              {{ format(currentMonth, 'MMMM yyyy') }}
            </h2>
            <button @click="nextMonth" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-lg">›</button>
          </div>
        </div>

        <!-- Calendar -->
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
            :key="day.toString()"
            class="border rounded-lg p-2 min-h-[140px] flex flex-col justify-start relative overflow-y-auto hover:bg-gray-50 transition-colors cursor-pointer"
            :class="{
              'bg-white': isSameMonth(day, currentMonth),
              'bg-gray-100': !isSameMonth(day, currentMonth)
            }"
            @click="openAddModal(day)"
          >
            <div class="flex justify-between items-start mb-1">
              <button 
                class="text-xs bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded opacity-0 hover:opacity-100 transition-opacity"
                @click.stop="openAddModal(day)"
              >
                Add Flight
              </button>
              <div class="font-bold text-sm">{{ format(day, 'd') }}</div>
            </div>

            <div 
              v-for="flight in getFlightsForDay(day)" 
              :key="flight.id" 
              class="text-xs mb-1 rounded-lg p-2 shadow-sm cursor-pointer hover:shadow-md transition-shadow"
              :class="{
                'bg-green-100 text-green-800 border border-green-200': flight.status === 'On Time',
                'bg-yellow-100 text-yellow-800 border border-yellow-200': flight.status === 'Delayed',
                'bg-red-100 text-red-800 border border-red-200': flight.status === 'Cancelled'
              }"
              @click.stop
            >
              <div class="flex justify-between items-center">
                <span class="font-semibold">{{ flight.flightNo }}</span>
                <span>{{ flight.time }}</span>
              </div>
              <div class="flex justify-between items-center mt-1">
                <span>{{ flight.origin }} → {{ flight.destination }}</span>
              </div>
              <div class="flex gap-1 mt-2 justify-end">
                <button @click.stop="openEditModal(flight)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 text-[10px] rounded transition-colors">Edit</button>
                <button @click.stop="openNotifyModal(flight)" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 text-[10px] rounded transition-colors">Notify</button>
                <button @click.stop="openDeleteModal(flight)" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 text-[10px] rounded transition-colors">Delete</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Add Schedule Modal -->
        <div v-if="showAddModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4 text-green-600">Add New Flight</h3>

            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium mb-1">Flight No. *</label>
                <input
                  v-model="newFlight.flightNo"
                  type="text"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                  placeholder="e.g., FL-1101"
                />
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium mb-1">Origin *</label>
                  <input
                    v-model="newFlight.origin"
                    type="text"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="e.g., MNL"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium mb-1">Destination *</label>
                  <input
                    v-model="newFlight.destination"
                    type="text"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="e.g., CEB"
                  />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">Date</label>
                <input
                  v-model="newFlight.date"
                  type="date"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50"
                  readonly
                />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">Time</label>
                <input
                  v-model="newFlight.time"
                  type="time"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select
                  v-model="newFlight.status"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                >
                  <option>On Time</option>
                  <option>Delayed</option>
                  <option>Cancelled</option>
                </select>
              </div>
            </div>

            <div class="flex justify-end mt-6 gap-2">
              <button @click="closeModals" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition-colors">Cancel</button>
              <button @click="addNewFlight" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-colors">Add Flight</button>
            </div>
          </div>
        </div>

        <!-- Edit Schedule Modal -->
        <div v-if="showEditModal && selectedFlight" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4 text-yellow-600">Edit Flight</h3>

            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium mb-1">Flight No.</label>
                <input
                  v-model="selectedFlight.flightNo"
                  type="text"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                />
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium mb-1">Origin</label>
                  <input
                    v-model="selectedFlight.origin"
                    type="text"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium mb-1">Destination</label>
                  <input
                    v-model="selectedFlight.destination"
                    type="text"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                  />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">Date</label>
                <input
                  v-model="selectedFlight.date"
                  type="date"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">Time</label>
                <input
                  :value="formatTimeForInput(selectedFlight.time)"
                  @input="selectedFlight.time = formatTimeForDisplay(($event.target as HTMLInputElement).value)"
                  type="time"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select
                  v-model="selectedFlight.status"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                >
                  <option>On Time</option>
                  <option>Delayed</option>
                  <option>Cancelled</option>
                </select>
              </div>
            </div>

            <div class="flex justify-end mt-6 gap-2">
              <button @click="closeModals" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition-colors">Cancel</button>
              <button @click="saveChanges" class="bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded-lg transition-colors">Save Changes</button>
            </div>
          </div>
        </div>

        <!-- Notify Modal -->
        <div v-if="showNotifyModal && selectedFlight" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4 text-blue-600">Notify Passengers</h3>
            <p class="mb-4 text-gray-700">
              Notify all passengers of flight <strong>{{ selectedFlight.flightNo }}</strong>?
            </p>
            <div class="flex justify-end gap-2">
              <button @click="closeModals" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition-colors">Cancel</button>
              <button @click="sendNotification" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors">Send Notification</button>
            </div>
          </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal && selectedFlight" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
          <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md">
            <div class="text-center">
              <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
              </div>
              <h3 class="text-xl font-bold mb-2 text-red-600">Delete Flight</h3>
              <p class="mb-4 text-gray-700">
                Are you sure you want to delete flight <strong>{{ selectedFlight.flightNo }}</strong>?
              </p>
              <p class="mb-6 text-sm text-red-600 font-medium">
                This action cannot be undone. All flight data will be permanently removed.
              </p>
            </div>
            <div class="flex justify-end gap-2">
              <button @click="closeModals" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition-colors">Cancel</button>
              <button @click="deleteFlight" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors">Confirm Delete</button>
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
::-webkit-scrollbar {
  width: 4px;
}
::-webkit-scrollbar-thumb {
  background: #93c5fd;
  border-radius: 10px;
}
</style>