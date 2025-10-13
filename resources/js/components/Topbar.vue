<script lang="ts" setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { router, Link, Head, usePage } from '@inertiajs/vue3'
import type { User } from '@/types'
import { Inertia } from '@inertiajs/inertia'

// Dropdown states
const isUserMenuOpen = ref(false)
const isNotifOpen = ref(false)
const dropdownRef = ref<HTMLElement | null>(null)
const notifRef = ref<HTMLElement | null>(null)

const page = usePage()
const user = computed<User>(() => page.props.auth.user as User)

// Compute initials
const userInitials = computed(() => {
  if (!user.value.name) return ''
  return user.value.name
    .split(' ')
    .map(n => n[0])
    .join('')
    .toUpperCase()
})

// Toggle dropdowns
function toggleUserMenu() {
  isUserMenuOpen.value = !isUserMenuOpen.value
  if (isNotifOpen.value) isNotifOpen.value = false
}
function toggleNotif() {
  isNotifOpen.value = !isNotifOpen.value
  if (isUserMenuOpen.value) isUserMenuOpen.value = false
}

// Close dropdowns when clicking outside
const handleClickOutside = (event: MouseEvent) => {
  if (
    (dropdownRef.value && dropdownRef.value.contains(event.target as Node)) ||
    (notifRef.value && notifRef.value.contains(event.target as Node))
  )
    return

  isUserMenuOpen.value = false
  isNotifOpen.value = false
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})
onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})

// Logout
const logout = () =>{
   Inertia.router.post('/logout')
  
}


// Sample notifications
const notifications = ref([
  { id: 1, title: 'Flight to Tokyo confirmed', time: '2 hours ago' },
  { id: 2, title: 'Booking #A1234 has been updated', time: '1 day ago' },
  { id: 3, title: 'Promo: 20% off for early bookings!', time: '3 days ago' }
])
</script>

<template>
  <Head title="SkyWings Airlines - Fly with Comfort" />

  <header
    class="bg-white/80 backdrop-blur-sm border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-700 sticky top-0 z-50 shadow-sm"
  >
    <div class="container mx-auto px-6 py-2 flex justify-between items-center">
      <!-- Logo -->
      <a
      href="/dashboard"
      class="flex items-center space-x-3">
        
        <div
          class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-sm"
        >
          <svg
            class="w-4 h-4 text-white"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
            />
          </svg>
        </div>
        <span class="text-lg font-bold text-blue-600 dark:text-blue-400">SkyWings</span>
      </a>

      <!-- Right-side Icons and User Menu -->
      <div class="flex items-center space-x-8">
        <!-- Notifications -->
        <div class="relative" ref="notifRef">
          <button
            
            @click="toggleNotif"
            class="relative p-2 rounded-full transition"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-5 h-5 text-gray-700 dark:text-gray-300"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
           
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6 6 0 10-12 0v3c0 .386-.145.753-.405 1.045L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
              />
            </svg>
            <span
              class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"
            ></span>
            
          </button>

          <!-- Notification Dropdown -->
          
        </div>

        <!-- My Bookings -->
        <div class="relative">
          <a
            href="/mybooking"
            class="p-2 rounded-full transition"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-5 h-5 text-gray-700 dark:text-gray-300"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
          </a>
        </div>

        <!-- Help Desk -->
        <div class="relative">
          <a
            href="/helpdesk"
            class="p-2 rounded-full transition"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-5 h-5 text-gray-700 dark:text-gray-300"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M18.364 5.636A9 9 0 105.636 18.364 9 9 0 0018.364 5.636zM12 8v4m0 4h.01"
              />
            </svg>
          </a>
        </div>

        <!-- User Menu -->
        <div class="relative" ref="dropdownRef">
          <button
            @click="toggleUserMenu"
            class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center cursor-pointer transition relative overflow-hidden"
          >
            <!-- User Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>

            <!-- Initials (on top if available) -->
            <span
              v-if="userInitials"
              class="absolute text-white font-bold uppercase text-sm"
            >
              {{ userInitials }}
            </span>
          </button>

          <transition name="fade">
            <div
              v-if="isUserMenuOpen"
              class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50"
            >
              <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                <p class="font-semibold text-gray-800 dark:text-gray-200">
                  {{ user.firstname }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  {{ user.email }}
                </p>
              </div>
              <ul>
                <li>
                  <Link
                    href="/profile"
                    class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-700 transition"
                  >
                    Profile
                  </Link>
                </li>
                <li>
                  <button
                    @click="logout"
                    class="w-full text-left px-4 py-2 hover:bg-red-100 dark:hover:bg-red-700 transition text-red-600 dark:text-red-400"
                  >
                    Logout
                  </button>
                </li>
              </ul>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </header>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
