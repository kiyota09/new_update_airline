<script setup lang="ts">
import RegisteredUserController from '@/actions/App/Http/Controllers/Auth/RegisteredUserController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { Form, Head, Link } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white text-gray-800 dark:from-gray-900 dark:to-gray-800 dark:text-gray-100">
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-700 sticky top-0 z-50">
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
                
                <nav class="flex items-center gap-4">
                    <Link
                        :href="login()"
                        class="inline-block rounded-lg border border-blue-600 px-5 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 transition-colors dark:text-blue-400 dark:border-blue-400 dark:hover:bg-blue-900/20"
                    >
                        Sign In
                    </Link>
                </nav>

            </div>
        </header>

        <!-- Main Content -->
        <main class="flex items-center justify-center min-h-[calc(100vh-140px)] py-12">
            <div class="w-full max-w-md mx-4">
                <Head title="Join SkyWings" />

                <!-- Logo and Title -->
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create Your Account</h1>
                    <p class="text-gray-600 dark:text-gray-300 mt-2">
                        Join SkyWings and start your journey
                    </p>
                </div>

                <!-- Register Form -->
                <div class="bg-white rounded-2xl shadow-xl p-8 dark:bg-gray-800">
                    <Form
                        v-bind="RegisteredUserController.store.form()"
                        :reset-on-success="['password', 'password_confirmation']"
                        v-slot="{ errors, processing }"
                        class="space-y-6"
                    >

                       

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <Label for="email" class="text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</Label>
                            <Input
                                id="email"
                                type="email"
                                required
                                :tabindex="2"
                                autocomplete="email"
                                name="email"
                                placeholder="Email Address"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors"
                            />
                            <InputError :message="errors.email" />
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <Label for="password" class="text-sm font-medium text-gray-700 dark:text-gray-300">Password</Label>
                            <Input
                                id="password"
                                type="password"
                                required
                                :tabindex="3"
                                autocomplete="new-password"
                                name="password"
                                placeholder="Create a password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors"
                            />
                            <InputError :message="errors.password" />
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="space-y-2">
                            <Label for="password_confirmation" class="text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</Label>
                            <Input
                                id="password_confirmation"
                                type="password"
                                required
                                :tabindex="4"
                                autocomplete="new-password"
                                name="password_confirmation"
                                placeholder="Confirm your password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors"
                            />
                            <InputError :message="errors.password_confirmation" />
                        </div>
                        
                        <!-- Terms Agreement -->
                        <div class="text-xs text-gray-600 dark:text-gray-400">
                            By creating an account, you agree to our 
                            <a href="#" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">Terms of Service</a> 
                            and 
                            <a href="#" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">Privacy Policy</a>.
                        </div>

                        <!-- Submit Button -->
                        <Button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg transition-colors flex items-center justify-center"
                            tabindex="5"
                            :disabled="processing"
                            data-test="register-user-button"
                        >
                            <LoaderCircle
                                v-if="processing"
                                class="h-4 w-4 animate-spin mr-2"
                            />
                            {{ processing ? 'Creating Account...' : 'Create Account' }}
                        </Button>
                    </Form>

                    <!-- Sign In Link -->
                    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                        Already have an account?
                        <TextLink
                            :href="login()"
                            class="text-blue-600 hover:text-blue-500 font-medium dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                            :tabindex="6"
                        >
                            Sign in
                        </TextLink>
                    </div>
                </div>

                <!-- Benefits Section -->
                <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6">
                    <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-3">SkyWings Member Benefits</h3>
                    <ul class="text-sm text-blue-700 dark:text-blue-400 space-y-2">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Earn miles on every flight
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Exclusive member-only deals
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Faster check-in and boarding
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Free flight changes within 24 hours
                        </li>
                    </ul>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8 mt-12">
            <div class="container mx-auto px-4 text-center">
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <span class="text-lg font-bold">SkyWings Airlines</span>
                </div>
                <p class="text-gray-400 text-sm">&copy; 2023 SkyWings Airlines. All rights reserved.</p>
            </div>
        </footer>
    </div>
</template>