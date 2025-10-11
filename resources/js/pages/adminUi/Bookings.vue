<script setup>

</script>

<template>
  <Head title="Booking Management" />
  
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
            Booking Management
          </h1>
          <button
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition"
          >
            + New Booking
          </button>
        </div>

        <!-- Bookings Table -->
        <div
          class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden"
        >
          <table class="w-full text-left border-collapse">
            <thead class="bg-blue-600 text-white">
              <tr>
                <th class="py-3 px-4">Booking ID</th>
                <th class="py-3 px-4">Passenger Name</th>
                <th class="py-3 px-4">Flight No.</th>
                <th class="py-3 px-4">Destination</th>
                <th class="py-3 px-4">Date</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4 text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Example Row -->
              <tr
                class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
              >
                <td class="py-3 px-4">BK-1024</td>
                <td class="py-3 px-4">John Dela Cruz</td>
                <td class="py-3 px-4">FL-230</td>
                <td class="py-3 px-4">Manila → Cebu</td>
                <td class="py-3 px-4">2025-10-12</td>
                <td class="py-3 px-4">
                  <span
                    class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium"
                    >Pending</span
                  >
                </td>
                <td class="py-3 px-4 flex justify-center space-x-2">
                  <button
                    class="bg-green-600 hover:bg-green-700 text-white text-sm py-1 px-3 rounded"
                  >
                    Approve
                  </button>
                  <button
                    class="bg-red-600 hover:bg-red-700 text-white text-sm py-1 px-3 rounded"
                  >
                    Cancel
                  </button>
                  <button
                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-1 px-3 rounded"
                  >
                    Modify
                  </button>
                  <button
                    class="bg-gray-600 hover:bg-gray-700 text-white text-sm py-1 px-3 rounded"
                  >
                    Print
                  </button>
                </td>
              </tr>

              <!-- Another Sample Row -->
              <tr
                class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
              >
                <td class="py-3 px-4">BK-1025</td>
                <td class="py-3 px-4">Maria Santos</td>
                <td class="py-3 px-4">FL-145</td>
                <td class="py-3 px-4">Davao → Manila</td>
                <td class="py-3 px-4">2025-10-13</td>
                <td class="py-3 px-4">
                  <span
                    class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium"
                    >Approved</span
                  >
                </td>
                <td class="py-3 px-4 flex justify-center space-x-2">
                  <button
                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-1 px-3 rounded"
                  >
                    Modify
                  </button>
                  <button
                    class="bg-gray-600 hover:bg-gray-700 text-white text-sm py-1 px-3 rounded"
                  >
                    Reissue
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Passenger Manifest Section -->
        <div
          class="mt-12 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6"
        >
          <h2 class="text-2xl font-bold mb-4 text-blue-600 dark:text-blue-400">
            Passenger Manifest
          </h2>
          <p class="text-gray-600 dark:text-gray-300 mb-4">
            View passengers for a specific flight.
          </p>
          <div class="flex space-x-4 mb-6">
            <input
              type="text"
              placeholder="Enter Flight Number (e.g., FL-230)"
              class="flex-1 rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 dark:bg-gray-700"
            />
            <button
              class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition"
            >
              View Manifest
            </button>
          </div>

          <!-- Example Table -->
          <table class="w-full text-left border-collapse">
            <thead class="bg-blue-100 dark:bg-gray-700">
              <tr>
                <th class="py-2 px-4">#</th>
                <th class="py-2 px-4">Passenger Name</th>
                <th class="py-2 px-4">Seat No.</th>
                <th class="py-2 px-4">Ticket Status</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="py-2 px-4">1</td>
                <td class="py-2 px-4">John Dela Cruz</td>
                <td class="py-2 px-4">12A</td>
                <td class="py-2 px-4 text-green-600 font-medium">Checked-In</td>
              </tr>
              <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="py-2 px-4">2</td>
                <td class="py-2 px-4">Maria Santos</td>
                <td class="py-2 px-4">14B</td>
                <td class="py-2 px-4 text-yellow-600 font-medium">Pending</td>
              </tr>
            </tbody>
          </table>
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
