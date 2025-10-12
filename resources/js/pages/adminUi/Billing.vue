<script setup>
import { ref, computed } from 'vue'
import Sidebar from './NewSideBar.vue'

// === Demo Data (Replace later with backend) ===
const transactions = ref([
  {
    id: 1,
    bookingId: 'BK-1001',
    passenger: 'John Dela Cruz',
    amount: 3200,
    status: 'Paid',
    date: '2025-10-09',
    method: 'Credit Card'
  },
  {
    id: 2,
    bookingId: 'BK-1002',
    passenger: 'Maria Santos',
    amount: 4500,
    status: 'Refunded',
    date: '2025-10-08',
    method: 'GCash'
  },
  {
    id: 3,
    bookingId: 'BK-1003',
    passenger: 'Alex Mendoza',
    amount: 2700,
    status: 'Pending',
    date: '2025-10-10',
    method: 'Bank Transfer'
  }
])

// === Filters & States ===
const selectedTransaction = ref(null)
const showInvoiceModal = ref(false)
const showRefundModal = ref(false)

// === Computed Reports ===
const totalIncome = computed(() =>
  transactions.value
    .filter((t) => t.status === 'Paid')
    .reduce((sum, t) => sum + t.amount, 0)
)
const totalRefunds = computed(() =>
  transactions.value
    .filter((t) => t.status === 'Refunded')
    .reduce((sum, t) => sum + t.amount, 0)
)
const totalPending = computed(() =>
  transactions.value
    .filter((t) => t.status === 'Pending')
    .reduce((sum, t) => sum + t.amount, 0)
)

// === Actions ===
const openInvoice = (transaction) => {
  selectedTransaction.value = transaction
  showInvoiceModal.value = true
}

const openRefundModal = (transaction) => {
  selectedTransaction.value = transaction
  showRefundModal.value = true
}

const closeModals = () => {
  showInvoiceModal.value = false
  showRefundModal.value = false
}

const confirmRefund = () => {
  if (selectedTransaction.value) {
    selectedTransaction.value.status = 'Refunded'
  }
  closeModals()
}
</script>

<template>
  <Head title="Payment & Billing Management" />
  
  <div class="flex min-h-screen bg-gray-50">
    <Sidebar />
    
    <div class="flex-1 ml-64">
      <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Payment & Billing Management</h1>
            <p class="text-gray-600">Manage payments, refunds, and billing transactions</p>
          </div>
          <button
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition"
          >
            + New Payment
          </button>
        </div>

        <!-- Dashboard Summary -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
          <div class="bg-green-100 p-6 rounded-2xl shadow text-center">
            <h2 class="text-3xl font-bold text-green-600">{{ totalIncome.toLocaleString() }} ₱</h2>
            <p class="font-medium text-gray-700">Total Income</p>
          </div>
          <div class="bg-yellow-100 p-6 rounded-2xl shadow text-center">
            <h2 class="text-3xl font-bold text-yellow-600">{{ totalPending.toLocaleString() }} ₱</h2>
            <p class="font-medium text-gray-700">Pending Payments</p>
          </div>
          <div class="bg-red-100 p-6 rounded-2xl shadow text-center">
            <h2 class="text-3xl font-bold text-red-600">{{ totalRefunds.toLocaleString() }} ₱</h2>
            <p class="font-medium text-gray-700">Total Refunds</p>
          </div>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
          <table class="w-full text-left border-collapse">
            <thead class="bg-blue-600 text-white">
              <tr>
                <th class="py-3 px-4">#</th>
                <th class="py-3 px-4">Booking ID</th>
                <th class="py-3 px-4">Passenger</th>
                <th class="py-3 px-4">Amount (₱)</th>
                <th class="py-3 px-4">Payment Method</th>
                <th class="py-3 px-4">Date</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4 text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="transaction in transactions"
                :key="transaction.id"
                class="border-b border-gray-200 hover:bg-gray-50 transition"
              >
                <td class="py-3 px-4">{{ transaction.id }}</td>
                <td class="py-3 px-4 font-medium">{{ transaction.bookingId }}</td>
                <td class="py-3 px-4">{{ transaction.passenger }}</td>
                <td class="py-3 px-4">{{ transaction.amount.toLocaleString() }}</td>
                <td class="py-3 px-4">{{ transaction.method }}</td>
                <td class="py-3 px-4">{{ transaction.date }}</td>
                <td class="py-3 px-4">
                  <span
                    class="px-3 py-1 rounded-full text-sm font-medium"
                    :class="{
                      'bg-green-100 text-green-700': transaction.status === 'Paid',
                      'bg-yellow-100 text-yellow-700': transaction.status === 'Pending',
                      'bg-red-100 text-red-700': transaction.status === 'Refunded'
                    }"
                  >
                    {{ transaction.status }}
                  </span>
                </td>
                <td class="py-3 px-4 flex justify-center gap-2">
                  <button
                    @click="openInvoice(transaction)"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm py-1 px-3 rounded"
                  >
                    Invoice
                  </button>
                  <button
                    @click="openRefundModal(transaction)"
                    class="bg-red-600 hover:bg-red-700 text-white text-sm py-1 px-3 rounded"
                    :disabled="transaction.status === 'Refunded'"
                  >
                    Refund
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Invoice Modal -->
        <div
          v-if="showInvoiceModal"
          class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
          <div
            class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md"
          >
            <h3 class="text-xl font-bold mb-4 text-blue-600">
              Receipt / Invoice
            </h3>

            <div class="text-sm space-y-2">
              <p><strong>Booking ID:</strong> {{ selectedTransaction.bookingId }}</p>
              <p><strong>Passenger:</strong> {{ selectedTransaction.passenger }}</p>
              <p><strong>Payment Method:</strong> {{ selectedTransaction.method }}</p>
              <p><strong>Date:</strong> {{ selectedTransaction.date }}</p>
              <p><strong>Amount:</strong> ₱{{ selectedTransaction.amount.toLocaleString() }}</p>
              <p><strong>Status:</strong> {{ selectedTransaction.status }}</p>
            </div>

            <div class="flex justify-end mt-6 gap-2">
              <button
                @click="closeModals"
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg"
              >
                Close
              </button>
              <button
                class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg"
              >
                Print / Save
              </button>
            </div>
          </div>
        </div>

        <!-- Refund Modal -->
        <div
          v-if="showRefundModal"
          class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
          <div
            class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md"
          >
            <h3 class="text-xl font-bold mb-4 text-red-600">
              Confirm Refund
            </h3>
            <p class="mb-4 text-gray-700">
              Are you sure you want to refund <strong>{{ selectedTransaction.amount.toLocaleString() }} ₱</strong> for booking <strong>{{ selectedTransaction.bookingId }}</strong>?
            </p>

            <div class="flex justify-end gap-2">
              <button
                @click="closeModals"
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg"
              >
                Cancel
              </button>
              <button
                @click="confirmRefund"
                class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg"
              >
                Confirm Refund
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
button {
  transition: all 0.2s ease;
}
</style>