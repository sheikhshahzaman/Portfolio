<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    education: Object,
});

const deleteEducation = (id) => {
    if (confirm('Are you sure you want to delete this education entry?')) {
        router.delete(route('admin.education.destroy', id));
    }
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
};
</script>

<template>
    <Head title="Manage Education" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Manage Education
                </h2>
                <Link :href="route('admin.education.create')">
                    <PrimaryButton>Add New Education</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <div class="space-y-4">
                            <div v-for="edu in education.data" :key="edu.id" class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            {{ edu.degree }}
                                        </h3>
                                        <p v-if="edu.field_of_study" class="text-md text-gray-700 dark:text-gray-300 mt-1">
                                            {{ edu.field_of_study }}
                                        </p>
                                        <p class="text-md text-gray-700 dark:text-gray-300 mt-1">
                                            {{ edu.institution }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            {{ formatDate(edu.start_date) }} -
                                            {{ edu.is_current ? 'Present' : formatDate(edu.end_date) }}
                                        </p>
                                        <p v-if="edu.grade" class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                            Grade: {{ edu.grade }}
                                        </p>
                                    </div>
                                    <div class="flex gap-2 ml-4">
                                        <Link :href="route('admin.education.edit', edu.id)" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Edit
                                        </Link>
                                        <button @click="deleteEducation(edu.id)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div v-if="education.links.length > 3" class="mt-6 flex justify-center gap-2">
                            <Link
                                v-for="(link, index) in education.links"
                                :key="index"
                                :href="link.url"
                                :class="[
                                    'px-4 py-2 text-sm border rounded',
                                    link.active
                                        ? 'bg-indigo-600 text-white border-indigo-600'
                                        : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600'
                                ]"
                                v-html="link.label"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
