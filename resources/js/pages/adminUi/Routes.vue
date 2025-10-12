<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Sidebar from './NewSideBar.vue';
import { ref } from 'vue';

// Modal states
const showAddModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);

// Form data
const formData = useForm({
  origin_route: '',
  destination_route: '',
  base_price: '',
  duration: '',
  distance: ''
});



// Sample route data for editing
const currentRoute = ref(null);

const openAddModal = () => {
  resetForm();
  showAddModal.value = true;
};

const openEditModal = (route) => {
  currentRoute.value = route;
  formData.value = {
    origin: route.origin,
    destination: route.destination,
    basePrice: route.basePrice.replace('₱', '').replace(',', ''),
    duration: route.duration,
    distance: route.distance.replace(' km', '')
  };
  showEditModal.value = true;
};

const openDeleteModal = (route) => {
  currentRoute.value = route;
  showDeleteModal.value = true;
};

const closeModals = () => {
  showAddModal.value = false;
  showEditModal.value = false;
  showDeleteModal.value = false;
  resetForm();
};

const resetForm = () => {
  formData.value = {
    origin_route: '',
    destination_route: '',
    base_price: '',
    duration: '',
    distance: ''
  };
  currentRoute.value = null;
};

const saveRoute = () => {
  console.log('Saving route:', formData.value);
  closeModals();
};

const confirmDelete = () => {
  console.log('Deleting route:', currentRoute.value);
  closeModals();
};

const submitRoute = () =>{
  formData.post('/route_location', {
    onSuccess: () => {
      closeModals();
    },
    onError: (errors) => {
      console.log(errors);
    }
  });
}




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
              <!-- Example Row -->
              <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                <td class="py-3 px-4">RT-1001</td>
                <td class="py-3 px-4">Manila (MNL)</td>
                <td class="py-3 px-4">Cebu (CEB)</td>
                <td class="py-3 px-4">₱3,200</td>
                <td class="py-3 px-4">1h 25m</td>
                <td class="py-3 px-4">571 km</td>
                <td class="py-3 px-4 flex justify-center space-x-2">
                  <button
                    @click="openEditModal({
                      id: 'RT-1001',
                      origin: 'Manila (MNL)',
                      destination: 'Cebu (CEB)',
                      basePrice: '₱3,200',
                      duration: '1h 25m',
                      distance: '571 km'
                    })"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-1 px-3 rounded"
                  >
                    Edit
                  </button>
                  <button
                    @click="openDeleteModal({
                      id: 'RT-1001',
                      origin: 'Manila (MNL)',
                      destination: 'Cebu (CEB)'
                    })"
                    class="bg-red-600 hover:bg-red-700 text-white text-sm py-1 px-3 rounded"
                  >
                    Delete
                  </button>
                </td>
              </tr>

              <!-- Another Example Row -->
              <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                <td class="py-3 px-4">RT-1002</td>
                <td class="py-3 px-4">Davao (DVO)</td>
                <td class="py-3 px-4">Manila (MNL)</td>
                <td class="py-3 px-4">₱4,500</td>
                <td class="py-3 px-4">1h 45m</td>
                <td class="py-3 px-4">977 km</td>
                <td class="py-3 px-4 flex justify-center space-x-2">
                  <button
                    @click="openEditModal({
                      id: 'RT-1002',
                      origin: 'Davao (DVO)',
                      destination: 'Manila (MNL)',
                      basePrice: '₱4,500',
                      duration: '1h 45m',
                      distance: '977 km'
                    })"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-1 px-3 rounded"
                  >
                    Edit
                  </button>
                  <button
                    @click="openDeleteModal({
                      id: 'RT-1002',
                      origin: 'Davao (DVO)',
                      destination: 'Manila (MNL)'
                    })"
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

    <!-- Add Route Modal -->
    <div
      v-if="showAddModal"
      class="fixed inset-0 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4 z-50"
    >
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl">
        <div class="p-6">
          <h2 class="text-2xl font-bold mb-4 text-blue-600">
            Add Flight Route
          </h2>
          <p class="text-gray-600 mb-4">
            Fill in the route details below to add a new flight route.
          </p>

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
              @click="submitRoute"
              class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition"
            >
              Save Route
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Route Modal -->
    <div
      v-if="showEditModal"
      class="fixed inset-0 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4 z-50"
    >
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl">
        <div class="p-6">
          <h2 class="text-2xl font-bold mb-4 text-blue-600">
            Edit Flight Route
          </h2>
          <p class="text-gray-600 mb-4">
            Update the route details below.
          </p>

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
              @click="saveRoute"
              class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition"
            >
              Update Route
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
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
