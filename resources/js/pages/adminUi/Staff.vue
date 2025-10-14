<script setup lang="ts">
import { computed, ref } from 'vue';
import Sidebar from './NewSideBar.vue';
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
// === Staff Data (demo) ===


// === States ===
const showModal = ref(false);
const showAssignModal = ref(false);


const selectedStaff = useForm({
    name: '',
    role: '',
    assignedFlight: null,
    status: '',
});

// === Actions ===
const openAddModal = () => {
    showModal.value = true;
};


const closeModals = () => {
    showModal.value = false;
    showAssignModal.value = false;
};

const saveStaff = () => {
    selectedStaff.post('/staff_submit');
};

const assignStaff = () => {
    closeModals();
};
const page = usePage();
const staff = computed(() => {
    return page.props.StaffList;
});


</script>

<template>
    <Head title="Staff Management" />
    
    <div class="flex min-h-screen bg-gray-50">
        <Sidebar />
       
        <div class="flex-1 ml-64">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Staff Management</h1>
                        <p class="text-gray-600">Manage airline staff and assignments</p>
                    </div>
                    <button
                        @click="openAddModal"
                        class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition hover:bg-blue-700"
                    >
                        + Add Staff
                    </button>
                </div>

                <!-- Staff Directory -->
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-700">
                        Staff Directory
                    </h2>
                    <input
                        type="text"
                        placeholder="Search by name or role..."
                        class="rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm"
                    />
                </div>

                <!-- Staff Table -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-xl">
                    <table class="w-full border-collapse text-left">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Assigned Flight</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="staffList in staff"
                                :key="staffList.id"
                                class="border-b border-gray-200 transition hover:bg-gray-50"
                            >
                                <td class="px-4 py-3">{{ staffList.id }}</td>
                                <td class="px-4 py-3 font-medium">
                                    {{ staffList.fullname }}
                                </td>
                                <td class="px-4 py-3">{{ staffList.role }}</td>
                                <td class="px-4 py-3">
                                    {{ staffList.assignedFlight }}
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="rounded-full px-3 py-1 text-sm font-medium"
                                        :class="{
                                            'bg-green-100 text-green-700':
                                                staffList.status === 'Active' ||
                                                staffList.status === 'On Duty',
                                            'bg-gray-100 text-gray-700':
                                                staffList.status === 'Available',
                                            'bg-red-100 text-red-700':
                                                staffList.status === 'Inactive',
                                        }"
                                    >
                                        {{ staffList.status }}
                                    </span>
                                </td>
                                <td class="flex justify-center gap-2 px-4 py-3">
                                    <button
                                        
                                        class="rounded bg-yellow-500 px-3 py-1 text-sm text-white hover:bg-yellow-600"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
                                    >
                                        Assign
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Summary -->
                <div class="mt-8 text-center font-medium text-gray-700">
                    Total Staff: {{ staff.length }}
                </div>

                <!-- Add/Edit Staff Modal -->
                <!-- <div
                    v-if="showModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                >
                    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                        <h3 class="mb-4 text-xl font-bold text-blue-600">
                            {{
                                selectedStaff.id
                                    ? 'Edit Staff'
                                    : 'Add New Staff'
                            }}
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium"
                                    >Full Name</label
                                >
                                <input
                                    type="text"
                                    v-model="selectedStaff.name"
                                    placeholder="Enter full name"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                                />
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium"
                                    >Role</label
                                >
                                <select
                                    v-model="selectedStaff.role"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                                >
                                    <option value="">Select Role</option>
                                    <option>Pilot</option>
                                    <option>Cabin Crew</option>
                                    <option>Ground Staff</option>
                                    <option>Flight Manager</option>
                                    <option>Finance Officer</option>
                                    <option>Admin</option>
                                </select>
                            </div>

                          

                            <div>
                                <label class="mb-1 block text-sm font-medium"
                                    >Status</label
                                >
                                <select
                                    v-model="selectedStaff.status"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                                >
                                    <option>Active</option>
                                    <option>Available</option>
                                    <option>On Duty</option>
                                    <option>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-2">
                            <button
                                @click="closeModals"
                                class="rounded-lg bg-gray-500 px-4 py-2 text-white hover:bg-gray-600"
                            >
                                Cancel
                            </button>
                            <button
                                @click="saveStaff"
                                class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                Save
                            </button>
                        </div>
                    </div>
                </div> -->
                
                <!-- Assign Flight Modal -->
                <div
                    v-if="showAssignModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                >
                    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                        <h3 class="mb-4 text-xl font-bold text-blue-600">
                            Assign Flight to {{ selectedStaff.name }}
                        </h3>

                        <label class="mb-2 block text-sm font-medium"
                            >Flight Number</label
                        >
                        <input
                            v-model="selectedStaff.assignedFlight"
                            type="text"
                            placeholder="Enter flight number (e.g., FL-102)"
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2"
                        />

                        <div class="mt-6 flex justify-end gap-2">
                            <button
                                @click="closeModals"
                                class="rounded-lg bg-gray-500 px-4 py-2 text-white hover:bg-gray-600"
                            >
                                Cancel
                            </button>
                            <button
                                @click="assignStaff"
                                class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                            >
                                Assign
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
button {
    transition: all 0.2s ease;
}
</style>