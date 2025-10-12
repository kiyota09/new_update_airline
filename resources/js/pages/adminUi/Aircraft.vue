<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';
import Sidebar from './NewSideBar.vue';

const page = usePage();

// Form for adding new aircraft
const form = useForm({
    model: '',
    registration: '',
    capacity: '',
    location: '',
    idnum: '',
});

// Reactive array for aircraft
const aircraft = ref<Array<AircraftItem>>(
    Array.isArray(page.props.aircraftss) ? page.props.aircraftss : []
);

// Modal control
const showAddAircraftModal = ref(false);

// Aircraft models
const aircraftModels = [
    'Airbus A320',
    'Boeing 737',
    'Airbus A330',
    'ATR 72',
    'Embraer E190',
];

// Airport type
interface Airport {
    id: number;
    country: string;
    city: string;
    airport: string;
}

// Filtered airport search
const filteredDeparture = ref<Airport[]>([]);
const departureSearch = ref('');

// Watch input for filtering locations
watch(departureSearch, (val) => {
    filteredDeparture.value = location.filter(
        (a) =>
            a.city.toLowerCase().includes(val.toLowerCase()) ||
            a.airport.toLowerCase().includes(val.toLowerCase()) ||
            a.country.toLowerCase().includes(val.toLowerCase())
    );
});

// Location data
const location: Airport[] = [
    { id: 1, country: 'United States', city: 'New York', airport: 'John F. Kennedy International Airport (JFK)' },
    { id: 2, country: 'United States', city: 'Los Angeles', airport: 'Los Angeles International Airport (LAX)' },
    { id: 3, country: 'United States', city: 'Chicago', airport: 'O’Hare International Airport (ORD)' },
    { id: 4, country: 'United States', city: 'San Francisco', airport: 'San Francisco International Airport (SFO)' },
    { id: 5, country: 'United Kingdom', city: 'London', airport: 'Heathrow Airport (LHR)' },
    { id: 6, country: 'United Kingdom', city: 'London', airport: 'Gatwick Airport (LGW)' },
    { id: 7, country: 'United Kingdom', city: 'Manchester', airport: 'Manchester Airport (MAN)' },
    { id: 8, country: 'United Kingdom', city: 'Birmingham', airport: 'Birmingham Airport (BHX)' },
    { id: 9, country: 'Germany', city: 'Frankfurt', airport: 'Frankfurt Airport (FRA)' },
    { id: 10, country: 'Germany', city: 'Munich', airport: 'Munich Airport (MUC)' },
    // ... add all other locations as needed
];

// Aircraft type
interface AircraftItem {
    model: string;
    registration: string;
    capacity: number | string;
    status?: string;
    location?: string;
    [key: string]: any;
}

// Fetch aircraft from backend (if you have a GET route)
const fetchAircraft = async () => {
    try {
        const response = await fetch('/aircraft'); // Replace with your GET endpoint
        const data = await response.json();
        aircraft.value = data.aircraftss || [];
    } catch (error) {
        console.error('Failed to fetch aircraft:', error);
    }
};

// Add new aircraft
const locationFlights = () => {
    form.post('/aircraft', {
        onSuccess: () => {
            console.log('Booking successful');
            // Add new aircraft to the array to update table immediately
            aircraft.value.push({
                model: form.model,
                registration: form.registration,
                capacity: form.capacity,
                location: form.location,
                status: 'Active', // default
            });
            form.reset();
            showAddAircraftModal.value = false;
        },
        onError: (errors) => console.log('Validation errors:', errors),
    });
};

// Load aircraft on component mount
onMounted(() => {
    fetchAircraft();
});
</script>


