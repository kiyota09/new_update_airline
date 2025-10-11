<script setup lang="ts">

import { dashboard, aircraft } from '@/routes';  // Import aircraft route
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Aircraft Management',
        href: aircraft().url,  // Fixed: removed quotes and fixed case
    },
];

// Mock data - replace with actual API calls
const aircrafts = ref([
    {
        id: 'AC001',
        model: 'Airbus A320',
        registration: 'RP-C1234',
        capacity: 180,
        status: 'Active',
        lastMaintenance: '2024-01-10',
        nextMaintenance: '2024-02-15',
        totalFlights: 245,
        location: 'Manila (MNL)'
    },
    {
        id: 'AC002',
        model: 'Boeing 737',
        registration: 'RP-C5678',
        capacity: 189,
        status: 'Active',
        lastMaintenance: '2024-01-05',
        nextMaintenance: '2024-02-10',
        totalFlights: 312,
        location: 'Cebu (CEB)'
    },
    {
        id: 'AC003',
        model: 'Airbus A321',
        registration: 'RP-C9012',
        capacity: 220,
        status: 'Maintenance',
        lastMaintenance: '2024-01-12',
        nextMaintenance: '2024-01-28',
        totalFlights: 187,
        location: 'Manila (MNL)'
    },
    {
        id: 'AC004',
        model: 'Boeing 777',
        registration: 'RP-C3456',
        capacity: 350,
        status: 'Active',
        lastMaintenance: '2023-12-20',
        nextMaintenance: '2024-03-05',
        totalFlights: 156,
        location: 'Davao (DVO)'
    },
    {
        id: 'AC005',
        model: 'Airbus A330',
        registration: 'RP-C7890',
        capacity: 277,
        status: 'Inactive',
        lastMaintenance: '2023-11-15',
        nextMaintenance: '2024-04-20',
        totalFlights: 98,
        location: 'Manila (MNL)'
    },
]);

const maintenanceLogs = ref([
    {
        id: 'ML001',
        aircraftId: 'AC003',
        model: 'Airbus A321',
        type: 'Scheduled Maintenance',
        date: '2024-01-12',
        status: 'Completed',
        description: 'Regular engine inspection and system checks',
        technician: 'John Smith',
        cost: 12500
    },
    {
        id: 'ML002',
        aircraftId: 'AC001',
        model: 'Airbus A320',
        type: 'Unscheduled Repair',
        date: '2024-01-08',
        status: 'Completed',
        description: 'Replaced landing gear hydraulic system',
        technician: 'Maria Garcia',
        cost: 18750
    },
    {
        id: 'ML003',
        aircraftId: 'AC002',
        model: 'Boeing 737',
        type: 'Scheduled Maintenance',
        date: '2024-01-05',
        status: 'Completed',
        description: 'Avionics software update and calibration',
        technician: 'Robert Johnson',
        cost: 9200
    },
    {
        id: 'ML004',
        aircraftId: 'AC004',
        model: 'Boeing 777',
        type: 'Component Replacement',
        date: '2023-12-20',
        status: 'Completed',
        description: 'APU overhaul and replacement',
        technician: 'Sarah Wilson',
        cost: 32500
    },
]);

const newAircraft = ref({
    model: '',
    registration: '',
    capacity: '',
    status: 'Active',
    location: ''
});

const showAddAircraftModal = ref(false);
const selectedAircraft = ref<any>(null);
const showMaintenanceModal = ref(false);

const aircraftModels = [
    'Airbus A320',
    'Airbus A321',
    'Airbus A330',
    'Boeing 737',
    'Boeing 777',
    'Boeing 787',
    'ATR 72',
    'Bombardier CRJ900'
];

const locations = [
    'Manila (MNL)',
    'Cebu (CEB)',
    'Davao (DVO)',
    'Clark (CRK)',
    'Iloilo (ILO)',
    'Cagayan de Oro (CGY)'
];

