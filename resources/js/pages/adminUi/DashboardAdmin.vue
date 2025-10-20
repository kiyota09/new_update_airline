<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { format, isAfter, isBefore, parseISO ,parse} from 'date-fns';
import { computed, onMounted } from 'vue';
import Sidebar from './NewSideBar.vue';
// Mock data

onMounted(() => {
    // Fetch dashboard data if needed
});

const page = usePage();
const userinfo = computed(() => page.props.UserData ?? []);
const book = page.props.history; // <-- plain array
const income = page.props.total_income;
const total_passenger = page.props.total_passenger;
const flight = page.props.flights_data;
const payments = page.props.history;

// ✅ Format total income with $ and commas
const total = computed(() => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(income);
});

const today = new Date();

// ✅ Upcoming schedules
const upcomingSchedules = computed(() => {
    return flight.filter((s) => isAfter(parseISO(s.date), today));
});

// ✅ Past schedules
const pastSchedules = computed(() => {
    return book.filter((s) => isBefore(parseISO(s.date), today));
});
</script>

<template>
    <div class="flex min-h-screen bg-gray-50">
        <Sidebar />

        <div class="col-6 ml-64 flex-1">
            <div class="p-6">
                <!-- Stats Overview -->
                <div
                    class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"
                >
                    <!-- Example card -->
                    <div
                        class="rounded-2xl bg-gradient-to-br from-gray-500 to-blue-600 p-6 text-white shadow-lg"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100">Total Users</p>
                                <p class="text-3xl font-bold">
                                    {{ userinfo.length }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="rounded-2xl bg-gradient-to-br from-blue-500 to-green-600 p-6 text-white shadow-lg"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100">Total Flights</p>
                                <p class="text-3xl font-bold">
                                    {{ flight.length }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="rounded-2xl bg-gradient-to-br from-green-500 to-violet-600 p-6 text-white shadow-lg"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100">Total Bookings</p>
                                <p class="text-3xl font-bold">
                                    {{ book.length }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="rounded-2xl bg-gradient-to-br from-purple-500 to-blue-600 p-6 text-white shadow-lg"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100">Total Passengers</p>
                                <p class="text-3xl font-bold">
                                    {{ total_passenger }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="rounded-2xl bg-gradient-to-br from-orange-500 to-blue-600 p-6 text-white shadow-lg"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100">Total Income</p>
                                <p class="text-3xl font-bold">{{ total }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tables Example -->
                <div class="space-y-6 p-6">
                    <!-- Upcoming Schedules -->
                    <div class="rounded-2xl bg-white p-6 shadow-lg">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">
                            Upcoming Schedules
                        </h3>
                        <div class="overflow-x-auto">
                            <table
                                class="min-w-full table-auto divide-y divide-gray-200"
                            >
                                <thead class="rounded-t-2xl bg-gray-100">
                                    <tr>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase"
                                        >
                                            Flight ID
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase"
                                        >
                                            from
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase"
                                        >
                                            to
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase"
                                        >
                                            time
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase"
                                        >
                                            date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr
                                        v-for="booking in upcomingSchedules"
                                        :key="booking.id"
                                        class="transition hover:bg-gray-50"
                                    >
                                        <td
                                            class="px-4 py-2 text-sm font-medium text-gray-900"
                                        >
                                            {{ booking.flightNo }}
                                        </td>
                                        <td
                                            class="px-4 py-2 text-sm text-gray-600"
                                        >
                                            {{ booking.origin }}
                                        </td>
                                        <td
                                            class="px-4 py-2 text-sm text-gray-600"
                                        >
                                            {{ booking.destination }}
                                        </td>
                                        <td
                                            class="px-4 py-2 text-sm text-gray-600"
                                        >
                                            {{
                                                format(
                                                    parse(
                                                        `${booking.date} ${booking.time}`,
                                                        'yyyy-MM-dd HH:mm',
                                                        new Date(),
                                                    ),
                                                    'hh:mm a',
                                                )
                                            }}
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            {{
                                                new Date(
                                                    booking.date,
                                                ).toLocaleDateString([], {
                                                    year: 'numeric',
                                                    month: 'short',
                                                    day: 'numeric',
                                                })
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Past Schedules -->
                    <div class="rounded-2xl bg-white p-6 shadow-lg">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">
                            Past Schedules
                        </h3>
                        <div class="overflow-x-auto">
                            <table
                                class="min-w-full table-auto divide-y divide-gray-200"
                            >
                                <thead class="rounded-t-2xl bg-gray-100">
                                    <tr>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase"
                                        >
                                            Booking ID
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase"
                                        >
                                            Flight No.
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase"
                                        >
                                            Passenger
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase"
                                        >
                                            Date
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase"
                                        >
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr
                                        v-for="booking in pastSchedules"
                                        :key="booking.id"
                                        class="transition hover:bg-gray-50"
                                    >
                                        <td
                                            class="px-4 py-2 text-sm font-medium text-gray-900"
                                        >
                                            {{ booking.booking_id }}
                                        </td>
                                        <td
                                            class="px-4 py-2 text-sm text-gray-600"
                                        >
                                            {{ booking.flightNo }}
                                        </td>
                                        <td
                                            class="px-4 py-2 text-sm text-gray-600"
                                        >
                                            {{ booking.passenger }}
                                        </td>
                                        <td
                                            class="px-4 py-2 text-sm text-gray-600"
                                        >
                                            {{ booking.date }}
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <span
                                                class="inline-block rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800"
                                            >
                                                Done
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
/* Optional: horizontal scroll styling */
::-webkit-scrollbar {
    height: 6px;
}
::-webkit-scrollbar-thumb {
    background-color: rgba(107, 114, 128, 0.5);
    border-radius: 9999px;
}
</style>