<template>
  

    <div class="flex min-h-screen bg-gray-50">
        <Sidebar />

        <div class="ml-64 flex-1">
            <div class="p-6">
                <!-- Header with Add Button -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Aircraft Management
                        </h1>
                        <p class="text-gray-600">
                            Manage your fleet of aircraft and maintenance
                            schedules
                        </p>
                    </div>
                    <button
                        @click="showAddAircraftModal = true"
                        class="flex items-center rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
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
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                            />
                        </svg>
                        Register New Aircraft
                    </button>
                </div>

                <!-- Aircraft Overview Cards -->
                <div
                    class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"
                >
                    <!-- Total Aircraft -->
                    <!-- <div
                        class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-lg"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100">Total Aircraft</p>
                                <p class="text-3xl font-bold">{{ aircraft.length}}</p>
                            </div>
                            <div class="rounded-xl bg-blue-400/20 p-3">
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div
                            class="mt-2 flex items-center text-sm text-blue-200"
                        >
                            <span class="ml-1">+2 from last quarter</span>
                        </div>
                    </div> -->

                    <!-- Active Aircraft -->
                    <div
                        class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-6 text-white shadow-lg"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100">Active Aircraft</p>
                                <p class="text-3xl font-bold">{{ aircraft.length}}</p>
                            </div>
                            <div class="rounded-xl bg-green-400/20 p-3">
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div
                            class="mt-2 flex items-center text-sm text-green-200"
                        >
                            <span class="ml-1">Total active Aircratf</span>
                        </div>
                    </div>

                    <!-- In Maintenance -->
                    <!-- <div
                        class="rounded-2xl bg-gradient-to-br from-yellow-500 to-yellow-600 p-6 text-white shadow-lg"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100">In Maintenance</p>
                                <p class="text-3xl font-bold"></p>
                            </div>
                            <div class="rounded-xl bg-yellow-400/20 p-3">
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div
                            class="mt-2 flex items-center text-sm text-yellow-200"
                        >
                            <span class="ml-1"
                                >Scheduled checks and repairs</span
                            >
                        </div>
                    </div> -->

                    <!-- Average Capacity -->
                    <div
                        class="rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 p-6 text-white shadow-lg"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100">Average Capacity</p>
                                <p class="text-3xl font-bold"></p>
                            </div>
                            <div class="rounded-xl bg-purple-400/20 p-3">
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div
                            class="mt-2 flex items-center text-sm text-purple-200"
                        >
                            <span class="ml-1">Seats per aircraft</span>
                        </div>
                    </div>
                </div>

                <!-- Aircraft Table -->
                <div class="rounded-lg bg-white p-6 shadow-md">
                    <h2 class="mb-4 text-xl font-semibold">Aircraft List</h2>
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 font-medium text-gray-700">
                                    Model
                                </th>
                                <th class="px-4 py-2 font-medium text-gray-700">
                                    Registration
                                </th>
                                <th class="px-4 py-2 font-medium text-gray-700">
                                    Capacity
                                </th>
                                <th class="px-4 py-2 font-medium text-gray-700">
                                    Status
                                </th>
                                <th class="px-4 py-2 font-medium text-gray-700">
                                    Location
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="aircraftItem in aircraft"
                                :key="aircraftItem.id"
                                class="border-b hover:bg-gray-50"
                            >
                                <td class="px-4 py-3">
                                    {{ aircraftItem.model }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ aircraftItem.registration }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ aircraftItem.capacity }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ aircraftItem.status }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ aircraftItem.location }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Add Aircraft Modal -->
                <div
                    v-if="showAddAircraftModal"
                   class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-white/30"
                >
                    <div class="w-full max-w-md rounded-lg bg-white p-6">
                        <h3 class="mb-4 text-xl font-bold">
                            Register New Aircraft
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Model</label
                                >
                                <select
                                    v-model="form.model"
                                    class="mt-1 w-full rounded-lg border p-2"
                                >
                                    <option value="">Select Model</option>
                                    <option
                                        v-for="model in aircraftModels"
                                        :key="model"
                                        :value="model"
                                    >
                                        {{ model }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Registration</label
                                >
                                <input
                                    v-model="form.registration"
                                    type="text"
                                    class="mt-1 w-full rounded-lg border p-2"
                                    placeholder="e.g. RP-C1234"
                                />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Capacity</label
                                >
                                <input
                                    v-model="form.capacity"
                                    type="number"
                                    class="mt-1 w-full rounded-lg border p-2"
                                    placeholder="e.g. 180"
                                />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Location</label
                                >
                                <div class="relative">
                                    <input
                                        type="text"
                                        v-model="departureSearch"
                                        placeholder="Type city or airport"
                                        class="w-full rounded-lg border px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    />
                                    <ul
                                        v-if="
                                            departureSearch &&
                                            filteredDeparture.length
                                        "
                                        class="absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-lg border bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
                                    >
                                        <li
                                            v-for="airport in filteredDeparture"
                                            :key="airport.id"
                                            @click="
                                                form.location =
                                                    airport.country +
                                                    ' - ' +
                                                    airport.airport;
                                                form.idnum =
                                                    airport.id.toString();
                                                departureSearch =
                                                    airport.country +
                                                    ' - ' +
                                                    airport.city +
                                                    ' - ' +
                                                    airport.airport;

                                                filteredDeparture = []; // hide dropdown
                                            "
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-700"
                                        >
                                            {{ airport.city }} -
                                            {{ airport.airport }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button
                                @click="showAddAircraftModal = false"
                                class="rounded-lg border px-4 py-2 hover:bg-gray-100"
                            >
                                Cancel
                            </button>
                            <button
                                @click="locationFlights"
                                class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
