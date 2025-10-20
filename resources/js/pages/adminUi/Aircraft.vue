<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
import Sidebar from './NewSideBar.vue';

const page = usePage();

// Form for adding new aircraft
const form = useForm({
    model: '',
    registration: '',
    location: '',
    idnum: '',
});

// Reactive array for aircraft
const aircraft = ref<Array<AircraftItem>>(
    Array.isArray(page.props.aircraftss) ? page.props.aircraftss : [],
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
            a.country.toLowerCase().includes(val.toLowerCase()),
    );
});

// Location data
const location: Airport[] = [
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
    // ... add all other locations as needed
];

// Aircraft type
interface AircraftItem {
    model: string;
    registration: string;
    status?: string;
    location?: string;
    [key: string]: any;
}

// Fetch aircraft from backend (if you have a GET route)
const fetchAircraft = async () => {
    try {
        const response = await fetch('/air'); // Replace with your GET endpoint
        const data = await response.json();
        aircraft.value = data.aircraftss || [];
    } catch (error) {
        console.log('Failed to fetch aircraft:', error);
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
                location: form.location,
                status: 'Active', // default
            });
            form.reset();
            showAddAircraftModal.value = false;
            window.location.reload();
        },
        onError: (errors) => console.log('Validation errors:', errors),
    });
};

// Load aircraft on component mount
onMounted(() => {
    fetchAircraft();
});

// Delete aircraft
const deleteAircraft = async (id: number) => {

    try {
        await form.delete(`/aircraft/${id}`);
        // Remove the deleted aircraft from local array
        aircraft.value = aircraft.value.filter(a => a.id !== id);
        console.log('Aircraft deleted successfully');
    } catch (error) {
        console.log('Failed to delete aircraft:', error);
    }
};
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
                    <!-- Active Aircraft -->
                    <div
                        class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-6 text-white shadow-lg"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100">Active Aircraft</p>
                                <p class="text-3xl font-bold">
                                    {{ aircraft.length }}
                                </p>
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
                                    Status
                                </th>
                                <th class="px-4 py-2 font-medium text-gray-700">
                                    Location
                                </th>
                                <th class="px-4 py-2 font-medium text-gray-700">
                                    Remove
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
                                    {{ aircraftItem.status }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ aircraftItem.location }}
                                </td>
                                <td class="px-4 py-3">
                                    <button
                                        @click="deleteAircraft(aircraftItem.id)"
                                        class="text-red-600 hover:underline"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Add Aircraft Modal -->
                <div
                    v-if="showAddAircraftModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-white/30 backdrop-blur-sm"
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

                            <!-- <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >First Class</label
                                >
                                <input
                                    v-model="form.firstClassCapacity"
                                    type="number"
                                    class="mt-1 w-full rounded-lg border p-2"
                                    placeholder="e.g. 180"
                                />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Business Class</label
                                >
                                <input
                                    v-model="form.businessClassCapacity"
                                    type="number"
                                    class="mt-1 w-full rounded-lg border p-2"
                                    placeholder="e.g. 180"
                                />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Economy Class</label
                                >
                                <input
                                    v-model="form.economyClassCapacity"
                                    type="number"
                                    class="mt-1 w-full rounded-lg border p-2"
                                    placeholder="e.g. 180"
                                />
                            </div> -->

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
