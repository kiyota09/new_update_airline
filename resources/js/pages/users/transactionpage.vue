<script setup lang="ts">
import Topbar from '@/components/Topbar.vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';


const page = usePage();


const bookedFlight = page.props.user_history || [];




</script>

<template>
    <div
        class="min-h-screen bg-gradient-to-b from-blue-50 to-white text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100"
    >
        <Topbar />
        <main class="container mx-auto space-y-12 px-4 py-8">
            <!-- 💳 Payment Transactions Section -->
            <section>
                <h2
                    class="mb-4 text-xl font-bold text-blue-600 dark:text-blue-400"
                >
                    Payment Transactions
                </h2>

                <div
                    v-if="bookedFlight.length"
                    class="overflow-hidden rounded-2xl bg-white shadow-xl dark:bg-gray-800"
                >
                    <table class="w-full border-collapse">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">Date</th>
                                <th class="px-4 py-3 text-left">Reference</th>
                                <th class="px-4 py-3 text-left">Method</th>
                                <th class="px-4 py-3 text-left">Amount</th>
                                <th class="px-4 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="txn in bookedFlight"
                                :key="txn.id"
                                class="border-b border-gray-200 transition hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700"
                            >
                                <td class="px-4 py-3">{{ txn.date }}</td>
                                <td class="px-4 py-3 font-medium">
                                    {{ txn.payment_ref }}
                                </td>
                                <td class="px-4 py-3">{{ txn.paymentMethod }}</td>
                                <td class="px-4 py-3">
                                    $ {{ txn.price.toFixed(2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-block rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800">
                                        Done
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p
                    v-else
                    class="mt-4 text-center text-gray-500 dark:text-gray-400"
                >
                    No payment transactions found.
                </p>
            </section>
        </main>
    </div>
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
