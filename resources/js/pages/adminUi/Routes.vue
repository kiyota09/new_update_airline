<script setup lang="ts">
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
import Sidebar from './NewSideBar.vue';
// Modal states
const showAddModals = ref(false);

const showEditModal = ref(false);
const showDeleteModal = ref(false);

// Form data
const formData = useForm({
    id: '',
    origin_route: '',
    destination_route: '',
    base_price: '',
    duration: '',
    distance: '',
    aircraft: '',
});

// Page data
const page = usePage();
const data = ref(page.props.RouteList);

const aircrafts = ref(page.props.AircraftList);

// Current selected route for edit/delete
const currentRoute = ref(null);

// Open Add Modal
const openAddModal = () => {
    resetForm();
    showAddModals.value = true;
};

// Open Edit Modal
const openEditModal = (route: any) => {
    currentRoute.value = route;
    formData.id = route.id;
    formData.origin_route = route.origin_route;
    formData.destination_route = route.destination_route;
    formData.base_price = route.base_price;
    formData.duration = route.duration;
    formData.distance = route.distance;
    showEditModal.value = true;
};

// Open Delete Modal
const openDeleteModal = (route: any) => {
    currentRoute.value = route;
    showDeleteModal.value = true;
};

// Close all modals and reset form
const closeModals = () => {
    showEditModal.value = false;
    showDeleteModal.value = false;
    resetForm();
};
const closeModal = () => {
    showAddModals.value = false;

    resetForm();
};

// Reset form
const resetForm = () => {
    formData.reset();
    currentRoute.value = null;
};

// Submit new route
const submitRoute = () => {

    formData.post('/route_location', {
        // prevent full reload
        preserveState: true,
        preserveScroll: true,

        onSuccess: (page) => {
            data.value = [
                ...data.value,
                { ...formData.value, id: page.props.newId },
            ];

            // Reset form and close modal
            formData.reset();
        },
        onError: (errors) => console.log(errors),
    });
    closeModal();
    window.location.reload();
};

watch(
    () => page.props.RouteList,
    (newList) => {
        if (newList) data.value = newList;
    },
);
// Update existing route
const updateRoute = () => {
    if (!currentRoute.value) return;

    router.put(`/routes/${currentRoute.value.id}`, formData, {
        onSuccess: (page) => {
            // Update local table without reload
            const index = data.value.findIndex(
                (r) => r.id === currentRoute.value.id,
            );
            if (index !== -1) {
                data.value[index] = { ...data.value[index], ...formData };
            }
            closeModals();
        },
        onError: (errors) => console.log(errors),
    });
};

// Confirm delete
const confirmDelete = () => {
    router.delete(`/route_location/${currentRoute.value.id}`, {
        onSuccess: () => {
            data.value = data.value.filter(
                (r) => r.id !== currentRoute.value.id,
            );
            closeModals();
        },
        onError: (errors) => console.log(errors),
    });
};

onMounted(() => {
    resetForm();
});

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



</script>

