<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3'

  const logout = () => router.post('/logout')


</script>
<template>
  <aside
    class="fixed left-0 top-0 h-screen w-64 bg-gradient-to-b from-blue-800 to-blue-900 text-white flex flex-col shadow-xl border-r border-blue-700"
  >
    <!-- Logo & Brand -->
    <div class="p-6 border-b border-blue-700">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
          </svg>
        </div>
        <div>
          <h1 class="text-xl font-bold">SkyWings</h1>
          <p class="text-blue-200 text-xs">Admin Panel</p>
        </div>
      </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 p-4 space-y-1">
      <!-- Dashboard -->
      <Link href="/u" class="flex items-center px-4 py-3 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
        <svg class="w-5 h-5 mr-3 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span class="font-medium">Dashboard</span>
      </Link>

      <!-- Aircraft -->
      <Link href="/air" class="flex items-center px-4 py-3 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
        <svg class="w-5 h-5 mr-3 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
        </svg>
        <span class="font-medium">Aircraft</span>
      </Link>

      <!-- Bookings -->
      <Link href="/booking" class="flex items-center px-4 py-3 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
        <svg class="w-5 h-5 mr-3 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
        </svg>
        <span class="font-medium">Bookings</span>
      </Link>

      <!-- Routes -->
      <Link href="/routess" class="flex items-center px-4 py-3 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
        <svg class="w-5 h-5 mr-3 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
        </svg>
        <span class="font-medium">Routes</span>
      </Link>

      <!-- Schedule -->
      <Link href="/schedule" class="flex items-center px-4 py-3 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
        <svg class="w-5 h-5 mr-3 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span class="font-medium">Schedule</span>
      </Link>

      <!-- Staff -->
      <Link href="/staff" class="flex items-center px-4 py-3 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
        <svg class="w-5 h-5 mr-3 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <span class="font-medium">Staff</span>
      </Link>

      <!-- Passengers -->
      <Link href="/passenger" class="flex items-center px-4 py-3 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
        <svg class="w-5 h-5 mr-3 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
        </svg>
        <span class="font-medium">Passengers</span>
      </Link>

      <!-- Billing -->
      <Link href="/billing" class="flex items-center px-4 py-3 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
        <svg class="w-5 h-5 mr-3 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
        </svg>
        <span class="font-medium">Billing</span>
      </Link>

      <!-- Seat Management -->
      <Link href="/seat" class="flex items-center px-4 py-3 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
        <svg class="w-5 h-5 mr-3 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
        </svg>
        <span class="font-medium">Seat Management</span>
      </Link>
    </nav>

    <!-- User Section & Logout -->
    <div class="p-4 border-t border-blue-700">
      <div class="flex items-center space-x-3 mb-4 p-3 rounded-lg bg-blue-700/30">
        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
          <span class="text-sm font-bold">AD</span>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium truncate">Admin User</p>
          <p class="text-xs text-blue-300 truncate">admin@skywings.com</p>
        </div>
      </div>
      
      <button
       @click="logout"
        class="w-full flex items-center justify-center px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-200 hover:text-white rounded-xl transition-all duration-200 border border-red-500/30 hover:border-red-500/50"
      >
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
        Logout
      </button>
    </div>
  </aside>
</template>



<style scoped>
/* Custom scrollbar for the sidebar */
aside::-webkit-scrollbar {
  width: 4px;
}

aside::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
}

aside::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.3);
  border-radius: 2px;
}

aside::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.5);
}

/* Smooth transitions for all interactive elements */
a, button {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Active state for current page */
.router-link-active {
  background: rgba(59, 130, 246, 0.5);
  border-left: 4px solid rgb(96, 165, 250);
}
</style>