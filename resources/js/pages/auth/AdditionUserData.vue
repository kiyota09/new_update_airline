<script lang="ts" setup>
import { useForm} from '@inertiajs/vue3';





const form = useForm({
    firstname:'',
    lastname: '',
    middlename: '',

    contact: '',
    gender: '',
    memberDate:'',
    block: '',
    barangay:'',
    municipality: '',
    province: '',
    country: '',
    validId: '',
    passport: '',
});

const submit = () =>{
    form.post('/additionalDatas');
}


</script>

<template>
    <div
        class="min-h-screen bg-gradient-to-b from-blue-50 to-white text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100"
    >
    <div class="bg-white/80 backdrop-blur-sm border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-700 sticky top-0 z-50">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <Link href="/" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-blue-600 dark:text-blue-400">NCST Airlines</span>
                    </Link>
                </div>
            </div>
        </div>
        

        <!-- Profile Content -->
        <main class="container mx-auto px-4 py-8">
            <div class="mx-auto max-w-4xl">
                <h1 class="mb-8 text-center text-3xl font-bold">USER INFO</h1>

                <!-- Personal Details Card -->
                <div
                    class="mb-8 rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-800"
                >
                    <h2
                        class="mb-6 text-xl font-bold text-blue-600 dark:text-blue-400"
                    >
                        Personal Details
                    </h2>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >First Name</label
                            >
                            <input
                                type="text"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-black dark:bg-gray-700 dark:text-gray-200"
                                v-model="form.firstname"
                            />
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Last Name</label
                            >
                            <input
                                type="text"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-black dark:bg-gray-700 dark:text-gray-200"
                                v-model="form.lastname"
                            />
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Middle Name</label
                            >
                            <input
                                type="text"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-black dark:bg-gray-700 dark:text-gray-200"
                                v-model="form.middlename"
                            />
                        </div>

                

                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Contact Number</label
                            >
                            <input
                                type="text"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-black dark:bg-gray-700 dark:text-gray-200"
                                v-model="form.contact"
                            />
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Gender</label
                            >
                            <select
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-black dark:bg-gray-700 dark:text-gray-200"
                                v-model="form.gender"
                            >
                                <option>Male</option>
                                <option>Female</option>
                                <option>Prefer not to say</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Member Since</label
                            >
                            <input
                                type="date"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-black dark:bg-gray-700 dark:text-gray-200"
                                v-model="form.memberDate"
                            />
                        </div>
                    </div>

                    <!-- Identification Documents Section -->
                    <div class="mt-6">
                        <label class="mb-1 block text-sm font-medium"
                            >Identification Documents</label
                        >
                        <div class="flex space-x-4">
                            <div
                                class="flex-1 cursor-pointer rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-6 text-center transition hover:border-blue-500 hover:bg-blue-50 dark:border-gray-600 dark:bg-gray-700"
                            >
                                <p
                                    class="font-medium text-gray-700 dark:text-gray-200"
                                >
                                    Upload Valid ID
                                </p>
                                <p
                                    class="text-sm text-gray-500 dark:text-gray-400"
                                >
                                    Click to upload government-issued ID
                                </p>
                                <input type="file" class="hidden" />
                            </div>

                            <div
                                class="flex-1 cursor-pointer rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-6 text-center transition hover:border-blue-500 hover:bg-blue-50 dark:border-gray-600 dark:bg-gray-700"
                            >
                                <p
                                    class="font-medium text-gray-700 dark:text-gray-200"
                                >
                                    Upload Passport
                                </p>
                                <p
                                    class="text-sm text-gray-500 dark:text-gray-400"
                                >
                                    Click to upload passport document
                                </p>
                                <input type="file" class="hidden" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Card -->
                <div
                    class="rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-800"
                >
                    <h2
                        class="mb-6 text-xl font-bold text-blue-600 dark:text-blue-400"
                    >
                        Address Information
                    </h2>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Block/Unit No.</label
                            >
                            <input
                                type="text"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-black dark:bg-gray-700 dark:text-gray-200"
                                v-model="form.block"
                            />
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Barangay</label
                            >
                            <input
                                type="text"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-black dark:bg-gray-700 dark:text-gray-200"
                                v-model="form.barangay"
                            />
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Municipality/City</label
                            >
                            <input
                                type="text"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-black dark:bg-gray-700 dark:text-gray-200"
                                v-model="form.municipality"
                            />
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium"
                                >Province</label
                            >
                            <input
                                type="text"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-black dark:bg-gray-700 dark:text-gray-200"
                                v-model="form.province"
                            />
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-sm font-medium"
                                >Country</label
                            >
                            <input
                                type="text"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-black dark:bg-gray-700 dark:text-gray-200"
                                v-model="form.country"
                            />
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-center space-x-4">
                    <button
                        @click="submit"
                        class="rounded-lg bg-blue-600 px-6 py-2 font-medium text-white transition-colors hover:bg-green-700"
                    >
                        Submit
                    </button>
                    <button
                        class="rounded-lg bg-gray-600 px-6 py-2 font-medium text-white transition-colors hover:bg-red-400"
                    >
                        Cancel
                    </button>
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