const addAircraft = () => {
    // In a real app, this would be an API call
    const newId = 'AC' + String(aircrafts.value.length + 1).padStart(3, '0');
    aircrafts.value.push({
        id: newId,
        model: newAircraft.value.model,
        registration: newAircraft.value.registration,
        capacity: parseInt(newAircraft.value.capacity),
        status: newAircraft.value.status,
        lastMaintenance: 'N/A',
        nextMaintenance: '2024-02-28',
        totalFlights: 0,
        location: newAircraft.value.location
    });
    
    // Reset form and close modal
    newAircraft.value = {
        model: '',
        registration: '',
        capacity: '',
        status: 'Active',
        location: ''
    };
    showAddAircraftModal.value = false;
};

const viewMaintenance = (aircraft) => {
    selectedAircraft.value = aircraft;
    showMaintenanceModal.value = true;
};

const getStatusColor = (status) => {
    switch(status) {
        case 'Active': return 'bg-green-100 text-green-800';
        case 'Maintenance': return 'bg-yellow-100 text-yellow-800';
        case 'Inactive': return 'bg-red-100 text-red-800';
        default: return 'bg-gray-100 text-gray-800';
    }
};

onMounted(() => {
    // In a real application, you would fetch data from your API here
    // fetchAircraftData();
});
</script>

