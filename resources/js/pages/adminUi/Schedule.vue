<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import {
    addDays,
    endOfMonth,
    endOfWeek,
    format,
    isSameMonth,
    startOfMonth,
    startOfWeek,
} from 'date-fns';
import { computed, onMounted, ref } from 'vue';
import Sidebar from './NewSideBar.vue';

interface Flight {
    id: number;
    flightNo: string;
    origin: string;
    destination: string;
    date: string;
    time: string;
    status: 'On Time' | 'Delayed' | 'Cancelled';
}

// --- Reactive States ---
const schedules = ref<Flight[]>([]);
const currentMonth = ref(new Date('2025-10-01'));
const showAddModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const showNotifyModal = ref(false);
const selectedFlight = ref<Flight | null>(null);
const selectedDate = ref<string>('');

const newFlight = ref<Omit<Flight, 'id'>>({
    flightNo: '',
    origin: '',
    destination: '',
    date: '',
    time: '08:00',
    status: 'On Time',
});

// --- Calendar Computed ---
const monthStart = computed(() => startOfMonth(currentMonth.value));
const monthEnd = computed(() => endOfMonth(currentMonth.value));
const calendarStart = computed(() => startOfWeek(monthStart.value));
const calendarEnd = computed(() => endOfWeek(monthEnd.value));

const days = computed(() => {
    const arr: Date[] = [];
    let day = calendarStart.value;
    while (day <= calendarEnd.value) {
        arr.push(day);
        day = addDays(day, 1);
    }
    return arr;
});

const getFlightsForDay = (day: Date) => {
    const dayStr = format(day, 'yyyy-MM-dd');
    return schedules.value.filter(f => f.date === dayStr);
};

// --- Fetch Flights ---
const fetchFlights = async () => {
    try {
        const res = await axios.get('/admin/schedule/json');
        schedules.value = res.data.map((f: any) => ({
            id: f.id,
            flightNo: f.flightNo,
            origin: f.origin,
            destination: f.destination,
            date: format(new Date(f.date), 'yyyy-MM-dd'),
            time: f.time,
            status: f.status,
        }));
    } catch (err) {
        console.error('Error fetching flights:', err);
    }
};

// --- Initialize ---
const page = usePage();
onMounted(() => {
    if (page.props.flights && page.props.flights.length > 0) {
        schedules.value = page.props.flights.map((f: any) => ({
            id: f.id,
            flightNo: f.flightNo,
            origin: f.origin,
            destination: f.destination,
            date: format(new Date(f.date), 'yyyy-MM-dd'),
            time: f.time,
            status: f.status as 'On Time' | 'Delayed' | 'Cancelled',
        }));
    } else {
        fetchFlights();
    }
});

// --- Modal Handlers ---
const openAddModal = (date: Date) => {
    selectedDate.value = format(date, 'yyyy-MM-dd');
    newFlight.value = {
        flightNo: '',
        origin: '',
        destination: '',
        date: selectedDate.value,
        time: '08:00',
        status: 'On Time',
    };
    showAddModal.value = true;
};

const openEditModal = (flight: Flight) => {
    selectedFlight.value = { ...flight };
    showEditModal.value = true;
};

const openDeleteModal = (flight: Flight) => {
    selectedFlight.value = { ...flight };
    showDeleteModal.value = true;
};

const openNotifyModal = (flight: Flight) => {
    selectedFlight.value = { ...flight };
    showNotifyModal.value = true;
};

const closeModals = () => {
    showAddModal.value = false;
    showEditModal.value = false;
    showDeleteModal.value = false;
    showNotifyModal.value = false;
    selectedFlight.value = null;
};

// --- Add Flight ---
const addNewFlight = async () => {
    try {
        if (!newFlight.value.flightNo) {
            newFlight.value.flightNo = 'FL-' + Math.floor(Math.random() * 9000 + 1000);
        }
        await axios.post('/admin/schedule', newFlight.value);
        await fetchFlights();
        closeModals();
        alert('Flight added successfully!');
    } catch (err: any) {
        console.error(err.response?.data || err);
        alert('Failed to add flight');
    }
};

