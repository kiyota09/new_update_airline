<script setup lang="ts">
import topbar from '@/components/Topbar.vue'
import { useForm } from '@inertiajs/vue3'
import { ref, watch, computed } from 'vue'

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

interface Flight {
  id: number
  airline: string
  flightNumber: string
  departure: string
  destination: string
  departureTime: string
  arrivalTime: string
  duration: string
  price: number
  date: string
  seatsAvailable: number
  aircraft: string
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

// ✈️ Available Flights Data
const availableFlights: Flight[] = [
  {
    id: 1,
    airline: 'SkyWings Airlines',
    flightNumber: 'SW501',
    departure: 'Manila (MNL)',
    destination: 'Tokyo (NRT)',
    departureTime: '08:00 AM',
    arrivalTime: '02:30 PM',
    duration: '6h 30m',
    price: 450,
    date: '2024-03-15',
    seatsAvailable: 24,
    aircraft: 'Airbus A330'
  },
  {
    id: 2,
    airline: 'Pacific Airways',
    flightNumber: 'PA789',
    departure: 'Manila (MNL)',
    destination: 'Tokyo (NRT)',
    departureTime: '02:15 PM',
    arrivalTime: '08:45 PM',
    duration: '6h 30m',
    price: 520,
    date: '2024-03-15',
    seatsAvailable: 12,
    aircraft: 'Boeing 787'
  },
  {
    id: 3,
    airline: 'SkyWings Airlines',
    flightNumber: 'SW502',
    departure: 'Manila (MNL)',
    destination: 'Tokyo (NRT)',
    departureTime: '10:30 PM',
    arrivalTime: '05:00 AM',
    duration: '6h 30m',
    price: 380,
    date: '2024-03-15',
    seatsAvailable: 45,
    aircraft: 'Airbus A330'
  },
  {
    id: 4,
    airline: 'Asia Connect',
    flightNumber: 'AC321',
    departure: 'Manila (MNL)',
    destination: 'Tokyo (NRT)',
    departureTime: '06:45 AM',
    arrivalTime: '01:15 PM',
    duration: '6h 30m',
    price: 490,
    date: '2024-03-16',
    seatsAvailable: 8,
    aircraft: 'Boeing 737'
  },
  {
    id: 5,
    airline: 'SkyWings Airlines',
    flightNumber: 'SW503',
    departure: 'Manila (MNL)',
    destination: 'Tokyo (NRT)',
    departureTime: '04:20 PM',
    arrivalTime: '10:50 PM',
    duration: '6h 30m',
    price: 420,
    date: '2024-03-16',
    seatsAvailable: 32,
    aircraft: 'Airbus A320'
  }
]

// Alternative dates for flights
const alternativeDates = [
  '2024-03-16',
  '2024-03-17',
  '2024-03-18',
  '2024-03-19',
  '2024-03-20'
]

// Modal Controls
const showModal = ref(false)
const showFlightResultsModal = ref(false)
const showPaymentModal = ref(false)
const selectedDestination = ref<Destination | null>(null)
const selectedFlight = ref<Flight | null>(null)

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

// ✈️ Flight Search Results Functions
const openFlightResultsModal = () => {
  
    showFlightResultsModal.value = true
  
}

const closeFlightResultsModal = () => {
  showFlightResultsModal.value = false
  selectedFlight.value = null
}

const selectFlight = (flight: Flight) => {
  selectedFlight.value = flight
}

const proceedToPayment = () => {
  if (selectedFlight.value) {
    showFlightResultsModal.value = false
    showPaymentModal.value = true
  } else {
    alert('Please select a flight first.')
  }
}

// ✈️ Payment Confirmation Modal Controls
const confirmPayment = () => {
  showPaymentModal.value = true
}

const cancelPayment = () => {
  showPaymentModal.value = false
}

const finalizePayment = () => {
  if (selectedFlight.value) {
    alert(`Payment successful for flight ${selectedFlight.value.flightNumber} to ${selectedFlight.value.destination}`)
  } else if (selectedDestination.value) {
    alert(`Payment successful for ${selectedDestination.value?.name}`)
  }
  showPaymentModal.value = false
  closeModal()
  closeFlightResultsModal()
}

// Dummy airports
const airports = [
  { id: 1, country: 'Philippines', city: 'Manila', airport: 'Ninoy Aquino International Airport (MNL)' },
  { id: 2, country: 'Japan', city: 'Tokyo', airport: 'Narita International Airport (NRT)' },
  { id: 3, country: 'France', city: 'Paris', airport: 'Charles de Gaulle Airport (CDG)' },
]

const searchFlights = () => {
  openFlightResultsModal()
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

// Filter flights based on search criteria
const filteredFlights = computed(() => {
  return availableFlights.filter(flight => 
    flight.departure.includes(form.departure.split(' - ')[0]) &&
    flight.destination.includes(form.destination.split(' - ')[0]) &&
    flight.date === form.departureDate
  )
})

// Get flights for alternative dates
const getFlightsForDate = (date: string) => {
  return availableFlights.filter(flight => 
    flight.departure.includes(form.departure.split(' - ')[0]) &&
    flight.destination.includes(form.destination.split(' - ')[0]) &&
    flight.date === date
  )
}
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

  <!-- Flight Search Results Modal -->
  <div
    v-if="showFlightResultsModal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
  >
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-11/12 md:w-4/5 lg:w-3/4 xl:w-2/3 p-6 relative max-h-[90vh] overflow-hidden flex flex-col">
      <button
        @click="closeFlightResultsModal"
        class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 dark:hover:text-white z-10"
      >
        ✕
      </button>

      <div class="space-y-6 flex-1 overflow-y-auto pr-2">
        <!-- Search Summary -->
        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
          <h2 class="text-2xl font-bold mb-2">Available Flights</h2>
          <p class="text-gray-600 dark:text-gray-300">
            {{ form.departure }} → {{ form.destination }} • {{ form.departureDate }} • 
            {{ form.passengers }} Passenger{{ parseInt(form.passengers) > 1 ? 's' : '' }} • 
            {{ flightClasses.find(fc => fc.id === form.flightClasses)?.name }}
          </p>
        </div>

        <!-- Selected Date Flights -->
        <div>
          <h3 class="text-xl font-semibold mb-4">Flights on {{ form.departureDate }}</h3>
          <div class="space-y-4">
            <div
              v-for="flight in filteredFlights"
              :key="flight.id"
              class="border rounded-lg p-4 hover:border-blue-500 transition-colors cursor-pointer"
              :class="selectedFlight?.id === flight.id ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-700'"
              @click="selectFlight(flight)"
            >
              <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="flex-1">
                  <div class="flex items-center space-x-4">
                    <div class="text-center">
                      <div class="text-lg font-bold">{{ flight.departureTime }}</div>
                      <div class="text-sm text-gray-500">{{ flight.departure }}</div>
                    </div>
                    <div class="flex-1 text-center">
                      <div class="text-sm text-gray-500">{{ flight.duration }}</div>
                      <div class="w-full h-px bg-gray-300 my-1"></div>
                      <div class="text-xs text-gray-500">Direct</div>
                    </div>
                    <div class="text-center">
                      <div class="text-lg font-bold">{{ flight.arrivalTime }}</div>
                      <div class="text-sm text-gray-500">{{ flight.destination }}</div>
                    </div>
                  </div>
                  <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ flight.airline }} • {{ flight.aircraft }} • {{ flight.flightNumber }}
                  </div>
                </div>
                <div class="mt-4 md:mt-0 md:ml-4 text-center">
                  <div class="text-2xl font-bold text-green-600">${{ flight.price }}</div>
                  <div class="text-sm text-gray-500">{{ flight.seatsAvailable }} seats left</div>
                  <button
                    @click.stop="selectFlight(flight)"
                    class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                  >
                    {{ selectedFlight?.id === flight.id ? 'Selected' : 'Select Flight' }}
                  </button>
                </div>
              </div>
            </div>

            <div v-if="filteredFlights.length === 0" class="text-center py-8 text-gray-500">
              No flights found for the selected date. Please check alternative dates below.
            </div>
          </div>
        </div>

        <!-- Alternative Dates -->
        <div>
          <h3 class="text-xl font-semibold mb-4">Also Available On These Dates</h3>
          <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <div
              v-for="date in alternativeDates"
              :key="date"
              class="border rounded-lg p-3 text-center cursor-pointer hover:border-blue-500 transition-colors"
            >
              <div class="font-semibold">{{ new Date(date).toLocaleDateString('en-US', { weekday: 'short' }) }}</div>
              <div class="text-lg font-bold">{{ new Date(date).getDate() }}</div>
              <div class="text-sm text-gray-500">{{ new Date(date).toLocaleDateString('en-US', { month: 'short' }) }}</div>
              <div class="text-xs text-green-600 mt-1">
                {{ getFlightsForDate(date).length }} flights
              </div>
              <div class="text-xs text-gray-500">
                from ${{ getFlightsForDate(date).reduce((min, flight) => flight.price < min ? flight.price : min, getFlightsForDate(date)[0]?.price || 0) }}
              </div>
            </div>
          </div>
        </div>

        <!-- Proceed to Payment Button -->
        <div class="border-t pt-4 mt-6">
          <div class="flex justify-between items-center">
            <div>
              <div v-if="selectedFlight" class="text-lg font-semibold">
                Selected: {{ selectedFlight.airline }} {{ selectedFlight.flightNumber }}
              </div>
              <div v-if="selectedFlight" class="text-2xl font-bold text-green-600">
                Total: ${{ selectedFlight.price * parseInt(form.passengers) }}
              </div>
            </div>
            <button
              @click="proceedToPayment"
              :disabled="!selectedFlight"
              class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed"
            >
              Proceed to Payment
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

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
      <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
        <div v-if="selectedFlight" class="space-y-2">
          <p class="font-semibold">{{ selectedFlight.airline }} - {{ selectedFlight.flightNumber }}</p>
          <p>{{ selectedFlight.departure }} → {{ selectedFlight.destination }}</p>
          <p>Departure: {{ selectedFlight.departureTime }}, {{ new Date(selectedFlight.date).toLocaleDateString() }}</p>
          <p class="text-lg font-bold text-green-600">Total: ${{ selectedFlight.price * parseInt(form.passengers) }}</p>
        </div>
        <div v-else-if="selectedDestination" class="space-y-2">
          <p class="font-semibold">{{ selectedDestination.name }}</p>
          <p>Passengers: {{ bookingForm.passengers }}</p>
          <p class="text-lg font-bold text-green-600">
            Total: ${{
              parseInt(selectedDestination.price.replace('$', '')) *
              bookingForm.passengers
            }}
          </p>
        </div>
      </div>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2">Payment Method</label>
        <select class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
          <option>Credit Card</option>
          <option>Debit Card</option>
          <option>PayPal</option>
          <option>Bank Transfer</option>
        </select>
      </div>

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