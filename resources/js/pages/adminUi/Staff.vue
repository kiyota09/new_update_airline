<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';

// === Staff Data (demo) ===
const staffList = ref([
    {
        id: 1,
        name: 'Captain Billy Justine Macalawa',
        role: 'Pilot',
        department: 'Flight Operations',
        assignedFlight: 'FL-11072',
        status: 'Active',
    },
    {
        id: 2,
        name: 'Math Divida',
        role: 'Cabin Crew',
        department: 'Inflight Services',
        assignedFlight: 'FL-11072',
        status: 'On Duty',
    },
    {
        id: 3,
        name: 'Nath Martos',
        role: 'Ground Staff',
        department: 'Ground Handling',
        assignedFlight: '-',
        status: 'Available',
    },
]);

// === States ===
const showModal = ref(false);
const showAssignModal = ref(false);
const selectedStaff = ref({
    id: null,
    name: '',
    role: '',
    department: '',
    assignedFlight: '',
    status: 'Available',
});

// === Actions ===
const openAddModal = () => {
    selectedStaff.value = {
        id: null,
        name: '',
        role: '',
        department: '',
        assignedFlight: '',
        status: 'Available',
    };
    showModal.value = true;
};

const openEditModal = (staff) => {
    selectedStaff.value = { ...staff };
    showModal.value = true;
};

const openAssignModal = (staff) => {
    selectedStaff.value = { ...staff };
    showAssignModal.value = true;
};

const closeModals = () => {
    showModal.value = false;
    showAssignModal.value = false;
};

const saveStaff = () => {
    if (selectedStaff.value.id) {
        // Edit existing
        const index = staffList.value.findIndex(
            (s) => s.id === selectedStaff.value.id,
        );
        if (index !== -1) staffList.value[index] = { ...selectedStaff.value };
    } else {
        // Add new
        selectedStaff.value.id = staffList.value.length + 1;
        staffList.value.push({ ...selectedStaff.value });
    }
    closeModals();
};

const assignStaff = () => {
    closeModals();
};
</script>

<template>
    <Head title="Staff Management" />
    <AppLayout>
        <div
            class="min-h-screen bg-gradient-to-b from-blue-50 to-white text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100"
        >
            <!-- Header -->
            <header
                class="sticky top-0 z-50 border-b border-gray-200 bg-white/80 backdrop-blur-sm dark:border-gray-700 dark:bg-gray-900/80"
            >
                <div
                    class="container mx-auto flex items-center justify-between px-4 py-4"
                >
                    <h1
                        class="text-2xl font-bold text-blue-600 dark:text-blue-400"
                    >
                        Staff Management
                    </h1>
                    <button
                        @click="openAddModal"
                        class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition hover:bg-blue-700"
                    >
                        + Add Staff
                    </button>
                </div>
            </header>

            <!-- Main Content -->
            <main class="container mx-auto px-4 py-8">
                <div class="mb-6 flex items-center justify-between">
                    <h2
                        class="text-xl font-bold text-gray-700 dark:text-gray-200"
                    >
                        Staff Directory
                    </h2>
                    <input
                        type="text"
                        placeholder="Search by name or role..."
                        class="rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm dark:bg-gray-700"
                    />
                </div>

                <!-- Staff Table -->
                <div
                    class="overflow-hidden rounded-2xl bg-white shadow-xl dark:bg-gray-800"
                >
                    <table class="w-full border-collapse text-left">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Department</th>
                                <th class="px-4 py-3">Assigned Flight</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="staff in staffList"
                                :key="staff.id"
                                class="border-b border-gray-200 transition hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700"
                            >
                                <td class="px-4 py-3">{{ staff.id }}</td>
                                <td class="px-4 py-3 font-medium">
                                    {{ staff.name }}
                                </td>
                                <td class="px-4 py-3">{{ staff.role }}</td>
                                <td class="px-4 py-3">
                                    {{ staff.department }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ staff.assignedFlight }}
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="rounded-full px-3 py-1 text-sm font-medium"
                                        :class="{
                                            'bg-green-100 text-green-700':
                                                staff.status === 'Active' ||
                                                staff.status === 'On Duty',
                                            'bg-gray-100 text-gray-700':
                                                staff.status === 'Available',
                                            'bg-red-100 text-red-700':
                                                staff.status === 'Inactive',
                                        }"
                                    >
                                        {{ staff.status }}
                                    </span>
                                </td>
                                <td class="flex justify-center gap-2 px-4 py-3">
                                    <button
                                        @click="openEditModal(staff)"
                                        class="rounded bg-yellow-500 px-3 py-1 text-sm text-white hover:bg-yellow-600"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="openAssignModal(staff)"
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
                <div
                    class="mt-8 text-center font-medium text-gray-700 dark:text-gray-300"
                >
                    Total Staff: {{ staffList.length }}
                </div>

                <!-- Add/Edit Staff Modal -->
                <div
                    v-if="showModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                >
                    <div
                        class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-800"
                    >
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
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 dark:bg-gray-700"
                                />
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium"
                                    >Role</label
                                >
                                <select
                                    v-model="selectedStaff.role"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 dark:bg-gray-700"
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
                                    >Department</label
                                >
                                <input
                                    type="text"
                                    v-model="selectedStaff.department"
                                    placeholder="e.g., Flight Operations"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 dark:bg-gray-700"
                                />
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium"
                                    >Status</label
                                >
                                <select
                                    v-model="selectedStaff.status"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 dark:bg-gray-700"
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
                </div>
                
                <!-- Assign Flight Modal -->
                <div
                    v-if="showAssignModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                >
                    <div
                        class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-800"
                    >
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
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 dark:bg-gray-700"
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
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>

<style scoped>
button {
    transition: all 0.2s ease;
}
</style>
