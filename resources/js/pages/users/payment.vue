<script setup>
import { ref } from 'vue'

const paymentMethod = ref('full')
const selectedBank = ref('Security Bank (0% Interest)')
const email = ref('')
const name = ref('')

const items = [
  { name: 'Tray Load Washing Machine', price: 37389.00 },
  { name: '43-UHD Android TV', price: 14998.00 },
  { name: 'Side-by-Side Refrigerator', price: 33598.00 }
]

const total = items.reduce((sum, item) => sum + item.price, 0)
</script>

<template>
  <div class="min-h-screen bg-gray-50 p-4">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-sm">
      <!-- Header -->
      <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 p-6 rounded-t-lg">
        <div class="text-white text-sm mb-1">You're paying</div>
        <div class="text-white text-lg font-medium">Anson's Philippines</div>
      </div>

      <div class="p-6">
        <!-- Back Button -->
        <button class="text-gray-500 text-sm mb-6 hover:text-gray-700">← Back</button>

        <!-- Items List -->
        <div class="mb-6">
          <div class="text-gray-700 font-medium mb-3">You're paying for these item(s)</div>
          <div class="space-y-2">
            <div
              v-for="(item, index) in items"
              :key="index"
              class="flex items-start gap-3 text-sm"
            >
              <div class="text-gray-400">{{ index + 1 }}</div>
              <div class="flex-1">
                <div class="text-gray-700">{{ item.name }}</div>
                <div class="text-gray-500">₱ {{ item.price.toFixed(2) }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Amount -->
        <div class="mb-6">
          <div class="text-gray-500 text-sm mb-1">Total amount</div>
          <div class="text-2xl font-bold text-gray-800">₱ {{ total.toFixed(2) }}</div>
        </div>

        <!-- Payment Method Options -->
        <div class="mb-6">
          <div class="text-gray-700 font-medium mb-3">Payment Method</div>
          <div class="grid grid-cols-4 gap-2 mb-4">
            <div class="flex flex-col items-center justify-center p-3 border rounded hover:border-blue-500 cursor-pointer">
              <div class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded mb-1">VISA</div>
              <div class="text-xs text-gray-500">Credit/Debit Card</div>
            </div>
            <div class="flex flex-col items-center justify-center p-3 border rounded hover:border-blue-500 cursor-pointer">
              <div class="bg-gradient-to-r from-blue-400 to-blue-600 text-white text-xs font-bold px-2 py-1 rounded mb-1">GCash</div>
            </div>
            <div class="flex flex-col items-center justify-center p-3 border rounded hover:border-blue-500 cursor-pointer">
              <div class="bg-black text-white text-xs font-bold px-2 py-1 rounded mb-1">MAYA</div>
              <div class="text-xs text-gray-500">MAYA</div>
            </div>
            <div class="flex flex-col items-center justify-center p-3 border rounded hover:border-blue-500 cursor-pointer">
              <div class="bg-yellow-400 text-black text-xs font-bold px-2 py-1 rounded mb-1">⚡</div>
              <div class="text-xs text-gray-500">Atome</div>
            </div>
          </div>
          
          <div class="flex items-center justify-center p-2 border rounded hover:border-emerald-500 cursor-pointer">
            <div class="flex items-center gap-2">
              <div class="w-16">
                <svg viewBox="0 0 60 20" class="w-full">
                  <text x="0" y="15" class="fill-emerald-500 font-bold" style="font-size: 12px">Grab</text>
                  <text x="25" y="15" class="fill-gray-700 font-bold" style="font-size: 12px">Pay</text>
                </svg>
              </div>
              <span class="text-xs text-gray-500">GrabPay</span>
            </div>
          </div>
        </div>
        <!-- Customer Information -->
        <div class="mb-6">
          <div class="text-gray-700 font-medium mb-3">Customer Information</div>
          
          <div class="mb-4">
            <label class="block text-sm text-gray-600 mb-2">Email</label>
            <input 
              type="email"
              placeholder="juan.delacruz@gmail.com"
              class="w-full border border-gray-300 rounded-lg p-3 text-sm"
              v-model="email"
            />
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-2">Name</label>
            <input 
              type="text"
              placeholder="Juan Dela Cruz"
              class="w-full border border-gray-300 rounded-lg p-3 text-sm"
              v-model="name"
            />
          </div>
        </div>

        <!-- Proceed Button -->
        <button class="w-full bg-blue-400 hover:bg-blue-500 text-white font-medium py-3 rounded-lg transition-colors">
          Proceed to installment plan →
        </button>
      </div>

      <!-- Footer -->
      <div class="bg-gray-800 text-white p-4 rounded-b-lg flex items-center justify-between">
        <div class="flex items-center gap-2">
          <div class="bg-emerald-500 text-white px-2 py-1 rounded text-xs font-bold">🔒 Secured Payment</div>
        </div>
        <div class="flex items-center gap-1 text-xs">
          <span>Powered by</span>
          <span class="font-bold">PayMongo</span>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* You can add component-specific styles here if needed */
</style>