<template>
    <Head title="Route Management" />

    <div class="flex min-h-screen bg-gray-50">
        <Sidebar />

        <div class="ml-64 flex-1">
            <div class="p-6">
                <div class="mb-8 flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-blue-600">
                        Route Management
                    </h1>
                    <button
                        @click="openAddModal"
                        class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition hover:bg-blue-700"
                    >
                        + Add Route
                    </button>
                </div>
               
                <!-- Routes Table -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-xl">
                    <table class="w-full border-collapse text-left">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-4 py-3">Route ID</th>
                                <th class="px-4 py-3">Origin</th>
                                <th class="px-4 py-3">Destination</th>
                                <th class="px-4 py-3">Base Price</th>
                                <th class="px-4 py-3">Duration</th>
                                <th class="px-4 py-3">Distance</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="row in data"
                                :key="row.id"
                                class="border-b border-gray-200 transition hover:bg-gray-50"
                            >
                                <td class="px-4 py-3">RT-10{{ row.id }}</td>
                                <td class="px-4 py-3">
                                    {{ row.origin_route }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ row.destination_route }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ row.base_price.toLocaleString() }}
                                </td>
                                <td class="px-4 py-3">{{ row.duration }}</td>
                                <td class="px-4 py-3">{{ row.distance }}km</td>
                                <td
                                    class="flex justify-center space-x-2 px-4 py-3"
                                >
                                    <button
                                        @click="openEditModal(row)"
                                        class="rounded bg-yellow-500 px-3 py-1 text-sm text-white hover:bg-yellow-600"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="openDeleteModal(row)"
                                        class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Modal -->
        <div
            v-if="showAddModals"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 p-4 backdrop-blur-sm"
        >
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-xl">
                <div class="p-6">
                    <h2 class="mb-4 text-2xl font-bold text-blue-600">
                        Add Flight Route
                    </h2>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Origin Dropdown -->
                         <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Aircraft</label
                            >
                            <select
                                v-model="formData.aircraft"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                            >
                                <option value="" disabled>Select aircraft</option>
                                <option
                                    v-for="aircraft in aircrafts"
                                    :key="aircraft.id"
                                    :value="aircraft.id"
                                >
                                    {{ aircraft.model }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Origin</label
                            >
                            <select
                                v-model="formData.origin_route"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                            >
                                <option value="" disabled>Select origin</option>
                                <option
                                    v-for="airport in airports"
                                    :key="airport.id"
                                    :value="airport.airport"
                                >
                                    {{ airport.city }} - {{ airport.airport }}
                                </option>
                            </select>
                        </div>

                        <!-- Destination Dropdown -->
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Destination</label
                            >
                            <select
                                v-model="formData.destination_route"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                            >
                                <option value="" disabled>
                                    Select destination
                                </option>
                                <option
                                    v-for="airport in airports"
                                    :key="airport.id"
                                    :value="airport.airport"
                                >
                                    {{ airport.city }} - {{ airport.airport }}
                                </option>
                            </select>
                        </div>

                        <!-- Base Price -->
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Base Price (₱)</label
                            >
                            <input
                                v-model="formData.base_price"
                                type="number"
                                placeholder="e.g., 3200"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                            />
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Duration</label
                            >
                            <input
                                v-model="formData.duration"
                                type="time"
                                placeholder="e.g., 1h 25m"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                            />
                        </div>

                        <!-- Distance -->
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Distance (km)</label
                            >
                            <input
                                v-model="formData.distance"
                                type="number"
                                placeholder="e.g., 571"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                            />
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        <button
                            @click="closeModal"
                            class="rounded-lg bg-gray-600 px-6 py-2 font-medium text-white transition hover:bg-gray-700"
                        >
                            Cancel
                        </button>
                        <button
                            @click="submitRoute"
                            class="rounded-lg bg-blue-600 px-6 py-2 font-medium text-white transition hover:bg-blue-700"
                        >
                            Save Route
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div
            v-if="showEditModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 p-4 backdrop-blur-sm"
        >
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-xl">
                <div class="p-6">
                    <h2 class="mb-4 text-2xl font-bold text-blue-600">
                        Edit Flight Route
                    </h2>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Origin</label
                            >
                            <input
                                v-model="formData.origin_route"
                                type="text"
                                placeholder="e.g., Manila (MNL)"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Destination</label
                            >
                            <input
                                v-model="formData.destination_route"
                                type="text"
                                placeholder="e.g., Cebu (CEB)"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Base Price (₱)</label
                            >
                            <input
                                v-model="formData.base_price"
                                type="number"
                                placeholder="e.g., 3200"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Duration</label
                            >
                            <input
                                v-model="formData.duration"
                                type="text"
                                placeholder="e.g., 1h 25m"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                            />
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Distance (km)</label
                            >
                            <input
                                v-model="formData.distance"
                                type="number"
                                placeholder="e.g., 571"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                            />
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        <button
                            @click="closeModals"
                            class="rounded-lg bg-gray-600 px-6 py-2 font-medium text-white transition hover:bg-gray-700"
                        >
                            Cancel
                        </button>
                        <button
                            @click="updateRoute"
                            class="rounded-lg bg-blue-600 px-6 py-2 font-medium text-white transition hover:bg-blue-700"
                        >
                            Update Route
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 p-4 backdrop-blur-sm"
        >
            <div class="w-full max-w-md rounded-2xl bg-white shadow-xl">
                <div class="p-6">
                    <h2 class="mb-4 text-2xl font-bold text-red-600">
                        Delete Route
                    </h2>
                    <p class="mb-4 text-gray-600">
                        Are you sure you want to delete the route from
                        <strong>{{ currentRoute?.origin_route }}</strong> to
                        <strong>{{ currentRoute?.destination_route }}</strong
                        >? This action cannot be undone.
                    </p>

                    <div class="mt-8 flex justify-end space-x-4">
                        <button
                            @click="closeModals"
                            class="rounded-lg bg-gray-600 px-6 py-2 font-medium text-white transition hover:bg-gray-700"
                        >
                            Cancel
                        </button>
                        <button
                            @click="confirmDelete"
                            class="rounded-lg bg-red-600 px-6 py-2 font-medium text-white transition hover:bg-red-700"
                        >
                            Delete Route
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
