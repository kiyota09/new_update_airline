<script setup lang="ts">
import topbar from '@/components/Topbar.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, ref, watch } from 'vue';
interface Airport {
    id: number;
    country: string;
    city: string;
    airport: string;
}

interface FlightClass {
    id: string;
    name: string;
}

interface Destination {
    id: number;
    name: string;
    image: string;
    price: string;
    perDay: string;
    description: string;
}

interface Booking {
    id: number;
    destination: string;
    image: string;
    flightNumber: string;
    date: string;
    status: 'Paid' | 'Pending' | 'Cancelled';
}

interface Flight {
    id: number;
    airline: string;
    flightNumber: string;
    departure: string;
    destination: string;
    departureTime: string;
    arrivalTime: string;
    duration: string;
    price: number;
    date: string;
    seatsAvailable: number;
    aircraft: string;
}

const form = useForm({
    departure: '',
    destination: '',
    departureDate: '',
    returnDate: '',
    passengers: '1',
    tripType: 'round-trip',
    flightClasses: 'economy',
});

const departureSearch = ref('');
const destinationSearch = ref('');
const filteredDeparture = ref<Airport[]>([]);
const filteredDestination = ref<Airport[]>([]);

const flightClasses: FlightClass[] = [
    { id: 'economy', name: 'Economy Class' },
    { id: 'premium', name: 'Premium Economy' },
    { id: 'business', name: 'Business Class' },
    { id: 'first', name: 'First Class' },
];

// 🌍 Featured destinations
const featuredDestinations: Destination[] = [
    {
        id: 1,
        name: 'Paris',
        image: 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1000&q=80',
        price: '$499',
        perDay: '$180',
        description:
            'Experience the romance of the City of Lights with exquisite cuisine, art, and architecture.',
    },
    {
        id: 2,
        name: 'Tokyo',
        image: 'https://images.unsplash.com/photo-1549692520-acc6669e2f0c?auto=format&fit=crop&w=1000&q=80',
        price: '$799',
        perDay: '$210',
        description:
            "Immerse yourself in a perfect blend of tradition and innovation in Japan's capital.",
    },
    {
        id: 3,
        name: 'New York',
        image: 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1000&q=80',
        price: '$399',
        perDay: '$150',
        description:
            'The city that never sleeps – iconic landmarks, culture, and world-class dining await.',
    },
    {
        id: 4,
        name: 'Bali',
        image: 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1000&q=80',
        price: '$699',
        perDay: '$130',
        description:
            'Relax in tropical paradise – pristine beaches, lush jungles, and luxury resorts.',
    },
];

// ✈️ Sample bookings (mock data)
const bookings: Booking[] = [
    {
        id: 1,
        destination: 'Paris',
        image: 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1000&q=80',
        flightNumber: 'SKY1234',
        date: '2025-10-20',
        status: 'Paid',
    },
    {
        id: 2,
        destination: 'Tokyo',
        image: 'https://images.unsplash.com/photo-1549692520-acc6669e2f0c?auto=format&fit=crop&w=1000&q=80',
        flightNumber: 'SKY5678',
        date: '2025-11-05',
        status: 'Pending',
    },
    {
        id: 3,
        destination: 'Bali',
        image: 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=800&q=80',
        flightNumber: 'SKY9012',
        date: '2025-12-10',
        status: 'Cancelled',
    },
];

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
        aircraft: 'Airbus A330',
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
        aircraft: 'Boeing 787',
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
        aircraft: 'Airbus A330',
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
        aircraft: 'Boeing 737',
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
        aircraft: 'Airbus A320',
    },
];

// Alternative dates for flights
const alternativeDates = [
    '2024-03-16',
    '2024-03-17',
    '2024-03-18',
    '2024-03-19',
    '2024-03-20',
];

// Modal Controls
const showModal = ref(false);
const showFlightResultsModal = ref(false);
const showPaymentModal = ref(false);
const showPaymentModals = ref(false);
const selectedDestination = ref<Destination | null>(null);
const selectedFlight = ref<Flight | null>(null);

// 🧾 Booking Form (used in the booking modal)
const bookingForm = ref({
    departure: '',
    tripType: 'round-trip',
    departureDate: '',
    returnDate: '',
    passengers: 1,
    flightClasses: 'economy',
});

