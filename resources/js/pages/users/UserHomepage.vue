<script setup lang="ts">
import topbar from '@/components/Topbar.vue'
import { useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

interface Airport {
  id: number
  country: string
  city: string
  airport: string
}

interface FlightClass {
  id: string
  name: string
}

interface Destination {
  id: number
  name: string
  image: string
  price: string
  perDay: string
  description: string
}

interface Booking {
  id: number
  destination: string
  image: string
  flightNumber: string
  date: string
  status: 'Paid' | 'Pending' | 'Cancelled'
}

const form = useForm({
  departure: '',
  destination: '',
  departureDate: '',
  returnDate: '',
  passengers: '1',
  tripType: 'round-trip',
  flightClasses: 'economy',
})

const departureSearch = ref('')
const destinationSearch = ref('')
const filteredDeparture = ref<Airport[]>([])
const filteredDestination = ref<Airport[]>([])

const flightClasses: FlightClass[] = [
  { id: 'economy', name: 'Economy Class' },
  { id: 'premium', name: 'Premium Economy' },
  { id: 'business', name: 'Business Class' },
  { id: 'first', name: 'First Class' },
]

// 🌍 Featured destinations
const featuredDestinations: Destination[] = [
  {
    id: 1,
    name: 'Paris',
    image:
      'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1000&q=80',
    price: '$499',
    perDay: '$180',
    description:
      'Experience the romance of the City of Lights with exquisite cuisine, art, and architecture.',
  },
  {
    id: 2,
    name: 'Tokyo',
    image:
      'https://images.unsplash.com/photo-1549692520-acc6669e2f0c?auto=format&fit=crop&w=1000&q=80',
    price: '$799',
    perDay: '$210',
    description:
      'Immerse yourself in a perfect blend of tradition and innovation in Japan\'s capital.',
  },
  {
    id: 3,
    name: 'New York',
    image:
      'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1000&q=80',
    price: '$399',
    perDay: '$150',
    description:
      'The city that never sleeps – iconic landmarks, culture, and world-class dining await.',
  },
  {
    id: 4,
    name: 'Bali',
    image:
      'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1000&q=80',
    price: '$699',
    perDay: '$130',
    description:
      'Relax in tropical paradise – pristine beaches, lush jungles, and luxury resorts.',
  },
]

// ✈️ Sample bookings (mock data)
const bookings: Booking[] = [
  {
    id: 1,
    destination: 'Paris',
    image:
      'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1000&q=80',
    flightNumber: 'SKY1234',
    date: '2025-10-20',
    status: 'Paid',
  },
  {
    id: 2,
    destination: 'Tokyo',
    image:
      'https://images.unsplash.com/photo-1549692520-acc6669e2f0c?auto=format&fit=crop&w=1000&q=80',
    flightNumber: 'SKY5678',
    date: '2025-11-05',
    status: 'Pending',
  },
  {
    id: 3,
    destination: 'Bali',
    image:
      'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=800&q=80',
    flightNumber: 'SKY9012',
    date: '2025-12-10',
    status: 'Cancelled',
  },
]

// ✈️ Booking Modal Controls
const showModal = ref(false)
const selectedDestination = ref<Destination | null>(null)

// 🧾 Booking Form (used in the booking modal)
const bookingForm = ref({
  departure: '',
  tripType: 'round-trip',
  departureDate: '',
  returnDate: '',
  passengers: 1,
  flightClasses: 'economy',
})

const openModal = (destination: Destination) => {
  selectedDestination.value = destination
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedDestination.value = null
}

// ✈️ Payment Confirmation Modal Controls
const showPaymentModal = ref(false)

const confirmPayment = () => {
  showPaymentModal.value = true
}

const cancelPayment = () => {
  showPaymentModal.value = false
}

const finalizePayment = () => {
  alert(`Payment successful for ${selectedDestination.value?.name}`)
  showPaymentModal.value = false
  closeModal()
}

// Dummy airports
const airports = [
  { id: 1, country: 'Philippines', city: 'Manila', airport: 'Ninoy Aquino International Airport (MNL)' },
  { id: 2, country: 'Japan', city: 'Tokyo', airport: 'Narita International Airport (NRT)' },
  { id: 3, country: 'France', city: 'Paris', airport: 'Charles de Gaulle Airport (CDG)' },
]

const searchFlights = () => {
  form.post('/booking')
}

// Filter search
watch(departureSearch, (val) => {
  filteredDeparture.value = airports.filter(
    (a) =>
      a.city.toLowerCase().includes(val.toLowerCase()) ||
      a.airport.toLowerCase().includes(val.toLowerCase()),
  )
})
watch(destinationSearch, (val) => {
  filteredDestination.value = airports.filter(
    (a) =>
      a.city.toLowerCase().includes(val.toLowerCase()) ||
      a.airport.toLowerCase().includes(val.toLowerCase()),
  )
})
</script>

<template>
  <topbar />

  <!-- Hero + Search Section -->
  <section class="relative overflow-hidden py-16 md:py-24">
    <div
      class="absolute inset-0 z-0 bg-gradient-to-r from-blue-600/10 to-blue-400/10 dark:from-blue-900/20 dark:to-blue-700/20"
    ></div>
    <div class="relative z-10 container mx-auto px-4">
      <div class="mx-auto mb-12 max-w-4xl text-center">
        <h1 class="mb-4 text-4xl font-bold md:text-5xl lg:text-6xl">
          Travel the World with
          <span class="text-blue-600 dark:text-blue-400">SkyWings</span>
        </h1>
        <p class="mx-auto mb-8 max-w-2xl text-lg text-gray-600 md:text-xl dark:text-gray-300">
          Experience premium comfort and exceptional service to over 120 destinations worldwide.
        </p>
      </div>

      <!-- Flight Search Form -->
      <div class="mx-auto max-w-4xl rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-800">
        <div class="mb-6 flex flex-wrap gap-4">
          <div class="flex items-center space-x-2">
            <input
              type="radio"
              id="round-trip"
              v-model="form.tripType"
              value="round-trip"
              class="text-blue-600 focus:ring-blue-500"
            />
            <label for="round-trip" class="text-sm font-medium">Round Trip</label>
          </div>
          <div class="flex items-center space-x-2">
            <input
              type="radio"
              id="one-way"
              v-model="form.tripType"
              value="one-way"
              class="text-blue-600 focus:ring-blue-500"
            />
            <label for="one-way" class="text-sm font-medium">One Way</label>
          </div>
        </div>

        <!-- Inputs -->
        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
          <div class="relative">
            <label class="mb-1 block text-sm font-medium">From</label>
            <input
              type="text"
              v-model="departureSearch"
              placeholder="Type city or airport"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
            <ul
              v-if="departureSearch && filteredDeparture.length"
              class="absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-lg border bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
            >
              <li
                v-for="airport in filteredDeparture"
                :key="airport.id"
                @click="
                  form.departure = airport.airport;
                  departureSearch = airport.city + ' - ' + airport.airport;
                  filteredDeparture = [];
                "
                class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-700"
              >
                {{ airport.city }} - {{ airport.airport }}
              </li>
            </ul>
          </div>

          <div class="relative">
            <label class="mb-1 block text-sm font-medium">To</label>
            <input
              type="text"
              v-model="destinationSearch"
              placeholder="Type city or airport"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
            <ul
              v-if="destinationSearch && filteredDestination.length"
              class="absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-lg border bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
            >
              <li
                v-for="airport in filteredDestination"
                :key="airport.id"
                @click="
                  form.destination = airport.airport;
                  destinationSearch = airport.city + ' - ' + airport.airport;
                  filteredDestination = [];
                "
                class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-700"
              >
                {{ airport.city }} - {{ airport.airport }}
              </li>
            </ul>
          </div>

          <div>
            <label class="mb-1 block text-sm font-medium">Class</label>
            <select
              v-model="form.flightClasses"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            >
              <option
                v-for="flightClass in flightClasses"
                :key="flightClass.id"
                :value="flightClass.id"
              >
                {{ flightClass.name }}
              </option>
            </select>
          </div>
        </div>

        <!-- Dates & Passengers -->
        <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-4">
          <div>
            <label class="mb-1 block text-sm font-medium">Departure</label>
            <input
              type="date"
              v-model="form.departureDate"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
          </div>
          <div>
            <label class="mb-1 block text-sm font-medium">Return</label>
            <input
              type="date"
              v-model="form.returnDate"
              :disabled="form.tripType === 'one-way'"
              :class="form.tripType === 'one-way' ? 'bg-gray-100 dark:bg-gray-600' : ''"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
          </div>
          <div>
            <label class="mb-1 block text-sm font-medium">Passengers</label>
            <select
              v-model="form.passengers"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            >
              <option value="1">1 Passenger</option>
              <option value="2">2 Passengers</option>
              <option value="3">3 Passengers</option>
              <option value="4">4 Passengers</option>
              <option value="5">5+ Passengers</option>
            </select>
          </div>
          <div class="flex items-end">
            <button
              @click="searchFlights"
              class="flex w-full items-center justify-center rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700"
            >
              Search Flights
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 🌍 Featured Destinations -->
  <section class="bg-gray-50 py-16 dark:bg-gray-900">
    <div class="container mx-auto px-4">
      <h2 class="mb-12 text-center text-3xl font-bold">Popular Destinations</h2>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="destination in featuredDestinations"
          :key="destination.id"
          class="overflow-hidden rounded-xl shadow-lg bg-white dark:bg-gray-800 transition-transform hover:scale-105"
        >
          <img :src="destination.image" :alt="destination.name" class="h-48 w-full object-cover" />
          <div class="p-4">
            <h3 class="text-lg font-bold">{{ destination.name }}</h3>
            <p class="text-sm text-gray-500">From {{ destination.price }}</p>
            <button
              @click="openModal(destination)"
              class="mt-3 w-full rounded-lg bg-blue-600 px-4 py-2 text-white font-semibold hover:bg-blue-700 transition"
            >
              Book
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Booking Modal -->
  <div
    v-if="showModal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
  >
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-11/12 md:w-1/2 p-6 relative max-h-[90vh] overflow-hidden flex flex-col">
      <button
        @click="closeModal"
        class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 dark:hover:text-white z-10"
      >
        ✕
      </button>

      <!-- NOTE: modal content is scrollable (flex-1 + overflow-y-auto) so long forms can scroll -->
      <div v-if="selectedDestination" class="space-y-4 flex-1 overflow-y-auto pr-2">
        <!-- Destination Image & Name -->
        <img
          :src="selectedDestination.image"
          :alt="selectedDestination.name"
          class="w-full h-48 object-cover rounded-xl"
        />
        <h2 class="text-2xl font-bold">{{ selectedDestination.name }}</h2>
        <p class="text-gray-600 dark:text-gray-300">{{ selectedDestination.description }}</p>

        <!-- Booking Details Form -->
        <div class="grid grid-cols-1 gap-4 mt-4">
          <div>
            <label class="block text-sm font-medium mb-1">Departure Airport</label>
            <select
              v-model="bookingForm.departure"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            >
              <option value="">Select Departure Airport</option>
              <option v-for="airport in airports" :key="airport.id" :value="airport.airport">
                {{ airport.city }} - {{ airport.airport }}
              </option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Trip Type</label>
            <select
              v-model="bookingForm.tripType"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            >
              <option value="round-trip">Round Trip</option>
              <option value="one-way">One Way</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Departure Date</label>
            <input
              type="date"
              v-model="bookingForm.departureDate"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
          </div>

          <div v-if="bookingForm.tripType === 'round-trip'">
            <label class="block text-sm font-medium mb-1">Return Date</label>
            <input
              type="date"
              v-model="bookingForm.returnDate"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Passengers</label>
            <input
              type="number"
              min="1"
              v-model.number="bookingForm.passengers"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Flight Class</label>
            <select
              v-model="bookingForm.flightClasses"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            >
              <option v-for="fc in flightClasses" :key="fc.id" :value="fc.id">
                {{ fc.name }}
              </option>
            </select>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
          <div>
            <p class="text-lg font-semibold">
              Total:
              {{
                '$' +
                (parseInt(selectedDestination.price.replace('$', '')) *
                  bookingForm.passengers)
              }}
            </p>
          </div>
          <button
            @click="confirmPayment"
            class="rounded-lg bg-green-600 px-6 py-2 text-white font-semibold hover:bg-green-700"
          >
            Confirm Booking
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Payment Modal -->
  <div
    v-if="showPaymentModal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
  >
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-11/12 md:w-1/3 p-6 relative">
      <button
        @click="cancelPayment"
        class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 dark:hover:text-white"
      >
        ✕
      </button>

      <h2 class="text-2xl font-bold mb-4">Payment Confirmation</h2>
      <p class="text-gray-600 dark:text-gray-300 mb-6">
        You are about to confirm payment for
        <strong>{{ selectedDestination?.name }}</strong>.
      </p>
      <div class="flex justify-end gap-4">
        <button
          @click="cancelPayment"
          class="rounded-lg border border-gray-300 px-4 py-2 font-medium hover:bg-gray-100 dark:hover:bg-gray-700"
        >
          Cancel
        </button>
        <button
          @click="finalizePayment"
          class="rounded-lg bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700"
        >
          Pay Now
        </button>
      </div>
    </div>
  </div>
</template>