<template>
    <Head title="Aircraft" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-6">
            <!-- Header with Add Button -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Aircraft Management</h1>
                    <p class="text-gray-600">Manage your fleet of aircraft and maintenance schedules</p>
                </div>
                <button 
                    @click="showAddAircraftModal = true"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 flex items-center"
                >
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Register New Aircraft
                </button>
            </div>

            <!-- Aircraft Overview Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Aircraft -->
                <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100">Total Aircraft</p>
                            <p class="text-3xl font-bold">{{ aircrafts.length }}</p>
                        </div>
                        <div class="rounded-xl bg-blue-400/20 p-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-blue-200">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span class="ml-1">+2 from last quarter</span>
                    </div>
                </div>

                <!-- Active Aircraft -->
                <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100">Active Aircraft</p>
                            <p class="text-3xl font-bold">{{ aircrafts.filter(a => a.status === 'Active').length }}</p>
                        </div>
                        <div class="rounded-xl bg-green-400/20 p-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-green-200">
                        <span class="ml-1">{{ Math.round((aircrafts.filter(a => a.status === 'Active').length / aircrafts.length) * 100) }}% of fleet</span>
                    </div>
                </div>

                <!-- In Maintenance -->
                <div class="rounded-2xl bg-gradient-to-br from-yellow-500 to-yellow-600 p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100">In Maintenance</p>
                            <p class="text-3xl font-bold">{{ aircrafts.filter(a => a.status === 'Maintenance').length }}</p>
                        </div>
                        <div class="rounded-xl bg-yellow-400/20 p-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-yellow-200">
                        <span class="ml-1">Scheduled checks and repairs</span>
                    </div>
                </div>

                <!-- Average Capacity -->
                <div class="rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100">Average Capacity</p>
                            <p class="text-3xl font-bold">
                                {{ Math.round(aircrafts.reduce((sum, aircraft) => sum + aircraft.capacity, 0) / aircrafts.length) }}
                            </p>
                        </div>
                        <div class="rounded-xl bg-purple-400/20 p-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-purple-200">
                        <span class="ml-1">Seats per aircraft</span>
                    </div>
                </div>
            </div>

            <!-- Aircraft List Table -->
            <div class="rounded-2xl bg-white p-6 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Aircraft Fleet</h3>
                    <div class="flex space-x-2">
                        <button class="text-sm text-blue-600 hover:text-blue-800">Export</button>
                        <button class="text-sm text-blue-600 hover:text-blue-800">Filter</button>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aircraft ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Model</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registration</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Capacity</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Next Maintenance</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="aircraft in aircrafts" :key="aircraft.id" class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ aircraft.id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ aircraft.model }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ aircraft.registration }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ aircraft.capacity }} seats</td>
                                <td class="px-4 py-3">
                                    <span :class="['px-2 py-1 text-xs rounded-full', getStatusColor(aircraft.status)]">
                                        {{ aircraft.status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ aircraft.nextMaintenance }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ aircraft.location }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    <div class="flex space-x-2">
                                        <button 
                                            @click="viewMaintenance(aircraft)"
                                            class="text-blue-600 hover:text-blue-800"
                                        >
                                            Maintenance
                                        </button>
                                        <button class="text-green-600 hover:text-green-800">Edit</button>
                                        <button class="text-red-600 hover:text-red-800">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Maintenance Logs -->
            <div class="rounded-2xl bg-white p-6 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Maintenance Logs</h3>
                    <button class="text-sm text-blue-600 hover:text-blue-800">View All</button>
                </div>
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Log ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aircraft</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Technician</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cost</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="log in maintenanceLogs" :key="log.id" class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ log.id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ log.aircraftId }} ({{ log.model }})</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ log.type }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ log.date }}</td>
                                <td class="px-4 py-3">
                                    <span :class="{
                                        'px-2 py-1 text-xs rounded-full': true,
                                        'bg-green-100 text-green-800': log.status === 'Completed',
                                        'bg-yellow-100 text-yellow-800': log.status === 'In Progress',
                                        'bg-red-100 text-red-800': log.status === 'Cancelled'
                                    }">
                                        {{ log.status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ log.technician }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">${{ log.cost.toLocaleString() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Aircraft Modal -->
        <div v-if="showAddAircraftModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Register New Aircraft</h3>
                </div>
                <div class="p-6">
                    <form @submit.prevent="addAircraft">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Aircraft Model</label>
                                <select v-model="newAircraft.model" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="" disabled>Select a model</option>
                                    <option v-for="model in aircraftModels" :key="model" :value="model">{{ model }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Registration Number</label>
                                <input v-model="newAircraft.registration" type="text" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="e.g., RP-C1234">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Passenger Capacity</label>
                                <input v-model="newAircraft.capacity" type="number" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="e.g., 180">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select v-model="newAircraft.status"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="Active">Active</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Location</label>
                                <select v-model="newAircraft.location" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="" disabled>Select a location</option>
                                    <option v-for="location in locations" :key="location" :value="location">{{ location }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="showAddAircraftModal = false"
                                class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Register Aircraft
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Maintenance Details Modal -->
        <div v-if="showMaintenanceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Maintenance History - {{ selectedAircraft?.model }} ({{ selectedAircraft?.registration }})
                        </h3>
                        <button @click="showMaintenanceModal = false" class="text-gray-500 hover:text-gray-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6 max-h-96 overflow-y-auto">
                    <div class="space-y-4">
                        <div v-for="log in maintenanceLogs.filter(l => l.aircraftId === selectedAircraft?.id)" :key="log.id" 
                             class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ log.type }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ log.description }}</p>
                                    <div class="flex items-center mt-2 text-sm text-gray-500">
                                        <span>By: {{ log.technician }}</span>
                                        <span class="mx-2">•</span>
                                        <span>Cost: ${{ log.cost.toLocaleString() }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span :class="{
                                        'px-2 py-1 text-xs rounded-full': true,
                                        'bg-green-100 text-green-800': log.status === 'Completed',
                                        'bg-yellow-100 text-yellow-800': log.status === 'In Progress',
                                        'bg-red-100 text-red-800': log.status === 'Cancelled'
                                    }">
                                        {{ log.status }}
                                    </span>
                                    <p class="text-sm text-gray-500 mt-1">{{ log.date }}</p>
                                </div>
                            </div>
                        </div>
                        <div v-if="maintenanceLogs.filter(l => l.aircraftId === selectedAircraft?.id).length === 0" 
                             class="text-center py-8 text-gray-500">
                            No maintenance records found for this aircraft.
                        </div>
                    </div>
                </div>
                <div class="p-6 border-t border-gray-200">
                    <div class="flex justify-end">
                        <button @click="showMaintenanceModal = false"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Add any custom styles here if needed */
</style>