// --- Update Flight ---
const saveChanges = async () => {
    if (!selectedFlight.value) return;
    try {
        await axios.put(`/admin/schedule/${selectedFlight.value.id}`, selectedFlight.value);
        await fetchFlights();
        closeModals();
        alert('Flight updated successfully!');
    } catch (err: any) {
        console.error(err.response?.data || err);
        alert('Failed to update flight');
    }
};

// --- Delete Flight ---
const deleteFlight = async () => {
    if (!selectedFlight.value) return;
    try {
        await axios.delete(`/admin/schedule/${selectedFlight.value.id}`);
        await fetchFlights();
        closeModals();
        alert('Flight deleted successfully!');
    } catch (err: any) {
        console.error(err.response?.data || err);
        alert('Failed to delete flight');
    }
};

// --- Notify ---
const sendNotification = () => {
    if (selectedFlight.value) {
        alert(`Passengers on flight ${selectedFlight.value.flightNo} have been notified.`);
    }
    closeModals();
};

// --- Month Navigation ---
const prevMonth = () => {
    currentMonth.value = addDays(monthStart.value, -1);
};
const nextMonth = () => {
    currentMonth.value = addDays(monthEnd.value, 1);
};
</script>

<template>
<Head title="Schedule Management" />
<div class="flex min-h-screen bg-gray-50">
    <Sidebar />
    <div class="ml-64 flex-1 p-6">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-blue-600">Schedule Management</h1>
            <div class="flex gap-2">
                <button @click="prevMonth" class="rounded-lg bg-gray-200 px-3 py-1 text-gray-700 hover:bg-gray-300">‹</button>
                <h2 class="text-lg font-semibold">{{ format(currentMonth, 'MMMM yyyy') }}</h2>
                <button @click="nextMonth" class="rounded-lg bg-gray-200 px-3 py-1 text-gray-700 hover:bg-gray-300">›</button>
            </div>
        </div>

        <!-- Calendar Days -->
        <div class="mb-2 grid grid-cols-7 text-center font-semibold text-gray-600">
            <div v-for="d in ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']" :key="d">{{ d }}</div>
        </div>

        <!-- Calendar Grid -->
        <div class="grid grid-cols-7 gap-2">
            <div v-for="day in days" :key="day.toString()" class="relative flex min-h-[140px] flex-col justify-start overflow-y-auto rounded-lg border p-2 transition-colors hover:bg-gray-50"
                :class="{'bg-white': isSameMonth(day, currentMonth), 'bg-gray-100': !isSameMonth(day, currentMonth)}"
                @click="openAddModal(day)">
                <div class="mb-1 flex items-start justify-between">
                    <button class="rounded bg-blue-500 px-2 py-1 text-xs text-white opacity-0 transition-opacity hover:bg-blue-600 hover:opacity-100" @click.stop="openAddModal(day)">Add Flight</button>
                    <div class="text-sm font-bold">{{ format(day,'d') }}</div>
                </div>

                <div v-for="flight in getFlightsForDay(day)" :key="flight.id" class="mb-1 cursor-pointer rounded-lg p-2 text-xs shadow-sm transition-shadow hover:shadow-md"
                    :class="{
                        'border border-green-200 bg-green-100 text-green-800': flight.status==='On Time',
                        'border border-yellow-200 bg-yellow-100 text-yellow-800': flight.status==='Delayed',
                        'border border-red-200 bg-red-100 text-red-800': flight.status==='Cancelled'
                    }"
                    @click.stop>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">{{ flight.flightNo }}</span>
                        <span>{{ flight.time }}</span>
                    </div>
                    <div class="mt-1 flex items-center justify-between">
                        <span>{{ flight.origin }} → {{ flight.destination }}</span>
                    </div>
                    <div class="mt-2 flex justify-end gap-1">
                        <button @click.stop="openEditModal(flight)" class="rounded bg-yellow-500 px-2 py-1 text-[10px] text-white hover:bg-yellow-600">Edit</button>
                        <button @click.stop="openNotifyModal(flight)" class="rounded bg-blue-600 px-2 py-1 text-[10px] text-white hover:bg-blue-700">Notify</button>
                        <button @click.stop="openDeleteModal(flight)" class="rounded bg-red-600 px-2 py-1 text-[10px] text-white hover:bg-red-700">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Flight Modal -->
        <div v-if="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="closeModals">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                <h3 class="mb-4 text-xl font-bold text-green-600">Add New Flight</h3>
                <div class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium">Flight No.</label>
                        <input v-model="newFlight.flightNo" type="text" placeholder="Leave empty to auto-generate"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"/>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium">Origin *</label>
                            <input v-model="newFlight.origin" type="text" placeholder="e.g., MNL"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"/>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium">Destination *</label>
                            <input v-model="newFlight.destination" type="text" placeholder="e.g., CEB"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"/>
                        </div>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">Date</label>
                        <input v-model="newFlight.date" type="date" readonly class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"/>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">Time</label>
                        <input v-model="newFlight.time" type="time" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"/>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">Status</label>
                        <select v-model="newFlight.status" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option>On Time</option>
                            <option>Delayed</option>
                            <option>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button @click="closeModals" class="rounded-lg bg-gray-500 px-4 py-2 text-white hover:bg-gray-600">Cancel</button>
                    <button @click="addNewFlight" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">Add Flight</button>
                </div>
            </div>
        </div>

        <!-- Edit Flight Modal -->
        <div v-if="showEditModal && selectedFlight" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="closeModals">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                <h3 class="mb-4 text-xl font-bold text-yellow-600">Edit Flight</h3>
                <div class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium">Flight No.</label>
                        <input v-model="selectedFlight.flightNo" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2"/>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium">Origin *</label>
                            <input v-model="selectedFlight.origin" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2"/>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium">Destination *</label>
                            <input v-model="selectedFlight.destination" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2"/>
                        </div>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">Date</label>
                        <input v-model="selectedFlight.date" type="date" class="w-full rounded-lg border border-gray-300 px-4 py-2"/>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">Time</label>
                        <input v-model="selectedFlight.time" type="time" class="w-full rounded-lg border border-gray-300 px-4 py-2"/>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">Status</label>
                        <select v-model="selectedFlight.status" class="w-full rounded-lg border border-gray-300 px-4 py-2">
                            <option>On Time</option>
                            <option>Delayed</option>
                            <option>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button @click="closeModals" class="rounded-lg bg-gray-500 px-4 py-2 text-white hover:bg-gray-600">Cancel</button>
                    <button @click="saveChanges" class="rounded-lg bg-yellow-600 px-4 py-2 text-white hover:bg-yellow-700">Save Changes</button>
                </div>
            </div>
        </div>

        <!-- Delete Flight Modal -->
        <div v-if="showDeleteModal && selectedFlight" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="closeModals">
            <div class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl text-center">
                <h3 class="mb-4 text-xl font-bold text-red-600">Delete Flight</h3>
                <p>Are you sure you want to delete flight <strong>{{ selectedFlight.flightNo }}</strong>?</p>
                <div class="mt-6 flex justify-center gap-4">
                    <button @click="closeModals" class="rounded-lg bg-gray-500 px-4 py-2 text-white hover:bg-gray-600">Cancel</button>
                    <button @click="deleteFlight" class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">Delete</button>
                </div>
            </div>
        </div>

        <!-- Notify Modal -->
        <div v-if="showNotifyModal && selectedFlight" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="closeModals">
            <div class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl text-center">
                <h3 class="mb-4 text-xl font-bold text-blue-600">Notify Passengers</h3>
                <p>Send notification to passengers on flight <strong>{{ selectedFlight.flightNo }}</strong>?</p>
                <div class="mt-6 flex justify-center gap-4">
                    <button @click="closeModals" class="rounded-lg bg-gray-500 px-4 py-2 text-white hover:bg-gray-600">Cancel</button>
                    <button @click="sendNotification" class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Notify</button>
                </div>
            </div>
        </div>

    </div>
</div>
</template>

<style scoped>
button { transition: all 0.2s ease; }
::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-thumb { background: #93c5fd; border-radius: 10px; }
</style>
