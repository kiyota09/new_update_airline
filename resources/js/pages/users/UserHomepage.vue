<script setup lang="ts">
import topbar from '@/components/Topbar.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

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
}

interface User {
    name: string;
    email: string;
}

// Booking form
const form = useForm({
    departure: '',
    destination: '',
    departureDate: '',
    returnDate: '',
    passengers: '1',
    tripType: 'round-trip',
    flightClasses: 'economy',
});

// Typeahead inputs
const departureSearch = ref('');
const destinationSearch = ref('');
const filteredDeparture = ref<Airport[]>([]);
const filteredDestination = ref<Airport[]>([]);

// Flight classes
const flightClasses: FlightClass[] = [
    { id: 'economy', name: 'Economy Class' },
    { id: 'premium', name: 'Premium Economy' },
    { id: 'business', name: 'Business Class' },
    { id: 'first', name: 'First Class' },
];

// Featured destinations
const featuredDestinations: Destination[] = [
    {
        id: 1,
        name: 'Paris',
        image: 'https://images.unsplash.com/photo-1502602898536-47ad22581b52?auto=format&fit=crop&w=1000&q=80',
        price: '$499',
    },
    {
        id: 2,
        name: 'Tokyo',
        image: 'https://images.unsplash.com/photo-1540959733332-0b10da0b8c7e?auto=format&fit=crop&w=1000&q=80',
        price: '$799',
    },
    {
        id: 3,
        name: 'New York',
        image: 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=1000&q=80',
        price: '$399',
    },
    {
        id: 4,
        name: 'Bali',
        image: 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1000&q=80',
        price: '$699',
    },
];

