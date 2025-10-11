<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { ref } from 'vue'

// === Demo Help Tickets (replace later with backend data) ===
const tickets = ref([
  {
    id: 1,
    subject: 'Refund Request for Cancelled Flight',
    category: 'Refund',
    status: 'Resolved',
    date: '2025-10-05',
  },
  {
    id: 2,
    subject: 'Lost Luggage Complaint',
    category: 'Baggage',
    status: 'Pending',
    date: '2025-10-07',
  },
  {
    id: 3,
    subject: 'Seat Change Request',
    category: 'Booking',
    status: 'In Progress',
    date: '2025-10-09',
  },
])

// === New Ticket Form ===
const newTicket = ref({
  subject: '',
  category: '',
  message: '',
})

const categories = ['Refund', 'Booking', 'Baggage', 'Flight Delay', 'Other']

const submitTicket = () => {
  if (!newTicket.value.subject || !newTicket.value.category || !newTicket.value.message) {
    alert('Please fill in all fields before submitting.')
    return
  }

  const newId = tickets.value.length + 1
  tickets.value.push({
    id: newId,
    subject: newTicket.value.subject,
    category: newTicket.value.category,
    status: 'Pending',
    date: new Date().toISOString().split('T')[0],
  })

  alert('Your request has been submitted successfully!')
  newTicket.value = { subject: '', category: '', message: '' }
}
</script>

<template>
  <Head title="Help Desk - SkyWings" />
  <AppLayout>
    <div
      class="min-h-screen bg-gradient-to-b from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100"
    >
      <!-- HEADER -->
      <header
        class="bg-white/80 backdrop-blur-sm border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-700 sticky top-0 z-50"
      >
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
          <h1 class="text-2xl font-bold text-blue-600 dark:text-blue-400">
            Help Desk
          </h1>
        </div>
      </header>

      <main class="container mx-auto px-4 py-8 space-y-12">
        <!-- 📨 Submit Request Section -->
        <section>
          <h2 class="text-xl font-bold mb-4 text-blue-600 dark:text-blue-400">
            Submit a New Request
          </h2>

          <div
            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl max-w-3xl mx-auto"
          >
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Subject -->
              <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Subject</label>
                <input
                  type="text"
                  v-model="newTicket.subject"
                  placeholder="Enter your request subject"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                />
              </div>

              <!-- Category -->
              <div>
                <label class="block text-sm font-medium mb-1">Category</label>
                <select
                  v-model="newTicket.category"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                >
                  <option value="">Select Category</option>
                  <option v-for="cat in categories" :key="cat" :value="cat">
                    {{ cat }}
                  </option>
                </select>
              </div>

              <!-- Message -->
              <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Message</label>
                <textarea
                  v-model="newTicket.message"
                  placeholder="Describe your issue or concern..."
                  rows="5"
                  class="w-full rounded-lg border border-gray-300 px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                ></textarea>
              </div>
            </div>

            <div class="flex justify-end mt-6">
              <button
                @click="submitTicket"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition"
              >
                Submit Request
              </button>
            </div>
          </div>
        </section>

        <!-- 💬 Previous Requests Section -->
        <section>
          <h2 class="text-xl font-bold mb-4 text-blue-600 dark:text-blue-400">
            My Requests
          </h2>

          <div
            v-if="tickets.length"
            class="overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-xl"
          >
            <table class="w-full border-collapse">
              <thead class="bg-blue-600 text-white">
                <tr>
                  <th class="py-3 px-4 text-left">Subject</th>
                  <th class="py-3 px-4 text-left">Category</th>
                  <th class="py-3 px-4 text-left">Status</th>
                  <th class="py-3 px-4 text-left">Date</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="ticket in tickets"
                  :key="ticket.id"
                  class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                >
                  <td class="py-3 px-4 font-medium">{{ ticket.subject }}</td>
                  <td class="py-3 px-4">{{ ticket.category }}</td>
                  <td class="py-3 px-4">
                    <span
                      class="px-3 py-1 rounded-full text-sm font-medium"
                      :class="{
                        'bg-green-100 text-green-700': ticket.status === 'Resolved',
                        'bg-yellow-100 text-yellow-700': ticket.status === 'Pending',
                        'bg-blue-100 text-blue-700': ticket.status === 'In Progress',
                      }"
                    >
                      {{ ticket.status }}
                    </span>
                  </td>
                  <td class="py-3 px-4">{{ ticket.date }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <p v-else class="text-gray-500 dark:text-gray-400 mt-4 text-center">
            You have no submitted requests yet.
          </p>
        </section>
      </main>
    </div>
  </AppLayout>
</template>

<style scoped>
table {
  width: 100%;
  border-spacing: 0;
}
th,
td {
  padding: 0.75rem 1rem;
  text-align: left;
}
</style>
