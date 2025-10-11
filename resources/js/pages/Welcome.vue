<script setup lang="ts">
import { login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import ero from "@/pages/images/ero.png";
import { Router } from 'lucide-vue-next';
</script>

<template>
  <Head title="SkyWings Airlines - Welcome to the Philippines">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <div class="min-h-screen bg-gradient-to-b from-sky-400 via-blue-400 to-blue-500 overflow-hidden relative">
    <!-- Moving Clouds Background -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="cloud cloud-1"></div>
      <div class="cloud cloud-2"></div>
      <div class="cloud cloud-3"></div>
      <div class="cloud cloud-4"></div>
      <div class="cloud cloud-5"></div>
    </div>

    <!-- Sidebar with Login/Register -->
    <div class="absolute top-8 right-8 z-30 flex flex-col gap-4">
      <Link
        :href="login()"
        class="bg-white/90 backdrop-blur-sm rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group"
      >
        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-blue-700 transition-colors">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
        </div>
        <span class="text-sm font-medium text-gray-700 block text-center">Login</span>
      </Link>

      <Link
        :href="register()"
        class="bg-white/90 backdrop-blur-sm rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group"
      >
        <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-green-700 transition-colors">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
          </svg>
        </div>
        <span class="text-sm font-medium text-gray-700 block text-center">Register</span>
      </Link>
    </div>

    <!-- Moving Plane - Centered with Animation -->
    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center z-20">
      <div class="floating-plane-container">
        <div class="relative">
          <!-- Airplane Image -->
          <img 
            :src="ero" 
            alt="SkyWings Airplane" 
            class="w-100 h-100 object-contain drop-shadow-2xl"
          >
          
          <!-- Jet trail -->
          <div class="absolute -right-6 top-1/2 transform -translate-y-1/2">
            <div class="w-12 h-1.5 bg-white/40 rounded-full blur-sm"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Welcome Card -->
    <div class="absolute bottom-8 right-8 z-30">
      <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-2xl max-w-sm transform transition-all duration-500 hover:scale-105">
        <div class="flex items-center space-x-3 mb-3">
          <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-blue-500 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
          </div>
          <h2 class="text-2xl font-bold text-gray-800">Welcome to the Philippines</h2>
        </div>
        <p class="text-gray-600 leading-relaxed">
          Discover the pearl of the Orient Seas. With over 7,000 stunning islands, pristine beaches, and vibrant culture, your adventure begins here with SkyWings Airlines.
        </p>
        
        <!-- Quick stats -->
        <div class="flex justify-between mt-4 pt-4 border-t border-gray-200">
          <div class="text-center">
            <div class="text-lg font-bold text-blue-600">7,641</div>
            <div class="text-xs text-gray-500">Islands</div>
          </div>
          <div class="text-center">
            <div class="text-lg font-bold text-green-600">26°C</div>
            <div class="text-xs text-gray-500">Average Temp</div>
          </div>
          <div class="text-center">
            <div class="text-lg font-bold text-yellow-600">365</div>
            <div class="text-xs text-gray-500">Beaches</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Brand Logo -->
    <div class="absolute top-8 left-8 z-30">
      <div class="flex items-center space-x-3">
        <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
          <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
          </svg>
        </div>
        <div class="bg-white/90 backdrop-blur-sm rounded-xl px-4 py-2 shadow-lg">
          <span class="text-xl font-bold text-gray-800">NCST Airlines</span>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Cloud animations */
.cloud {
  position: absolute;
  background: white;
  border-radius: 1000px;
  animation: moveClouds 60s linear infinite;
  opacity: 0.7;
}

.cloud-1 {
  width: 200px;
  height: 60px;
  top: 20%;
  animation-duration: 80s;
  animation-delay: -10s;
}

.cloud-2 {
  width: 150px;
  height: 45px;
  top: 40%;
  animation-duration: 70s;
  animation-delay: -25s;
}

.cloud-3 {
  width: 180px;
  height: 55px;
  top: 60%;
  animation-duration: 90s;
  animation-delay: -5s;
}

.cloud-4 {
  width: 120px;
  height: 35px;
  top: 30%;
  animation-duration: 65s;
  animation-delay: -40s;
}

.cloud-5 {
  width: 160px;
  height: 50px;
  top: 70%;
  animation-duration: 75s;
  animation-delay: -15s;
}

.cloud::before {
  content: '';
  position: absolute;
  top: -80%;
  left: 10%;
  width: 50%;
  height: 150%;
  background: white;
  border-radius: 50%;
}

.cloud::after {
  content: '';
  position: absolute;
  top: -40%;
  right: 20%;
  width: 30%;
  height: 100%;
  background: white;
  border-radius: 50%;
}

@keyframes moveClouds {
  from {
    transform: translateX(100vw);
  }
  to {
    transform: translateX(-200px);
  }
}

/* Enhanced Plane Floating Animation - Centered */
.floating-plane-container {
  animation: gentleFloat 8s ease-in-out infinite;
  transform-origin: center;
}

@keyframes gentleFloat {
  0% {
    transform: translateY(0px) rotate(0deg);
  }
  25% {
    transform: translateY(-8px) rotate(0.5deg);
  }
  50% {
    transform: translateY(-15px) rotate(0deg);
  }
  75% {
    transform: translateY(-8px) rotate(-0.5deg);
  }
  100% {
    transform: translateY(0px) rotate(0deg);
  }
}
</style>