// Airports list (sample, add the rest)
const airports = [
    {
        id: 1,
        country: 'United States',
        city: 'New York',
        airport: 'John F. Kennedy International Airport (JFK)',
    },
    {
        id: 2,
        country: 'United States',
        city: 'Los Angeles',
        airport: 'Los Angeles International Airport (LAX)',
    },
    {
        id: 3,
        country: 'United States',
        city: 'Chicago',
        airport: 'O’Hare International Airport (ORD)',
    },
    {
        id: 4,
        country: 'United States',
        city: 'San Francisco',
        airport: 'San Francisco International Airport (SFO)',
    },
    {
        id: 5,
        country: 'United Kingdom',
        city: 'London',
        airport: 'Heathrow Airport (LHR)',
    },
    {
        id: 6,
        country: 'United Kingdom',
        city: 'London',
        airport: 'Gatwick Airport (LGW)',
    },
    {
        id: 7,
        country: 'United Kingdom',
        city: 'Manchester',
        airport: 'Manchester Airport (MAN)',
    },
    {
        id: 8,
        country: 'United Kingdom',
        city: 'Birmingham',
        airport: 'Birmingham Airport (BHX)',
    },
    {
        id: 9,
        country: 'Germany',
        city: 'Frankfurt',
        airport: 'Frankfurt Airport (FRA)',
    },
    {
        id: 10,
        country: 'Germany',
        city: 'Munich',
        airport: 'Munich Airport (MUC)',
    },
    {
        id: 11,
        country: 'Germany',
        city: 'Berlin',
        airport: 'Berlin Brandenburg Airport (BER)',
    },
    {
        id: 12,
        country: 'France',
        city: 'Paris',
        airport: 'Charles de Gaulle Airport (CDG)',
    },
    { id: 13, country: 'France', city: 'Paris', airport: 'Orly Airport (ORY)' },
    {
        id: 14,
        country: 'France',
        city: 'Nice',
        airport: 'Nice Côte d’Azur Airport (NCE)',
    },
    {
        id: 15,
        country: 'Italy',
        city: 'Rome',
        airport: 'Leonardo da Vinci International Airport (FCO)',
    },
    {
        id: 16,
        country: 'Italy',
        city: 'Milan',
        airport: 'Malpensa Airport (MXP)',
    },
    {
        id: 17,
        country: 'Italy',
        city: 'Venice',
        airport: 'Marco Polo Airport (VCE)',
    },
    {
        id: 18,
        country: 'Spain',
        city: 'Madrid',
        airport: 'Adolfo Suárez Madrid–Barajas Airport (MAD)',
    },
    {
        id: 19,
        country: 'Spain',
        city: 'Barcelona',
        airport: 'Barcelona El Prat Airport (BCN)',
    },
    {
        id: 20,
        country: 'Spain',
        city: 'Valencia',
        airport: 'Valencia Airport (VLC)',
    },
    {
        id: 21,
        country: 'Japan',
        city: 'Tokyo',
        airport: 'Narita International Airport (NRT)',
    },
    {
        id: 22,
        country: 'Japan',
        city: 'Tokyo',
        airport: 'Haneda Airport (HND)',
    },
    {
        id: 23,
        country: 'Japan',
        city: 'Osaka',
        airport: 'Kansai International Airport (KIX)',
    },
    {
        id: 24,
        country: 'Japan',
        city: 'Osaka',
        airport: 'Osaka Itami Airport (ITM)',
    },
    {
        id: 25,
        country: 'Australia',
        city: 'Sydney',
        airport: 'Sydney Kingsford Smith Airport (SYD)',
    },
    {
        id: 26,
        country: 'Australia',
        city: 'Melbourne',
        airport: 'Melbourne Airport (MEL)',
    },
    {
        id: 27,
        country: 'Australia',
        city: 'Brisbane',
        airport: 'Brisbane Airport (BNE)',
    },
    {
        id: 28,
        country: 'Australia',
        city: 'Perth',
        airport: 'Perth Airport (PER)',
    },
    {
        id: 29,
        country: 'China',
        city: 'Beijing',
        airport: 'Beijing Capital International Airport (PEK)',
    },
    {
        id: 30,
        country: 'China',
        city: 'Shanghai',
        airport: 'Shanghai Pudong International Airport (PVG)',
    },
    {
        id: 31,
        country: 'China',
        city: 'Guangzhou',
        airport: 'Guangzhou Baiyun International Airport (CAN)',
    },
    {
        id: 32,
        country: 'China',
        city: 'Shenzhen',
        airport: 'Shenzhen Bao’an International Airport (SZX)',
    },
    {
        id: 33,
        country: 'India',
        city: 'Delhi',
        airport: 'Indira Gandhi International Airport (DEL)',
    },
    {
        id: 34,
        country: 'India',
        city: 'Mumbai',
        airport: 'Chhatrapati Shivaji Maharaj International Airport (BOM)',
    },
    {
        id: 35,
        country: 'India',
        city: 'Bangalore',
        airport: 'Kempegowda International Airport (BLR)',
    },
    {
        id: 36,
        country: 'India',
        city: 'Kolkata',
        airport: 'Netaji Subhas Chandra Bose International Airport (CCU)',
    },
    {
        id: 37,
        country: 'Brazil',
        city: 'São Paulo',
        airport: 'São Paulo–Guarulhos International Airport (GRU)',
    },
    {
        id: 38,
        country: 'Brazil',
        city: 'Rio de Janeiro',
        airport: 'Galeão–Antonio Carlos Jobim International Airport (GIG)',
    },
    {
        id: 39,
        country: 'Brazil',
        city: 'Brasília',
        airport: 'Presidente Juscelino Kubitschek International Airport (BSB)',
    },
    {
        id: 40,
        country: 'Brazil',
        city: 'Salvador',
        airport: 'Deputado Luís Eduardo Magalhães International Airport (SSA)',
    },
    {
        id: 41,
        country: 'South Africa',
        city: 'Johannesburg',
        airport: 'O. R. Tambo International Airport (JNB)',
    },
    {
        id: 42,
        country: 'South Africa',
        city: 'Cape Town',
        airport: 'Cape Town International Airport (CPT)',
    },
    {
        id: 43,
        country: 'South Africa',
        city: 'Durban',
        airport: 'King Shaka International Airport (DUR)',
    },
    {
        id: 44,
        country: 'South Africa',
        city: 'Port Elizabeth',
        airport: 'Port Elizabeth International Airport (PLZ)',
    },
    {
        id: 45,
        country: 'Canada',
        city: 'Toronto',
        airport: 'Toronto Pearson International Airport (YYZ)',
    },
    {
        id: 46,
        country: 'Canada',
        city: 'Vancouver',
        airport: 'Vancouver International Airport (YVR)',
    },
    {
        id: 47,
        country: 'Canada',
        city: 'Montreal',
        airport: 'Montréal–Pierre Elliott Trudeau International Airport (YUL)',
    },
    {
        id: 48,
        country: 'Canada',
        city: 'Calgary',
        airport: 'Calgary International Airport (YYC)',
    },
    {
        id: 49,
        country: 'Mexico',
        city: 'Mexico City',
        airport: 'Mexico City International Airport (MEX)',
    },
    {
        id: 50,
        country: 'Mexico',
        city: 'Cancún',
        airport: 'Cancún International Airport (CUN)',
    },
    {
        id: 51,
        country: 'Philippines',
        city: 'Manila',
        airport: 'Ninoy Aquino International Airport (MNL)',
    },
    {
        id: 52,
        country: 'Philippines',
        city: 'Cebu',
        airport: 'Mactan–Cebu International Airport (CEB)',
    },
    {
        id: 53,
        country: 'Philippines',
        city: 'Davao',
        airport: 'Francisco Bangoy International Airport (DVO)',
    },
    {
        id: 54,
        country: 'Philippines',
        city: 'Clark',
        airport: 'Clark International Airport (CRK)',
    },
    {
        id: 55,
        country: 'Philippines',
        city: 'Iloilo',
        airport: 'Iloilo International Airport (ILO)',
    },
    {
        id: 56,
        country: 'Philippines',
        city: 'Bacolod',
        airport: 'Bacolod–Silay International Airport (BCD)',
    },
    {
        id: 57,
        country: 'Philippines',
        city: 'Kalibo',
        airport: 'Kalibo International Airport (KLO)',
    },
    {
        id: 58,
        country: 'Philippines',
        city: 'Tagbilaran',
        airport: 'Bohol–Panglao International Airport (TAG)',
    },
    {
        id: 59,
        country: 'Philippines',
        city: 'Cagayan de Oro',
        airport: 'Laguindingan Airport (CGY)',
    },
    {
        id: 60,
        country: 'Philippines',
        city: 'General Santos',
        airport: 'General Santos International Airport (GES)',
    },
    {
        id: 61,
        country: 'Philippines',
        city: 'Puerto Princesa',
        airport: 'Puerto Princesa International Airport (PPS)',
    },
    {
        id: 62,
        country: 'Philippines',
        city: 'Zamboanga',
        airport: 'Zamboanga International Airport (ZAM)',
    },
];