const openModal = (destination: Destination) => {
    selectedDestination.value = destination;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedDestination.value = null;
};
// ✈️ Flight Search Results Functions
const openFlightResultsModal = () => {
    showFlightResultsModal.value = true;
};

const closeFlightResultsModal = () => {
    showFlightResultsModal.value = false;
    selectedFlight.value = null;
};

const selectFlight = (flight: Flight) => {
    selectedFlight.value = flight;
};

// ✈️ Payment Confirmation Modal Controls
const confirmPayment = () => {
    showPaymentModal.value = true;
};

const cancelPayment = () => {
    showPaymentModal.value = false;
};
const cancelPayments = () => {
    showPaymentModals.value = false;
};

const finalizePayment = () => {
    if (selectedFlight.value) {
        alert(
            `Payment successful for flight ${selectedFlight.value.flightNumber} to ${selectedFlight.value.destination}`,
        );
    } else if (selectedDestination.value) {
        alert(`Payment successful for ${selectedDestination.value?.name}`);
    }
    showPaymentModal.value = false;
    closeModal();
    closeFlightResultsModal();
};

// Dummy airports
const airports = [
    {
        id: 1,
        country: 'Philippines',
        city: 'Manila',
        airport: 'Ninoy Aquino International Airport (MNL)',
    },
    {
        id: 2,
        country: 'Japan',
        city: 'Tokyo',
        airport: 'Narita International Airport (NRT)',
    },
    {
        id: 3,
        country: 'France',
        city: 'Paris',
        airport: 'Charles de Gaulle Airport (CDG)',
    },
];

const searchFlights = () => {
    openFlightResultsModal();
    searchDestination();
};

// Filter search
watch(departureSearch, (val) => {
    filteredDeparture.value = airports.filter(
        (a) =>
            a.city.toLowerCase().includes(val.toLowerCase()) ||
            a.airport.toLowerCase().includes(val.toLowerCase()),
    );
});
watch(destinationSearch, (val) => {
    filteredDestination.value = airports.filter(
        (a) =>
            a.city.toLowerCase().includes(val.toLowerCase()) ||
            a.airport.toLowerCase().includes(val.toLowerCase()),
    );
});

// Filter flights based on search criteria
const filteredFlights = computed(() => {
    return availableFlights.filter(
        (flight) =>
            flight.departure.includes(form.departure.split(' - ')[0]) &&
            flight.destination.includes(form.destination.split(' - ')[0]) &&
            flight.date === form.departureDate,
    );
});

// Get flights for alternative dates
const getFlightsForDate = (date: string) => {
    return availableFlights.filter(
        (flight) =>
            flight.departure.includes(form.departure.split(' - ')[0]) &&
            flight.destination.includes(form.destination.split(' - ')[0]) &&
            flight.date === date,
    );
};
const page = usePage();
const results = ref([]);
const flightPrice = ref<number | null>(0); // reactive price

const fetchPrice = async (flight: Flight) => {
    try {
        const response = await axios.post(
            '/price_destination',
            {
                departure: flight.origin || form.departure,
                destination: flight.destination || form.destination,
            },
            {
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content'),
                },
            },
        );

        // Assign the fetched price to the reactive variable
        flightPrice.value = response.data.price || flight.price || 0;
        console.table('Fetched price:', flightPrice.value);
    } catch (error) {
        console.error('Error fetching price:', error);
        flightPrice.value = 0;
    }
};

const searchDestination = async () => {
    const dt = {
        departure: form.departure,
        destination: form.destination,
        departureDate: form.departureDate,
    };
    console.table('Searching with data:', dt);

    try {
        const res = await axios.post('/search_destination', dt, {
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute('content'),
            },
        });
        results.value = res.data;
        console.table('Results:', results.value);

        // Fetch the price after getting results
        await fetchPrice();
        console.table('Price from backend:', flightPrice.value);
    } catch (err: any) {
        if (err.response && err.response.status === 422) {
            console.error('Validation errors:', err.response.data.errors);
        } else {
            console.error(err);
        }
    }
};

const selectedResultFlight = ref(null);
const selectResultFlight = async (flight: Flight) => {
    selectedResultFlight.value = flight;
    selectedFlight.value = flight;
    console.table('Selected Flight:', flight);

    await fetchPrice(flight); // updates flightPrice reactive variable
};
const proceedToPayment = () => {
    const flightToPay = selectedResultFlight.value || selectedFlight.value;

    if (flightToPay) {
        selectedFlight.value = flightToPay;
        showFlightResultsModal.value = false;
        showPaymentModal.value = true;
        console.table('Proceeding to payment for flight:', flightToPay);
    } else {
        alert('Please select a flight first.');
    }
};

