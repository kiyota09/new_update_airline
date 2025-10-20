<script setup lang="ts">
import axios from 'axios';
import { computed, onMounted, ref } from 'vue';
import Sidebar from './NewSideBar.vue';

const passengers = ref([]);
const searchQuery = ref('');

onMounted(async () => {
    try {
        const res = await axios.get('/user2_history');
        passengers.value = res.data;
    } catch (error) {
        console.error(error);
    }
});

// ✅ Filtering Logic
const filteredPassengers = computed(() => {
    if (!searchQuery.value) return passengers.value;
    const s = searchQuery.value.toLowerCase();

    return passengers.value.filter(
        (p: any) =>
            p.firstname?.toLowerCase().includes(s) ||
            p.lastname?.toLowerCase().includes(s) ||
            p.email?.toLowerCase().includes(s) ||
            p.country?.toLowerCase().includes(s) ||
            p.contact?.toLowerCase().includes(s),
    );
});

const selectedPassenger = ref<any>(null);
const showProfileModal = ref(false);
const showHistoryModal = ref(false);

// ✅ FIXED: Pass whole passenger object not just id
const viewProfile = (passenger: any) => {
    selectedPassenger.value = passenger;
    showProfileModal.value = true;
};

const viewHistory = (passenger: any) => {
    selectedPassenger.value = passenger;
    showHistoryModal.value = true;
};

const closeModals = () => {
    showProfileModal.value = false;
    showHistoryModal.value = false;
};
</script>

