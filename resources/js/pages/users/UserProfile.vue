<script lang="ts" setup>
import Topbar from '@/components/Topbar.vue';
import type { User } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';

const props = defineProps<{
  user: User;
  additionalData: {
    firstname?: string;
    lastname?: string;
    middlename?: string;
    contact?: string;
    gender?: string;
    block?: string;
    barangay?: string;
    municipality?: string;
    province?: string;
    country?: string;
    memberDate?: string;
    validId?: string;
    passport?: string;
  } | null;
}>();

// Previews for uploaded or existing files
const preview = ref({
  validId: props.additionalData?.validId ? `/${props.additionalData.validId}` : null,
  passport: props.additionalData?.passport ? `/${props.additionalData.passport}` : null,
});

// Form initialization with defaults from props
const form = useForm({
  firstname: props.additionalData?.firstname || '',
  lastname: props.additionalData?.lastname || '',
  middlename: props.additionalData?.middlename || '',
  email: props.user?.email || '',
  contact: props.additionalData?.contact || '',
  gender: props.additionalData?.gender || '',
  memberDate: props.additionalData?.memberDate || props.user?.created_at || '',
  block: props.additionalData?.block || '',
  barangay: props.additionalData?.barangay || '',
  municipality: props.additionalData?.municipality || '',
  province: props.additionalData?.province || '',
  country: props.additionalData?.country || '',
  validId: null as File | null,
  passport: null as File | null,
});

// Handle file uploads
const handleFileUpload = (e: Event, field: 'validId' | 'passport') => {
  const file = (e.target as HTMLInputElement).files?.[0];
  if (file) {
    form[field] = file;
    preview.value[field] = URL.createObjectURL(file);
  }
};

// Submit updated profile
const updateForm = () => {
  form.post('/profile/update', {
    forceFormData: true, // required to send files
  });
};

// Go back
const back = () => {
  window.history.back();
};
</script>

<template>
  <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100">
    <Topbar />

    <main class="container mx-auto px-4 py-8">
      <div class="mx-auto max-w-4xl">
        <h1 class="mb-8 text-center text-3xl font-bold">My Profile</h1>

        <!-- Personal Details -->
        <div class="mb-8 rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-800">
          <h2 class="mb-6 text-xl font-bold text-blue-600 dark:text-blue-400">Personal Details</h2>
          <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
              <label class="mb-1 block text-sm font-medium">First Name</label>
              <input v-model="form.firstname" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" />
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium">Last Name</label>
              <input v-model="form.lastname" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" />
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium">Middle Name</label>
              <input v-model="form.middlename" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" />
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium">Email</label>
              <input v-model="form.email" type="email" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" readonly />
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium">Contact Number</label>
              <input v-model="form.contact" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" />
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium">Gender</label>
              <input v-model="form.gender" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" readonly />
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium">Member Since</label>
              <input v-model="form.memberDate" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" readonly />
            </div>
          </div>
        </div>

        <!-- Identification Documents -->
        <div class="mb-8 rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-800">
          <h2 class="mb-6 text-xl font-bold text-blue-600 dark:text-blue-400">Identification Documents</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Valid ID -->
            <div class="flex flex-col items-center border-2 border-dashed p-4 rounded-lg">
              <label class="mb-2 font-medium">Valid ID</label>
              <input type="file" accept="image/*" @change="e => handleFileUpload(e, 'validId')" />
              <img v-if="preview.validId" :src="preview.validId" class="h-32 object-contain rounded-lg mt-2" />
            </div>
            <!-- Passport -->
            <div class="flex flex-col items-center border-2 border-dashed p-4 rounded-lg">
              <label class="mb-2 font-medium">Passport</label>
              <input type="file" accept="image/*" @change="e => handleFileUpload(e, 'passport')" />
              <img v-if="preview.passport" :src="preview.passport" class="h-32 object-contain rounded-lg mt-2" />
            </div>
          </div>
        </div>

        <!-- Address Information -->
        <div class="rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-800">
          <h2 class="mb-6 text-xl font-bold text-blue-600 dark:text-blue-400">Address Information</h2>
          <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
              <label class="mb-1 block text-sm font-medium">Block/Unit No.</label>
              <input v-model="form.block" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" />
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium">Barangay</label>
              <input v-model="form.barangay" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" />
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium">Municipality/City</label>
              <input v-model="form.municipality" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" />
            </div>
            <div>
              <label class="mb-1 block text-sm font-medium">Province</label>
              <input v-model="form.province" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" />
            </div>
            <div class="md:col-span-2">
              <label class="mb-1 block text-sm font-medium">Country</label>
              <input v-model="form.country" type="text" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:bg-gray-700 dark:text-gray-200" />
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-center space-x-4">
          <button @click="updateForm" class="rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">Edit Profile</button>
          <button @click="back" class="rounded-lg bg-gray-600 px-6 py-2 text-white hover:bg-gray-700">Back</button>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
