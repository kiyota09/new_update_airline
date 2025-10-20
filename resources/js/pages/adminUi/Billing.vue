<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Sidebar from './NewSideBar.vue';

const page = usePage();
const income = page.props.total_income;
const payments = page.props.history;
// ✅ Format total income with $ and commas
const total = computed(() => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(income);
});

// === Demo Data (Replace later with backend) ===

// === Filters & States ===
const selectedTransaction = ref<any>(null);
const showInvoiceModal = ref(false);
const showRefundModal = ref(false);

// === Computed Reports ===

// === Actions ===
const openInvoice = (transaction) => {
    selectedTransaction.value = transaction;
    showInvoiceModal.value = true;
};

const closeModals = () => {
    showInvoiceModal.value = false;
    showRefundModal.value = false;
};

const confirmRefund = () => {
    if (selectedTransaction.value) {
        selectedTransaction.value.status = 'Refunded';
    }
    closeModals();
};
</script>

<template>
    <Head title="Payment & Billing Management" />

    <div class="flex min-h-screen bg-gray-50">
        <Sidebar />

        <div class="ml-64 flex-1">
            <div class="p-6">
                <!-- Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Payment & Billing Management
                        </h1>
                        <p class="text-gray-600">
                            Manage payments, refunds, and billing transactions
                        </p>
                    </div>
                </div>

                <!-- Dashboard Summary -->
                <div class="mb-8 grid gap-6 md:grid-cols-3">
                    <div
                        class="rounded-2xl bg-green-100 p-6 text-center shadow"
                    >
                        <h2 class="text-3xl font-bold text-green-600">
                            {{ total }}
                        </h2>
                        <p class="font-medium text-gray-700">Total Income</p>
                    </div>
                </div>
                <!-- Transactions Table -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-xl">
                    <table class="w-full border-collapse text-left">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Booking ID</th>
                                <th class="px-4 py-3">Reference</th>
                                <th class="px-4 py-3">Passenger</th>
                                <th class="px-4 py-3">Amount ($)</th>
                                <th class="px-4 py-3">Payment Method</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="transaction in payments"
                                :key="transaction.id"
                                class="border-b border-gray-200 transition hover:bg-gray-50"
                            >
                                <td class="px-4 py-3">{{ transaction.id }}</td>
                                <td class="px-4 py-3 font-medium">
                                    {{ transaction.booking_id }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ transaction.payment_ref }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ transaction.passenger }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ transaction.price.toLocaleString() }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ transaction.paymentMethod }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ transaction.date }}
                                </td>
                                <td
                                    class="px-4 py-3 font-medium text-green-600"
                                >
                                    Paid
                                </td>
                                <td class="flex justify-center gap-2 px-4 py-3">
                                    <button
                                        @click="openInvoice(transaction)"
                                        class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
                                    >
                                        Details
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Invoice Modal -->
                <div
                    v-if="showInvoiceModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                >
                    <div
                        class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl"
                    >
                        <!-- Header -->
                        <div
                            class="mb-4 flex items-center justify-between border-b pb-3"
                        >
                            <div>
                                <h3 class="text-xl font-bold text-blue-600">
                                    Receipt / Invoice
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Transaction Details
                                </p>
                            </div>
                            <span class="text-sm text-gray-400"
                                >#{{ selectedTransaction.payment_ref }}</span
                            >
                        </div>

                        <!-- Company Info -->
                        <div class="mb-4 text-sm text-gray-700">
                            <p><strong>Airline:</strong> SkyHigh Airlines</p>
                            <p>
                                <strong>Address:</strong> 123 Aviation St,
                                Manila, Philippines
                            </p>
                            <p><strong>Contact:</strong> +63 {{ selectedTransaction.contact }}</p>
                        </div>

                        <!-- Passenger Info -->
                        <div class="mb-4 border-b pb-3 text-sm text-gray-700">
                            <p>
                                <strong>Passenger:</strong>
                                {{ selectedTransaction.passenger }}
                            </p>
                            <p>
                                <strong>Payment Method:</strong>
                                {{ selectedTransaction.paymentMethod }}
                            </p>
                            <p>
                                <strong>Date:</strong>
                                {{ selectedTransaction.date }}
                            </p>
                            <p>
                                <strong>Status:</strong>
                                <span class="font-medium text-green-600"
                                    >Paid</span
                                >
                            </p>
                        </div>

                        <!-- Transaction Table -->
                        <div class="mb-4">
                            <table class="w-full text-sm">
                                <thead class="border-b">
                                    <tr>
                                        <th class="pb-2 text-left">
                                            Description
                                        </th>
                                        <th class="pb-2 text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-2">
                                            Booking
                                            {{ selectedTransaction.booking_id }}
                                        </td>
                                        <td class="py-2 text-right">
                                            ${{
                                                selectedTransaction.price.toLocaleString()
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="border-t pt-2">
                                    <tr class="font-bold text-gray-800">
                                        <td class="pt-2">Total</td>
                                        <td class="pt-2 text-right">
                                            ${{
                                                selectedTransaction.price.toLocaleString()
                                            }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Footer -->
                        <div
                            class="flex items-center justify-between border-t pt-3"
                        >
                            <button
                                @click="closeModals"
                                class="rounded-lg bg-gray-500 px-4 py-2 text-white hover:bg-gray-600"
                            >
                                Close
                            </button>
                            <button
                                @click="window.print()"
                                class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                            >
                                Print / Save
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Refund Modal -->
                <div
                    v-if="showRefundModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                >
                    <div
                        class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl"
                    >
                        <h3 class="mb-4 text-xl font-bold text-red-600">
                            Confirm Refund
                        </h3>
                        <p class="mb-4 text-gray-700">
                            Are you sure you want to refund
                            <strong
                                >{{
                                    selectedTransaction.amount.toLocaleString()
                                }}
                                ₱</strong
                            >
                            for booking
                            <strong>{{ selectedTransaction.bookingId }}</strong
                            >?
                        </p>

                        <div class="flex justify-end gap-2">
                            <button
                                @click="closeModals"
                                class="rounded-lg bg-gray-500 px-4 py-2 text-white hover:bg-gray-600"
                            >
                                Cancel
                            </button>
                            <button
                                @click="confirmRefund"
                                class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700"
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
