<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import Sidebar from './NewSideBar.vue';
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

// Modal states
const showAddModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);

// Form data
const formData = useForm({
  id: '',
  origin_route: '',
  destination_route: '',
  base_price: '',
  duration: '',
  distance: ''
});

// Page data
const page = usePage();
const data = ref(page.props.RouteList);

// Current selected route for edit/delete
const currentRoute = ref(null);

// Open Add Modal
const openAddModal = () => {
  resetForm();
  showAddModal.value = true;
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
  showAddModal.value = false;
  showEditModal.value = false;
  showDeleteModal.value = false;
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
    onSuccess: (page) => {
      data.value.push({ ...formData.value, id: page.props.newId });
      closeModals();
    },
    onError: (errors) => console.log(errors),
  });
};

// Update existing route
const updateRoute = () => {
  if (!currentRoute.value) return;

  router.put(`/routes/${currentRoute.value.id}`, formData, {
    onSuccess: (page) => {
      // Update local table without reload
      const index = data.value.findIndex(r => r.id === currentRoute.value.id);
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
      data.value = data.value.filter(r => r.id !== currentRoute.value.id);
      closeModals();
    },
    onError: (errors) => console.log(errors),
  });
};

onMounted(() => {
  resetForm();
});


const airports = [
  { id: 1, country: 'Philippines', city: 'Manila', airport: 'Ninoy Aquino International Airport (MNL)' },
  { id: 2, country: 'Japan', city: 'Tokyo', airport: 'Narita International Airport (NRT)' },
  { id: 3, country: 'France', city: 'Paris', airport: 'Charles de Gaulle Airport (CDG)' },
];
</script>



<template>
  <Head title="Route Management" />

  <div class="flex min-h-screen bg-gray-50">
    <Sidebar />

    <div class="flex-1 ml-64">
      <div class="p-6">
        <div class="flex justify-between items-center mb-8">
          <h1 class="text-3xl font-bold text-blue-600">
            Route Management
          </h1>
          <button
            @click="openAddModal"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition"
          >
            + Add Route
          </button>
        </div>

        <!-- Routes Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
          <table class="w-full text-left border-collapse">
            <thead class="bg-blue-600 text-white">
              <tr>
                <th class="py-3 px-4">Route ID</th>
                <th class="py-3 px-4">Origin</th>
                <th class="py-3 px-4">Destination</th>
                <th class="py-3 px-4">Base Price</th>
                <th class="py-3 px-4">Duration</th>
                <th class="py-3 px-4">Distance</th>
                <th class="py-3 px-4 text-center">Actions</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="row in data"
                :key="row.id"
                class="border-b border-gray-200 hover:bg-gray-50 transition"
              >
                <td class="py-3 px-4">RT-10{{ row.id }}</td>
                <td class="py-3 px-4">{{ row.origin_route }}</td>
                <td class="py-3 px-4">{{ row.destination_route }}</td>
                <td class="py-3 px-4">{{ row.base_price }}</td>
                <td class="py-3 px-4">{{ row.duration }}</td>
                <td class="py-3 px-4">{{ row.distance }}km</td>
                <td class="py-3 px-4 flex justify-center space-x-2">
                  <button
                    @click="openEditModal(row)"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-1 px-3 rounded"
                  >
                    Edit
                  </button>
                  <button
                    @click="openDeleteModal(row)"
                    class="bg-red-600 hover:bg-red-700 text-white text-sm py-1 px-3 rounded"
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
  v-if="showAddModal"
  class="fixed inset-0 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4 z-50"
>
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl">
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-4 text-blue-600">
        Add Flight Route
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Origin Dropdown -->
        <div>
          <label class="block text-sm font-medium mb-1">Origin</label>
          <select
            v-model="formData.origin_route"
            class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50"
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
          <label class="block text-sm font-medium mb-1">Destination</label>
          <select
            v-model="formData.destination_route"
            class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50"
          >
            <option value="" disabled>Select destination</option>
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
          <label class="block text-sm font-medium mb-1">Base Price (₱)</label>
          <input
            v-model="formData.base_price"
            type="number"
            placeholder="e.g., 3200"
            class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50"
          />
        </div>

        <!-- Duration -->
        <div>
          <label class="block text-sm font-medium mb-1">Duration</label>
          <input
            v-model="formData.duration"
            type="text"
            placeholder="e.g., 1h 25m"
            class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50"
          />
        </div>

        <!-- Distance -->
        <div>
          <label class="block text-sm font-medium mb-1">Distance (km)</label>
          <input
            v-model="formData.distance"
            type="number"
            placeholder="e.g., 571"
            class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50"
          />
        </div>
      </div>

      <div class="mt-8 flex justify-end space-x-4">
        <button
          @click="closeModals"
          class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg transition"
        >
          Cancel
        </button>
        <button
          @click="submitRoute"
          class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition"
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
      class="fixed inset-0 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4 z-50"
    >
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl">
        <div class="p-6">
          <h2 class="text-2xl font-bold mb-4 text-blue-600">
            Edit Flight Route
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium mb-1">Origin</label>
              <input
                v-model="formData.origin_route"
                type="text"
                placeholder="e.g., Manila (MNL)"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Destination</label>
              <input
                v-model="formData.destination_route"
                type="text"
                placeholder="e.g., Cebu (CEB)"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Base Price (₱)</label>
              <input
                v-model="formData.base_price"
                type="number"
                placeholder="e.g., 3200"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Duration</label>
              <input
                v-model="formData.duration"
                type="text"
                placeholder="e.g., 1h 25m"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50"
              />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Distance (km)</label>
              <input
                v-model="formData.distance"
                type="number"
                placeholder="e.g., 571"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50"
              />
            </div>
          </div>

          <div class="mt-8 flex justify-end space-x-4">
            <button
              @click="closeModals"
              class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg transition"
            >
              Cancel
            </button>
            <button
              @click="updateRoute"
              class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition"
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
      class="fixed inset-0 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4 z-50"
    >
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        <div class="p-6">
          <h2 class="text-2xl font-bold mb-4 text-red-600">
            Delete Route
          </h2>
          <p class="text-gray-600 mb-4">
            Are you sure you want to delete the route from 
            <strong>{{ currentRoute?.origin_route }}</strong> to 
            <strong>{{ currentRoute?.destination_route }}</strong>? 
            This action cannot be undone.
          </p>

          <div class="mt-8 flex justify-end space-x-4">
            <button
              @click="closeModals"
              class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg transition"
            >
              Cancel
            </button>
            <button
              @click="confirmDelete"
              class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-lg transition"
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
