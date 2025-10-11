<script lang="ts" setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { router, Link, Head, usePage } from '@inertiajs/vue3'
import type { User } from '@/types';



// Dropdown toggle state
const isOpen = ref(false)
const dropdownRef = ref<HTMLElement | null>(null)

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

// Toggle menu
function toggleMenu() {
  isOpen.value = !isOpen.value;
}

// Close dropdown when clicking outside
const handleClickOutside = (event: MouseEvent) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target as Node)) {
    isOpen.value = false
  }
}

// Lifecycle hooks
onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})
onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})

// Logout
const logout = () => router.post('/logout')
</script>

<template>
  <Head title="SkyWings Airlines - Fly with Comfort" />

  <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-700 sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center space-x-4">
        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
          </svg>
        </div>
        <span class="text-xl font-bold text-blue-600 dark:text-blue-400">SkyWings</span>
      </div>
      
      <!-- User Menu -->
      <div class="relative" ref="dropdownRef">
        <button
          @click="toggleMenu"
          class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center cursor-pointer hover:ring-2 hover:ring-blue-500 transition"
        >
          <span class="text-white font-bold uppercase">{{ userInitials }}</span>
        </button>

        <transition name="fade">
          <div
            v-if="isOpen"
            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50"
          >
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
              <p class="font-semibold text-gray-800 dark:text-gray-200">{{ user.firstname }}</p>
              <p class="text-sm text-gray-500 dark:text-gray-400">{{ user.email }}</p>
            </div>
            <ul>
              <li>
                <Link href="/profile" class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-700 transition">Profile</Link>
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