const topay = async () => {
    showPaymentModals.value = true;
};

const name = ref('');
const contact = ref('');

const selectedPaymentMethod = ref('');
const selectPayment = (method) => {
    selectedPaymentMethod.value = method;
    console.table(method);
};

const finalizePayments = async () => {
    let paymentData: any = {};

    // 🔹 Start PayMongo payment first
    await topay();

    if (selectedFlight.value) {
        paymentData = {
            type: 'flight',
            flightId: selectedFlight.value.id,
            flightNumber: selectedFlight.value.flightno,
            airline: selectedFlight.value.airline,
            origin: selectedFlight.value.origin,
            destination: selectedFlight.value.destination,
            departureTime: selectedFlight.value.departureTime,
            arrivalTime: selectedFlight.value.arrivalTime,
            date: selectedFlight.value.date,
            passengers: parseInt(form.passengers),
            flightClass: form.flightClasses,
            totalPrice: flightPrice.value! * parseInt(form.passengers),
        };
    } else if (selectedDestination.value) {
        paymentData = {
            type: 'destination',
            destinationId: selectedDestination.value.id,
            destinationName: selectedDestination.value.name,
            passengers: bookingForm.passengers,
            tripType: bookingForm.tripType,
            departureDate: bookingForm.departureDate,
            returnDate: bookingForm.returnDate,
            flightClass: bookingForm.flightClasses,
            totalPrice:
                flightPrice.value! *
                parseInt(bookingForm.passengers.toString()),
        };
    }

    console.table('Payment Data:', paymentData);

    showPaymentModal.value = false;
    closeModal();
    closeFlightResultsModal();
};

const submit_history = async () => {
    const historyData = {
        name: name.value || '',
        contact: contact.value || '',
        flightNumber: selectedFlight.value.flightNo || '',
        origin: selectedFlight.value?.origin || '',
        time: selectedFlight.value?.time || '',
        destination:
            selectedFlight.value?.destination ||
            selectedDestination.value?.name ||
            '',
        date: selectedFlight.value?.date || bookingForm.departureDate || '',
        totalPrice: flightPrice.value! * parseInt(form.passengers),
        paymentMethod: selectedPaymentMethod.value || '',
    };
    console.dir(historyData);
    console.table(historyData);
    try {
        const response = await axios.post('/userHistory', historyData, {
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute('content'),
            },
        });
        console.log('History submission response:', response.data);
    } catch (error) {
        console.error('Error submitting history:', error);
    }
};

