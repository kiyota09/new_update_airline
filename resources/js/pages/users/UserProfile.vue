<script lang="ts" setup>
import Topbar from '@/components/Topbar.vue';
import type { User } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const data = defineProps<{
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
    } | null;
}>();

const form = useForm({
    firstname: data.additionalData?.firstname || '',
    lastname: data.additionalData?.lastname || '',
    middlename: data.additionalData?.middlename || '',
    email: data.user?.email || '',
    contact: data.additionalData?.contact || '',
    gender: data.additionalData?.gender || '',
    memberDate: data.additionalData?.memberDate
        ? new Date(data.additionalData.memberDate).toLocaleDateString('en-US', {
              month: '2-digit',
              day: '2-digit',
              year: '2-digit',
          })
        : data.user?.created_at
        ? new Date(data.user.created_at).toLocaleDateString('en-US', {
              month: '2-digit',
              day: '2-digit',
              year: '2-digit',
          })
        : '',
    block: data.additionalData?.block || '',
    barangay: data.additionalData?.barangay || '',
    municipality: data.additionalData?.municipality || '',
    province: data.additionalData?.province || '',
    country: data.additionalData?.country || '',
});

const updateform = () => {
    form.post('/profile/update');
};



const back = () => {
    window.history.back();
};
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100">
        <Topbar />
        <!-- debug -->
        {{ data }}

        <main class="container mx-auto px-4 py-8">
            <div class="mx-auto max-w-4xl">
                <h1 class="mb-8 text-center text-3xl font-bold">My Profile</h1>

                <!-- Personal Details Card -->
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

                <!-- Address Card -->
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
                    <button @click="updateform" class="rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">Edit Profile</button>
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
