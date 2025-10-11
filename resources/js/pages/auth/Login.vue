<script setup lang="ts">
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Form, Head, Link } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
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
                        :href="register()"
                        class="inline-block rounded-lg border border-blue-600 px-5 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 transition-colors dark:text-blue-400 dark:border-blue-400 dark:hover:bg-blue-900/20"
                    >
                        Sign Up
                    </Link>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex items-center justify-center min-h-[calc(100vh-140px)] py-12">
            <div class="w-full max-w-md mx-4">
                <Head title="Log in to SkyWings" />

                <!-- Logo and Title -->
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Welcome Back</h1>
                    <p class="text-gray-600 dark:text-gray-300 mt-2">
                        Sign in to your SkyWings account
                    </p>
                </div>

                <!-- Status Message -->
                <div
                    v-if="status"
                    class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-center dark:bg-green-900/20 dark:border-green-800 dark:text-green-400"
                >
                    {{ status }}
                </div>

                <!-- Login Form -->
                <div class="bg-white rounded-2xl shadow-xl p-8 dark:bg-gray-800">
                    <Form
                        v-bind="AuthenticatedSessionController.store.form()"
                        :reset-on-success="['password']"
                        v-slot="{ errors, processing }"
                        class="space-y-6"
                    >
                        <!-- Email Field -->
                        <div class="space-y-2">
                            <Label for="email" class="text-sm font-medium text-gray-700 dark:text-gray-300">Email address</Label>
                            <Input
                                id="email"
                                type="email"
                                name="email"
                                required
                                autofocus
                                :tabindex="1"
                                autocomplete="email"
                                placeholder="email@example.com"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors"
                            />
                            <InputError :message="errors.email" />
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <Label for="password" class="text-sm font-medium text-gray-700 dark:text-gray-300">Password</Label>
                                <TextLink
                                    v-if="canResetPassword"
                                    :href="request()"
                                    class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                    :tabindex="5"
                                >
                                    Forgot password?
                                </TextLink>
                            </div>
                            <Input
                                id="password"
                                type="password"
                                name="password"
                                required
                                :tabindex="2"
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-colors"
                            />
                            <InputError :message="errors.password" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center space-x-3">
                            <Checkbox 
                                id="remember" 
                                name="remember" 
                                :tabindex="3"
                                class="text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:border-gray-600"
                            />
                            <Label for="remember" class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                                Remember me
                            </Label>
                        </div>

                        <!-- Submit Button -->
                        <Button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg transition-colors flex items-center justify-center"
                            :tabindex="4"
                            :disabled="processing"
                            data-test="login-button"
                        >
                            <LoaderCircle
                                v-if="processing"
                                class="h-4 w-4 animate-spin mr-2"
                            />
                            {{ processing ? 'Signing in...' : 'Sign In' }}
                        </Button>
                    </Form>

                    <!-- Sign Up Link -->
                    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                        Don't have an account?
                        <TextLink 
                            :href="register()" 
                            :tabindex="5"
                            class="text-blue-600 hover:text-blue-500 font-medium dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                        >
                            Sign up
                        </TextLink>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-8 text-center text-xs text-gray-500 dark:text-gray-400">
                    By signing in, you agree to our 
                    <a href="#" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">Terms of Service</a> 
                    and 
                    <a href="#" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">Privacy Policy</a>.
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