<script setup>
import { ref, reactive, onMounted } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'

// === State ===
const occupiedSeats = ref(['1A', '1B', '2C', '3E', '4F', '5G', '6H', '7I'])
const selectedClass = ref('economy')
const totalSeats = 100

const seatClasses = [
  { id: 'first', name: 'First Class', color: 'bg-yellow-500' },
  { id: 'business', name: 'Business Class', color: 'bg-blue-600' },
  { id: 'economy', name: 'Economy Class', color: 'bg-green-600' },
]

const zones = reactive([
  { id: 'first', name: 'First Class', rows: [1, 2], seatClass: 'first' },
  { id: 'business', name: 'Business Class', rows: [3, 4, 5], seatClass: 'business' },
  { id: 'economy', name: 'Economy Class', rows: [6, 7, 8, 9, 10], seatClass: 'economy' },
])

const summary = ref({ total: totalSeats, occupied: occupiedSeats.value.length })

// === Functions ===
const toggleSeat = (id) => {
  if (occupiedSeats.value.includes(id)) {
    occupiedSeats.value = occupiedSeats.value.filter((s) => s !== id)
  } else {
    occupiedSeats.value.push(id)
  }
  updateSummary()
}

const updateSummary = () => {
  summary.value.occupied = occupiedSeats.value.length
}

const resetLayout = () => {
  occupiedSeats.value = []
  updateSummary()
}

const exportSeats = () => {
  const data = JSON.stringify({ occupied: occupiedSeats.value }, null, 2)
  const blob = new Blob([data], { type: 'application/json' })
  const url = URL.createObjectURL(blob)
  const a = document.createElement('a')
  a.href = url
  a.download = 'occupied-seats.json'
  a.click()
  URL.revokeObjectURL(url)
}
</script>

<template>
  <Head title="Seat Management" />
  <AppLayout>
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100">
      <!-- Header -->
      <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-700 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
          <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400">Seat Management</h1>
          <button
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition"
          >
            + Configure Layout
          </button>
        </div>
      </header>

      <!-- Main Content -->
      <main class="container mx-auto px-4 py-8">
        <!-- Seat class legend -->
        <div class="flex flex-wrap justify-center gap-4 mb-8">
          <div v-for="cls in seatClasses" :key="cls.id" class="flex items-center gap-2">
            <div :class="[cls.color, 'w-5 h-5 rounded']"></div>
            <span class="font-medium">{{ cls.name }}</span>
          </div>
          <div class="flex items-center gap-2">
            <div class="bg-red-600 w-5 h-5 rounded"></div>
            <span class="font-medium">Occupied</span>
          </div>
        </div>

        <!-- Action buttons -->
        <div class="flex justify-center gap-4 mb-6">
          <button @click="resetLayout" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition">
            Reset Seats
          </button>
          <button @click="exportSeats" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
            Export Occupied
          </button>
        </div>

        <!-- Seat Map -->
        <div class="space-y-8">
          <div v-for="zone in zones" :key="zone.id" class="p-6 rounded-2xl shadow-lg"
            :class="{
              'bg-yellow-50 border-yellow-200': zone.id === 'first',
              'bg-blue-50 border-blue-200': zone.id === 'business',
              'bg-green-50 border-green-200': zone.id === 'economy',
            }"
          >
            <h2 class="text-xl font-bold mb-4 text-center text-gray-800 dark:text-gray-100">
              {{ zone.name }}
            </h2>

            <!-- Seat Rows -->
            <div v-for="r in zone.rows" :key="r" class="flex justify-center gap-6 mb-3 flex-wrap">
              <!-- Left side -->
              <div class="flex gap-2">
                <div
                  v-for="l in ['A', 'B', 'C', 'D', 'E']"
                  :key="l"
                  @click="toggleSeat(r + l)"
                  class="w-10 h-10 flex items-center justify-center font-bold rounded-lg text-white cursor-pointer transition transform hover:-translate-y-1"
                  :class="[
                    occupiedSeats.includes(r + l)
                      ? 'bg-red-600'
                      : zone.id === 'first'
                      ? 'bg-yellow-500'
                      : zone.id === 'business'
                      ? 'bg-blue-600'
                      : 'bg-green-600'
                  ]"
                  :title="`Seat ${r + l} - ${
                    occupiedSeats.includes(r + l) ? 'Reserved' : 'Available'
                  }`"
                >
                  {{ l }}
                </div>
              </div>

              <!-- Aisle -->
              <div class="flex items-center justify-center w-12 text-gray-500 font-semibold text-xs">
                AISLE
              </div>

              <!-- Right side -->
              <div class="flex gap-2">
                <div
                  v-for="r2 in ['F', 'G', 'H', 'I', 'J']"
                  :key="r2"
                  @click="toggleSeat(r + r2)"
                  class="w-10 h-10 flex items-center justify-center font-bold rounded-lg text-white cursor-pointer transition transform hover:-translate-y-1"
                  :class="[
                    occupiedSeats.includes(r + r2)
                      ? 'bg-red-600'
                      : zone.id === 'first'
                      ? 'bg-yellow-500'
                      : zone.id === 'business'
                      ? 'bg-blue-600'
                      : 'bg-green-600'
                  ]"
                  :title="`Seat ${r + r2} - ${
                    occupiedSeats.includes(r + r2) ? 'Reserved' : 'Available'
                  }`"
                >
                  {{ r2 }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Seat Summary -->
        <div class="mt-8 text-center text-gray-700 dark:text-gray-300 font-medium">
          <p>
            <strong>Total Seats:</strong> {{ summary.total }} &nbsp;•&nbsp;
            <strong>Occupied:</strong> {{ summary.occupied }} &nbsp;•&nbsp;
            <strong>Available:</strong> {{ summary.total - summary.occupied }}
          </p>
        </div>
      </main>
    </div>
  </AppLayout>
</template>

<style scoped>
button {
  transition: all 0.2s ease;
}
</style>
