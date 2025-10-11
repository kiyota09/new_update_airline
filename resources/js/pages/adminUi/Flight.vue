<script setup lang="ts">

import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';

const breadcrumbs = [
  { label: 'Dashboard', href: '/dashboard' },
  { label: 'Flight Management', href: '/flightmanagement' }
];

const isModalOpen = ref(false);

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};
</script>

<template>
  <Head title="Flight Management" />

    <div class="p-6 bg-gray-50 min-h-screen">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-sky-800">Flight Management</h1>
        <button
          @click="openModal"
          class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-lg shadow-md"
        >
          + Add Flight
        </button>
      </div>

      <!-- Description -->
      <p class="text-gray-600 mb-6">
        Manage flights — Add, update, or cancel flights. Set flight details,
        schedules, status, and assign crew.
      </p>

      <!-- Table -->
      <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <table class="min-w-full text-sm text-left text-gray-600">
          <thead class="bg-sky-100 text-gray-700 uppercase text-xs">
            <tr>
              <th class="px-6 py-3">Flight No.</th>
              <th class="px-6 py-3">Aircraft</th>
              <th class="px-6 py-3">Origin</th>
              <th class="px-6 py-3">Destination</th>
              <th class="px-6 py-3">Schedule</th>
              <th class="px-6 py-3">Status</th>
              <th class="px-6 py-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b hover:bg-gray-50">
              <td class="px-6 py-3 font-medium">NC101</td>
              <td class="px-6 py-3">A320</td>
              <td class="px-6 py-3">Manila</td>
              <td class="px-6 py-3">Cebu</td>
              <td class="px-6 py-3">2025-10-15 09:00</td>
              <td class="px-6 py-3">
                <span
                  class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs"
                >
                  On-time
                </span>
              </td>
              <td class="px-6 py-3 flex justify-center gap-2">
                <button class="text-sky-600 hover:text-sky-800">
                  <i class="fa-solid fa-pen"></i>
                </button>
                <button class="text-red-500 hover:text-red-700">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </td>
            </tr>

            <tr class="border-b hover:bg-gray-50">
              <td class="px-6 py-3 font-medium">NC202</td>
              <td class="px-6 py-3">B737</td>
              <td class="px-6 py-3">Davao</td>
              <td class="px-6 py-3">Manila</td>
              <td class="px-6 py-3">2025-10-15 13:30</td>
              <td class="px-6 py-3">
                <span
                  class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs"
                >
                  Delayed
                </span>
              </td>
              <td class="px-6 py-3 flex justify-center gap-2">
                <button class="text-sky-600 hover:text-sky-800">
                  <i class="fa-solid fa-pen"></i>
                </button>
                <button class="text-red-500 hover:text-red-700">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modal -->
      <div
        v-if="isModalOpen"
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
      >
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6 relative">
          <h2 class="text-xl font-semibold mb-4">Add Flight</h2>

          <form @submit.prevent="closeModal" class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700"
                >Flight Number</label
              >
              <input
                type="text"
                class="mt-1 w-full border rounded-lg p-2"
                placeholder="e.g. NC303"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700"
                >Aircraft Type</label
              >
              <input
                type="text"
                class="mt-1 w-full border rounded-lg p-2"
                placeholder="e.g. A320"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Origin</label>
              <input
                type="text"
                class="mt-1 w-full border rounded-lg p-2"
                placeholder="e.g. Manila"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700"
                >Destination</label
              >
              <input
                type="text"
                class="mt-1 w-full border rounded-lg p-2"
                placeholder="e.g. Cebu"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700"
                >Schedule</label
              >
              <input
                type="datetime-local"
                class="mt-1 w-full border rounded-lg p-2"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700"
                >Duration (hrs)</label
              >
              <input
                type="number"
                class="mt-1 w-full border rounded-lg p-2"
                placeholder="e.g. 2"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Status</label>
              <select class="mt-1 w-full border rounded-lg p-2">
                <option>On-time</option>
                <option>Delayed</option>
                <option>Cancelled</option>
                <option>Landed</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700"
                >Crew Assigned</label
              >
              <input
                type="text"
                class="mt-1 w-full border rounded-lg p-2"
                placeholder="e.g. Capt. Reyes, F.O. Dela Cruz"
              />
            </div>

            <div class="col-span-2 flex justify-end gap-3 mt-4">
              <button
                type="button"
                @click="closeModal"
                class="px-4 py-2 border rounded-lg hover:bg-gray-100"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg"
              >
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

</template>

<style scoped>
[v-cloak] {
  display: none;
}
</style>