<template>
    <Head title="Passenger Management" />

    <div class="flex min-h-screen bg-gray-50">
        <Sidebar />

        <div class="ml-64 flex-1">
            <div class="p-6">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Passenger Management
                        </h1>
                        <p class="text-gray-600">
                            Manage passenger information and travel history
                        </p>
                    </div>
                </div>

                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-700">
                        Registered Passengers
                    </h2>
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search by name or email..."
                        class="rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm"
                    />
                </div>

                <div class="overflow-hidden rounded-2xl bg-white shadow-xl">
                    <table class="w-full border-collapse text-left">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Firstname</th>
                                <th class="px-4 py-3">Lastname</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Contact</th>
                                <th class="px-4 py-3">Country</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                    </table>

                    <div class="max-h-[400px] overflow-y-auto">
                        <table class="w-full border-collapse text-left">
                            <tbody>
                                <tr
                                    v-for="passenger in filteredPassengers"
                                    :key="passenger.id"
                                    class="border-b border-gray-200 transition hover:bg-gray-50"
                                >
                                    <td class="px-4 py-3">
                                        {{ passenger.id }}
                                    </td>
                                    <td class="px-4 py-3 font-medium">
                                        {{ passenger.firstname }}
                                    </td>
                                    <td class="px-4 py-3 font-medium">
                                        {{ passenger.lastname }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ passenger.email }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ passenger.contact }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ passenger.country }}
                                    </td>
                                    <td
                                        class="flex justify-center gap-2 px-4 py-3"
                                    >
                                        <button
                                            @click="viewProfile(passenger)"
                                            class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
                                        >
                                            View
                                        </button>
                                        <!-- <button
                                            @click="viewHistory(passenger.id)"
                                            class="rounded bg-yellow-500 px-3 py-1 text-sm text-white hover:bg-yellow-600"
                                        >
                                            History
                                        </button> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-8 text-center font-medium text-gray-700">
                    <p>Total Registered Passengers: {{ passengers.length }}</p>
                </div>

                <div
                    v-if="showProfileModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 backdrop-blur-sm"
                >
                    <div
                        class="animate-fadeIn w-full max-w-lg overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-2xl"
                    >
                        <!-- Header -->
                        <div
                            class="flex items-center justify-between bg-blue-600 px-6 py-4 text-white"
                        >
                            <h3 class="text-xl font-semibold">
                                Passenger Profile
                            </h3>
                            <button
                                @click="closeModals"
                                class="hover:text-white-200 rounded-lg bg-blue-500 px-3 py-1 text-white hover:bg-blue-700"
                            >
                                X
                            </button>
                        </div>

                        <!-- Content -->
                        <div
                            class="max-h-[460px] overflow-y-auto rounded-xl border border-gray-200 bg-gray-50 p-6 shadow-inner"
                        >
                            <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                        >First Name</span
                                    >
                                    <span
                                        class="text-base font-medium text-gray-800"
                                        >{{ selectedPassenger.firstname }}</span
                                    >
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                        >Last Name</span
                                    >
                                    <span
                                        class="text-base font-medium text-gray-800"
                                        >{{ selectedPassenger.lastname }}</span
                                    >
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                        >Middle Name</span
                                    >
                                    <span
                                        class="text-base font-medium text-gray-800"
                                        >{{
                                            selectedPassenger.middlename
                                        }}</span
                                    >
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                        >Email</span
                                    >
                                    <span
                                        class="text-base font-medium text-gray-800"
                                        >{{ selectedPassenger.email }}</span
                                    >
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                        >Contact</span
                                    >
                                    <span
                                        class="text-base font-medium text-gray-800"
                                        >{{ selectedPassenger.contact }}</span
                                    >
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                        >Country</span
                                    >
                                    <span
                                        class="text-base font-medium text-gray-800"
                                        >{{ selectedPassenger.country }}</span
                                    >
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                        >Gender</span
                                    >
                                    <span
                                        class="text-base font-medium text-gray-800"
                                        >{{ selectedPassenger.gender }}</span
                                    >
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                        >Member Since</span
                                    >
                                    <span
                                        class="text-base font-medium text-gray-800"
                                        >{{
                                            selectedPassenger.memberDate
                                        }}</span
                                    >
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                        >Block</span
                                    >
                                    <span
                                        class="text-base font-medium text-gray-800"
                                        >{{ selectedPassenger.block }}</span
                                    >
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                        >Barangay</span
                                    >
                                    <span
                                        class="text-base font-medium text-gray-800"
                                        >{{ selectedPassenger.barangay }}</span
                                    >
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-semibold tracking-wide text-gray-500 uppercase"
                                        >Municipality</span
                                    >
                                    <span
                                        class="text-base font-medium text-gray-800"
                                        >{{
                                            selectedPassenger.municipality
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Footer Buttons -->
                        <div
                            class="flex justify-end gap-3 border-t bg-gray-50 px-6 py-4"
                        >
                            <button
                                @click="closeModals"
                                class="rounded-lg bg-gray-500 px-4 py-2 text-white transition hover:bg-gray-600"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>

                <!-- <div
                    v-if="showHistoryModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                >
                    <div
                        class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl"
                    >
                        <h3 class="mb-4 text-xl font-bold text-blue-600">
                            Travel History — {{ selectedPassenger.name }}
                        </h3>
                        <table class="w-full border-collapse text-left">
                            <thead class="bg-blue-100">
                                <tr>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Flight</th>
                                    <th class="px-4 py-2">Route</th>
                                    <th class="px-4 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td class="px-4 py-2">2025-09-10</td>
                                    <td class="px-4 py-2">FL-102</td>
                                    <td class="px-4 py-2">Manila → Cebu</td>
                                    <td
                                        class="px-4 py-2 font-medium text-green-600"
                                    >
                                        Completed
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="px-4 py-2">2025-08-22</td>
                                    <td class="px-4 py-2">FL-076</td>
                                    <td class="px-4 py-2">Cebu → Davao</td>
                                    <td
                                        class="px-4 py-2 font-medium text-yellow-600"
                                    >
                                        Refunded
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-6 flex justify-end">
                            <button
                                class="rounded-lg bg-gray-600 px-4 py-2 text-white hover:bg-gray-700"
                                @click="closeModals"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>

<style scoped>
button {
    transition: all 0.2s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.96);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.25s ease-out;
}
</style>
