<script lang="ts">

</script>

<template>
  

    <div
      class="min-h-screen bg-gradient-to-b from-blue-50 to-white text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100"
    >
      <!-- Header -->
      <header
        class="bg-white/80 backdrop-blur-sm border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-700 sticky top-0 z-50"
      >
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
          <div class="flex items-center space-x-4">
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
              <svg
                class="w-6 h-6 text-white"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                ></path>
              </svg>
            </div>
            <span class="text-xl font-bold text-blue-600 dark:text-blue-400"
              >SkyWings Admin</span
            >
          </div>

          <div class="relative">
            <button
              class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center cursor-pointer hover:ring-2 hover:ring-blue-500 transition"
            >
              <span class="text-white font-bold uppercase">AD</span>
            </button>
          </div>
        </div>
      </header>

      <!-- Main Content -->
      <main class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
          <h1 class="text-3xl font-bold text-blue-600 dark:text-blue-400">
            Route Management
          </h1>
          <button
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition"
          >
            + Add Route
          </button>
        </div>

        <!-- Routes Table -->
        <div
          class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden"
        >
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
              <tr
                class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
              >
                <td class="py-3 px-4">RT-1001</td>
                <td class="py-3 px-4">Manila (MNL)</td>
                <td class="py-3 px-4">Cebu (CEB)</td>
                <td class="py-3 px-4">₱3,200</td>
                <td class="py-3 px-4">1h 25m</td>
                <td class="py-3 px-4">571 km</td>
                <td class="py-3 px-4 flex justify-center space-x-2">
                  <button
                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-1 px-3 rounded"
                  >
                    Edit
                  </button>
                  <button
                    class="bg-red-600 hover:bg-red-700 text-white text-sm py-1 px-3 rounded"
                  >
                    Delete
                  </button>
                </td>
              </tr>

              <!-- Another Example Row -->
              <tr
                class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
              >
                <td class="py-3 px-4">RT-1002</td>
                <td class="py-3 px-4">Davao (DVO)</td>
                <td class="py-3 px-4">Manila (MNL)</td>
                <td class="py-3 px-4">₱4,500</td>
                <td class="py-3 px-4">1h 45m</td>
                <td class="py-3 px-4">977 km</td>
                <td class="py-3 px-4 flex justify-center space-x-2">
                  <button
                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-1 px-3 rounded"
                  >
                    Edit
                  </button>
                  <button
                    class="bg-red-600 hover:bg-red-700 text-white text-sm py-1 px-3 rounded"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Add/Edit Route Form -->
        <div
          class="mt-12 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6"
        >
          <h2 class="text-2xl font-bold mb-4 text-blue-600 dark:text-blue-400">
            Add / Edit Flight Route
          </h2>
          <p class="text-gray-600 dark:text-gray-300 mb-4">
            Fill in the route details below to add a new flight route or edit an existing one.
          </p>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium mb-1">Origin</label>
              <input
                type="text"
                placeholder="e.g., Manila (MNL)"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 dark:bg-gray-700"
              />
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Destination</label>
              <input
                type="text"
                placeholder="e.g., Cebu (CEB)"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 dark:bg-gray-700"
              />
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Base Price (₱)</label>
              <input
                type="number"
                placeholder="e.g., 3200"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 dark:bg-gray-700"
              />
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Duration</label>
              <input
                type="text"
                placeholder="e.g., 1h 25m"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 dark:bg-gray-700"
              />
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Distance (km)</label>
              <input
                type="number"
                placeholder="e.g., 571"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 dark:bg-gray-700"
              />
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="mt-8 flex justify-end space-x-4">
            <button
              class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg transition"
            >
              Clear
            </button>
            <button
              class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition"
            >
              Save Route
            </button>
          </div>
        </div>
      </main>
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