// User data


// Search flights
const searchFlights = () => {
    form.post('/booking', {
        onSuccess: () => console.log('Booking successful'),
        onError: (errors) => console.log('Validation errors:', errors),
    });
};

// Typeahead filtering
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
</script>

<template>
    <topbar />

    <div>
        <!-- Hero -->
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
                        Experience premium comfort and exceptional service to
                        over 120 destinations worldwide.
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

                    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                        <!-- Departure -->
                        <!-- Departure -->
                        <div class="relative">
                            <label class="mb-1 block text-sm font-medium"
                                >From</label
                            >
                            <input
                                type="text"
                                v-model="departureSearch"
                                placeholder="Type city or airport"
                                class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            />
                            <ul
                                v-if="
                                    departureSearch && filteredDeparture.length
                                "
                                class="absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-lg border bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
                            >
                                <li
                                    v-for="airport in filteredDeparture"
                                    :key="airport.id"
                                    @click="
                                        form.departure = airport.airport;
                                        departureSearch =
                                            airport.city +
                                            ' - ' +
                                            airport.airport;
                                        filteredDeparture = []; // hide dropdown
                                    "
                                    class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-700"
                                >
                                    {{ airport.city }} - {{ airport.airport }}
                                </li>
                            </ul>
                        </div>

                        <!-- Destination -->
                        <div class="relative">
                            <label class="mb-1 block text-sm font-medium"
                                >To</label
                            >
                            <input
                                type="text"
                                v-model="destinationSearch"
                                placeholder="Type city or airport"
                                class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            />
                            <ul
                                v-if="
                                    destinationSearch &&
                                    filteredDestination.length
                                "
                                class="absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-lg border bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
                            >
                                <li
                                    v-for="airport in filteredDestination"
                                    :key="airport.id"
                                    @click="
                                        form.destination = airport.airport;
                                        destinationSearch =
                                            airport.city +
                                            ' - ' +
                                            airport.airport;
                                        filteredDestination = []; // hide dropdown
                                    "
                                    class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-700"
                                >
                                    {{ airport.city }} - {{ airport.airport }}
                                </li>
                            </ul>
                        </div>

                        <!-- Flight Class -->
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Class</label
                            >
                            <select
                                v-model="form.flightClasses"
                                class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
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
                                class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
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
                                class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Passengers</label
                            >
                            <select
                                v-model="form.passengers"
                                class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
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
                                class="flex w-full items-center justify-center rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors hover:bg-blue-700"
                            >
                                <svg
                                    class="mr-2 h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    ></path>
                                </svg>
                                Search Flights
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Destinations -->
        <section class="bg-gray-50 py-16 dark:bg-gray-900">
            <div class="container mx-auto px-4">
                <h2 class="mb-12 text-center text-3xl font-bold">
                    Popular Destinations
                </h2>
                <div
                    class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="destination in featuredDestinations"
                        :key="destination.id"
                        class="overflow-hidden rounded-xl shadow-lg transition-transform duration-300 hover:scale-105"
                    >
                        <div class="relative h-48 bg-gray-300">
                            <img
                                :src="destination.image"
                                :alt="destination.name"
                                class="h-full w-full object-cover"
                            />
                            <div
                                class="absolute right-0 bottom-0 left-0 bg-gradient-to-t from-black/70 to-transparent p-4"
                            >
                                <h3 class="text-lg font-bold text-white">
                                    {{ destination.name }}
                                </h3>
                                <p class="text-white/80">
                                    From {{ destination.price }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
