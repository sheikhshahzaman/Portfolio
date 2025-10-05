<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const adminLinks = [
    { name: 'Projects', href: '/admin/projects', description: 'Manage your portfolio projects' },
    { name: 'Experiences', href: '/admin/experiences', description: 'Manage work experience' },
    { name: 'Skills', href: '/admin/skills', description: 'Manage technical skills' },
    { name: 'Education', href: '/admin/education', description: 'Manage education history' },
    { name: 'Testimonials', href: '/admin/testimonials', description: 'Manage client testimonials' },
    { name: 'Blog Posts', href: '/admin/blog-posts', description: 'Manage blog posts' },
    { name: 'Settings', href: '/admin/settings', description: 'Update site settings' },
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-bold mb-6">Portfolio Admin Panel</h3>
                        <p class="mb-8">Manage all content sections of your portfolio from here.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <Link
                                v-for="link in adminLinks"
                                :key="link.name"
                                :href="link.href"
                                class="block p-6 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                            >
                                <h4 class="text-lg font-semibold mb-2">{{ link.name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ link.description }}</p>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
