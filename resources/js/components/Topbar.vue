<script lang="ts" setup>
import type { User } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onBeforeUnmount, ref } from 'vue';

// Dropdown states
const isUserMenuOpen = ref(false);
const isUserBookingOpen = ref(false);
const isNotifOpen = ref(false);

// Dropdown refs
const dropdownUserRef = ref<HTMLElement | null>(null);
const dropdownBookingRef = ref<HTMLElement | null>(null);
const dropdownNotifRef = ref<HTMLElement | null>(null);

const page = usePage();
const user = computed<User>(() => page.props.auth.user as User);

// Compute initials
const userInitials = computed(() => {
    if (!user.value.name) return '';
    return user.value.name
        .split(' ')
        .map((n) => n[0])
        .join('')
        .toUpperCase();
});

// Toggle dropdowns
const toggleUserMenu = () => {
    isUserMenuOpen.value = !isUserMenuOpen.value;
    if (isNotifOpen.value) isNotifOpen.value = false;
    if (isUserBookingOpen.value) isUserBookingOpen.value = false;
};
const toggleBookingMenu = () => {
    isUserBookingOpen.value = !isUserBookingOpen.value;
    if (isNotifOpen.value) isNotifOpen.value = false;
    if (isUserMenuOpen.value) isUserMenuOpen.value = false;
};
const toggleNotif = () => {
    isNotifOpen.value = !isNotifOpen.value;
    if (isUserMenuOpen.value) isUserMenuOpen.value = false;
    if (isUserBookingOpen.value) isUserBookingOpen.value = false;
};

// Close dropdowns when clicking outside
const handleClickOutside = (event: MouseEvent) => {
    const target = event.target as Node;
    if (
        (dropdownUserRef.value && dropdownUserRef.value.contains(target)) ||
        (dropdownBookingRef.value && dropdownBookingRef.value.contains(target)) ||
        (dropdownNotifRef.value && dropdownNotifRef.value.contains(target))
    ) return;

    isUserMenuOpen.value = false;
    isUserBookingOpen.value = false;
    isNotifOpen.value = false;
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});
onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});

// Logout
const logout = () => {
    router.post('/logout');
};

// Sample notifications
const notifications = ref([
    { id: 1, title: 'Flight to Tokyo confirmed', time: '2 hours ago' },
    { id: 2, title: 'Booking #A1234 has been updated', time: '1 day ago' },
    { id: 3, title: 'Promo: 20% off for early bookings!', time: '3 days ago' },
]);
</script>

<template>
    <Head title="SkyWings Airlines - Fly with Comfort" />

    <header class="sticky top-0 z-50 border-b border-gray-200 bg-white/80 shadow-sm backdrop-blur-sm dark:border-gray-700 dark:bg-gray-900/80">
        <div class="container mx-auto flex items-center justify-between px-6 py-2">
            <!-- Logo -->
            <a href="/dashboard" class="flex items-center space-x-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 shadow-sm">
                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </div>
                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">SkyWings</span>
            </a>

            <!-- Right-side icons -->
            <div class="flex items-center space-x-8">
                <!-- Notifications -->
                <div class="relative" ref="dropdownNotifRef">
                    <button @click="toggleNotif" class="relative rounded-full p-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6 6 0 10-12 0v3c0 .386-.145.753-.405 1.045L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-500"></span>
                    </button>
                    <transition name="fade">
                        <div v-if="isNotifOpen" class="absolute right-0 z-50 mt-2 w-64 rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                            <ul>
                                <li v-for="note in notifications" :key="note.id" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    {{ note.title }} - <span class="text-xs text-gray-500">{{ note.time }}</span>
                                </li>
                            </ul>
                        </div>
                    </transition>
                </div>

                <!-- My Bookings -->
                <div class="relative" ref="dropdownBookingRef">
                    <button @click="toggleBookingMenu" class="rounded-full p-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </button>
                    <transition name="fade">
                        <div v-if="isUserBookingOpen" class="absolute right-0 z-50 mt-2 w-48 rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                            <ul>
                                <li>
                                    <Link href="/mybooking" class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-700">My Bookings</Link>
                                </li>
                                <li>
                                    <Link href="/mytransac" class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-700">Transactions</Link>
                                </li>
                            </ul>
                        </div>
                    </transition>
                </div>

                <!-- Help Desk -->
                <div class="relative">
                    <a href="/helpdesk" class="rounded-full p-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636A9 9 0 105.636 18.364 9 9 0 0018.364 5.636zM12 8v4m0 4h.01"/>
                        </svg>
                    </a>
                </div>

                <!-- User Menu -->
                <div class="relative" ref="dropdownUserRef">
                    <button @click="toggleUserMenu" class="relative flex h-9 w-9 cursor-pointer items-center justify-center overflow-hidden rounded-full bg-blue-600 transition">
                        <span v-if="userInitials" class="absolute text-sm font-bold text-white uppercase">{{ userInitials }}</span>
                    </button>
                    <transition name="fade">
                        <div v-if="isUserMenuOpen" class="absolute right-0 z-50 mt-2 w-48 rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                            <div class="border-b border-gray-200 p-3 dark:border-gray-700">
                                <p class="font-semibold text-gray-800 dark:text-gray-200">{{ user.firstname }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ user.email }}</p>
                            </div>
                            <ul>
                                <li><Link href="/profile" class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-700">Profile</Link></li>
                                <li><button @click="logout" class="w-full px-4 py-2 text-left text-red-600 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-700">Logout</button></li>
                            </ul>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </header>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
table {
  width: 100%;
  border-spacing: 0;
}
</style>
