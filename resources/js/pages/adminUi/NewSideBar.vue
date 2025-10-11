<script setup lang="ts">
import { useRoute, RouterLink } from 'vue-router'

// Lucide Icons
import { LayoutGrid } from 'lucide-vue-next'

// Current route for active link highlighting
const route = useRoute()

const navItems = [
  { name: 'Dashboard', icon: LayoutGrid, path: '/DashboardAdmin' },
  // Add more items here if needed
]
</script>

<template>
  <aside
    class="h-screen w-64 bg-blue-700 text-white flex flex-col shadow-lg fixed left-0 top-0"
  >
    <!-- Logo / Header -->
    <div class="p-6 flex items-center justify-center border-b border-blue-600">
      <h1 class="text-xl font-semibold">Airline Admin</h1>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto mt-4">
      <ul class="space-y-1">
        <li v-for="item in navItems" :key="item.path">
          <RouterLink
            :to="item.path"
            class="flex items-center px-5 py-3 text-sm font-medium rounded-lg hover:bg-blue-600 transition-all"
            :class="{ 'bg-blue-600': route.path === item.path }"
          >
            <item.icon class="w-5 h-5 mr-3" />
            <span>{{ item.name }}</span>
          </RouterLink>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<style scoped>
/* Scrollbar Styling */
nav::-webkit-scrollbar {
  width: 6px;
}
nav::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.3);
  border-radius: 3px;
}
</style>