// Using axios
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
                    <span class="text-blue-600 dark:text-blue-400"
                        >SkyWings</span
                    >
                </h1>
                <p
                    class="mx-auto mb-8 max-w-2xl text-lg text-gray-600 md:text-xl dark:text-gray-300"
                >
                    Experience premium comfort and exceptional service to over
                    120 destinations worldwide.
                </p>
            </div>

            <!-- Flight Search Form -->
            <div
                class="mx-auto max-w-4xl rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-800"
            >
                <div class="mb-6 flex flex-wrap gap-4">
                    <div class="flex items-center space-x-2">
                        <input
                            type="radio"
                            id="round-trip"
                            v-model="form.tripType"
                            value="round-trip"
                            class="text-blue-600 focus:ring-blue-500"
                        />
                        <label for="round-trip" class="text-sm font-medium"
                            >Round Trip</label
                        >
                    </div>
                    <div class="flex items-center space-x-2">
                        <input
                            type="radio"
                            id="one-way"
                            v-model="form.tripType"
                            value="one-way"
                            class="text-blue-600 focus:ring-blue-500"
                        />
                        <label for="one-way" class="text-sm font-medium"
                            >One Way</label
                        >
                    </div>
                </div>

                <!-- Inputs -->
                <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="relative">
                        <label class="mb-1 block text-sm font-medium"
                            >From</label
                        >
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
                                    departureSearch =
                                        airport.city + ' - ' + airport.airport;
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
                            v-if="
                                destinationSearch && filteredDestination.length
                            "
                            class="absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-lg border bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
                        >
                            <li
                                v-for="airport in filteredDestination"
                                :key="airport.id"
                                @click="
                                    form.destination = airport.airport;
                                    destinationSearch =
                                        airport.city + ' - ' + airport.airport;
                                    filteredDestination = [];
                                "
                                class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-700"
                            >
                                {{ airport.city }} - {{ airport.airport }}
                            </li>
                        </ul>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Class</label
                        >
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
                        <label class="mb-1 block text-sm font-medium"
                            >Departure</label
                        >
                        <input
                            type="date"
                            v-model="form.departureDate"
                            class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Return</label
                        >
                        <input
                            type="date"
                            v-model="form.returnDate"
                            :disabled="form.tripType === 'one-way'"
                            :class="
                                form.tripType === 'one-way'
                                    ? 'bg-gray-100 dark:bg-gray-600'
                                    : ''
                            "
                            class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Passengers</label
                        >
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
            <h2 class="mb-12 text-center text-3xl font-bold">
                Popular Destinations
            </h2>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="destination in featuredDestinations"
                    :key="destination.id"
                    class="overflow-hidden rounded-xl bg-white shadow-lg transition-transform hover:scale-105 dark:bg-gray-800"
                >
                    <img
                        :src="destination.image"
                        :alt="destination.name"
                        class="h-48 w-full object-cover"
                    />
                    <div class="p-4">
                        <h3 class="text-lg font-bold">
                            {{ destination.name }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            From {{ destination.price }}
                        </p>
                        <button
                            @click="openModal(destination)"
                            class="mt-3 w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white transition hover:bg-blue-700"
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
        <div
            class="relative flex max-h-[90vh] w-11/12 flex-col overflow-hidden rounded-2xl bg-white p-6 shadow-2xl md:w-4/5 lg:w-3/4 xl:w-2/3 dark:bg-gray-800"
        >
            <button
                @click="closeFlightResultsModal"
                class="absolute top-3 right-3 z-10 text-gray-500 hover:text-gray-800 dark:hover:text-white"
            >
                ✕
            </button>

            <div class="flex-1 space-y-6 overflow-y-auto pr-2">
                <!-- Search Summary -->
                <div class="rounded-lg bg-blue-50 p-4 dark:bg-blue-900/20">
                    <h2 class="mb-2 text-2xl font-bold">Search Flights</h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ form.departure }} → {{ form.destination }} •
                        {{ form.departureDate }} •
                        {{ form.passengers }} Passenger{{
                            parseInt(form.passengers) > 1 ? 's' : ''
                        }}
                        •
                        {{
                            flightClasses.find(
                                (fc) => fc.id === form.flightClasses,
                            )?.name
                        }}
                    </p>
                </div>

                <!-- Selected Date Flights -->
                <div>
                    <h3 class="mb-4 text-xl font-semibold">
                        Flights on {{ form.departureDate }}
                    </h3>
                    <div class="space-y-4">
                        <div
                            v-for="flight in filteredFlights"
                            :key="flight.id"
                            class="cursor-pointer rounded-lg border p-4 transition-colors hover:border-blue-500"
                            :class="
                                selectedFlight?.id === flight.id
                                    ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20'
                                    : 'border-gray-200 dark:border-gray-700'
                            "
                            @click="selectFlight(flight)"
                        >
                            <div
                                class="flex flex-col justify-between md:flex-row md:items-center"
                            >
                                <div class="flex-1">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-center">
                                            <div class="text-lg font-bold">
                                                {{ flight.departureTime }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ flight.departure }}
                                            </div>
                                        </div>
                                        <div class="flex-1 text-center">
                                            <div class="text-sm text-gray-500">
                                                {{ flight.duration }}
                                            </div>
                                            <div
                                                class="my-1 h-px w-full bg-gray-300"
                                            ></div>
                                            <div class="text-xs text-gray-500">
                                                Direct
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-lg font-bold">
                                                {{ flight.arrivalTime }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ flight.destination }}
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-2 text-sm text-gray-600 dark:text-gray-400"
                                    >
                                        {{ flight.airline }} •
                                        {{ flight.aircraft }} •
                                        {{ flight.flightNumber }}
                                    </div>
                                </div>
                                <div class="mt-4 text-center md:mt-0 md:ml-4">
                                    <div
                                        class="text-2xl font-bold text-green-600"
                                    >
                                        ${{ flight.price }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ flight.seatsAvailable }} seats left
                                    </div>
                                    <button
                                        @click.stop="selectFlight(flight)"
                                        class="mt-2 rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                                    >
                                        {{
                                            selectedFlight?.id === flight.id
                                                ? 'Selected'
                                                : 'Select Flight'
                                        }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div
                            v-for="flight in results"
                            :key="flight.id"
                            @click="selectResultFlight(flight)"
                            :class="[
                                'mb-3 cursor-pointer rounded-xl border bg-white p-4 shadow-sm transition-all duration-200',
                                selectedResultFlight?.id === flight.id
                                    ? 'border-blue-500 bg-blue-50 shadow-md'
                                    : 'border-gray-300 hover:border-blue-400 hover:bg-blue-50 hover:shadow-md',
                            ]"
                        >
                            <p class="mb-1 text-sm text-gray-500">
                                ✈️ Flight No:
                            </p>
                            <p class="mb-2 text-lg font-semibold text-gray-800">
                                {{ flight.flightNo }}
                            </p>

                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <p>
                                    <span class="font-medium text-gray-600"
                                        >Origin:</span
                                    >
                                    {{ flight.origin }}
                                </p>
                                <p>
                                    <span class="font-medium text-gray-600"
                                        >Destination:</span
                                    >
                                    {{ flight.destination }}
                                </p>
                                <p>
                                    <span class="font-medium text-gray-600"
                                        >Date:</span
                                    >
                                    {{ flight.date }}
                                </p>
                                <p>
                                    <span class="font-medium text-gray-600"
                                        >Time:</span
                                    >
                                    {{
                                        new Date(
                                            '1970-01-01T' + flight.time,
                                        ).toLocaleTimeString([], {
                                            hour: '2-digit',
                                            minute: '2-digit',
                                        })
                                    }}
                                </p>
                            </div>

                            <div class="mt-3">
                                <span
                                    class="rounded-full px-3 py-1 text-xs font-semibold"
                                    :class="{
                                        'bg-green-100 text-green-700':
                                            flight.status === 'On Time',
                                        'bg-yellow-100 text-yellow-700':
                                            flight.status === 'Delayed',
                                        'bg-red-100 text-red-700':
                                            flight.status === 'Cancelled',
                                    }"
                                >
                                    {{ flight.status }}
                                </span>
                            </div>
                        </div>

                        <div
                            v-if="results.length === 0"
                            class="py-8 text-center text-gray-500"
                        >
                            No flights found for the selected date. Please check
                            alternative dates below.
                        </div>
                    </div>
                </div>

                <!-- Proceed to Payment Button -->
                <div class="mt-6 border-t pt-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div
                                v-if="selectedResultFlight"
                                class="text-lg font-semibold"
                            >
                                Selected Fligth:
                                {{ selectedResultFlight.flightNo }}
                                {{ selectedResultFlight.flightNumber }}
                            </div>
                            <div
                                v-if="selectedResultFlight"
                                class="text-2xl font-bold text-green-600"
                            >
                                <p class="text-lg font-bold text-green-600">
                                    Total: ${{
                                        flightPrice * parseInt(form.passengers)
                                    }}
                                </p>
                            </div>
                        </div>
                        <button
                            @click="proceedToPayment"
                            :disabled="!selectedResultFlight"
                            :class="[
                                'rounded-lg px-6 py-3 font-semibold text-white',
                                selectedResultFlight
                                    ? 'bg-green-600 hover:bg-green-700'
                                    : 'cursor-not-allowed bg-gray-400',
                            ]"
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
        <div
            class="relative flex max-h-[90vh] w-11/12 flex-col overflow-hidden rounded-2xl bg-white p-6 shadow-2xl md:w-1/2 dark:bg-gray-800"
        >
            <button
                @click="closeModal"
                class="absolute top-3 right-3 z-10 text-gray-500 hover:text-gray-800 dark:hover:text-white"
            >
                ✕
            </button>

            <!-- NOTE: modal content is scrollable (flex-1 + overflow-y-auto) so long forms can scroll -->
            <div
                v-if="selectedDestination"
                class="flex-1 space-y-4 overflow-y-auto pr-2"
            >
                <!-- Destination Image & Name -->
                <img
                    :src="selectedDestination.image"
                    :alt="selectedDestination.name"
                    class="h-48 w-full rounded-xl object-cover"
                />
                <h2 class="text-2xl font-bold">
                    {{ selectedDestination.name }}
                </h2>
                <p class="text-gray-600 dark:text-gray-300">
                    {{ selectedDestination.description }}
                </p>

                <!-- Booking Details Form -->
                <div class="mt-4 grid grid-cols-1 gap-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Departure Airport</label
                        >
                        <select
                            v-model="bookingForm.departure"
                            class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="">Select Departure Airport</option>
                            <option
                                v-for="airport in airports"
                                :key="airport.id"
                                :value="airport.airport"
                            >
                                {{ airport.city }} - {{ airport.airport }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Trip Type</label
                        >
                        <select
                            v-model="bookingForm.tripType"
                            class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="round-trip">Round Trip</option>
                            <option value="one-way">One Way</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Departure Date</label
                        >
                        <input
                            type="date"
                            v-model="bookingForm.departureDate"
                            class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        />
                    </div>

                    <div v-if="bookingForm.tripType === 'round-trip'">
                        <label class="mb-1 block text-sm font-medium"
                            >Return Date</label
                        >
                        <input
                            type="date"
                            v-model="bookingForm.returnDate"
                            class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        />
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Passengers</label
                        >
                        <input
                            type="number"
                            min="1"
                            v-model.number="bookingForm.passengers"
                            class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        />
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium"
                            >Flight Class</label
                        >
                        <select
                            v-model="bookingForm.flightClasses"
                            class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option
                                v-for="fc in flightClasses"
                                :key="fc.id"
                                :value="fc.id"
                            >
                                {{ fc.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div
                    class="mt-6 flex items-center justify-between border-t border-gray-200 pt-4 dark:border-gray-700"
                >
                    <div>
                        <p class="text-lg font-bold text-green-600">
                            Total: ${{
                                flightPrice * parseInt(form.passengers)
                            }}
                        </p>
                    </div>
                    <button
                        @click="confirmPayment"
                        class="rounded-lg bg-green-600 px-6 py-2 font-semibold text-white hover:bg-green-700"
                    >
                        Confirm Booking
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment confirmation Modal -->
    <div
        v-if="showPaymentModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
    >
        <div
            class="relative w-11/12 rounded-xl bg-white p-6 shadow-2xl md:w-1/3 dark:bg-gray-800"
        >
            <button
                @click="cancelPayment"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 dark:hover:text-white"
            >
                ✕
            </button>

            <h2 class="mb-4 text-2xl font-bold">Payment Confirmation</h2>
            <div class="mb-6 rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                <div v-if="selectedFlight" class="space-y-2">
                    <p class="font-semibold">
                        {{ selectedFlight.airline || selectedFlight.flightNo }}
                    </p>
                    <p>
                        {{ selectedFlight.origin }} →
                        {{ selectedFlight.destination }}
                    </p>

                    <p>
                        Departure Time:
                        {{
                            new Date(
                                '1970-01-01T' + selectedFlight.time,
                            ).toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit',
                            })
                        }},
                        <br />
                        Date:
                        {{ new Date(selectedFlight.date).toLocaleDateString() }}
                    </p>
                    <p class="text-lg font-bold text-green-600">
                        Total: ${{ flightPrice * parseInt(form.passengers) }}
                    </p>
                </div>
                <div v-else-if="selectedDestination" class="space-y-2">
                    <p class="font-semibold">{{ selectedDestination.name }}</p>
                    <p>Passengers: {{ bookingForm.passengers }}</p>
                    <p class="text-lg font-bold text-green-600">
                        Total: ${{ flightPrice * parseInt(form.passengers) }}
                    </p>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <button
                    @click="cancelPayment"
                    class="rounded-lg border border-gray-300 px-4 py-2 font-medium hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    Cancel
                </button>
                <button
                    @click="topay"
                    class="rounded-lg bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700"
                >
                    Pay Now
                </button>
            </div>
        </div>
    </div>

    <!-- Payment modal -->
    <div
        v-if="showPaymentModals"
        class="fixed inset-0 z-50 flex items-center justify-center bg-white/50 backdrop-blur-sm"
    >
        <!-- Scrollable container -->
        <div
            class="relative mx-auto max-h-[90vh] w-full overflow-y-auto rounded-lg bg-gray-50 p-4 shadow-lg md:max-w-2xl"
        >
            <div class="rounded-lg bg-white shadow-sm">
                <!-- Header -->
                <div
                    class="sticky top-0 z-10 rounded-t-lg bg-gradient-to-r from-emerald-400 to-emerald-500 p-6"
                >
                    <div class="text-lg font-medium text-white">
                        SkyWings Airlines
                    </div>
                </div>

                <div class="space-y-6 p-6">
                    <!-- Back Button -->
                    <button
                        @click="closeModal"
                        class="mb-2 text-sm text-gray-500 hover:text-gray-700"
                    >
                        ← Back
                    </button>

                    <!-- Flight Info -->
                    <div>
                        <div class="mb-3 font-medium text-gray-700">
                            You're paying
                        </div>
                        <div class="space-y-2">
                            <p class="font-semibold">
                                {{
                                    selectedFlight.airline ||
                                    selectedFlight.flightNo
                                }}
                            </p>
                            <p>
                                {{ selectedFlight.origin }} →
                                {{ selectedFlight.destination }}
                            </p>
                            <p>
                                Departure Time:
                                {{
                                    new Date(
                                        '1970-01-01T' + selectedFlight.time,
                                    ).toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: '2-digit',
                                    })
                                }},
                                <br />
                                Date:
                                {{
                                    new Date(
                                        selectedFlight.date,
                                    ).toLocaleDateString()
                                }}
                            </p>
                        </div>
                    </div>

                    <!-- Total -->
                    <div>
                        <div class="mb-1 text-sm text-gray-500">
                            Total amount
                        </div>
                        <p class="text-lg font-bold text-green-600">
                            ₱{{ flightPrice * parseInt(form.passengers) }}
                        </p>
                    </div>

                    <!-- Payment Methods -->
                    <div>
                        <div class="mb-3 font-medium text-gray-700">
                            Payment Method
                        </div>
                        <div class="mb-4 grid grid-cols-4 gap-2">
                            <!-- GCash -->
                            <div
                                @click="selectPayment('GCash')"
                                :class="[
                                    'flex cursor-pointer flex-col items-center justify-center rounded border p-3 transition',
                                    selectedPaymentMethod === 'GCash'
                                        ? 'border-emerald-500 bg-emerald-50'
                                        : 'hover:border-blue-500',
                                ]"
                            >
                                <div
                                    class="mb-1 rounded bg-gradient-to-r from-blue-400 to-blue-600 px-2 py-1 text-xs font-bold text-white"
                                >
                                    GCash
                                </div>
                            </div>

                            <!-- Maya -->
                            <div
                                @click="selectPayment('Maya')"
                                :class="[
                                    'flex cursor-pointer flex-col items-center justify-center rounded border p-3 transition',
                                    selectedPaymentMethod === 'Maya'
                                        ? 'border-emerald-500 bg-emerald-50'
                                        : 'hover:border-blue-500',
                                ]"
                            >
                                <div
                                    class="mb-1 rounded bg-black px-2 py-1 text-xs font-bold text-white"
                                >
                                    MAYA
                                </div>
                                <div class="text-xs text-gray-500">MAYA</div>
                            </div>
                        </div>

                        <!-- Selected method display -->
                        <p
                            v-if="selectedPaymentMethod"
                            class="mt-2 text-center text-sm text-gray-600"
                        >
                            Selected Method:
                            <span class="font-semibold text-emerald-600">
                                {{ selectedPaymentMethod }}
                            </span>
                        </p>
                    </div>

                    <!-- Customer Info -->
                    <div>
                        <div class="mb-3 font-medium text-gray-700">
                            Customer Information
                        </div>

                        <div class="mb-4">
                            <label class="mb-2 block text-sm text-gray-600"
                                >Name</label
                            >
                            <input
                                type="text"
                                v-model="name"
                                placeholder="Enter your name"
                                class="w-full rounded-lg border border-gray-300 p-3 text-sm focus:ring focus:ring-emerald-300 focus:outline-none"
                                required
                            />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm text-gray-600"
                                >Number</label
                            >
                            <input
                                type="text"
                                v-model="contact"
                                placeholder="Enter your number"
                                class="w-full rounded-lg border border-gray-300 p-3 text-sm focus:ring focus:ring-emerald-300 focus:outline-none"
                                required
                            />
                        </div>
                    </div>

                    <!-- Pay Now -->
                    <div class="pb-2">
                        <button
                            @click="submit_history"
                            class="w-full rounded-lg bg-emerald-500 py-3 font-medium text-white transition-colors hover:bg-emerald-600"
                        >
                            Proceed to Payment →
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
